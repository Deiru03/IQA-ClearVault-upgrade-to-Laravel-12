
        <form method="POST" action="{{ route('user-feedback.store') }}">
            @csrf

            <div class="mb-8 text-center bg-blue-50 p-6 rounded-lg shadow-sm border border-blue-100">
                <h2 class="text-2xl font-semibold text-blue-800 mb-2">Your Opinion Matters!</h2>
                <p class="text-lg text-gray-700">
                    We value your feedback! Please take a moment to answer this survey and help us improve your experience.
                </p>
                <div class="mt-2 text-sm text-gray-600">
                    Your responses will help us create a better platform for everyone.
                </div>
            </div>          <!-- Category 1: User Experience -->
            <h3 class="text-lg font-semibold mb-4">Category 1: User Experience</h3>

            <div class="space-y-6">
                <!-- Question 1 -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <x-input-label for="c1_1" class="text-lg font-medium text-gray-800 mb-3" :value="__('How easy was it to navigate through the website?')" />
                    <div class="grid grid-cols-1 gap-3">
                        @foreach(['Very Easy', 'Easy', 'Neutral', 'Difficult', 'Very Difficult'] as $index => $option)
                            <label class="flex items-center space-x-3 p-0 hover:bg-gray-50 rounded-md transition-colors">
                                <input type="radio" name="c1_1" value="{{ $index + 1 }}" {{ old('c1_1') == $index + 1 ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="text-gray-700">{{ $option }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('c1_1')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Question 2 -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <x-input-label for="c1_2" class="text-lg font-medium text-gray-800 mb-3" :value="__('Did you find the information you were looking for?')" />
                    <div class="grid grid-cols-1 gap-3">
                        @foreach(['Yes, easily', 'Yes, but with some difficulty', 'No'] as $index => $option)
                            <label class="flex items-center space-x-3 p-0 hover:bg-gray-50 rounded-md transition-colors">
                                <input type="radio" name="c1_2" value="{{ $index + 1 }}" {{ old('c1_2') == $index + 1 ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="text-gray-700">{{ $option }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('c1_2')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Questions 3-5 (similar pattern) -->
                @foreach([
                    'c1_3' => ['How visually appealing do you find the website design?', ['Excellent', 'Good', 'Average', 'Poor', 'Very Poor']],
                    'c1_4' => ['How quickly does the website load for you?', ['Very Fast', 'Fast', 'Neutral', 'Slow', 'Very Slow']],
                    'c1_5' => ['How likely are you to recommend this website to others?', ['Very Likely', 'Likely', 'Neutral', 'Unlikely', 'Very Unlikely']]
                ] as $name => [$question, $options])
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <x-input-label for="{{ $name }}" class="text-lg font-medium text-gray-800 mb-3" :value="__($question)" />
                        <div class="grid grid-cols-1 gap-3">
                            @foreach($options as $index => $option)
                                <label class="flex items-center space-x-3 p-0 hover:bg-gray-50 rounded-md transition-colors">
                                    <input type="radio" name="{{ $name }}" value="{{ $index + 1 }}" {{ old($name) == $index + 1 ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span class="text-gray-700">{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error($name)
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>
            
            <!-- Category 2: Content -->
            <!-- Category 2: Content -->
            <h3 class="text-lg font-semibold mb-4">Category 2: Content</h3>

            <div class="space-y-6">
                @foreach([
                    'c2_1' => ['Is the content on the website relevant to your needs?', ['Highly Relevant', 'Relevant', 'Neutral', 'Irrelevant', 'Highly Irrelevant']],
                    'c2_2' => ['How well-organized is the content on the website?', ['Excellent', 'Good', 'Average', 'Poor', 'Very Poor']],
                    'c2_4' => ['How accurate do you find the information on the website?', ['Very Accurate', 'Accurate', 'Neutral', 'Inaccurate', 'Very Inaccurate']],
                    'c2_5' => ['How engaging is the content presented?', ['Very Engaging', 'Engaging', 'Neutral', 'Unengaging', 'Very Unengaging']]
                ] as $name => [$question, $options])
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <x-input-label for="{{ $name }}" class="text-lg font-medium text-gray-800 mb-3" :value="__($question)" />
                        <div class="grid grid-cols-1 gap-3">
                            @foreach($options as $index => $option)
                                <label class="flex items-center space-x-3 p-0 hover:bg-gray-50 rounded-md transition-colors">
                                    <input type="radio" name="{{ $name }}" value="{{ $index + 1 }}" {{ old($name) == $index + 1 ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span class="text-gray-700">{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error($name)
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach

                <!-- Special question with text input -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <x-input-label for="c2_3" class="text-lg font-medium text-gray-800 mb-3" :value="__('Are there any missing topics or sections you like to see?')" />
                    <div class="space-y-3">
                        <label class="flex items-center space-x-3">
                            <input type="radio" name="c2_3" value="1" {{ old('c2_3') == 1 ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="text-gray-700">Yes</span>
                        </label>
                        <div class="ml-7">
                            <input type="text" name="c2_3_specify" value="{{ old('c2_3_specify') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="Please specify">
                        </div>
                        <label class="flex items-center space-x-3">
                            <input type="radio" name="c2_3" value="0" {{ old('c2_3') == 0 ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="text-gray-700">No</span>
                        </label>
                    </div>
                    @error('c2_3')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>     
            
            
            <!-- Category 3: Technical Performance -->
            <h3 class="text-lg font-semibold mb-4">Category 3: Technical Performance</h3>

            <div class="space-y-6">
                <!-- Question about errors/bugs -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <x-input-label for="c3_1" class="text-lg font-medium text-gray-800 mb-3" :value="__('Did you encounter any errors or bugs while using the website?')" />
                    <div class="space-y-3">
                        <label class="flex items-center space-x-3">
                            <input type="radio" name="c3_1" value="1" {{ old('c3_1') == 1 ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="text-gray-700">Yes</span>
                        </label>
                        <div class="ml-7">
                            <input type="text" name="c3_1_specify" value="{{ old('c3_1_specify') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="Please specify the issues you encountered">
                        </div>
                        <label class="flex items-center space-x-3">
                            <input type="radio" name="c3_1" value="0" {{ old('c3_1') == 0 ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="text-gray-700">No</span>
                        </label>
                    </div>
                    @error('c3_1')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Standard radio button questions -->
                @foreach([
                    'c3_2' => ['How satisfied are you with the website\'s mobile responsiveness?', 
                               ['Very Satisfied', 'Satisfied', 'Neutral', 'Dissatisfied', 'Very Dissatisfied']],
                    'c3_3' => ['How secure do you feel using this website?', 
                               ['Very Secure', 'Secure', 'Neutral', 'Insecure', 'Very Insecure']],
                    'c3_4' => ['How often does the website crash or fail to load?', 
                               ['Never', 'Rarely', 'Sometimes', 'Often', 'Always']]
                ] as $name => [$question, $options])
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <x-input-label for="{{ $name }}" class="text-lg font-medium text-gray-800 mb-3" :value="__($question)" />
                        <div class="grid grid-cols-1 gap-3">
                            @foreach($options as $index => $option)
                                <label class="flex items-center space-x-3 p-0 hover:bg-gray-50 rounded-md transition-colors">
                                    <input type="radio" name="{{ $name }}" value="{{ $index + 1 }}" {{ old($name) == $index + 1 ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span class="text-gray-700">{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error($name)
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach

                <!-- Question about improvements -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <x-input-label for="c3_5" class="text-lg font-medium text-gray-800 mb-3" :value="__('Are there any features or functionalities you\'d like to see improved?')" />
                    <div class="space-y-3">
                        <label class="flex items-center space-x-3">
                            <input type="radio" name="c3_5" value="1" {{ old('c3_5') == 1 ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="text-gray-700">Yes</span>
                        </label>
                        <div class="ml-7">
                            <input type="text" name="c3_5_specify" value="{{ old('c3_5_specify') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="Please specify desired improvements">
                        </div>
                        <label class="flex items-center space-x-3">
                            <input type="radio" name="c3_5" value="0" {{ old('c3_5') == 0 ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="text-gray-700">No</span>
                        </label>
                    </div>
                    @error('c3_5')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>          
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Submit') }}
                </x-primary-button>
            </div>
        </form>