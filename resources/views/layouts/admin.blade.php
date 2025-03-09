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
        .bg-red-500 {
            background-color: #f56565;
        }
        .rounded-full {
            border-radius: 9999px;
        }

        .h-2 {
            height: 0.5rem;
        }

        .w-2 {
            width: 0.5rem;
        }

        .hidden {
            display: none;
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
            background-color: #ddecfa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #46597a;
        }

        .notification-content {
            flex: 1;
        }

        .notification-time {
            font-size: 12px;
            color: #a0aec0;
        }

        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 50;
        }

    </style>

    <body class="font-sans antialiased"x-data="{ showUserFeedbackModal: false }">
        <!-- Users Feedback to System Modal (COMPONENT) -->
        <!-- Floating Notification -->

        <div class="min-h-screen bg-gray-100 flex" x-data="{ showUserFeedbackModal: false }">
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

            <style>
                #userFeedbackModal {
                    perspective: 1000px;
                }
                
                #userFeedbackModal > div {
                    backface-visibility: hidden;
                    transform-style: preserve-3d;
                }
            </style>
                <!-- Sidebar -->
                {{-- <div class="w-60 bg-gray-800 text-white h-screen fixed z-10">
                    <div class="flex items-center p-4">
                        <img src="{{ Auth::user()->profile_picture }}" alt="Profile Picture" class="profile-picture">
                        <span class="text-lg font-semibold">{{ Auth::user()->name }}</span>
                    </div> --}}
                <div class="w-60 bg-gray-800 text-white h-screen fixed z-10 overflow-y-auto">
                    {{-- <div class="profile-section">
                        @if(Auth::check())
                            @if(Auth::user()->profile_picture)
                                <img src="{{ Auth::user()->profile_picture }}" alt="Profile Picture" class="profile-picture h-9 w-9">
                            @else
                                <div class="h-9 w-9 profile-picture flex items-center justify-center text-white font-bold" style="background-color: {{ '#' . substr(md5(Auth::user()->name), 0, 6) }};">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="text-lg font-semibold">{{ Auth::user()->name }}</span>
                        @endif
                        {{-- <img src="{{ asset('images/OMSCLogo.png') }}" alt="Logo" class="h-12 w-12 mr-2">
                        <span class="text-lg font-semibold">{{ Auth::user()->name }}</span> --}
                    </div>  --}}

                    @php
                    $role = Auth::user()->user_type;
                    $sAdmin = Auth::user()->user_type === 'Admin' && !Auth::user()->campus_id;
                    $welcomeMessage = [
                        'Admin' => 'Welcome to the OMSC Admin Dashboard',
                        'Program-Head' => 'Welcome to the OMSC Program Head Dashboard',
                        'Dean' => 'Welcome to the OMSC Dean Dashboard',
                        'default' => 'Welcome to the OMSC Admin Dashboard'
                    ];
                
                    // switch ($role) {
                    //     case 'Admin':
                    //         echo $welcomeMessage['Admin'];
                    //         break;
                    //     case 'sAdmin':
                    //         echo $welcomeMessage['sAdmin'];
                    //         break;
                    //     case 'Program-Head':
                    //         echo $welcomeMessage['Program-Head'];
                    //         break;
                    //     case 'Dean':
                    //         echo $welcomeMessage['Dean'];
                    //         break;
                    //     default:
                    //         echo $welcomeMessage['default'];
                    //         break;
                    // }

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
                    <div class="mt-auto -mb-4 p-2">
                        <a href="{{ route('admin.home') }}" class="block hover:bg-gray-700 rounded-lg transition duration-300 ease-in-out">
                            <div class="flex flex-col items-center p-4">
                                <img src="{{ asset('images/OMSCLogo.png') }}" alt="OMSC Logo" class="w-16 h-16 mb-3">
                                <p class="text-sm text-gray-400 text-center group-hover:text-indigo-300 transition duration-150 ease-in-out">
                                    @if  ($sAdmin)
                                        Welcome to the Super Admin Dashboard
                                    @else
                                        {{$welcomeMessage[$role]}}
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500 mt-2 text-center group-hover:text-indigo-300 transition duration-150 ease-in-out">
                                    Manage clearances, analyze reports, and oversee system files.
                                </p>
                            </div>
                        </a>
                    </div>
                    <nav class="mt-2">
                        <!-- Storage Used only for Program-Head and Dean -->
                        @if (Auth::user()->user_type == 'Program-Head' || Auth::user()->user_type == 'Dean')
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
                        @endif
                        <!-- Dashboard -->
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M12 3l9 9-9 9-9-9 9-9z" />
                            </svg>
                            <span class="{{ request()->routeIs('admin.dashboard') ? 'text-indigo-300 font-semibold' : '' }}">Dashboard</span>
                        </a>

                        <!-- Clearances -->
                        <div x-data="{ clearancesOpen: {{ request()->routeIs('admin.views.clearances') || request()->routeIs('admin.clearance.manage') || request()->routeIs('admin.clearance.check') || request()->routeIs('phd.programHeadDean.clearance') ? 'true' : 'false' }} }">
                            <a @click="clearancesOpen = !clearancesOpen" class="flex items-center px-10 py-4 hover:bg-gray-700 cursor-pointer {{ request()->routeIs('admin.views.clearances') || request()->routeIs('admin.clearance.manage') || request()->routeIs('admin.clearance.check') || request()->routeIs('admin.clearances.show') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                </svg>
                                <span class="{{ request()->routeIs('admin.views.clearances') || request()->routeIs('admin.clearance.manage') || request()->routeIs('admin.clearance.check') ? 'text-indigo-300 font-semibold' : '' }}">Clearance</span>
                                <span id="clearancesRedDot" class="ml-2 bg-red-500 rounded-full h-2 w-2 hidden"></span>
                                <svg :class="{'rotate-90': clearancesOpen}" class="ml-auto h-5 w-5 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <div x-show="clearancesOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="pl-8">
                                <!-- View Clearance -->
                                <a href="{{ route('admin.views.clearances') }}" class="flex items-center px-4 py-2 text-sm hover:bg-gray-700 {{ request()->routeIs('admin.views.clearances') ? 'bg-gray-700 text-indigo-300' : 'text-gray-300' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    <span>View Clearance</span>
                                </a>
                                
                                <!-- Manage Clearance (Admin Only) -->
                                @if(Auth::user()->user_type == 'Admin')
                                    <a href="{{ route('admin.clearance.manage') }}" class="flex items-center px-4 py-2 text-sm hover:bg-gray-700 {{ request()->routeIs('admin.clearance.manage') ? 'bg-gray-700 text-indigo-300' : 'text-gray-300' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.204-.107-.397.165-.71.505-.78.929l-.15.894c-.09.542-.56.94-1.109.94h-1.094c-.55 0-1.02-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.78-.93-.398-.164-.855-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        <span>Manage Clearance</span>
                                    </a>
                                @endif

                                <!-- Check Clearance -->
                                <a href="{{ route('admin.clearance.check') }}" class="flex items-center px-4 py-2 text-sm hover:bg-gray-700 {{ request()->routeIs('admin.clearance.check') || request()->routeIs('admin.clearances.show') ? 'bg-gray-700 text-indigo-300' : 'text-gray-300' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                                    </svg>
                                    <span>Check Clearance</span>
                                    <span id="clearanceBadge" class="ml-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center hidden">0</span>
                                </a>

                                <!-- Upload Clearances (Program-Head or Dean Only) -->
                                @if(Auth::user()->user_type == 'Program-Head' || (Auth::user()->user_type == 'Dean'))
                                    <a href="{{ route('phd.programHeadDean.clearance') }}" class="flex items-center px-4 py-2 text-sm hover:bg-gray-700 {{ request()->routeIs('phd.programHeadDean.clearance') ? 'bg-gray-700 text-indigo-300' : 'text-gray-300' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15m0-3-3-3m0 0-3 3m3-3V15" />
                                        </svg>
                                        <span>Upload Clearances</span>
                                        <span id="clearanceBadge" class="ml-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center hidden">0</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- History of Faculty Reports -->
                        <a href="{{ route('admin.views.submittedReports') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('admin.views.submittedReports') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                            </svg>
                            <span class="{{ request()->routeIs('admin.views.submittedReports') ? 'text-indigo-300 font-semibold' : '' }}">History of Reports</span>
                        </a>

                        <!-- Admin Action Reports -->
                        <a href="{{ route('admin.views.actionReports') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('admin.views.actionReports') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                            </svg>
                            <span class="{{ request()->routeIs('admin.views.actionReports') ? 'text-indigo-300 font-semibold' : '' }}">Admin Action Reports</span>
                        </a>

                        <!-- Faculty -->
                        <a href="{{ route('admin.views.faculty') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('admin.views.faculty') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                            <span class="{{ request()->routeIs('admin.views.faculty') ? 'text-indigo-300 font-semibold' : '' }}">Faculty</span>
                        </a>

                        <!-- My Files // Archives -->
                        <a href="{{ route('admin.views.archive') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('admin.views.archive') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                            </svg>
                            <span class="{{ request()->routeIs('admin.views.archive') ? 'text-indigo-300 font-semibold' : '' }}">Archives</span>
                        </a>

                        <!-- Admin ID Management -->
                        @if(Auth::user()->user_type == 'Admin')
                        <a href="{{ route('admin.adminIdManagement') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('admin.adminIdManagement') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-9 w-9 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                            </svg>
                            <span class="{{ request()->routeIs('admin.adminIdManagement') ? 'text-indigo-300 font-semibold' : '' }}">Admin ID Management</span>
                        </a>
                        @endif

                        <!-- College -->
                        @if(Auth::user()->user_type == 'Admin')
                            <a href="{{ route('admin.views.college') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('admin.views.college') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                                <span class="{{ request()->routeIs('admin.views.college') ? 'text-indigo-300 font-semibold' : '' }}">College</span>
                            </a>
                        @endif
                        <!-- Admin Offices -->
                        @if(Auth::user()->user_type == 'Admin')
                            <a href="{{ route('admin.views.offices-index') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('admin.views.offices-index') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                </svg>
                                <span class="{{ request()->routeIs('admin.views.offices-index') ? 'text-indigo-300 font-semibold' : '' }}">Admin Offices</span>
                            </a>
                        @endif
                        <!-- Campuses -->
                        @if(Auth::user()->user_type == 'Admin')
                            <a href="{{ route('admin.views.campuses') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('admin.views.campuses') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                <span class="{{ request()->routeIs('admin.views.campuses') ? 'text-indigo-300 font-semibold' : '' }}">Campuses</span>
                            </a>
                        @endif

                        <!-- Profile -->
                        <a href="{{ route('admin.profile.edit') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('admin.profile.edit') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <span class="{{ request()->routeIs('admin.profile.edit') ? 'text-indigo-300 font-semibold' : '' }}">Profile</span>
                        </a>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}" class="flex items-center w-full">
                            @csrf
                            <button type="submit" class="flex items-center w-full text-left px-9 py-4 hover:bg-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>

                        <!-- Secret Settings (Hidden - Ctrl+Shift+S to show) -->
                        <div id="secretSettings" class="hidden">
                            <a href="#" class="flex items-center px-10 py-4 hover:bg-gray-700 text-red-400 {{ request()->routeIs('about-us') ? 'bg-gray-700 border-l-4 border-red-500' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                                <span>Secret Settings</span>
                            </a>
                            <!-- System Feedback -->
                            <a href="{{ route('others.feedbackIndex') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 text-green-400 {{ request()->routeIs('others.feedbackIndex') ? 'bg-gray-700 border-l-4 border-green-500' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                </svg>
                                <span class="{{ request()->routeIs('others.feedbackIndex') ? 'text-indigo-300 font-semibold' : '' }}">System Feedback</span>
                            </a>

                        </div>

                        <!-- About Us -->
                        <a href="{{ route('about-us') }}" class="flex items-center px-10 py-4 hover:bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 {{-- request()->routeIs('about.us') ? 'bg-gradient-to-r from-indigo-500 to-purple-600 border-l-4 border-indigo-500' : '' --}} transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="{{ request()->routeIs('about.us') ? 'text-white font-semibold' : '' }}">About Us</span>
                        </a>

                        <script>
                            // Secret Settings Keyboard Shortcut
                            document.addEventListener('keydown', function(e) {
                                if (e.ctrlKey && e.shiftKey && e.altKey && e.key === 'Z') {
                                    e.preventDefault();
                                    const secretSettings = document.getElementById('secretSettings');
                                    
                                    // Remove hidden class with animation
                                    secretSettings.classList.remove('hidden');
                                    secretSettings.style.animation = 'slideIn 0.3s ease-out';
                                    secretSettings.style.opacity = '1';
                                    secretSettings.style.transform = 'translateX(0)';

                                    // Add timer to hide with animation
                                    setTimeout(() => {
                                        secretSettings.style.animation = 'slideOut 0.3s ease-in';
                                        secretSettings.style.opacity = '0';
                                        secretSettings.style.transform = 'translateX(-20px)';
                                        
                                        // Add hidden class after animation completes
                                        setTimeout(() => {
                                            secretSettings.classList.add('hidden');
                                        }, 300);
                                    }, 5000);
                                }
                            });
                        </script>

                        <style>
                            @keyframes slideIn {
                                from {
                                    opacity: 0;
                                    transform: translateX(-20px);
                                }
                                to {
                                    opacity: 1;
                                    transform: translateX(0);
                                }
                            }

                            @keyframes slideOut {
                                from {
                                    opacity: 1;
                                    transform: translateX(0);
                                }
                                to {
                                    opacity: 0;
                                    transform: translateX(-20px);
                                }
                            }

                            #secretSettings {
                                transition: opacity 0.3s ease, transform 0.3s ease;
                            }
                        </style>
                    </nav>
                </div>

                <div class="flex-1 ml-60">
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

                                <div class="text-center">
                                    {{-- <h4>{{ date('F d, Y') }}</h4> --}}
                                    <p> {{ date( 'd, l' )}} </p><p id="currentTime">{{ date('h:i A') }}</p>
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
                                    <!-- User Feedback to System Button -->
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
                                    <button id="tutorialBtn" class="text-gray-600 hover:text-indigo-600 transition-colors duration-200 hover:scale-110 relative group ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                        </svg>
                                        <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                            Guide Videos
                                        </div>
                                    </button>

                                    <!-- Overview Link -->
                                    <a href="{{ route('admin.overview') }}" class="text-gray-600 hover:text-gray-900 transition-colors duration-200 hover:scale-110 relative group">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                        </svg>
                                        <span class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                            Overview of the System
                                        </span>
                                    </a>

                                    <!-- Notification Bell -->
                                    <div class="notification-div relative group" style="position: relative; top: 0px; right: 0px;">
                                        <button id="notificationBell" class="relative hover:bg-gray-100 p-2 rounded-full transition-colors duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 hover:text-indigo-600 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
                                            </svg>
                                            <span id="notificationCount" class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center hidden animate-bounce">0</span>
                                            <span class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                                Notifications (Click to Open)
                                            </span>
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
                                            <x-dropdown-link :href="route('admin.profile.edit')"
                                                class="hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-150">
                                                {{ __('Profile') }}
                                            </x-dropdown-link>

                                            @foreach(Auth::user()->availableRoles() as $role)
                                                @if($role !== Auth::user()->user_type)
                                                    @if(!(Auth::user()->user_type === 'Admin' && !Auth::user()->campus_id) && !(Auth::user()->user_type === 'Program-Head' && !Auth::user()->campus_id) && !(Auth::user()->user_type === 'Dean' && !Auth::user()->campus_id))
                                                        @if((Auth::user()->user_type !== 'Admin' || Auth::user()->campus_id) && (Auth::user()->user_type !== 'Program-Head' || Auth::user()->campus_id) && (Auth::user()->user_type !== 'Dean' || Auth::user()->campus_id))
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
                                                    @endif
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
                        <!-- Main Content -->
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
                        <div class="container mx-auto text-center text-gray-800">
                            <p class="text-sm">&copy; 2024 OMSCS IQA ClearVault.</p>
                            <div class="flex justify-center space-x-4 mt-4">
                                <a href="#" class="hover:text-indigo-400">Privacy Policy</a>
                                <a href="#" class="hover:text-indigo-400">Terms of Service</a>
                                <a href="#" class="hover:text-indigo-400">Contact Us</a>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>

        <!-- Tutorial Video Modal -->
        <div id="videoModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
            <div class="bg-white/5 backdrop-blur-lg p-6 rounded-lg shadow-lg w-full max-w-5xl mx-4 border border-indigo-400/50 shadow-indigo-500/30">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-light text-white" id="videoTitle">System Tutorial</h2>
                    <button onclick="closeVideoModal()" class="text-white/60 hover:text-white text-4xl">
                    &times;
                    </button>
                </div>
            
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Sidebar Tutorials List -->
                    <div class="md:w-1/3 bg-white/10 rounded-lg p-3">
                        <h3 class="text-white text-sm mb-2 border-b border-white/20 pb-1">Available Tutorials:</h3>
                        <div class="overflow-y-auto max-h-80 pr-2 tutorial-list">
                            <button onclick="changeVideo('creating-account', 'Creating Account', 'Learn how to create an account and get started with IQA ClearVault system.')" 
                                    class="tutorial-btn bg-indigo-600/40 hover:bg-indigo-600/60 text-white py-2 px-3 rounded transition-all duration-300 text-left w-full mb-2">
                                Creating Account
                            </button>
                            <button onclick="changeVideo('upload-clearance', 'Upload Clearance', 'Learn how to upload clearance documents as a faculty member.')" 
                                    class="tutorial-btn bg-indigo-500/40 hover:bg-indigo-600/60 text-white py-2 px-3 rounded transition-all duration-300 text-left w-full mb-2">
                                Upload Clearance - Faculty
                            </button>
                            <button onclick="changeVideo('program-head-guide', 'Program Head Guide', 'Learn how to manage clearances as a Program Head, including approval workflows and document management.')" 
                                    class="tutorial-btn bg-indigo-500/40 hover:bg-indigo-600/60 text-white py-2 px-3 rounded transition-all duration-300 text-left w-full mb-2">
                                Program Head Guide
                            </button>
                            <!-- Sample future tutorials (can be added later) -->
                            <button class="tutorial-btn bg-indigo-500/40 hover:bg-indigo-600/60 text-white py-2 px-3 rounded transition-all duration-300 text-left w-full mb-2 opacity-50">
                                Managing Faculty (Coming Soon)
                            </button>
                            <button class="tutorial-btn bg-indigo-500/40 hover:bg-indigo-600/60 text-white py-2 px-3 rounded transition-all duration-300 text-left w-full mb-2 opacity-50">
                                Check Clearanc (Coming Soon)
                            </button>
                            <button class="tutorial-btn bg-indigo-500/40 hover:bg-indigo-600/60 text-white py-2 px-3 rounded transition-all duration-300 text-left w-full mb-2 opacity-50">
                                Advanced Reporting (Coming Soon)
                            </button>
                            <button class="tutorial-btn bg-indigo-500/40 hover:bg-indigo-600/60 text-white py-2 px-3 rounded transition-all duration-300 text-left w-full mb-2 opacity-50">
                                System Administration (Coming Soon)
                            </button>
                        </div>
                    </div>
                    
                    <!-- Video Player -->
                    <div class="md:w-2/3">
                        <div class="relative" style="padding-bottom: 56.25%;">
                            <video id="tutorialVideo" class="absolute inset-0 w-full h-full rounded-lg" 
                                   controls
                                   preload="metadata">
                                <source src="{{ asset('images/guide-video/Creating_Account.mp4') }}" type="video/mp4" id="videoSource">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <p class="text-white/80 mt-4 text-sm" id="videoDescription">Learn how to create an account and get started with IQA ClearVault system.</p>
                    </div>
                </div>
            </div>
        </div>

        <style>
            /* Custom scrollbar for the tutorial list */
            .tutorial-list::-webkit-scrollbar {
                width: 6px;
            }
            
            .tutorial-list::-webkit-scrollbar-track {
                background: rgba(255, 255, 255, 0.1);
                border-radius: 10px;
            }
            
            .tutorial-list::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.3);
                border-radius: 10px;
            }
            
            .tutorial-list::-webkit-scrollbar-thumb:hover {
                background: rgba(255, 255, 255, 0.5);
            }
        </style>

        <!-- Notification Scripts -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const notificationBell = document.getElementById('notificationBell');
                const notificationDropdown = document.getElementById('notificationDropdown');
                const notificationList = document.getElementById('notificationList');
                const notificationCount = document.getElementById('notificationCount');

                function fetchUnreadNotifications() {
                    fetch('/notifications/unread')
                        .then(response => response.json())
                        .then(data => {
                            notificationList.innerHTML = ''; // Clear existing notifications
                            if (data.length > 0) {
                                notificationCount.textContent = data.length;
                                notificationCount.classList.remove('hidden');
                                data.forEach(notification => {
                                    const listItem = document.createElement('li');
                                    listItem.classList.add('flex', 'items-center', 'p-2', 'border-b', 'border-gray-200', 'hover:bg-gray-100', 'text-gray-700', 'text-[11px]');
                                    listItem.innerHTML = `
                                        <div class="notification-avatar">${notification.user_name.charAt(0)}</div>
                                        <div class="notification-content hover:text-indigo-600" onclick="markNotificationAsRead(${notification.id}); window.location.href = '/admin/admin/clearances/${notification.user_id}/${notification.user_clearance_id}'">
                                            <p class="font-semibold">${notification.user_name}</p>
                                            <p>${notification.notification_message}</p>
                                            <p class="notification-time">${new Date(notification.created_at).toLocaleTimeString()}</p>
                                        </div>
                                        <button onclick="markNotificationAsRead(${notification.id})" class="text-blue-500 text-xs border-2 border-blue-500 rounded-md px-2 py-1 hover:bg-blue-500 hover:text-white transition-colors duration-200">Mark as Read</button>
                                    `;
                                    notificationList.appendChild(listItem);
                                });
                            } else {
                                notificationCount.classList.add('hidden');
                                const listItem = document.createElement('li');
                                listItem.classList.add('p-2', 'text-gray-500');
                                listItem.textContent = 'No new notifications';
                                notificationList.appendChild(listItem);
                            }
                        })
                        .catch(error => console.error('Error fetching notifications:', error));
                }

                notificationBell.addEventListener('click', function() {
                    notificationDropdown.classList.toggle('hidden');
                });

                // Fetch immediately when page loads
                fetchUnreadNotifications();

                // Set up regular interval for fetching notifications
                let notificationInterval = setInterval(fetchUnreadNotifications, 15000);

                // Expose function to refresh notifications after marking as read
                window.refreshNotificationsAfterMark = function() {
                    // Clear existing interval
                    clearInterval(notificationInterval);

                    // Fetch immediately
                    fetchUnreadNotifications();

                    // Wait 2 seconds then fetch again
                    setTimeout(() => {
                        fetchUnreadNotifications();
                        // Restart regular interval
                        notificationInterval = setInterval(fetchUnreadNotifications, 15000);
                    }, 300);
                };
                                // // Fetch notifications every 10 seconds
                // setInterval(fetchUnreadNotifications, 15000);

                // // Fetch notifications every 1 second if markNotificationAsRead is true
                // if (markNotificationAsRead === true) {
                //     setInterval(fetchUnreadNotifications, 1000);
                //     setTimeout(() => {
                //         fetchUnreadNotifications(false);
                //     }, 3000);
                // } else {
                //     fetchUnreadNotifications(false);
                //     setInterval(fetchUnreadNotifications, 15000);
                // }
            });

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

            function changeVideo(videoKey, title, description) {
                const videoSource = document.getElementById('videoSource');
                const video = document.getElementById('tutorialVideo');
                const videoTitle = document.getElementById('videoTitle');
                const videoDescription = document.getElementById('videoDescription');
                
                // Define video mapping
                const videos = {
                    'creating-account': 'Creating_Account.mp4',
                    'upload-clearance': 'Upload_Clearance_Faculty.mp4',
                    'program-head-guide': 'Program_Head_Guide.mp4'
                    // Add more videos as they become available
                };
                
                // Update video source
                videoSource.src = "{{ asset('images/guide-video') }}/" + videos[videoKey];
                
                // Update title and description
                videoTitle.textContent = "System Tutorial - " + title;
                videoDescription.textContent = description;
                
                // Highlight selected button
                document.querySelectorAll('.tutorial-btn').forEach(btn => {
                    btn.classList.replace('bg-indigo-600/40', 'bg-indigo-500/40');
                });
                // Get the clicked button and add stronger highlighting
                const selectedBtn = event.currentTarget;
                document.querySelectorAll('.tutorial-btn').forEach(btn => {
                    btn.classList.replace('bg-indigo-600/40', 'bg-indigo-500/40');
                    btn.classList.remove('border-l-4', 'border-white', 'pl-2');
                });
                
                // Apply more visible styling to the selected button
                selectedBtn.classList.replace('bg-indigo-500/40', 'bg-indigo-600/70');
                selectedBtn.classList.add('border-l-4', 'border-white', 'pl-2');
                
                // Load the new video
                video.load();
                video.play();
            }
            
            function closeVideoModal() {
                const video = document.getElementById('tutorialVideo');
                // Pause the video when closing the modal
                video.pause();
                document.getElementById('videoModal').classList.add('hidden');
                document.getElementById('videoModal').classList.remove('flex');
            }
        </script>

        {{-- Clearance Counts Sidebar --}}
        <script>
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

                            const totalNewUploads = Object.values(data).reduce((a, b) => a + b, 0);
                            const clearanceBadge = document.getElementById('clearanceBadge');
                            const clearancesRedDot = document.getElementById('clearancesRedDot');
                            if (totalNewUploads > 0) {
                                clearanceBadge.textContent = totalNewUploads;
                                clearanceBadge.classList.remove('hidden');
                                clearancesRedDot.classList.remove('hidden');
                            } else {
                                clearanceBadge.classList.add('hidden');
                                clearancesRedDot.classList.add('hidden');
                            }
                        })
                        .catch(error => console.error('Error fetching notification counts:', error));
                }

                // Check for new notifications every 30 seconds
                setInterval(fetchNotificationCounts, 60000);
                fetchNotificationCounts(); // Initial check
            });
        </script>

        <!-- Loading Spinner -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Get the current route name from meta tag
                const routeNameMeta = document.querySelector('meta[name="route-name"]');
                const currentRoute = routeNameMeta ? routeNameMeta.getAttribute('content') : '';

                // Check if current route is user clearance details
                const isUserClearanceDetails = currentRoute === 'admin.clearance.user-details';

                // Only create and show loading spinner if not on user clearance details page
                if (!isUserClearanceDetails) {
                    // Create loading spinner HTML
                    const spinnerHTML = `
                        <div id="loadingSpinner" class="fixed inset-0 flex items-center justify-center bg-gray-900/70 backdrop-blur-sm hidden" style="z-index: 1000;">
                            <div class="relative flex flex-col items-center">
                                <div class="w-32 h-32 mb-8 relative animate-bounce">
                                    <img src="${window.location.origin}/images/OMSCLogo.png" alt="OMSC Logo" class="w-full h-full object-contain animate-pulse">
                                    <div class="absolute inset-0 rounded-full border-8 border-transparent border-t-indigo-500 border-r-indigo-500 animate-spin"></div>
                                </div>
                                <div class="text-center mt-4">
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
                                <div class="w-64 bg-gray-700 rounded-full h-1 overflow-hidden mt-4">
                                    <div id="progressBar" class="w-0 h-full bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-500 transition-all duration-300 ease-out"></div>
                                </div>
                            </div>
                        </div>
                    `;

                    // Add styles
                    const style = document.createElement('style');
                    style.textContent = `
                        .delay-75 { animation-delay: 75ms; }
                        .delay-100 { animation-delay: 100ms; }
                        .delay-150 { animation-delay: 150ms; }
                        .delay-200 { animation-delay: 200ms; }
                        .delay-300 { animation-delay: 300ms; }
                        .delay-400 { animation-delay: 400ms; }
                        .delay-500 { animation-delay: 500ms; }
                        .delay-600 { animation-delay: 600ms; }
                        .delay-700 { animation-delay: 700ms; }
                    `;
                    document.head.appendChild(style);

                    // Add spinner to body
                    document.body.insertAdjacentHTML('beforeend', spinnerHTML);

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

                    // Handle form submissions
                    document.querySelectorAll('form').forEach(form => {
                        form.addEventListener('submit', () => {
                            const interval = showLoading();
                            setTimeout(() => hideLoading(interval), 1000);
                        });
                    });

                    // Handle link clicks
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
