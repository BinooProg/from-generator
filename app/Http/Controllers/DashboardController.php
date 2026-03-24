<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $formsBaseQuery = $user->forms();

        $forms = (clone $formsBaseQuery)
            ->withCount('submissions')
            ->latest()
            ->paginate(10)
            ->appends(['view' => 'forms']);

        $totalForms       = (clone $formsBaseQuery)->count();
        $activeForms      = (clone $formsBaseQuery)->where('is_active', true)->count();
        $totalSubmissions = Form::query()
            ->whereBelongsTo($user)
            ->withCount('submissions')
            ->get()
            ->sum('submissions_count');

        // Submissions tab
        $formFilter  = $request->query('sform');
        $searchQuery = $request->query('ssearch');

        $submissionsQuery = Submission::query()
            ->whereHas('form', fn($q) => $q->where('user_id', $user->id))
            ->with('form')
            ->latest();

        if ($formFilter) {
            $submissionsQuery->where('form_id', $formFilter);
        }

        if ($searchQuery) {
            $submissionsQuery->where('content', 'like', "%{$searchQuery}%");
        }

        $submissions = $submissionsQuery
            ->paginate(15, ['*'], 'spage')
            ->appends(array_filter([
                'view'    => 'submissions',
                'sform'   => $formFilter,
                'ssearch' => $searchQuery,
            ]));

        $userFormsSimple = (clone $formsBaseQuery)->select('id', 'title')->latest()->get();

        // Recent activity feed
        $recentSubmissions = Submission::query()
            ->whereHas('form', fn($q) => $q->where('user_id', $user->id))
            ->with('form:id,title,slug')
            ->latest()
            ->limit(10)
            ->get()
            ->map(fn($s) => [
                'type'      => 'submission',
                'label'     => $s->form->title,
                'meta'      => null,
                'timestamp' => $s->created_at,
                'url'       => route('dashboard', ['view' => 'submissions']),
            ]);

        $recentForms = (clone $formsBaseQuery)
            ->select('id', 'title', 'created_at', 'updated_at')
            ->latest('updated_at')
            ->limit(10)
            ->get()
            ->map(fn($f) => [
                'type'      => $f->created_at->eq($f->updated_at) ? 'form_created' : 'form_updated',
                'label'     => $f->title,
                'meta'      => null,
                'timestamp' => $f->updated_at,
                'url'       => route('forms.edit', $f->id),
            ]);

        $recentActivity = $recentSubmissions
            ->concat($recentForms)
            ->sortByDesc('timestamp')
            ->take(10)
            ->values();

        $thisWeekSubmissions = Submission::query()
            ->whereHas('form', fn($q) => $q->where('user_id', $user->id))
            ->where('created_at', '>=', now()->startOfWeek())
            ->count();

        return view('dashboard', [
            'user'                => $user,
            'forms'               => $forms,
            'totalForms'          => $totalForms,
            'activeForms'         => $activeForms,
            'totalSubmissions'    => $totalSubmissions,
            'thisWeekSubmissions' => $thisWeekSubmissions,
            'submissions'         => $submissions,
            'userFormsSimple'     => $userFormsSimple,
            'recentActivity'      => $recentActivity,
        ]);
    }
}
