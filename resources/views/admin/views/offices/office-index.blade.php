<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Offices Management') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="mb-8 flex justify-between items-center">
            <h2 class="text-3xl font-bold text-gray-800">Manage Offices</h2>
            <div>
                <button onclick="openModal('officeModal')"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full mr-4 transition duration-300 ease-in-out transform hover:scale-105">
                    Add Office
                </button>
            </div>
        </div>

        <!-- Session Status -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p class="font-bold">Error</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif
        <!-- Floating Notification -->
        <div id="notification"
            class="fixed top-10 right-0 transform transition-transform duration-300 ease-in-out z-50 max-w-sm w-full bg-gray-800 rounded-lg shadow-xl border-l-4 overflow-hidden {{ session('success') || session('error') ? '' : 'translate-x-full' }}">
            <div class="p-4 flex items-center">
                <div id="notificationIcon"
                    class="flex-shrink-0 {{ session('success') ? 'text-emerald-400' : 'text-rose-400' }}">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3 w-0 flex-1">
                    <p id="notificationMessage" class="text-sm font-medium text-gray-100">
                        {{ session('success') ?? session('error') }}
                    </p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button onclick="this.closest('#notification').classList.add('translate-x-full')"
                        class="inline-flex text-gray-300 hover:text-gray-100">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="animate-progress h-1 {{ session('success') ? 'bg-emerald-400' : 'bg-rose-400' }}"
                style="width: 100%"></div>
        </div>

        <style>
            @keyframes progress {
                from {
                    width: 100%;
                }

                to {
                    width: 0%;
                }
            }

            .animate-progress {
                animation: progress 3s linear;
            }
        </style>

        @if (session('success') || session('error'))
            <script>
                setTimeout(() => {
                    document.getElementById('notification').classList.add('translate-x-full');
                }, 3000);
            </script>
        @endif

          <!-- Analytics Section -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            <!-- Office Distribution -->
            <div class="bg-white p-6 rounded-lg shadow-lg border-2 border-indigo-200">
                <h3 class="text-lg font-bold mb-4">Office Distribution</h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="officeChart"></canvas>
                </div>
            </div>

            <!-- Staff per Office -->
            <div class="bg-white p-6 rounded-lg shadow-lg border-2 border-indigo-200">
                <h3 class="text-lg font-bold mb-4">Staff per Office</h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="staffChart"></canvas>
                </div>
            </div>

            <!-- Office Activity -->
            <div class="bg-white p-6 rounded-lg shadow-lg border-2 border-indigo-200">
                <h3 class="text-lg font-bold mb-4">Office Activity</h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Include Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Office Distribution Chart
                const officeCtx = document.getElementById('officeChart').getContext('2d');
                const officeChart = new Chart(officeCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Office 1', 'Office 2', 'Office 3'], // Replace with dynamic data
                        datasets: [{
                            label: 'Office Distribution',
                            data: [10, 20, 30], // Replace with dynamic data
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                        }]
                    },
                    options: {
                        responsive: true,
                    }
                });

                // Staff per Office Chart
                const staffCtx = document.getElementById('staffChart').getContext('2d');
                const staffChart = new Chart(staffCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Office 1', 'Office 2', 'Office 3'], // Replace with dynamic data
                        datasets: [{
                            label: 'Staff per Office',
                            data: [5, 10, 15], // Replace with dynamic data
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                        }]
                    },
                    options: {
                        responsive: true,
                    }
                });

                // Office Activity Chart
                const activityCtx = document.getElementById('activityChart').getContext('2d');
                const activityChart = new Chart(activityCtx, {
                    type: 'line',
                    data: {
                        labels: ['January', 'February', 'March'], // Replace with dynamic data
                        datasets: [{
                            label: 'Office Activity',
                            data: [30, 50, 70], // Replace with dynamic data
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        responsive: true,
                    }
                });
            });
        </script>

        <!-- Offices List -->
        <div class="bg-white shadow-md border border-gray-200 rounded-lg overflow-hidden mt-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @foreach ($Offices as $office)
                    <div
                        class="bg-gradient-to-br from-white to-gray-100 rounded-lg p-6 hover:shadow-xl transition duration-300 transform hover:-translate-y-1 border border-gray-200 hover:bg-gradient-to-br hover:from-blue-50 hover:to-indigo-50">
                        <div class="flex items-center mb-4">
                            <div
                                class="bg-yellow-100 rounded-full p-3 mr-4 border-2 border-yellow-300 transition-colors duration-300 group-hover:bg-blue-100 group-hover:border-blue-300">
                                @if($office->profile_picture)
                                    <img src="{{ url('/office_pictures/' . basename($office->profile_picture)) }}" alt="{{ asset('images/default-office.jpg') }}" class="h-16 w-16 rounded-full object-cover">
                                @else
                                    <img src="{{ asset('images/default-office.jpg') }}" alt="Office Picture" class="h-16 w-16 rounded-full object-cover">
                                @endif
                            </div>
                            <div>
                                <h3
                                    class="text-xl font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors duration-300">
                                    {{ $office->name ?? 'Office Name' }}</h3>
                                <p
                                    class="text-sm text-gray-600 group-hover:text-indigo-400 transition-colors duration-300">
                                    {{ $office->staff_count ?? '0' }} staff members</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="openOfficeModal('{{ $office->id ?? '' }}')"
                                class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-3 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center shadow-md hover:bg-gradient-to-r hover:from-indigo-500 hover:to-purple-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                <span class="ml-1">View</span>
                            </button>
                            <button onclick="openConfirmModal('destroy', '{{ $office->id ?? '' }}')"
                                class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-3 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center shadow-md hover:bg-gradient-to-r hover:from-red-500 hover:to-pink-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                <span class="ml-1">Remove</span>
                            </button>
                            {{-- "window.location.href='{{ route('admin.editOffice', ['id' => $office->id ?? '']) }}'" --}}
                            <button onclick="openEditOfficeModal('{{ $office->id ?? '' }}')"
                                class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-3 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center shadow-md hover:bg-gradient-to-r hover:from-yellow-500 hover:to-orange-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                <span class="ml-1">Edit</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Add Office Modal -->
    <div id="officeModal"
        class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden z-10 transition-opacity duration-300" style="z-index: 50">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Add New Office</h2>
                <button onclick="closeModal('officeModal')" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.office.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Profile Picture Upload -->
                <div class="flex flex-col items-center mb-6">
                    <div class="relative w-32 h-32 mb-4">
                        <img id="preview" src="{{ asset('images/default-office.jpg') }}" 
                             class="w-full h-full object-cover rounded-full border-4 border-indigo-200">
                        <label for="profile_picture" 
                               class="absolute bottom-0 right-0 bg-indigo-600 p-2 rounded-full cursor-pointer hover:bg-indigo-700 transition-colors">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </label>
                        <input type="file" id="profile_picture" name="profile_picture" class="hidden" 
                               accept="image/*" onchange="previewImage(event)">
                    </div>
                    <span class="text-sm text-gray-500">Upload office logo or image</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="name" class="text-sm font-medium text-gray-700">Office Name</label>
                        <input type="text" name="name" id="name"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all"
                            required placeholder="Enter office name">
                    </div>

                    <div class="space-y-2">
                        <label for="campus_id" class="text-sm font-medium text-gray-700">Campus Designation</label>
                        <select name="campus_id" id="campus_id"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all"
                            required>
                            <option value="">Select a Campus</option>
                            @foreach (\App\Models\Campus::all() as $campus)
                                <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="description" class="text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all"
                        placeholder="Enter office description"></textarea>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeModal('officeModal')"
                        class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition-all">
                        Add Office
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Office Modal --}}
    <div id="editOfficeModal"
        class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden z-10 transition-opacity duration-300" style="z-index: 50">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Edit Office</h2>
                <button onclick="closeModal('editOfficeModal')" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form method="POST" id="editOfficeForm" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="flex flex-col items-center mb-6">
                    <div class="relative w-32 h-32 mb-4">
                        <img id="editPreview" src="{{ asset('images/default-office.jpg') }}" 
                             class="w-full h-full object-cover rounded-full border-4 border-indigo-200">
                        <label for="edit_profile_picture" 
                               class="absolute bottom-0 right-0 bg-indigo-600 p-2 rounded-full cursor-pointer hover:bg-indigo-700 transition-colors">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </label>
                        <input type="file" id="edit_profile_picture" name="profile_picture" class="hidden" 
                               accept="image/*" onchange="previewEditImage(event)">
                    </div>
                    <span class="text-sm text-gray-500">Update office logo or image</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="edit_name" class="text-sm font-medium text-gray-700">Office Name</label>
                        <input type="text" name="name" id="edit_name"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all"
                            required>
                    </div>

                    <div class="space-y-2">
                        <label for="edit_campus_id" class="text-sm font-medium text-gray-700">Campus Designation</label>
                        <select name="campus_id" id="edit_campus_id"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all"
                            required>
                            <option value="">Select a Campus</option>
                            @foreach (\App\Models\Campus::all() as $campus)
                                <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="edit_description" class="text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="edit_description" rows="4"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all"></textarea>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeModal('editOfficeModal')"
                        class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition-all">
                        Update Office
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('preview');
            preview.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
    </script>

    <!-- Confirmation Modal -->
    <div id="confirmModal"
        class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-70 hidden z-20 transition-opacity duration-300" style="z-index: 100">
        <div class="bg-white p-6 rounded-lg shadow-md max-w-sm w-full">
            <h3 class="text-xl font-bold mb-4">Confirm Deletion</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to remove this office? This action cannot be undone.
            </p>
            <div class="flex justify-end space-x-4">
                <button onclick="closeModal('confirmModal')"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Add your JavaScript functions here
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function openConfirmModal(action, id) {
            const form = document.getElementById('deleteForm');
            form.action = `/admin/Office-Delete/${id}`;
            openModal('confirmModal');
        }

        function openEditOfficeModal(id) {
            fetch(`/admin/admin/Office-Edit/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_name').value = data.name;
                    document.getElementById('edit_campus_id').value = data.campus_id;
                    document.getElementById('edit_description').value = data.description;
                    document.getElementById('editPreview').src = data.profile_picture ? data.profile_picture : '/images/default-office.jpg';
                    
                    const form = document.getElementById('editOfficeForm');
                    form.action = `/admin/admin/Office-Update/${id}`;
                    
                    openModal('editOfficeModal');
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error loading office data', 'error');
                });
        }

        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            const notificationMessage = document.getElementById('notificationMessage');
            const notificationIcon = document.getElementById('notificationIcon');

            notificationMessage.textContent = message;
            notification.classList.remove('hidden', 'bg-green-500', 'bg-red-500');
            notification.classList.add(type === 'success' ? 'bg-green-500' : 'bg-red-500');
            notification.classList.remove('translate-x-full');

            setTimeout(() => {
                notification.classList.add('translate-x-full');
            }, 3000);
        }
    </script>
</x-admin-layout>
