<x-admin-layout>
    <!-- Header remains the same -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Feedback Analytics') }}
        </h2>
    </x-slot>

    @php
        $userFeedbacks = \App\Models\UsersFeedbackSystem::all();
        
        // Updated calculations for Likert scale (1-5)
        $uxScores = $userFeedbacks->map(function($feedback) {
            return ($feedback->c1_1 + $feedback->c1_2 + $feedback->c1_3 + $feedback->c1_4 + $feedback->c1_5) / 5;
        })->avg();
        
        $contentScores = $userFeedbacks->map(function($feedback) {
            return ($feedback->c2_1 + $feedback->c2_2 + $feedback->c2_3 + $feedback->c2_4 + $feedback->c2_5) / 5;
        })->avg();
        
        $technicalScores = $userFeedbacks->map(function($feedback) {
            return ($feedback->c3_1 + $feedback->c3_2 + $feedback->c3_3 + $feedback->c3_4 + $feedback->c3_5) / 5;
        })->avg();

        // Helper function to get color class based on Likert score
        function getScoreColorClass($score) {
            if ($score >= 4) return 'text-green-600'; // Very Positive
            if ($score >= 3) return 'text-yellow-600'; // Neutral to Positive
            return 'text-red-600'; // Needs Improvement
        }
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Analytics Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-6 rounded-lg shadow border border-indigo-500">
                    <h3 class="font-bold text-lg mb-2">User Experience</h3>
                    <div class="text-3xl font-bold {{ getScoreColorClass($uxScores) }}">
                        {{ number_format($uxScores, 2) }}/5
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow border border-indigo-500">
                    <h3 class="font-bold text-lg mb-2">Content Quality</h3>
                    <div class="text-3xl font-bold {{ getScoreColorClass($contentScores) }}">
                        {{ number_format($contentScores, 2) }}/5
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow border border-indigo-500">
                    <h3 class="font-bold text-lg mb-2">Technical Performance</h3>
                    <div class="text-3xl font-bold {{ getScoreColorClass($technicalScores) }}">
                        {{ number_format($technicalScores, 2) }}/5
                    </div>
                </div>
            </div>

            <!-- Charts section remains largely the same, just update the colors to match Likert scale -->
            @php
            // Group feedback by date to calculate daily averages.
            $groupedFeedbacks = $userFeedbacks->groupBy(fn($f) => $f->created_at->format('Y-m-d'));
            $dates = $groupedFeedbacks->keys()->toArray();

            $uxByDate = [];
            $contentByDate = [];
            $technicalByDate = [];

            foreach($groupedFeedbacks as $feedbacks) {
                $uxByDate[] = $feedbacks->average(fn($f) => ($f->c1_1 + $f->c1_2 + $f->c1_3 + $f->c1_4 + $f->c1_5)/5) ?? 0;
                $contentByDate[] = $feedbacks->average(fn($f) => ($f->c2_1 + $f->c2_2 + $f->c2_3 + $f->c2_4 + $f->c2_5)/5) ?? 0;
                $technicalByDate[] = $feedbacks->average(fn($f) => ($f->c3_1 + $f->c3_2 + $f->c3_3 + $f->c3_4 + $f->c3_5)/5) ?? 0;
            }
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div class="bg-white p-4 rounded-lg shadow h-[400px] border-b-4 border border-green-500">
                <h3 class="text-center font-semibold mb-2">Score Distribution</h3>
                <canvas id="feedbackChart" style="width: 100%; height: 90%"></canvas>
            </div>
            <div class="bg-white p-4 rounded-lg shadow h-[400px] border-b-4 border border-yellow-500">
                <h3 class="text-center font-semibold mb-2">Trends Over Time</h3>
                <canvas id="lineChart" style="width: 100%; height: 90%"></canvas>
            </div>
            <div class="bg-white p-4 rounded-lg shadow h-[400px] flex flex-col items-center border-b-4 border border-red-500">
                <h3 class="text-center font-semibold mb-2">Score Comparison</h3>
                <div class="w-full h-full flex items-center justify-center">
                    <canvas id="pieChart" style="max-width: 100%; max-height: 90%"></canvas>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
                const chartColors = {
                    positive: '#22c55e', // Green for high scores
                    neutral: '#eab308',  // Yellow for medium scores
                    negative: '#ef4444'  // Red for low scores
                };

                // Update chart configurations with new colors and proper Likert scale labeling
                // Bar Chart
                new Chart(document.getElementById('feedbackChart').getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: ['User Experience', 'Content Quality', 'Technical Performance'],
                        datasets: [{
                            label: 'Average Score (1-5)',
                            data: [{{ $uxScores }}, {{ $contentScores }}, {{ $technicalScores }}],
                            backgroundColor: [chartColors.positive, chartColors.neutral, chartColors.negative]
                        }]
                    },
                    options: {
                        scales: {
                            y: { 
                                beginAtZero: true, 
                                max: 5,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });

                // Rest of the charts remain the same...

                // Line Chart Over Time
                new Chart(document.getElementById('lineChart').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($dates) !!},
                        datasets: [
                            {
                                label: 'UX',
                                data: {!! json_encode($uxByDate) !!},
                                borderColor: '#4ade80',
                                fill: false
                            },
                            {
                                label: 'Content',
                                data: {!! json_encode($contentByDate) !!},
                                borderColor: '#fde047',
                                fill: false
                            },
                            {
                                label: 'Technical',
                                data: {!! json_encode($technicalByDate) !!},
                                borderColor: '#f87171',
                                fill: false
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: { beginAtZero: true, max: 5 }
                        }
                    }
                });

                // Pie Chart Distribution
                new Chart(document.getElementById('pieChart').getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: ['UX','Content','Technical'],
                        datasets: [{
                            data: [{{ $uxScores }}, {{ $contentScores }}, {{ $technicalScores }}],
                            backgroundColor: ['#4ade80','#fde047','#f87171']
                        }]
                    }
                });
            </script>

            <!-- Update the table to show Likert scale responses -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">UX Score</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content Score</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Technical Score</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comments</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userFeedbacks as $feedback)
                                    @php
                                        $uxAvg = ($feedback->c1_1 + $feedback->c1_2 + $feedback->c1_3 + $feedback->c1_4 + $feedback->c1_5) / 5;
                                        $contentAvg = ($feedback->c2_1 + $feedback->c2_2 + $feedback->c2_3 + $feedback->c2_4 + $feedback->c2_5) / 5;
                                        $technicalAvg = ($feedback->c3_1 + $feedback->c3_2 + $feedback->c3_3 + $feedback->c3_4 + $feedback->c3_5) / 5;
                                    @endphp
                                    <!-- Rest of the table row structure remains the same -->
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $feedback->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $uxAvg <= 2 ? 'bg-green-100 text-green-800' : ($uxAvg <= 3.5 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ number_format($uxAvg, 2) }}/5
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $contentAvg <= 2 ? 'bg-green-100 text-green-800' : ($contentAvg <= 3.5 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ number_format($contentAvg, 2) }}/5
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $technicalAvg <= 2 ? 'bg-green-100 text-green-800' : ($technicalAvg <= 3.5 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ number_format($technicalAvg, 2) }}/5
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <div class="tooltip" title="{{ $feedback->comment }}">
                                                {{ Str::limit($feedback->comment, 50) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $feedback->created_at->format('M d, Y h:i A') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
