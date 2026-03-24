<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubmissionController extends Controller
{
    public function destroy(Request $request, Submission $submission): RedirectResponse
    {
        abort_unless($submission->form->user_id === $request->user()->id, 403);

        $submission->delete();

        return redirect()->route('dashboard', array_filter([
            'view'    => 'submissions',
            'sform'   => $request->query('sform'),
            'ssearch' => $request->query('ssearch'),
            'spage'   => $request->query('spage', 1),
        ]));
    }

    public function downloadFile(Request $request, Submission $submission, string $fieldId)
    {
        $user = $request->user();
        abort_if(! $user || $submission->form->user_id !== $user->id, 403);

        return $this->serveSubmissionFile($submission, $fieldId);
    }

    public function downloadFileAttachment(Request $request, Submission $submission, string $fieldId)
    {
        $user = $request->user();
        abort_if(! $user || $submission->form->user_id !== $user->id, 403);

        return $this->serveSubmissionFile($submission, $fieldId);
    }

    protected function serveSubmissionFile(Submission $submission, string $fieldId)
    {

        $filePath = $submission->content[$fieldId] ?? null;

        if (! is_string($filePath) || $filePath === '') {
            abort(404);
        }

        $disk = Storage::disk('local')->exists($filePath)
            ? 'local'
            : (Storage::disk('public')->exists($filePath) ? 'public' : null);

        if ($disk === null) {
            abort(404);
        }

        $fullPath = Storage::disk($disk)->path($filePath);

        if (! is_file($fullPath)) {
            abort(404);
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = $finfo ? (finfo_file($finfo, $fullPath) ?: 'application/octet-stream') : 'application/octet-stream';

        if ($finfo) {
            finfo_close($finfo);
        }

        return response()->download($fullPath, basename($fullPath), [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'private, no-store, max-age=0',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $user        = $request->user();
        $formFilter  = $request->query('sform');
        $searchQuery = $request->query('ssearch');

        $query = Submission::query()
            ->whereHas('form', fn($q) => $q->where('user_id', $user->id))
            ->with('form')
            ->latest();

        if ($formFilter) {
            $query->where('form_id', $formFilter);
        }

        if ($searchQuery) {
            $query->where('content', 'like', "%{$searchQuery}%");
        }

        $submissions = $query->get();

        // Build a unified header across all forms' fields
        $fieldLabels = [];
        foreach ($submissions as $submission) {
            foreach ($submission->form->getFields() as $field) {
                $fieldLabels[$field['id']] = $field['label'];
            }
        }

        $csvRows   = [];
        $csvRows[] = array_merge(['Form', 'Submitted At', 'IP Address'], array_values($fieldLabels));

        foreach ($submissions as $submission) {
            $row = [
                $submission->form->title,
                $submission->created_at->format('Y-m-d H:i:s'),
                $submission->ip_address ?? '',
            ];

            foreach (array_keys($fieldLabels) as $fieldId) {
                $value = $submission->content[$fieldId] ?? '';

                // Export file uploads as plain absolute URLs for maximum CSV client compatibility.
                if (is_string($value) && str_starts_with($value, 'submissions/')) {
                    $relativeUrl = route('submissions.files.download-attachment', [
                        'submission' => $submission->id,
                        'fieldId' => $fieldId,
                    ], false);

                    $value = rtrim($request->root(), '/') . $relativeUrl;
                }

                $row[] = is_array($value) ? implode(', ', $value) : $value;
            }

            $csvRows[] = $row;
        }

        $filename = 'submissions-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($csvRows) {
            $handle = fopen('php://output', 'w');
            foreach ($csvRows as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, $filename, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
