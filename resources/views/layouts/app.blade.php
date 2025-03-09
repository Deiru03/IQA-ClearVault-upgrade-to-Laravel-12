<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Dashboard') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script src="//unpkg.com/alpinejs" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <style>
         .profile-picture {
            width: 40px; /* Adjust size as needed */
            height: 40px;
            border-radius: 50%; /* Make it circular */
            object-fit: cover; /* Ensure the image covers the area */
            margin-right: 10px; /* Space between image and text */
        }
        .profile-section {
            display: flex;
            align-items: center;
            padding: 10px;
        }
        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 50;
        }

        #notificationDropdown {
            font-size: 11px;
            right: 0;
            top: 40;
            width: 500px;
            max-height: 400px;
            overflow-y: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            /* bring-to-front: 100; */
        }

        #notificationList li {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
            transition: background-color 0.2s;
        }

        #notificationList li:hover {
            background-color: #f7fafc;
        }

        .notification-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            background-color: #cce0f5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #4a5568;
        }

        .notification-content {
            flex: 1;
        }

        .notification-time {
            font-size: 12px;
            color: #a0aec0;
        }
    </style>

    @php
        $userId = Auth::id();
        $totalSize = 0;

        $uploadedClearances = \App\Models\UploadedClearance::where('user_id', $userId)->get();

        foreach ($uploadedClearances as $clearance) {
            $filePath = storage_path('app/public/' . $clearance->file_path);
            if (file_exists($filePath)) {
                $totalSize += filesize($filePath);
            }
        }

        $storageSize = $totalSize;
    @endphp

    <body class="font-sans antialiased" x-data="{ showUserFeedbackModal: false }">
        {{-- <div id="notification"
            class="fixed top-10 right-0 transform transition-transform duration-300 ease-in-out z-50 max-w-sm w-full bg-gray-800 rounded-lg shadow-xl border-l-4 overflow-hidden {{ session('success') || session('error') ? '' : 'translate-x-full' }}" style="z-index: 150;">
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
        </div> --}}

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

        <div class="min-h-screen bg-gray-100 flex">
            <div x-show="showUserFeedbackModal" 
                class="hidden fixed inset-0 flex items-center justify-center bg-gray-900/10 backdrop-blur-sm z-50 p-4" 
                style="z-index: 100;" 
                id="userFeedbackModal"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-10 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-10 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95">
                
                <div class="bg-white rounded-2xl shadow-2xl p-4 w-full max-w-lg max-h-[90vh] overflow-y-auto transform transition-all"
                    @click.away="showUserFeedbackModal = false">
                    
                    <!-- Header -->
                    <div class="sticky top-0 bg-gradient-to-r from-indigo-600 via-purple-500 to-indigo-600 z-10 rounded-xl shadow-lg">
                        <div class="flex justify-between items-center p-6">
                            <div class="flex items-center space-x-4">
                                <div class="p-2 bg-white/20 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                        class="h-8 w-8 text-white transform transition-transform hover:scale-110 duration-200" 
                                        fill="none" 
                                        viewBox="0 0 24 24" 
                                        stroke="currentColor">
                                        <path stroke-linecap="round" 
                                            stroke-linejoin="round" 
                                            stroke-width="2" 
                                            d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-white tracking-wide">User Feedback</h2>
                                    <p class="text-indigo-100 text-sm">Share your thoughts with us</p>
                                </div>
                            </div>
                            
                            <button @click="showUserFeedbackModal = false" 
                                class="p-2 hover:bg-white/20 rounded-lg transition-all duration-200 group"
                                id="closeUserFeedbackModal">
                                <svg class="w-6 h-6 text-white group-hover:rotate-90 transition-transform duration-300" 
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" 
                                        stroke-linejoin="round" 
                                        stroke-width="2" 
                                        d="M6 18L18 6M6 6l12 12">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="mt-6 p-6 rounded-xl bg-gradient-to-b from-gray-50 to-white border border-indigo-100 shadow-inner">
                        @include('components.Feedbacks.UserFeedbackForm')
                    </div>

                    <!-- Footer -->
                    <div class="mt-6 px-6 py-4 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-sm text-gray-500 text-center">
                            Your feedback helps us improve our system. Thank you for your contribution!
                        </p>
                    </div>
                </div>
            </div>
            <!-- Sidebar -->
            <div class="w-60 bg-gray-800 text-white h-screen fixed z-10 overflow-y-auto">
                {{-- <div class="profile-section">
                    @if(Auth::check())
                        @if(Auth::user()->profile_picture)
                            <img src="{{ Auth::user()->profile_picture }}" alt="Profile Picture" class="h-9 w-9 rounded-full mr-2">
                        @else
                            <div class="h-9 w-9 rounded-full mr-2 flex items-center justify-center text-white font-bold" style="background-color: {{ '#' . substr(md5(Auth::user()->name), 0, 6) }};">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <span class="text-lg font-semibold">{{ Auth::user()->name }}</span>
                    @endif
                    {{-- <img src="{{ asset('images/OMSCLogo.png') }}" alt="Logo" class="h-12 w-12 mr-2">
                    <span class="text-lg font-semibold">{{ Auth::user()->name }}</span> --}
                </div> --}}
                <a href="{{ route('faculty.home') }}" class="block hover:bg-gray-700 rounded-lg transition duration-300 ease-in-out">
                    <div class="flex flex-col items-center p-4">
                        <img src="{{ asset('images/OMSCLogo.png') }}" alt="OMSC Logo" class="w-16 h-16 mb-3">
                        <p class="text-sm text-gray-400 text-center group-hover:text-indigo-300 transition duration-150 ease-in-out">
                            Welcome to the OMSC Faculty Dashboard
                        </p>
                        <p class="text-xs text-gray-500 mt-2 text-center group-hover:text-indigo-300 transition duration-150 ease-in-out">
                            Manage clearances, view reports, and access files with ease.
                        </p>
                    </div>
                </a>
                <nav class="mt-0">

                    <!-- Storage Used -->
                    <div class="px-4 py-2">
                        <div class="bg-gray-700 rounded-lg p-3 hover:bg-gray-600 transition-all duration-200">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                                </svg>
                                @php
                                    $storageSiz = $storageSize;
                                    $sizeInMB = $storageSiz / (1024 * 1024);
                                    if($sizeInMB >= 1024) {
                                        $size = number_format($sizeInMB / 1024, 2) . ' GB';
                                    } else {
                                        $size = number_format($sizeInMB, 2) . ' MB';
                                    }
                                @endphp
                                <span class="text-gray-300 text-sm">Your Storage Used: 
                                    <span class="text-indigo-400 font-medium block text-center">{{ $size }}</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('faculty.dashboard') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M12 3l9 9-9 9-9-9 9-9z" />
                        </svg>
                        <span class="{{ request()->routeIs('dashboard') ? 'text-indigo-300 font-semibold' : '' }}">Dashboard</span>
                    </a>

                    <!-- Clearances -->
                    <div x-data="{ clearancesOpen: {{ request()->routeIs('faculty.views.clearances') || request()->routeIs('faculty.clearances.index') ? 'true' : 'false' }} }">
                        <div class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('faculty.views.clearances') || request()->routeIs('faculty.clearances.index') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                            <a href="{{ route('faculty.views.clearances') }}" class="flex-1 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                </svg>
                                <span class="{{ request()->routeIs('faculty.views.clearances') || request()->routeIs('faculty.clearances.index') ? 'text-indigo-300 font-semibold' : '' }}">Clearance</span>
                            </a>
                            <button @click.stop="clearancesOpen = !clearancesOpen" class="ml-auto">
                                <svg :class="{'rotate-90': clearancesOpen}" class="h-5 w-5 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <div x-show="clearancesOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="pl-16">
                            <a href="{{ route('faculty.views.clearances') }}" class="flex items-center px-4 py-2 text-sm hover:bg-gray-700 {{ request()->routeIs('faculty.views.clearances') ? 'bg-gray-700 text-indigo-300' : 'text-gray-300' }}">
                                <span>View Clearance</span>
                            </a>
                            <a href="{{ route('faculty.clearances.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-gray-700 {{ request()->routeIs('faculty.clearances.index') ? 'bg-gray-700 text-indigo-300' : 'text-gray-300' }}">
                                <span>Clearance Checklists</span>
                            </a>
                        </div>
                    </div>

                    <!-- Submitted Reports -->
                    <a href="{{ route('faculty.views.submittedReports') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('faculty.views.submittedReports') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                        </svg>
                        <span class="{{ request()->routeIs('faculty.views.submittedReports') ? 'text-indigo-300 font-semibold' : '' }}">History of Reports</span>
                    </a>

                    <!-- My Submitted Files -->
                    <a href="{{ route('faculty.views.myFiles') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('faculty.views.myFiles') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                        </svg>
                        <span class="{{ request()->routeIs('faculty.views.myFiles') ? 'text-indigo-300 font-semibold' : '' }}">My Submitted Files</span>
                    </a>

                     <!-- Archive -->
                     <a href="{{ route('faculty.views.archive') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('faculty.views.archive') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                        <span class="{{ request()->routeIs('faculty.views.archive') ? 'text-indigo-300 font-semibold' : '' }}">Archive</span>
                    </a>

                    <!-- Test Page -->
                    {{-- <a href="{{ route('faculty.views.test') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('faculty.views.test') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                        </svg>
                        <span class="{{ request()->routeIs('faculty.views.test') ? 'text-indigo-300 font-semibold' : '' }}">Test Page</span>
                    </a> --}}

                    <!-- Profile -->
                    <a href="{{ route('profile.edit') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('profile.edit') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <span class="{{ request()->routeIs('profile.edit') ? 'text-indigo-300 font-semibold' : '' }}">Profile</span>
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="flex items-center w-full">
                        @csrf
                        <button type="submit" class="flex items-center w-full text-left px-10 py-4 hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </nav>

                <!-- About Us -->
                <a href="{{ route('about-us') }}" class="flex items-center px-10 py-4 hover:bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 {{-- request()->routeIs('about.us') ? 'bg-gradient-to-r from-indigo-500 to-purple-600 border-l-4 border-indigo-500' : '' --}} transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span class="{{ request()->routeIs('about.us') ? 'text-white font-semibold' : '' }}">About Us</span>
                </a>
            </div>

            <div class="flex-1 ml-60"> <!-- Added margin-left to prevent content from being behind the sidebar -->
                <!-- Page Content -->
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                <header class="bg-white shadow sticky-header">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <button onclick="window.history.back()" class="mr-4 text-gray-600 hover:text-gray-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                                    </svg>
                                </button>
                                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                    {{ $header }} <!-- Use the header variable -->
                                </h2>
                            </div>

                            <!-- Date and Time -->
                            <div class="text-center -mt-3">
                                <h4>{{ date('F d, Y') }}</h4>
                                <span> {{ date( 'l' )}} </span><span id="currentTime">{{ date('h:i A') }}</span>
                                <script>
                                    function updateTime() {
                                        const timeElement = document.getElementById('currentTime');
                                        const now = new Date();
                                        timeElement.textContent = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
                                    }
                                    // Update time immediately and then every minute
                                    updateTime();
                                    setInterval(updateTime, 60000);
                                </script>
                            </div>

                            <div class="flex items-center space-x-4">
                                 <!-- Feedback Button -->
                                 <button @click="showUserFeedbackModal = true" id="feedbackButton"
                                    class="hover:bg-gray-100 p-2 rounded-full transition-colors duration-200 relative group">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                                        class="w-6 h-6 text-gray-600 hover:text-indigo-600 transition-colors duration-200"
                                        onmouseover="this.style.transform='scale(1.1)'" 
                                        onmouseout="this.style.transform='scale(1)'">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                    </svg>
                                    <span class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                        Add Feedback
                                    </span>
                                </button>

                                <script>
                                    // Feedback Modal
                                    const feedbackModal = document.getElementById('userFeedbackModal');
                                    const feedbackButton = document.getElementById('feedbackButton');
                                    const closeButton = document.getElementById('closeFeedbackModal');

                                    feedbackButton.addEventListener('click', () => {
                                        feedbackModal.classList.remove('hidden');
                                    });

                                    closeButton.addEventListener('click', () => {
                                        feedbackModal.classList.add('hidden');
                                    });
                                </script>

                                <!-- Tutorial Button -->
                                <button id="tutorialBtn" class="text-gray-600 hover:text-gray-900 transition-colors duration-200 hover:scale-110 relative group ml-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 0 1 0 1.972l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z" />
                                    </svg>
                                    <span class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                        Watch Tutorial
                                    </span>
                                </button>

                                <!-- Overview Link -->
                                <a href="{{ route('faculty.overview') }}" class="text-gray-600 hover:text-gray-900 transition-colors duration-200 hover:scale-110 relative group">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                    </svg>
                                    <span class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                        Overview of the System
                                    </span>
                                </a>
                                
                                <!-- Notification Bell -->
                                <div class="notification-div relative" style="position: relative; top: 0px; right: 0px;">
                                    <button id="notificationBell" class="relative text-gray-600 hover:bg-gray-100 p-2 rounded-full transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hover:text-indigo-600 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
                                        </svg>
                                        <span id="notificationCount" class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center hidden animate-bounce">0</span>
                                    </button>
                                    <div id="notificationDropdown" class="absolute right-0 mt-2 w-[300px] bg-white border border-gray-200 rounded-lg shadow-lg hidden hover:shadow-xl transition-shadow duration-200">
                                        <ul id="notificationList" class="p-2">
                                            <!-- Notifications will be appended here -->
                                        </ul>
                                    </div>
                                </div>

                                <!-- User Dropdown -->
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                            @if(Auth::user()->profile_picture)
                                                @if (str_contains(Auth::user()->profile_picture, 'http'))
                                                    <img src="{{ Auth::user()->profile_picture }}" alt="Profile Picture" class="h-6 w-6 rounded-full mr-2">
                                                @else
                                                    <img src="{{ url('/profile_pictures/' . basename(Auth::user()->profile_picture)) }}" alt="Profile Picture" class="h-6 w-6 rounded-full mr-2">
                                                @endif
                                            @else
                                                <div class="h-6 w-6 rounded-full mr-2 flex items-center justify-center text-white font-bold" style="background-color: {{ '#' . substr(md5(Auth::user()->name), 0, 6) }};">
                                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                {{ Auth::user()->name }}
                                                (<span class="@if(Auth::user()->user_type === 'Admin' && !Auth::user()->campus_id) text-red-600 font-semibold @elseif(Auth::user()->user_type === 'Admin') text-blue-600 font-semibold @elseif(Auth::user()->user_type === 'Program-Head') text-emerald-600 font-semibold @elseif(Auth::user()->user_type === 'Dean') text-amber-600 font-semibold @else text-gray-600 font-semibold @endif">
                                                    {{ Auth::user()->user_type === 'Admin' && !Auth::user()->campus_id ? 'Super Admin' : Auth::user()->user_type }}
                                                </span>)
                                            </div>
                                            <div class="ms-1">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('profile.edit')"
                                            class="hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-150">
                                            {{ __('Profile') }}
                                        </x-dropdown-link>

                                        @foreach(Auth::user()->availableRoles() as $role)
                                            @if($role !== Auth::user()->user_type)
                                                <form method="POST" action="{{ route('switchRole') }}">
                                                    @csrf
                                                    <input type="hidden" name="role" value="{{ $role }}">
                                                    <x-dropdown-link :href="route('switchRole')"
                                                            class="hover:bg-green-50 hover:text-green-600 transition-colors duration-150"
                                                            onclick="event.preventDefault();
                                                                        this.closest('form').submit();">
                                                        {{ __('Switch to ' . $role) }}
                                                    </x-dropdown-link>
                                                </form>
                                            @endif
                                        @endforeach

                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                class="hover:bg-red-50 hover:text-red-600 transition-colors duration-150"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>
                    </div>
                </header>
                @endisset

                <!-- Page Content -->
                <main class="min-h-screen overflow-x-hidden">
                    <div class="py-12">
                        <div class="{{--max-w-7xl--}}max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-gray-900">
                                    {{ $slot }}
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="bg-white py-6 mt-auto">
                    <div class="container mx-auto px-4 text-center text-gray-800">
                        <p class="text-sm">&copy; 2024 OMSCS IQA ClearVault.</p>
                        <div class="flex flex-wrap justify-center gap-4 mt-4">
                            <a href="#" class="hover:text-indigo-400">Privacy Policy</a>
                            <a href="#" class="hover:text-indigo-400">Terms of Service</a>
                            <a href="#" class="hover:text-indigo-400">Contact Us</a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <!-- Tutorial Video Modal -->
        <div id="videoModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
            <div class="bg-white/5 backdrop-blur-lg p-6 rounded-lg shadow-lg w-full max-w-5xl mx-4">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-light text-white">System Tutorial - Creating Account</h2>
                    <button onclick="closeVideoModal()" class="text-white/60 hover:text-white text-4xl">
                        &times;
                    </button>
                </div>
                <div class="relative" style="padding-bottom: 56.25%;">
                    <!-- Using local MP4 video file instead of YouTube embed -->
                    <video id="tutorialVideo" class="absolute inset-0 w-full h-full rounded-lg" 
                            controls
                            preload="metadata">
                        <source src="{{ asset('images/guide-video/Upload_Clearance_Faculty.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <p class="text-white/80 mt-4 text-sm">Learn how to create an account and get started with IQA ClearVault system.</p>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded',function() {
               fetchNotifications();
                document.getElementById('notificationBell').addEventListener('click', function() {
                   const dropdown = document.getElementById('notificationDropdown');
                   dropdown.classList.toggle('hidden');
               });
           });
            function fetchNotifications() {
               fetch('/api/notifications/unread-faculty') // Adjust the URL to match your route
                   .then(response => response.json())
                   .then(data => {
                       updateNotificationUI(data);
                   })
                   .catch(error => console.error('Error fetching notifications:', error));
           }

            // Fetch immediately when page loads
            fetchNotifications();

            // Set up regular interval for fetching notifications
            let notificationInterval = setInterval(fetchNotifications, 15000);

            // Expose function to refresh notifications after marking as read
            window.refreshNotificationsAfterMark = function() {
                // Clear existing interval
                clearInterval(notificationInterval);

                // Fetch immediately
                fetchNotifications();

                // Wait 2 seconds then fetch again
                setTimeout(() => {
                    fetchNotifications();
                    // Restart regular interval
                    notificationInterval = setInterval(fetchNotifications, 15000);
                }, 300);
            };


            function updateNotificationUI(notifications) {
               const notificationCount = document.getElementById('notificationCount');
               const notificationList = document.getElementById('notificationList');
                // Update notification count
               if (notifications.length > 0) {
                   notificationCount.textContent = notifications.length;
                   notificationCount.classList.remove('hidden');
               } else {
                   notificationCount.classList.add('hidden');
               }

                 // Clear existing notifications
                notificationList.innerHTML = '';

                if (notifications.length > 0) {
                    notifications.forEach(notification => {
                        const listItem = document.createElement('li');
                        listItem.classList.add('flex', 'items-center', 'p-2', 'border-b', 'border-gray-200', 'hover:bg-gray-100', 'text-gray-700', 'text-[11px]');
                        listItem.innerHTML = `
                            <div class="notification-avatar">${notification.admin_user_name.charAt(0)}</div>
                            <div class="notification-content hover:text-indigo-600" onclick="markNotificationAsRead(${notification.id}); window.location.href='{{ route('faculty.views.clearances') }}';">
                                <p class="font-bold text-black">${notification.admin_user_name}</p>
                                <p style="font-weight: bold;">${notification.notification_type}</p>
                                <p>${notification.notification_message}</p>
                                <p class="notification-time">${new Date(notification.created_at).toLocaleTimeString()}</p>
                            </div>
                            <button onclick="markNotificationAsRead(${notification.id})" class="text-blue-500 text-xs border-2 border-blue-500 rounded-md px-2 py-1 hover:bg-blue-500 hover:text-white transition-colors duration-200">Mark as Read</button>
                        `;
                        notificationList.appendChild(listItem);
                    });
                } else {
                    const listItem = document.createElement('li');
                    listItem.classList.add('p-2', 'text-gray-500');
                    listItem.textContent = 'No new notifications';
                    notificationList.appendChild(listItem);
                }
            }

            // Mark Notification as Read
            function markNotificationAsRead(notificationId) {
                fetch(`/notifications/${notificationId}/mark-as-read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the notification from the UI
                        const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
                        if (notificationElement) {
                            notificationElement.remove();
                        }

                        // Update notification count
                        const notificationCount = document.getElementById('notificationCount');
                        const currentCount = parseInt(notificationCount.textContent);
                        if (currentCount > 1) {
                            notificationCount.textContent = currentCount - 0;
                            refreshNotificationsAfterMark();
                        } else {
                            notificationCount.classList.add('hidden');
                            const notificationList = document.getElementById('notificationList');
                            notificationList.innerHTML = '<li class="p-2 text-gray-500">No new notifications</li>';
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
            }

            
            // Video Tutorial Modal Functions
            document.getElementById('tutorialBtn').addEventListener('click', function() {
                document.getElementById('videoModal').classList.remove('hidden');
                document.getElementById('videoModal').classList.add('flex');
            });

            function closeVideoModal() {
                const video = document.getElementById('tutorialVideo');
                // Pause the video when closing the modal
                video.pause();
                document.getElementById('videoModal').classList.add('hidden');
                document.getElementById('videoModal').classList.remove('flex');
            }
        </script>

        <!-- Loading Spinner -->
        <div id="loadingSpinner" class="fixed inset-0 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm hidden z-50">
            <div class="relative flex flex-col items-center">
                <!-- Logo Container with Animation -->
                <div class="w-32 h-32 mb-8 relative animate-bounce">
                    <img src="{{ asset('images/OMSCLogo.png') }}" alt="OMSC Logo" class="w-full h-full object-contain animate-pulse">
                    <!-- Spinning ring around logo -->
                    <div class="absolute inset-0 rounded-full border-8 border-transparent border-t-indigo-500 border-r-indigo-500 animate-spin"></div>
                </div>
                <!-- Animated Loading Text -->
                <div class="text-center p-6">
                    <div class="flex items-center space-x-2">
                        <span class="text-white text-xl font-medium tracking-wider">
                            <span class="inline-block animate-pulse">C</span>
                            <span class="inline-block animate-pulse delay-75">l</span>
                            <span class="inline-block animate-pulse delay-100">e</span>
                            <span class="inline-block animate-pulse delay-150">a</span>
                            <span class="inline-block animate-pulse delay-200">r</span>
                            <span class="inline-block animate-pulse delay-300">V</span>
                            <span class="inline-block animate-pulse delay-400">a</span>
                            <span class="inline-block animate-pulse delay-500">u</span>
                            <span class="inline-block animate-pulse delay-600">l</span>
                            <span class="inline-block animate-pulse delay-700">t</span>
                        </span>
                    </div>
                    <div id="progressText" class="mt-2 text-indigo-300">Loading... 0%</div>
                </div>
                <!-- Progress bar -->
                <div class="w-64 bg-gray-700 rounded-full h-1 overflow-hidden mt-4">
                    <div id="progressBar" class="w-0 h-full bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-500 transition-all duration-300 ease-out"></div>
                </div>
            </div>
        </div>

        <style>
            .delay-75 { animation-delay: 75ms; }
            .delay-100 { animation-delay: 100ms; }
            .delay-150 { animation-delay: 150ms; }
            .delay-200 { animation-delay: 200ms; }
            .delay-300 { animation-delay: 300ms; }
            .delay-400 { animation-delay: 400ms; }
            .delay-500 { animation-delay: 500ms; }
            .delay-600 { animation-delay: 600ms; }
            .delay-700 { animation-delay: 700ms; }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Check if the clearance-show container is present
                const isClearanceShow = document.getElementById('clearanceShowContainer') !== null;

                if (!isClearanceShow) {
                    const loadingSpinner = document.getElementById('loadingSpinner');
                    const progressBar = document.getElementById('progressBar');
                    const progressText = document.getElementById('progressText');
                    let progress = 0;

                    function updateProgress(percent) {
                        progressBar.style.width = `${percent}%`;
                        progressText.textContent = `Loading... ${Math.round(percent)}%`;
                    }

                    function simulateProgress() {
                        const interval = setInterval(() => {
                            if (progress < 90) {
                                progress += Math.random() * 30;
                                if (progress > 90) progress = 90;
                                updateProgress(progress);
                            }
                        }, 500);
                        return interval;
                    }

                    function showLoading() {
                        progress = 0;
                        updateProgress(0);
                        loadingSpinner.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                        return simulateProgress();
                    }

                    function hideLoading(interval) {
                        clearInterval(interval);
                        progress = 100;
                        updateProgress(100);
                        setTimeout(() => {
                            loadingSpinner.classList.add('hidden');
                            document.body.style.overflow = '';
                        }, 500);
                    }

                    // Show loading spinner on page unload
                    window.addEventListener('beforeunload', () => {
                        const interval = showLoading();
                        setTimeout(() => hideLoading(interval), 1000);
                    });

                    // Add loading spinner for all form submissions
                    document.querySelectorAll('form').forEach(form => {
                        form.addEventListener('submit', () => {
                            const interval = showLoading();
                            setTimeout(() => hideLoading(interval), 1000);
                        });
                    });

                    // Add loading spinner for all links that are not "#" or javascript:void(0)
                    document.querySelectorAll('a').forEach(link => {
                        if (link.href && !link.href.includes('#') && !link.href.includes('javascript:void(0)')) {
                            link.addEventListener('click', () => {
                                const interval = showLoading();
                                setTimeout(() => hideLoading(interval), 1000);
                            });
                        }
                    });
                }
            });
        </script>
    </body>
</html>
