<div>
    {{-- ── Filter Bar ── --}}
    <div
        class="bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-6 mb-6 transition-colors duration-300">
        <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
            <h3 class="text-xl font-light tracking-tight">
                Analytics <strong class="font-semibold">Overview</strong>
            </h3>
            <div class="flex flex-wrap gap-3 items-center">
                {{-- Form selector --}}
                <div class="relative">
                    <select wire:model.live="selectedFormId"
                        class="appearance-none h-9 w-44 pl-3 pr-8 text-sm border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-900 dark:focus:ring-neutral-100 focus:border-transparent transition-colors duration-200">
                        <option value="">All Forms</option>
                        @foreach ($forms as $form)
                            <option value="{{ $form->id }}">{{ $form->title }}</option>
                        @endforeach
                    </select>
                    <svg class="pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-neutral-400"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                {{-- Range selector --}}
                <div class="flex border border-neutral-200 dark:border-neutral-700">
                    @foreach (['7' => '7d', '30' => '30d', '90' => '90d'] as $val => $label)
                        <button wire:click="$set('range', '{{ $val }}')"
                            class="px-3 py-1.5 text-xs font-medium transition-colors duration-200 {{ $range === $val ? 'bg-neutral-900 dark:bg-neutral-100 text-white dark:text-neutral-900' : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-800' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ── KPI Cards ── --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div
            class="bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-6 transition-colors duration-300">
            <p class="text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400 mb-2">In
                Period</p>
            <p class="text-3xl font-light tracking-tight">{{ $totalInRange }}</p>
            <p class="text-xs text-neutral-400 mt-1">last {{ $range }} days</p>
        </div>

        <div
            class="bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-6 transition-colors duration-300">
            <p class="text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400 mb-2">This
                Week</p>
            <p class="text-3xl font-light tracking-tight">{{ $thisWeek }}</p>
            @if ($weekChange > 0)
                <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1">↑ {{ $weekChange }}% vs last week</p>
            @elseif ($weekChange < 0)
                <p class="text-xs text-red-600 dark:text-red-400 mt-1">↓ {{ abs($weekChange) }}% vs last week</p>
            @else
                <p class="text-xs text-neutral-400 mt-1">same as last week</p>
            @endif
        </div>

        <div
            class="bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-6 transition-colors duration-300">
            <p class="text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400 mb-2">This
                Month</p>
            <p class="text-3xl font-light tracking-tight">{{ $thisMonth }}</p>
            <p class="text-xs text-neutral-400 mt-1">{{ now()->format('F') }}</p>
        </div>

        <div
            class="bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-6 transition-colors duration-300">
            <p class="text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400 mb-2">All Time
            </p>
            <p class="text-3xl font-light tracking-tight">{{ $totalAllTime }}</p>
            <p class="text-xs text-neutral-400 mt-1">
                {{ $activeForms }} active {{ Str::plural('form', $activeForms) }}
            </p>
        </div>
    </div>

    @if ($totalAllTime > 0)
        {{-- ── Submissions Over Time ── --}}
        <div class="bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-6 mb-6 transition-colors duration-300"
            wire:ignore>
            <p class="text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400 mb-4">
                Submissions Over Time</p>
            <div style="height: 220px;">
                <canvas id="analyticsLineChart"></canvas>
            </div>
        </div>

        {{-- ── Submissions by Form ── --}}
        @if (count($perFormLabels) > 0)
            <div class="bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-6 mb-6 transition-colors duration-300"
                wire:ignore>
                <p class="text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400 mb-4">
                    Submissions by Form</p>
                <div style="height: {{ max(120, count($perFormLabels) * 36) }}px;">
                    <canvas id="analyticsBarChart"></canvas>
                </div>
            </div>
        @endif

        {{-- ── Field Answer Distributions ── --}}
        @if (!empty($fieldStats))
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                @foreach ($fieldStats as $stat)
                    <div
                        class="bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-6 transition-colors duration-300">
                        <p
                            class="text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400 mb-4">
                            {{ $stat['label'] }}</p>
                        <div class="space-y-3">
                            @foreach ($stat['tally'] as $option => $count)
                                @php $pct = $stat['total'] > 0 ? round($count / $stat['total'] * 100) : 0; @endphp
                                <div>
                                    <div class="flex justify-between items-baseline text-sm mb-1">
                                        <span class="text-neutral-700 dark:text-neutral-300 truncate max-w-[70%]">
                                            {{ $option }}
                                        </span>
                                        <span class="text-neutral-500 dark:text-neutral-400 shrink-0 pl-2 tabular-nums">
                                            {{ $count }} ({{ $pct }}%)
                                        </span>
                                    </div>
                                    <div class="h-1.5 bg-neutral-100 dark:bg-neutral-800">
                                        <div class="h-1.5 bg-neutral-900 dark:bg-neutral-100 transition-all duration-500"
                                            style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif ($selectedFormId)
            <div
                class="bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-6 mb-6 transition-colors duration-300">
                <p class="text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400 mb-2">
                    Field Breakdown</p>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 font-light">
                    No choice fields (dropdown, radio, checkbox) in this form.
                </p>
            </div>
        @endif
    @else
        {{-- ── Empty state ── --}}
        <div
            class="bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-12 text-center transition-colors duration-300">
            <svg class="w-16 h-16 mx-auto mb-4 text-neutral-300 dark:text-neutral-700" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <p class="text-neutral-600 dark:text-neutral-400 font-light">
                No submissions yet. Share your forms to start collecting data.
            </p>
        </div>
    @endif

    @assets
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    @endassets

    @script
        <script>
            let lineChart = null;
            let barChart = null;

            function chartPalette() {
                const dark = document.documentElement.classList.contains('dark');
                return {
                    line: dark ? '#f5f5f5' : '#171717',
                    fill: dark ? 'rgba(245,245,245,0.07)' : 'rgba(23,23,23,0.06)',
                    bar: dark ? '#d4d4d4' : '#262626',
                    grid: dark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)',
                    tick: dark ? '#737373' : '#a3a3a3',
                };
            }

            function buildCharts(dailyLabels, dailyData, perFormLabels, perFormData) {
                const p = chartPalette();

                // Line chart
                const lineCanvas = document.getElementById('analyticsLineChart');
                if (lineCanvas) {
                    if (lineChart) {
                        lineChart.destroy();
                        lineChart = null;
                    }
                    lineChart = new Chart(lineCanvas, {
                        type: 'line',
                        data: {
                            labels: dailyLabels,
                            datasets: [{
                                data: dailyData,
                                borderColor: p.line,
                                backgroundColor: p.fill,
                                borderWidth: 1.5,
                                pointRadius: 0,
                                pointHoverRadius: 4,
                                fill: true,
                                tension: 0.3,
                            }],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                mode: 'index',
                                intersect: false
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: item => ` ${item.raw} submission${item.raw !== 1 ? 's' : ''}`,
                                    },
                                },
                            },
                            scales: {
                                x: {
                                    grid: {
                                        color: p.grid
                                    },
                                    ticks: {
                                        color: p.tick,
                                        maxTicksLimit: 10
                                    }
                                },
                                y: {
                                    grid: {
                                        color: p.grid
                                    },
                                    ticks: {
                                        color: p.tick,
                                        stepSize: 1,
                                        beginAtZero: true
                                    }
                                },
                            },
                        },
                    });
                }

                // Horizontal bar chart
                const barCanvas = document.getElementById('analyticsBarChart');
                if (barCanvas && perFormLabels.length > 0) {
                    if (barChart) {
                        barChart.destroy();
                        barChart = null;
                    }
                    barChart = new Chart(barCanvas, {
                        type: 'bar',
                        data: {
                            labels: perFormLabels,
                            datasets: [{
                                data: perFormData,
                                backgroundColor: p.bar,
                                borderWidth: 0
                            }],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            indexAxis: 'y',
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        color: p.grid
                                    },
                                    ticks: {
                                        color: p.tick,
                                        stepSize: 1,
                                        beginAtZero: true
                                    }
                                },
                                y: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        color: p.tick
                                    }
                                },
                            },
                        },
                    });
                }
            }

            // Initial render
            buildCharts(
                @js($dailyLabels),
                @js($dailyData),
                @js($perFormLabels),
                @js($perFormData)
            );

            // Re-draw when Livewire fires updated chart data
            $wire.on('analyticsChartData', ({
                dailyLabels,
                dailyData,
                perFormLabels,
                perFormData
            }) => {
                buildCharts(dailyLabels, dailyData, perFormLabels, perFormData);
            });
        </script>
    @endscript
</div>
