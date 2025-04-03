<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('System Backup') }}
        </h2>
    </x-slot>
    
    <!-- Notification System -->
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="fixed top-4 right-4 z-50 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md"
            role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="font-bold">Success</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button @click="show = false" class="inline-flex text-green-500 hover:text-green-600">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" 
            x-init="setTimeout(() => show = false, 5000)" 
            x-show="show" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="fixed top-4 right-4 z-50 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-md"
            role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="font-bold">Error</p>
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button @click="show = false" class="inline-flex text-red-500 hover:text-red-600">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                    </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <svg class="w-7 h-7 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Backup Management
                </h1>
                <div class="text-sm text-gray-500 bg-blue-50 px-3 py-1 rounded-full flex items-center">
                    <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Last backup: 
                    @php
                        $backupPath = storage_path('app/private/OMSC IQA ClearVault/');
                        $lastBackupTime = null;
                        
                        if (is_dir($backupPath)) {
                            $files = array_filter(scandir($backupPath), function($item) use ($backupPath) {
                                $fullPath = $backupPath . $item;
                                return !is_dir($fullPath) && pathinfo($fullPath, PATHINFO_EXTENSION) == 'sql';
                            });
                            
                            if (count($files) > 0) {
                                $newestFile = null;
                                $newestTime = 0;
                                
                                foreach ($files as $file) {
                                    $fullPath = $backupPath . $file;
                                    $fileTime = filemtime($fullPath);
                                    if ($fileTime > $newestTime) {
                                        $newestTime = $fileTime;
                                        $newestFile = $fullPath;
                                    }
                                }
                                
                                if ($newestFile) {
                                    $lastBackupTime = \Carbon\Carbon::createFromTimestamp($newestTime)->diffForHumans();
                                }
                            }
                        }
                    @endphp
                    <span class="ml-1 font-semibold">{{ $lastBackupTime ?? 'Never' }}</span>
                </div>
            </div>

            <!-- System Requirements Banner -->
            <div class="bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl shadow-sm border border-yellow-200 mb-8 overflow-hidden">
                <div class="p-5 flex items-start">
                    <div class="flex-shrink-0 bg-yellow-200 p-2 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-yellow-800">Server Requirements</h3>
                        <p class="mt-1 text-sm text-yellow-700">
                            This backup functionality is only available when running on a local server or on hosting environments where MySQL/SSH commands (mysqldump) are available and properly configured.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Backup Dashboard Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Backup Status Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold text-gray-800">Backup Status</h2>
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Healthy</span>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">Database Backup</span>
                                    <span class="font-medium text-gray-800">2 days ago</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 80%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">File Storage Backup</span>
                                    <span class="font-medium text-gray-800">5 days ago</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-yellow-500 h-2 rounded-full" style="width: 60%"></div>
                                </div>
                            </div>
                            <div class="pt-2">
                                <p class="text-sm text-gray-600">
                                    <svg class="w-4 h-4 inline mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Regular backups ensure your data is protected. We recommend backing up at least once a week.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Create Backup Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create New Backup
                        </h2>
                        <form action="{{ route('backup.run') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 hover:bg-blue-50 hover:border-blue-200 transition-colors">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500" id="backup_database" name="backup_database" value="1">
                                    <div class="ml-3">
                                        <span class="text-gray-800 font-medium">Database Backup</span>
                                        <p class="text-xs text-gray-500 mt-1">Backs up all your system database tables</p>
                                    </div>
                                </label>
                            </div>
                            <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 hover:bg-blue-50 hover:border-blue-200 transition-colors">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500" id="backup_files" name="backup_files" value="1">
                                    <div class="ml-3">
                                        <span class="text-gray-800 font-medium">Storage Files Backup</span>
                                        <p class="text-xs text-gray-500 mt-1">Backs up user uploaded documents and files</p>
                                    </div>
                                </label>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 text-white py-2.5 px-4 rounded-lg transition duration-300 ease-in-out flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                Run Backup Now
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Download Backup Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download Backups
                        </h2>
                        <div class="space-y-4">
                            @php
                                // Calculate estimated database size
                                try {
                                    $dbSize = 0;
                                    // Try to estimate from latest backup file first
                                    $backupPath = storage_path('app/private/OMSC IQA ClearVault/');
                                    if (is_dir($backupPath)) {
                                        $files = array_filter(scandir($backupPath), function($item) use ($backupPath) {
                                            $fullPath = $backupPath . $item;
                                            return !is_dir($fullPath) && pathinfo($fullPath, PATHINFO_EXTENSION) == 'sql';
                                        });
                                        
                                        if (count($files) > 0) {
                                            $newestFile = null;
                                            $newestTime = 0;
                                            
                                            foreach ($files as $file) {
                                                $fullPath = $backupPath . $file;
                                                $fileTime = filemtime($fullPath);
                                                if ($fileTime > $newestTime) {
                                                    $newestTime = $fileTime;
                                                    $newestFile = $fullPath;
                                                }
                                            }
                                            
                                            if ($newestFile) {
                                                $dbSize = round(filesize($newestFile) / (1024 * 1024), 2);
                                            }
                                        }
                                    }
                                    
                                    // Calculate user documents size
                                    $docsSize = 0;
                                    $docPath = storage_path('app/public/user_uploaded_documents/');
                                    
                                    if (is_dir($docPath)) {
                                        $iterator = new RecursiveIteratorIterator(
                                            new RecursiveDirectoryIterator($docPath, RecursiveDirectoryIterator::SKIP_DOTS)
                                        );
                                        
                                        foreach ($iterator as $file) {
                                            if ($file->isFile()) {
                                                $docsSize += $file->getSize();
                                            }
                                        }
                                        
                                        $docsSize = round($docsSize / (1024 * 1024), 2);
                                    }
                                } catch (\Exception $e) {
                                    $dbSize = 0;
                                    $docsSize = 0;
                                }
                            @endphp
                            
                            <div class="space-y-5">
                                <!-- Database Backup Download -->
                                <div>
                                    <div class="mb-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Database Backup</label>
                                        <p class="text-xs text-gray-500">Download your database structure and content as SQL file</p>
                                    </div>
                                    <form action="{{ route('backup.database') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white py-3 px-4 rounded-lg flex items-center justify-center transition duration-300 ease-in-out shadow-sm">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Download SQL
                                            <span class="ml-2 bg-green-800 bg-opacity-50 text-xs px-2 py-1 rounded-full">
                                                {{ $dbSize }} MB
                                            </span>
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- User Documents Backup Download -->
                                <div>
                                    <div class="mb-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">User Documents</label>
                                        <p class="text-xs text-gray-500">Generate a ZIP archive of all user uploaded files and documents</p>
                                    </div>
                                    <form action="{{ route('backup.user_documents') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white py-3 px-4 rounded-lg flex items-center justify-center transition duration-300 ease-in-out shadow-sm text-sm">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Generate ZIP Archive
                                            <span class="ml-2 bg-purple-800 bg-opacity-50 text-xs px-2 py-1 rounded-full">
                                                {{ $docsSize }} MB
                                            </span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Existing Backup Files Section -->

            <!-- Existing Backup Files Section -->
            <div class="bg-gradient-to-br from-indigo-50 to-blue-100 rounded-xl shadow-md border-2 border-indigo-200 overflow-hidden mb-8">
                <div class="relative p-6">
                    <!-- Visual indicator accent -->
                    <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-indigo-500 to-blue-600"></div>
                    <h2 class="text-xl font-bold text-indigo-800 mb-6 flex items-center pl-3">
                        <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                        SQL Backup Files
                    </h2>

                    <div class="overflow-x-auto rounded-lg border border-indigo-200 shadow-sm bg-white bg-opacity-80">
                        <table class="min-w-full divide-y divide-indigo-100">
                            <thead class="bg-indigo-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-700 uppercase tracking-wider">File Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-700 uppercase tracking-wider">Size</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-700 uppercase tracking-wider">Date Created</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-indigo-100">
                                @php
                                    $backupPath = storage_path('app/private/OMSC IQA ClearVault/');
                                    $files = [];
                                    
                                    if (is_dir($backupPath)) {
                                        // Get all SQL files
                                        $allFiles = array_filter(scandir($backupPath), function($item) use ($backupPath) {
                                            $fullPath = $backupPath . $item;
                                            return !is_dir($fullPath) && pathinfo($fullPath, PATHINFO_EXTENSION) == 'sql';
                                        });
                                        
                                        // Create array with file names and modification times
                                        $fileData = [];
                                        foreach ($allFiles as $file) {
                                            $fullPath = $backupPath . $file;
                                            if (file_exists($fullPath)) {
                                                $fileData[$file] = filemtime($fullPath);
                                            }
                                        }
                                        
                                        // Sort by modification time, newest first
                                        arsort($fileData);
                                        
                                        // Get the sorted file names
                                        $files = array_keys($fileData);
                                    }
                                @endphp

                                @if(count($files) > 0)
                                    @foreach($files as $file)
                                        @php
                                            $fullPath = $backupPath . $file;
                                            $fileSize = file_exists($fullPath) ? round(filesize($fullPath) / (1024 * 1024), 2) : 0;
                                            $fileDate = file_exists($fullPath) ? date("Y-m-d H:i:s", filemtime($fullPath)) : '';
                                        @endphp
                                        <tr class="hover:bg-indigo-50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 01-2-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    <div class="text-sm font-medium text-gray-900">{{ $file }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-500">{{ $fileSize }} MB</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($fileDate)->diffForHumans() }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <!-- Download Button -->
                                                    <a href="{{ route('backup.download', $file) }}" 
                                                    class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-md transition-colors flex items-center border border-indigo-200">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                        </svg>
                                                        Download
                                                    </a>

                                                    <!-- Delete Button -->
                                                    <form action="{{ route('backup.delete', $file) }}" method="POST" 
                                                        onsubmit="return confirm('Are you sure you want to delete this backup file?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-md transition-colors flex items-center border border-red-200">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500 bg-indigo-50">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-indigo-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                                </svg>
                                                <p class="font-medium text-indigo-700">No backup files found in the specified directory.</p>
                                                <p class="text-xs mt-2 text-indigo-500">Run a backup to get started</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ZIP Backup Files Section -->
            <div class="bg-gradient-to-br from-orange-50 to-amber-100 rounded-xl shadow-md border-2 border-orange-200 overflow-hidden mb-8">
                <div class="relative p-6">
                    <!-- Visual indicator accent -->
                    <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-orange-500 to-amber-600"></div>
                    <h2 class="text-xl font-bold text-orange-800 mb-6 flex items-center pl-3">
                        <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                        ZIP Backup Files
                    </h2>

                    <div class="overflow-x-auto rounded-lg border border-orange-200 shadow-sm bg-white bg-opacity-80">
                        <table class="min-w-full divide-y divide-orange-100">
                            <thead class="bg-orange-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">File Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">Size</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">Date Created</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-orange-100">
                                @php
                                    $backupPath = storage_path('app/private/OMSC IQA ClearVault/');
                                    $zipFiles = [];
                                    
                                    if (is_dir($backupPath)) {
                                        // Get all ZIP files
                                        $allFiles = array_filter(scandir($backupPath), function($item) use ($backupPath) {
                                            $fullPath = $backupPath . $item;
                                            return !is_dir($fullPath) && pathinfo($fullPath, PATHINFO_EXTENSION) == 'zip';
                                        });
                                        
                                        // Create array with file names and modification times
                                        $fileData = [];
                                        foreach ($allFiles as $file) {
                                            $fullPath = $backupPath . $file;
                                            if (file_exists($fullPath)) {
                                                $fileData[$file] = filemtime($fullPath);
                                            }
                                        }
                                        
                                        // Sort by modification time, newest first
                                        arsort($fileData);
                                        
                                        // Get the sorted file names
                                        $zipFiles = array_keys($fileData);
                                    }
                                @endphp

                                @if(count($zipFiles) > 0)
                                    @foreach($zipFiles as $file)
                                        @php
                                            $fullPath = $backupPath . $file;
                                            $fileSize = file_exists($fullPath) ? round(filesize($fullPath) / (1024 * 1024), 2) : 0;
                                            $fileDate = file_exists($fullPath) ? date("Y-m-d H:i:s", filemtime($fullPath)) : '';
                                        @endphp
                                        <tr class="hover:bg-orange-50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 01-2-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    <div class="text-sm font-medium text-gray-900">{{ $file }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-500">{{ $fileSize }} MB</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($fileDate)->diffForHumans() }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <!-- Download Button -->
                                                    <a href="{{ route('backup.download', $file) }}" 
                                                    class="text-orange-600 hover:text-orange-900 bg-orange-50 hover:bg-orange-100 px-3 py-1.5 rounded-md transition-colors flex items-center border border-orange-200">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                        </svg>
                                                        Download
                                                    </a>

                                                    <!-- Delete Button -->
                                                    <form action="{{ route('backup.delete', $file) }}" method="POST" 
                                                        onsubmit="return confirm('Are you sure you want to delete this backup file?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-md transition-colors flex items-center border border-red-200">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500 bg-orange-50">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-orange-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                                </svg>
                                                <p class="font-medium text-orange-700">No ZIP backup files found in the specified directory.</p>
                                                <p class="text-xs mt-2 text-orange-500">Run a file backup to get started</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Cloud Backup Section -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-sm border border-blue-200 overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                            </svg>
                            Cloud Backup
                        </h2>
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">Coming Soon</span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 opacity-70">
                        <div class="p-4 border border-blue-200 rounded-lg bg-white flex flex-col items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400 mb-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm0 22c-5.514 0-10-4.486-10-10s4.486-10 10-10 10 4.486 10 10-4.486 10-10 10zm-2.426-14.741l7.104 4.286-7.104 4.286v-8.572z"/>
                            </svg>
                            <p class="font-medium text-gray-600">Google Drive</p>
                        </div>
                        
                        <div class="p-4 border border-blue-200 rounded-lg bg-white flex flex-col items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400 mb-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M21.586 10.461l-10.05 10.075c-1.95 1.949-5.122 1.949-7.071 0s-1.95-5.122 0-7.072l10.628-10.585c1.17-1.17 3.073-1.17 4.243 0 1.169 1.17 1.17 3.072 0 4.242l-8.507 8.464c-.39.391-1.024.39-1.414 0s-.39-1.024 0-1.414l7.093-7.05-1.415-1.414-7.093 7.049c-1.172 1.172-1.171 3.073 0 4.244s3.071 1.171 4.242 0l8.507-8.464c.977-.977 1.464-2.256 1.464-3.536 0-2.769-2.246-4.999-5-4.999-1.28 0-2.559.488-3.536 1.465l-10.627 10.583c-1.366 1.368-2.05 3.159-2.05 4.951 0 3.863 3.13 7 7 7 1.792 0 3.583-.684 4.95-2.05l10.05-10.075-1.414-1.414z"/>
                            </svg>
                            <p class="font-medium text-gray-600">Dropbox</p>
                        </div>
                        
                        <div class="p-4 border border-blue-200 rounded-lg bg-white flex flex-col items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400 mb-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6 17h-12v-2h12v2zm0-4h-12v-2h12v2zm0-4h-12v-2h12v2z"/>
                            </svg>
                            <p class="font-medium text-gray-600">OneDrive</p>
                        </div>
                    </div>
                    
                    <div class="text-center p-4 bg-white rounded-lg border border-blue-200">
                        <p class="text-gray-700 mb-3">Cloud backup functionality will be available in a future update. This will allow you to automatically backup your data to popular cloud storage providers.</p>
                        <button disabled class="bg-blue-100 text-blue-400 cursor-not-allowed py-2 px-6 rounded-lg font-medium">
                            Configure Cloud Backup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>