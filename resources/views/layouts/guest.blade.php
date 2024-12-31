<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'OMSC') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                background: linear-gradient(45deg, #1e3a8a, #3b82f6, #e0f7fa);
                background-size: 400% 400%;
                animation: gradientBG 15s ease infinite;
                font-family: 'Figtree', Arial, sans-serif;
                overflow-x: hidden;
            }

            @keyframes gradientBG {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            .floating-items {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                z-index: 0;
            }

            .floating-item {
                position: absolute;
                display: block;
                list-style: none;
                animation: float 25s linear infinite;
                bottom: -150px;
                font-size: 24px;
                color: rgba(255, 255, 255, 0.3);
            }

            .floating-item:nth-child(1) { left: 25%; animation-delay: 0s; }
            .floating-item:nth-child(2) { left: 10%; animation-delay: 2s; animation-duration: 12s; }
            .floating-item:nth-child(3) { left: 70%; animation-delay: 4s; }
            .floating-item:nth-child(4) { left: 40%; animation-delay: 0s; animation-duration: 18s; }
            .floating-item:nth-child(5) { left: 65%; animation-delay: 0s; }
            .floating-item:nth-child(6) { left: 75%; animation-delay: 3s; }
            .floating-item:nth-child(7) { left: 35%; animation-delay: 7s; }
            .floating-item:nth-child(8) { left: 50%; animation-delay: 15s; animation-duration: 45s; }
            .floating-item:nth-child(9) { left: 20%; animation-delay: 2s; animation-duration: 35s; }
            .floating-item:nth-child(10) { left: 85%; animation-delay: 0s; animation-duration: 11s; }

            @keyframes float {
                0% {
                    transform: translateY(0) rotate(0deg);
                    opacity: 1;
                }
                100% {
                    transform: translateY(-1000px) rotate(720deg);
                    opacity: 0;
                }
            }

            .content-wrapper {
                position: relative;
                z-index: 1;
            }

            .logo-container {
                animation: fadeInDown 1s ease-out;
            }

            .logo {
                transition: transform 0.3s ease;
            }

            .logo:hover {
                transform: scale(1.1);
            }

            .form-container {
                animation: fadeIn 1s ease-out;
            }

            @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
            @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        </style>
    </head>
    <body>
        <div class="floating-items">
            <li class="floating-item">📚</li>
            <li class="floating-item">🎓</li>
            <li class="floating-item">✏️</li>
            <li class="floating-item">🖋️</li>
            <li class="floating-item">📝</li>
            <li class="floating-item">🔬</li>
            <li class="floating-item">🧪</li>
            <li class="floating-item">📐</li>
            <li class="floating-item">🖥️</li>
            <li class="floating-item">🧮</li>
        </div>
        <div class="min-h-screen flex flex-col md:flex-row content-wrapper">
            <!-- Left side - Logo and College Name -->
            <div class="w-full md:w-1/2 flex flex-col justify-center items-center p-6 md:p-12 logo-container">
            <a href="/" class="group relative transition-all duration-500 ease-in-out transform hover:scale-110">
                <div class="relative">
                <img src="{{ asset('images/OMSCLogo.png') }}" alt="OMSC Logo" 
                     class="w-32 h-32 md:w-48 md:h-48 shadow-xl rounded-full logo 
                        transition-all duration-500 hover:shadow-2xl 
                        hover:shadow-blue-400/50" />
                <!-- Decorative ring -->
                <div class="absolute -inset-4 border-4 border-white/30 rounded-full 
                      animate-spin-slow opacity-70"></div>
                </div>
                <!-- Return Home label moved above the image -->
                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-4 
                       px-3 py-2 bg-white/90 backdrop-blur-sm text-blue-700 
                       text-sm rounded-lg opacity-0 group-hover:opacity-100 
                       transition-all duration-300 shadow-lg z-50">
                    <span class="relative z-50">
                        Return to Home
                        <div class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-600 
                            transform scale-x-0 group-hover:scale-x-100 
                            transition-transform duration-300"></div>
                    </span>
                </div>
            </a>
            <h3 class="mt-8 text-2xl md:text-3xl font-serif font-semibold text-white 
                   text-center transform hover:scale-105 transition-transform 
                   duration-300 select-none">
                <span class="block text-shadow-lg">OCCIDENTAL MINDORO</span>
                <span class="block text-shadow-lg mt-2">STATE COLLEGE</span>
            </h3>
            </div>

            <!-- Right side - Content -->
            <div class="w-full md:w-1/2 flex items-center justify-center p-6 md:p-12 form-container">
            <div class="w-full max-w-lg bg-white/95 backdrop-blur-sm p-8 rounded-xl 
                    shadow-2xl transform transition-all duration-300 
                    hover:shadow-blue-400/30 hover:scale-[1.02]">
                {{ $slot }}
            </div>
            </div>
        </div>

        <style>
            .text-shadow-lg {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            }
            .animate-spin-slow {
            animation: spin 8s linear infinite;
            }
        </style>

        <!-- Loading Spinner -->
        <div id="loadingSpinner" class="fixed inset-0 flex items-center justify-center bg-gray-900/90 backdrop-blur-sm hidden z-50">
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
            });
        </script>
    </body>
</html>
