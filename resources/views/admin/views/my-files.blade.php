<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Files') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium">My Files</h3>
                    <p class="mt-2">Here you can view and manage files shared with you.</p>
                    <!-- Add your My Files management content here -->
                </div>
            </div>            
        </div>
    </div>

    @php
        $userId = Auth::id();
    @endphp

    @storageUsage($userId)
    
    <div class="container mx-auto px-4 py-8 bg-white rounded-lg border-2 border-indigo-200">
        <h4 class="text-2xl font-bold mb-6 text-gray-800">Admin Dashboard</h4>

        @php
            $storageSiz = $storageSizeASP;
            $sizeInMB = $storageSiz / (1024 * 1024);
            if($sizeInMB >= 1024) {
                $size = number_format($sizeInMB / 1024, 2) . ' GB';
            } else {
                $size = number_format($sizeInMB, 2) . ' MB';
            }
        @endphp

        <div class="flex items-center justify-between mb-4">
            <span class="text-lg font-semibold text-gray-700">Personal Storage</span>
            <span class="text-2xl font-bold text-blue-600">{{ $size }}</span>
        </div>

        <div class="w-full bg-gray-200 rounded-full h-4 mb-2">
            <div class="h-full rounded-full bg-gradient-to-r {{ $isHighUsage ? 'from-red-500 to-red-600' : 'from-blue-500 to-indigo-600' }} transition-all duration-500" 
            style="width: {{ $percentage }}%">
            </div>
        </div>
        
        <div class="flex justify-between text-sm text-gray-500">
            <span>0 MB</span>
            <span><strong class="font-semibold text-blue-600">{{ $percentage }}% </strong>used of {{ $maxStorage }} MB</span>
            <span>{{$maxStorage }} MB</span>
        </div>
    </div>
    
    
</x-admin-layout>