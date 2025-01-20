<x-guest-layout>
<form method="POST" action="{{ route('registerAdminStaff') }}" class="w-full bg-white p-1 rounded-lg ">
    @csrf

    @if ($errors->any())
    <div class="mb-4 p-4 rounded-md bg-red-50 border border-red-200">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">There were errors with your submission:</h3>
                <div class="mt-2 text-sm text-red-700">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif

    <h2 class="text-2xl font-semibold mb-4 text-center text-gray-800">Create an Admin Staff Account</h2>

    <div class="grid grid-cols-2 gap-3 mb-4">
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-xs font-medium text-gray-700" />
            <x-text-input id="name" class="mt-1 block w-full text-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-xs font-medium text-gray-700" />
            <x-text-input id="email" class="mt-1 block w-full text-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Campus and Office -->
    <div class="grid grid-cols-2 gap-3 mb-4">
        <div>
            <x-input-label for="campus_id" :value="__('Campus')" class="text-xs font-medium text-gray-700" />
            <select id="campus_id" name="campus_id" class="mt-1 block w-full text-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                <option value="">Select Campus</option>
                @foreach($campuses as $campus)
                    <option value="{{ $campus->id }}" {{ old('campus_id') == $campus->id ? 'selected' : '' }}>{{ $campus->name }}</option>
                @endforeach
            </select>
            @error('campus_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <x-input-label for="office_id" :value="__('Office')" class="text-xs font-medium text-gray-700" />
            <select id="office_id" name="office_id" class="mt-1 block w-full text-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                <option value="">Select Office</option>
            </select>
            @error('office_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-2 gap-3 mb-4">
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-xs font-medium text-gray-700" />
            <x-text-input id="password" class="mt-1 block w-full text-sm" type="password" name="password" required autocomplete="new-password" />
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-xs font-medium text-gray-700" />
            <x-text-input id="password_confirmation" class="mt-1 block w-full text-sm" type="password" name="password_confirmation" required autocomplete="new-password" />
            @error('password_confirmation')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex items-center justify-between mb-4">
        <a class="text-md text-blue-600 hover:text-blue-600" href="{{ route('login') }}">
            {{ __('Sign In') }}
        </a>
        <x-primary-button class="ml-3 px-4 py-2 text-sm bg-blue-600 hover:bg-blue-700">
            {{ __('Register') }}
        </x-primary-button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const campusSelect = document.getElementById('campus_id');
        const officeSelect = document.getElementById('office_id');

        campusSelect.addEventListener('change', function() {
            const campusId = this.value;
            fetch(`/get-offices/${campusId}`)
                .then(response => response.json())
                .then(data => {
                    officeSelect.innerHTML = '<option value="">Select Office</option>';
                    data.forEach(office => {
                        officeSelect.innerHTML += `<option value="${office.id}">${office.name}</option>`;
                    });
                })
                .catch(error => console.error('Error fetching offices:', error));
        });
    });
</script>

</x-guest-layout>