<x-admin-layout>
    <x-slot name="header">
        {{ __('Dashboard') }} <!-- Set the header content here -->
    </x-slot>

    <!-- Existing Content -->
    <div class="bg-white overflow-hidden">
        <div class="p-1 text-gray-900">
            {{ __("") }}
        </div>
    </div>
    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Faculty Card -->
                <a href="{{ route('admin.views.faculty') }}" class="bg-green-500 text-white p-4 rounded-lg shadow relative hover:bg-green-600 transition duration-300 ease-in-out cursor-pointer transform hover:scale-105 hover:shadow-lg">
                    <div>
                        <h3 class="text-lg font-bold">Total Users</h3>
                        <p class="text-2xl">{{ $TotalUser }}</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50 transition-transform duration-300 ease-in-out transform hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </a>
                <!-- Clearance Card -->
                <a href="{{ route('admin.views.clearances') }}" class="bg-purple-500 text-white p-4 rounded-lg shadow relative hover:bg-purple-600 transition duration-300 ease-in-out cursor-pointer transform hover:scale-105 hover:shadow-lg">
                    <div>
                        <h3 class="text-lg font-bold">Check My Faculty</h3>
                        <p class="text-2xl">{{ $managedFacultyCount }}</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50 transition-transform duration-300 ease-in-out transform hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </a>
                @if(Auth::user()->user_type === 'Admin')
                    <!-- My College Card -->
                    <a href="{{ route('admin.views.college') }}" class="bg-blue-500 text-white p-4 rounded-lg shadow relative hover:bg-blue-600 transition duration-300 ease-in-out cursor-pointer transform hover:scale-105 hover:shadow-lg">
                        <div>
                            <h3 class="text-lg font-bold">College</h3>
                            <p class="text-2xl">{{ $collegeCount ?? 0 }}</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50 transition-transform duration-300 ease-in-out transform hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </a>
                @endif
                <!-- Shared Files Card -->
                <a href="{{ route('admin.views.submittedReports') }}" class="bg-orange-500 text-white p-4 rounded-lg shadow relative hover:bg-orange-600 transition duration-300 ease-in-out cursor-pointer transform hover:scale-105 hover:shadow-lg">
                    <div>
                        <h3 class="text-lg font-bold">History of Report</h3>
                        <p class="text-2xl">{{ $submittedReportsCount ?? 0 }}</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50 transition-transform duration-300 ease-in-out transform hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </a>

                @if (Auth::user()->user_type == 'Program-Head' || Auth::user()->user_type == 'Dean')
                    <!-- Clearance Progress Card -->
                    {{-- <a href="{{ route('admin.views.submittedReports') }}" class="bg-orange-500 text-white p-4 rounded-lg shadow relative hover:bg-orange-600 transition duration-300 ease-in-out cursor-pointer transform hover:scale-105 hover:shadow-lg">
                        <div>
                            <h3 class="text-lg font-bold">My Clearance Progress</h3>
                            <p class="text-2xl">
                                @if(Auth::user()->clearances_status == 'complete')
                                    Completed
                                @elseif(Auth::user()->clearances_status == 'pending') 
                                    In Progress
                                @elseif(Auth::user()->clearances_status == 'return')
                                    Resubmit Required
                                @else
                                    Not Started
                                @endif
                            </p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50 transition-transform duration-300 ease-in-out transform hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </a> --}}
                @endif
            </div>

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Example Card 1 -->
                <a href="{{ route('admin.profile.edit') }}" class="bg-emerald-500 text-white p-4 rounded-lg shadow relative hover:bg-emerald-600 transition duration-300 ease-in-out cursor-pointer transform hover:scale-105 hover:shadow-lg">
                    <div>
                        <h3 class="text-lg font-bold">Profile</h3>
                        <p class="text-2xl"></p>

                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50 transition-transform duration-300 ease-in-out transform hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <!-- SVG Path -->
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </a>

                @if(Auth::user()->user_type === 'Admin')
                    <!-- Example Card 2 -->
                    <a href="{{ route('admin.clearance.manage') }}" class="bg-fuchsia-500 text-white p-4 rounded-lg shadow relative hover:bg-fuchsia-600 transition duration-300 ease-in-out cursor-pointer transform hover:scale-105 hover:shadow-lg">
                        <div>
                            <h3 class="text-lg font-bold">Manage Clearance</h3>
                            <p class="text-2xl"></p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 absolute top-2 right-2 opacity-50 transition-transform duration-300 ease-in-out transform hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </a>
                @endif
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Clearance Status -->
                <div class="bg-white p-4 rounded-lg shadow-lg border-2 border-indigo-200">
                    <h3 class="text-lg font-bold mb-2">Clearance Status</h3>
                    <div class="h-48">
                        <canvas id="clearanceStatusChart"></canvas>
                    </div>
                    <div class="mt-2 text-sm text-gray-600 flex justify-between">
                        <span>In Progress: {{ $clearancePending }}</span>
                        <span>Complete: {{ $clearanceComplete }}</span>
                        <span>Return: {{ $clearanceReturn }}</span>
                    </div>
                </div>

                <!-- Faculty Status -->
                <div class="bg-white p-4 rounded-lg shadow-lg border-2 border-indigo-200">
                    <h3 class="text-lg font-bold mb-2">Faculty Status</h3>
                    <div class="h-48">
                        <canvas id="facultyStatusChart"></canvas>
                    </div>
                    <div class="mt-2 text-sm text-gray-600 relative">
                        <button
                            id="facultyButton"
                            class="w-full py-2 text-blue-500 hover:underline"
                            onmouseenter="showFacultyPopup()"
                            onmouseleave="hideFacultyPopup()"
                        >
                            View Faculty Breakdown
                        </button>

                        <div
                            id="facultyPopup"
                            class="hidden absolute left-0 top-full mt-2 bg-white border border-gray-200 rounded-lg shadow-lg p-4 z-10 w-72"
                        >
                            <div class="grid grid-cols-1 gap-2">
                                <div class="flex justify-between">
                                    <span class="font-medium">Permanent (Full-Time):</span>
                                    <span>{{ $facultyPermanentFT }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Permanent (Temporary):</span>
                                    <span>{{ $facultyPermanentT }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Part-Time (Full-Time):</span>
                                    <span>{{ $facultyPartTimeFT }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Part-Time:</span>
                                    <span>{{ $facultyPartTime }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Dean:</span>
                                    <span>{{ $usersDean }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Program Head:</span>
                                    <span>{{ $usersPH }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                function showFacultyPopup() {
                    const popup = document.getElementById('facultyPopup');
                    popup.classList.remove('hidden');
                }

                function hideFacultyPopup() {
                    const popup = document.getElementById('facultyPopup');
                    popup.classList.add('hidden');
                }
                </script>

                <!-- User Type Distribution -->
                <div class="bg-white p-4 rounded-lg shadow-lg border-2 border-indigo-200">
                    <h3 class="text-lg font-bold mb-2">User Types</h3>
                    <div class="h-48">
                        <canvas id="userTypeChart"></canvas>
                    </div>
                    <div class="mt-2 text-sm text-gray-600 flex justify-between">
                        <span>Admin: {{ $facultyAdmin }}</span>
                        <span>Dean: {{ $facultyDean }}</span>
                        <span>Program Head: {{ $facultyPH }}</span>
                        <span>Faculty: {{ $facultyFaculty }}</span>
                    </div>
                </div>

                <!-- Overall Analytics -->
                <div class="bg-white p-4 rounded-lg shadow-lg border-2 border-indigo-200">
                    <h3 class="text-lg font-bold mb-2">Overall Analytics</h3>
                    <div class="h-48">
                        <canvas id="overallAnalyticsChart"></canvas>
                    </div>
                    <div class="mt-2 text-sm text-gray-600 relative">
                        <button
                            id="analyticsButton"
                            class="w-full py-2 text-blue-500 hover:underline"
                            onmouseenter="showAnalyticsPopup()"
                            onmouseleave="hideAnalyticsPopup()"
                        >
                            View Analytics Breakdown
                        </button>

                        <!-- Tooltip/Popup Content -->
                        <div
                            id="analyticsPopup"
                            class="hidden absolute left-0 top-full mt-2 bg-white border border-gray-200 rounded-lg shadow-lg p-4 z-10 w-72"
                        >
                            <div class="grid grid-cols-1 gap-2">
                                <div class="flex justify-between">
                                    <span class="font-medium">Users:</span>
                                    <span>{{ $TotalUser }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Clearances:</span>
                                    <span>{{ $clearanceTotal }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Checklists:</span>
                                    <span>{{ $clearanceChecklist }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Faculty:</span>
                                    <span>{{ $facultyAdmin + $facultyFaculty }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Completed Clearances (This Month):</span>
                                    <span>{{ $completedClearancesThisMonth }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">New Users (This Month):</span>
                                    <span>{{ $newUsersThisMonth }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Recent Logins (This Month):</span>
                                    <span>{{ $recentLogins }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                    function showAnalyticsPopup() {
                        const popup = document.getElementById('analyticsPopup');
                        popup.classList.remove('hidden');
                    }

                    function hideAnalyticsPopup() {
                        const popup = document.getElementById('analyticsPopup');
                        popup.classList.add('hidden');
                    }
                    </script>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Clearance Status Chart
                    new Chart(document.getElementById('clearanceStatusChart'), {
                        type: 'doughnut',
                        data: {
                            labels: ['In Progress', 'Complete', 'Resubmit'],
                            datasets: [{
                                data: [{{ $clearancePending }}, {{ $clearanceComplete }}, {{ $clearanceReturn }}],
                                backgroundColor: ['#FCD34D', '#10B981', '#F97316']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });

                    // Faculty Status Chart
                    new Chart(document.getElementById('facultyStatusChart'), {
                        type: 'bar',
                        data: {
                            labels: ['Dean', 'Program Head', 'Permanent-FullTime', 'Permanent-Temporary', 'Part-Time', 'Part-Time-FullTime'],
                            datasets: [{
                                data: [{{ $usersDean }}, {{ $usersPH }}, {{ $facultyPermanentFT }}, {{ $facultyPermanentT }}, {{ $facultyPartTime }}, {{ $facultyPartTimeFT }}],
                                backgroundColor: ['#3B82F6', '#10B981', '#EF4444', '#F59E0B', '#8B5CF6', '#EC4899', '#0EA5E9']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    display: true
                                },
                                x: {
                                    display: true
                                }
                            }
                        }
                    });

                    // User Type Chart
                    new Chart(document.getElementById('userTypeChart'), {
                        type: 'pie',
                        data: {
                            labels: ['Admin', 'Faculty', 'Dean', 'Program Head'],
                            datasets: [{
                                data: [{{ $facultyAdmin }}, {{ $facultyFaculty }}, {{ $facultyDean }}, {{ $facultyPH }}],
                                backgroundColor: ['#3B82F6', '#10B981', '#F97316', '#8B5CF6']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });

                    // Overall Analytics Chart
                    new Chart(document.getElementById('overallAnalyticsChart'), {
                        type: 'line',
                        data: {
                            labels: ['Users', 'Clearances', 'Checklists', 'Faculty', 'Completed Clearances', 'New Users', 'Recent Logins'],
                            datasets: [{
                                data: [{{ $TotalUser }}, {{ $clearanceTotal }}, {{ $clearanceChecklist }}, {{ $facultyAdmin + $facultyFaculty }}, {{ $completedClearancesThisMonth }}, {{ $newUsersThisMonth }}, {{ $recentLogins }}],
                                backgroundColor: ['#3B82F6', '#10B981', '#FCD34D', '#8B5CF6', '#EC4899', '#F59E0B', '#34D399']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false, // Hide the legend
                                    position: 'right'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            if (context.raw !== null) {
                                                label += context.raw;
                                            }
                                            return label;
                                        }
                                    }
                                }
                            },
                            scales: {
                                r: {
                                    display: true
                                }
                            }
                        }
                    });
                });
            </script>
        </div>
    </div>

    <!-- Storage Information -->
    <div class="py-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-xl shadow-xl border-2 border-indigo-200 hover:shadow-2xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-xl font-bold text-gray-800">System Storage Overview</h4>
                        <p class="text-gray-500 text-sm">Monitor storage consumption in real-time</p>
                    </div>
                    <div class="p-2 bg-blue-50 rounded-lg">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                        </svg>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-gray-50 to-white p-4 rounded-xl border border-gray-100 shadow-inner">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-base font-bold text-gray-700">Current Usage</span>
                        <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600">
                            {{ number_format($storageSize / (1024 * 1024), 2) }} MB
                        </span>
                    </div>
                    
                    @php
                        $maxStorage = 150000;
                        $percentage = number_format(min(($storageSize / (1024 * 1024 * $maxStorage)) * 100, 100), 2);
                        $isHighUsage = $percentage > 90;
                    @endphp
                    
                    <div class="relative w-full h-4 bg-gray-200 rounded-full overflow-hidden mb-2">
                        <div class="h-full rounded-full transition-all duration-700 ease-in-out 
                            {{ $percentage >= 80 ? 'bg-gradient-to-r from-red-500 to-red-600 animate-none' : 
                               ($isHighUsage ? 'bg-gradient-to-r from-red-800 to-red-300' : 
                               'bg-gradient-to-r from-blue-500 to-blue-600') }} relative"
                            style="width: {{ $percentage }}%">
                            <div class="absolute inset-0 {{ $percentage >= 80 ? 'bg-white/20' : 'bg-white/10' }}"></div>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">0 MB</span>
                        <span class="px-2 py-0.5 rounded-full {{ $isHighUsage ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $percentage }}% Used
                        </span>
                        <span class="text-gray-500">{{ $maxStorage > 999 ? number_format($maxStorage/1000, 1) . ' GB' : $maxStorage . ' MB' }} <span class="text-xs text-gray-400 italic mt-1">(Temporary Limit)</span></span>
                        
                    </div>

                    @if($isHighUsage)
                    <div class="mt-2 p-2 bg-red-50 rounded-lg border border-red-100">
                        <p class="text-sm text-red-700 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Storage nearly full. Free up space.
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Storage Warning Modal -->
    @if($percentage >= 80)
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-red-800">
                                Storage Warning
                            </h3>
                            <div class="mt-1">
                                <p class="text-sm text-red-700">
                                    @if($percentage >= 90)
                                        Critical storage level! Your storage is at {{ $percentage }}% capacity. Please free up space immediately to prevent system issues.
                                    @else
                                        Your storage is at {{ $percentage }}% capacity. Consider freeing up space soon.
                                    @endif
                                </p>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('admin.views.submittedReports') }}" class="inline-flex items-center px-3 py-2 border border-red-600 text-sm leading-4 font-medium rounded-md text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                    Manage Storage
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="py-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

             <!-- Managed Users Section -->
             <div class="mt-8 bg-white p-6 rounded-lg shadow-lg border border-gray-200 relative">
                <h3 class="text-lg font-bold mb-4">Users You Manage</h3>
                <p class="text-sm text-gray-600 mb-4">Click on a user to view and check their clearance details.</p>
                <button onclick="window.open('{{ route('admin.generateReport') }}', '_blank')" class="absolute top-4 right-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Generate Report
                </button>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($managedUsers as $user)
                        @php
                            $userClearance = $user->userClearances->first();
                            $latestUpload = $userClearance ? $userClearance->uploadedClearances
                                ->where('is_archived', false)
                                ->sortByDesc('created_at')
                                ->first() : null;

                            $hasComplied = false;
                            if ($latestUpload) {
                                $feedback = $latestUpload->requirement->feedback
                                    ->where('user_id', $user->id)
                                    ->where('is_archived', false)
                                    ->first();
                                $hasComplied = $feedback &&
                                    $feedback->signature_status == 'Resubmit' &&
                                    $latestUpload->created_at > $feedback->updated_at;
                            }
                            
                            $firstClearanceId = $user->userClearances->isNotEmpty() ? $user->userClearances->first()->id : null;
                        @endphp

                          <a href="{{ $firstClearanceId ? route('admin.clearances.show', ['userId' => $user->id, 'clearanceId' => $firstClearanceId]) : '#'}}" class="flex items-center space-x-4 p-4 rounded-lg shadow hover:bg-gray-100 transition duration-300 relative
                            @if($hasComplied)
                                bg-blue-50
                            @elseif($user->clearances_status == 'complete')
                                bg-green-50
                            @elseif($user->clearances_status == 'pending')
                                bg-yellow-50
                            @elseif($user->clearances_status == 'return')
                                bg-red-50
                            @else
                                bg-gray-50
                            @endif">
                            @if (str_contains($user->profile_picture, 'http'))
                                <img src="{{ $user->profile_picture }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover">
                            @elseif ($user->profile_picture)
                                <img src="{{ url('/profile_pictures/' . basename($user->profile_picture)) }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover">
                            @else
                                <img src="{{ url('/images/default-profile.png') }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover">
                            @endif
                            <div class="min-w-0 flex-1 relative">
                                <h4 class="text-lg font-semibold truncate">{{ $user->name }}</h4>
                                <p class="text-sm text-gray-500 truncate max-w-full">{{ $user->email }}</p>
                                <p class="text-sm font-medium
                                    @if($hasComplied)
                                        text-blue-600
                                    @elseif($user->clearances_status == 'complete')
                                        text-green-600
                                    @elseif($user->clearances_status == 'pending')
                                        text-yellow-600
                                    @elseif($user->clearances_status == 'return')
                                        text-red-600
                                    @else
                                        text-gray-600
                                    @endif
                                ">
                                    @if($hasComplied)
                                        Return Complied
                                    @elseif($user->clearances_status == 'pending')
                                        In Progress
                                    @elseif($user->clearances_status == 'complete')
                                        Complied
                                    @elseif($user->clearances_status == 'return')
                                        Resubmit
                                    @else
                                        {{ ucfirst($user->clearances_status) }}
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500 mb-2">
                                    @if($latestUpload)
                                        Recent: {{ ucfirst($latestUpload->created_at->format('m/d/Y')) }}
                                    @else
                                        Recent: N/A
                                    @endif
                                </p>
                                <div class="user-clearance-link" data-user-id="{{ $user->id }}">
                                    <span class="user-badge hidden absolute top-0 right-0 bg-gradient-to-r from-red-500 to-pink-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center animate-bounce shadow-lg border-2 border-white transform hover:scale-110 transition-all duration-300 ease-in-out hover:shadow-xl"></span>
                                </div>
                            </div>

                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     let newUploadsPerUser = {};

        //     function checkForNewUploads() {
        //         fetch('/api/new-uploads-per-user')
        //             .then(response => response.json())
        //             .then(data => {
        //                 newUploadsPerUser = data;
        //                 document.querySelectorAll('.user-clearance-link').forEach(link => {
        //                     const userId = link.dataset.userId;
        //                     const badge = link.querySelector('.user-badge');
        //                     if (newUploadsPerUser[userId] > 0) {
        //                         badge.textContent = newUploadsPerUser[userId];
        //                         badge.classList.remove('hidden');
        //                     } else {
        //                         badge.classList.add('hidden');
        //                     }
        //                 });
        //             })
        //             .catch(error => console.error('Error fetching new uploads:', error));
        //     }

        //     // Initial check
        //     checkForNewUploads();
        // });

        document.addEventListener('DOMContentLoaded', function() {
            function fetchNotificationCounts() {
                fetch('/notifications/counts')
                    .then(response => response.json())
                    .then(data => {
                        document.querySelectorAll('.user-clearance-link').forEach(link => {
                            const userId = link.dataset.userId;
                            const badge = link.querySelector('.user-badge');
                            if (data[userId] > 0) {
                                badge.textContent = data[userId];
                                badge.classList.remove('hidden');
                            } else {
                                badge.classList.add('hidden');
                            }
                        });
                    })
                    .catch(error => console.error('Error fetching notification counts:', error));
            }

            // Initial fetch
            fetchNotificationCounts();

            // Optionally, refresh counts periodically
            setInterval(fetchNotificationCounts, 60000); // Every 1 minute
        });
    </script>

</x-admin-layout>
