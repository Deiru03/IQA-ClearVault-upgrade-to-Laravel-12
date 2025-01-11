<x-office-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Quick Actions -->
            <div class="mt-0 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('profile.edit') }}" class="bg-gradient-to-br from-green-400 to-green-600 text-white p-6 rounded-xl shadow-md relative hover:shadow-xl transition duration-300 ease-in-out cursor-pointer transform hover:-translate-y-1">
                    <div class="relative z-10">
                        <h3 class="text-xl font-bold mb-1">Profile</h3>
                        <p class="text-sm mt-2 text-green-100">View and edit your profile information</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 absolute bottom-2 right-2 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>

                <a href="{{ route('faculty.views.clearances') }}" class="bg-gradient-to-br from-purple-400 to-purple-600 text-white p-6 rounded-xl shadow-md relative hover:shadow-xl transition duration-300 ease-in-out cursor-pointer transform hover:-translate-y-1">
                    <div class="relative z-10">
                        <h3 class="text-xl font-bold mb-1">View Checklist</h3>
                        <p class="text-sm mt-2 text-purple-100">Check your clearance and uploaded files</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 absolute bottom-2 right-2 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </a>

                <a href="{{ route('faculty.views.myFiles') }}" class="bg-gradient-to-br from-blue-400 to-blue-600 text-white p-6 rounded-xl shadow-md relative hover:shadow-xl transition duration-300 ease-in-out cursor-pointer transform hover:-translate-y-1">
                    <div class="relative z-10">
                        <h3 class="text-xl font-bold mb-1">Manage My Files</h3>
                        <p class="text-sm mt-2 text-blue-100">View and manage your uploaded files</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 absolute bottom-2 right-2 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </a>

                <a href="{{ route('faculty.views.submittedReports') }}" class="bg-gradient-to-br from-yellow-400 to-yellow-600 text-white p-6 rounded-xl shadow-md relative hover:shadow-xl transition duration-300 ease-in-out cursor-pointer transform hover:-translate-y-1">
                    <div class="relative z-10">
                        <h3 class="text-xl font-bold mb-1">Submitted History</h3>
                        <p class="text-sm mt-2 text-yellow-100">View your submission history</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 absolute bottom-2 right-2 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </a>
            </div>

            <!-- New Clearance Status Overview -->
            <div class="mt-8 bg-white overflow-hidden shadow-lg rounded-xl">
                <div class="p-8">
                    <h3 class="text-2xl font-bold mb-8 text-indigo-800 border-b-2 border-indigo-100 pb-3">Clearance Status Overview</h3>

                    <!-- Completion Rate Bar -->
                    <div class="mb-10">
                        <h4 class="font-semibold text-lg mb-4 text-gray-700">Completion Rate</h4>
                        <div class="w-full bg-gray-100 rounded-full h-6 p-1">
                            <div class="bg-gradient-to-r from-green-400 to-green-600 h-4 rounded-full transition-all duration-500" style="width: {{ $completionRate }}%;"></div>
                        </div>
                        <div class="flex items-center justify-between mt-3">
                            <p class="text-sm font-medium text-gray-600">{{ $completionRate }}% completed</p>
                            @if($completionRate == 100)
                                <a href="{{ route('faculty.generateClearanceReport') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-400 to-green-600 text-white text-sm font-medium rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Generate Clearance Slip
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
                            <h4 class="font-semibold text-lg mb-6 text-gray-700">Requirements Breakdown</h4>
                            <div class="relative" style="height: 300px;">
                                <canvas id="requirementsChart"></canvas>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
                            <h4 class="font-semibold text-lg mb-6 text-gray-700">Completion Progress</h4>
                            <div class="relative" style="height: 300px;">
                                <canvas id="progressChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Requirements Breakdown Chart
                    var ctx1 = document.getElementById('requirementsChart').getContext('2d');
                    new Chart(ctx1, {
                        type: 'doughnut',
                        data: {
                            labels: ['Uploaded', 'Missing', 'Resubmit'],
                            datasets: [{
                                data: [{{ $uploadedRequirements }}, {{ $missingRequirements }}, {{ $returnedDocuments }}],
                                backgroundColor: ['#10B981', '#FBBF24', '#EF4444'],
                                borderColor: ['#fff', '#fff', '#fff'],
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });

                    // Completion Progress Chart
                    var ctx2 = document.getElementById('progressChart').getContext('2d');
                    new Chart(ctx2, {
                        type: 'bar',
                        data: {
                            labels: ['Total', 'Uploaded', 'Missing', 'Resubmit'],
                            datasets: [{
                                label: 'Requirements',
                                data: [{{ $totalRequirements }}, {{ $uploadedRequirements }}, {{ $missingRequirements }}, {{ $returnedDocuments }}],
                                backgroundColor: ['#6366F1', '#10B981', '#FBBF24', '#EF4444'],
                                borderColor: ['#4F46E5', '#059669', '#D97706', '#DC2626'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }
                            }
                        }
                    });
                });
            </script>

            <!-- Modal for First-Time Users -->
            @if($showProfileModal)
                <div id="profileModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
                    <div class="bg-white p-8 rounded-xl shadow-2xl max-w-md mx-auto transform transition-all duration-300 ease-in-out hover:scale-105">
                        <h3 class="text-2xl font-bold mb-6 text-indigo-600">Complete Your Profile</h3>
                        <p class="mb-6 text-gray-600 leading-relaxed">Please update your profile with your program and position information to enhance your experience.</p>
                        <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">
                            <a href="{{ route('profile.edit') }}" class="w-full sm:w-auto bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                                Edit Profile
                            </a>
                            <button onclick="closeModal()" class="w-full sm:w-auto bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-md">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
                <script>
                    function closeModal() {
                        document.getElementById('profileModal').style.display = 'none';
                    }
                </script>
            @endif
                   
            <!-- Notification for No Active Clearance -->
            @if($noActiveClearance)
                <div id="clearanceModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
                    <div class="bg-white p-8 rounded-xl shadow-2xl max-w-md mx-auto transform transition-all duration-300 ease-in-out hover:scale-105">
                        <h3 class="text-2xl font-bold mb-6 text-red-600">No Active Clearance</h3>
                        <p class="mb-6 text-gray-600 leading-relaxed">You currently do not have an active clearance. Please contact your administrator.</p>
                        <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">
                            <button onclick="closeClearanceModal()" class="w-full sm:w-auto bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-md">
                                Close
                            </button>
                            <a href="{{ route('faculty.views.clearances') }}" class="w-full sm:w-auto bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-md">
                                Get A Copy
                            </a>
                        </div>
                    </div>
                </div>

                <script>
                    function closeClearanceModal() {
                        document.getElementById('clearanceModal').style.display = 'none';
                    }
                </script>
            @endif
        </div>
    </div>
</x-office-layout>
