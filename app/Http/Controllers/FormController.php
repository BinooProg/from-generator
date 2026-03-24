<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FormController extends Controller
{
    // ── Builder (authenticated) ───────────────────────────────────────────

    public function create(): View
    {
        return view('form-builder');
    }

    public function edit(int $formId): View
    {
        return view('form-builder', ['formId' => $formId]);
    }

    public function activate(Request $request, Form $form): RedirectResponse
    {
        abort_unless($form->user_id === $request->user()->id, 403);

        $form->is_active = true;
        $form->save();

        return redirect()->route('dashboard', ['view' => 'forms', 'page' => $request->query('page', 1)]);
    }

    public function deactivate(Request $request, Form $form): RedirectResponse
    {
        abort_unless($form->user_id === $request->user()->id, 403);

        $form->is_active = false;
        $form->save();

        return redirect()->route('dashboard', ['view' => 'forms', 'page' => $request->query('page', 1)]);
    }

    public function destroy(Request $request, Form $form): RedirectResponse
    {
        abort_unless($form->user_id === $request->user()->id, 403);

        $form->delete();

        return redirect()->route('dashboard', ['view' => 'forms', 'page' => $request->query('page', 1)]);
    }

    // ── Public form ───────────────────────────────────────────────────────

    public function show(string $slug): View
    {
        $form = Form::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('forms.show', compact('form'));
    }

    public function submit(Request $request, string $slug): RedirectResponse
    {
        $form = $request->attributes->get('publicForm');

        if (! $form instanceof Form) {
            $form = Form::where('slug', $slug)->where('is_active', true)->firstOrFail();
        }

        $fields = $form->getFields();
        $validated = (array) $request->attributes->get('validatedPublicSubmission', []);

        $inputTypes = ['text', 'email', 'number', 'phone', 'date', 'url', 'textarea', 'select', 'radio', 'checkbox', 'file'];

        $content = [];

        foreach ($fields as $field) {
            if (! in_array($field['type'], $inputTypes)) {
                continue;
            }

            $id = $field['id'];

            if ($field['type'] === 'file' && $request->hasFile($id)) {
                $content[$id] = $request->file($id)->store(
                    'submissions/' . $form->id,
                    'local',
                );
            } elseif ($field['type'] === 'checkbox') {
                $content[$id] = (array) ($validated[$id] ?? []);
            } else {
                $content[$id] = $validated[$id] ?? null;
            }
        }

        Submission::create([
            'form_id'    => $form->id,
            'content'    => $content,
            'ip_address' => $request->ip(),
        ]);

        $successMessage = $form->settings['success_message'] ?? 'Thank you! Your response has been recorded.';

        return redirect()
            ->route('forms.show', $form->slug)
            ->with('success', $successMessage);
    }
}
