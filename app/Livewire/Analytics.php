<?php

namespace App\Livewire;

use App\Models\Form;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Analytics extends Component
{
    public ?int $selectedFormId = null;
    public string $range = '30';

    public function render()
    {
        $user  = Auth::user();
        $forms = Form::where('user_id', $user->id)->select('id', 'title')->latest()->get();
        $days  = (int) $this->range;
        $since = now()->subDays($days)->startOfDay();

        $baseQuery = Submission::query()
            ->whereHas('form', fn($q) => $q->where('user_id', $user->id));

        if ($this->selectedFormId) {
            $baseQuery->where('form_id', $this->selectedFormId);
        }

        // KPIs
        $totalInRange = (clone $baseQuery)->where('created_at', '>=', $since)->count();
        $totalAllTime = (clone $baseQuery)->count();
        $thisWeek     = (clone $baseQuery)->where('created_at', '>=', now()->startOfWeek())->count();
        $lastWeek     = (clone $baseQuery)
            ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->count();
        $weekChange   = $lastWeek > 0
            ? (int) round((($thisWeek - $lastWeek) / $lastWeek) * 100)
            : ($thisWeek > 0 ? 100 : 0);
        $thisMonth   = (clone $baseQuery)->where('created_at', '>=', now()->startOfMonth())->count();
        $activeForms = Form::where('user_id', $user->id)->where('is_active', true)->count();

        // Daily chart — fill gaps with 0
        $dailyRaw = (clone $baseQuery)
            ->where('created_at', '>=', $since)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $dailyLabels = [];
        $dailyData   = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date          = now()->subDays($i)->format('Y-m-d');
            $dailyLabels[] = now()->subDays($i)->format('M j');
            $dailyData[]   = $dailyRaw[$date] ?? 0;
        }

        // Per-form breakdown (top 8 in range)
        $perFormQuery = Form::where('user_id', $user->id)
            ->withCount(['submissions' => fn($q) => $q->where('created_at', '>=', $since)]);

        if ($this->selectedFormId) {
            $perFormQuery->where('id', $this->selectedFormId);
        }

        $perForm       = $perFormQuery->orderByDesc('submissions_count')->limit(8)->get();
        $perFormLabels = $perForm->pluck('title')->toArray();
        $perFormData   = $perForm->pluck('submissions_count')->toArray();

        // Field answer distributions (choice fields, only when a form is selected)
        $fieldStats = [];
        if ($this->selectedFormId) {
            $form = Form::where('user_id', $user->id)->find($this->selectedFormId);
            if ($form) {
                $submissions = (clone $baseQuery)
                    ->where('created_at', '>=', $since)
                    ->get(['content']);

                foreach ($form->getFields() as $field) {
                    if (!in_array($field['type'] ?? '', ['select', 'radio', 'checkbox'])) {
                        continue;
                    }
                    $tally = [];
                    foreach ($submissions as $sub) {
                        $val = $sub->content[$field['id']] ?? null;
                        if ($val === null) continue;
                        foreach ((array) $val as $v) {
                            if ($v !== '') {
                                $tally[$v] = ($tally[$v] ?? 0) + 1;
                            }
                        }
                    }
                    if (!empty($tally)) {
                        arsort($tally);
                        $fieldStats[] = [
                            'label' => $field['label'],
                            'tally' => $tally,
                            'total' => array_sum($tally),
                        ];
                    }
                }
            }
        }

        $this->dispatch(
            'analyticsChartData',
            dailyLabels: $dailyLabels,
            dailyData: $dailyData,
            perFormLabels: $perFormLabels,
            perFormData: $perFormData,
        );

        return view('livewire.analytics', compact(
            'forms',
            'totalInRange',
            'totalAllTime',
            'thisWeek',
            'lastWeek',
            'weekChange',
            'thisMonth',
            'activeForms',
            'dailyLabels',
            'dailyData',
            'perFormLabels',
            'perFormData',
            'fieldStats',
        ));
    }
}
