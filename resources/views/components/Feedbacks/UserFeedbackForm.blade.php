
        <form method="POST" action="{{ route('user-feedback.store') }}">
            @csrf

            <!-- Category 1: User Experience -->
            <h3 class="text-lg font-semibold mb-4">Category 1: User Experience</h3>

            <div class="mb-4">
                <x-input-label for="c1_1" :value="__('How easy was it to navigate through the website?')" />
                <div>
                    @foreach(['Very Easy', 'Easy', 'Neutral', 'Difficult', 'Very Difficult'] as $index => $option)
                        <label>
                            <input type="radio" name="c1_1" value="{{ $index + 1 }}" {{ old('c1_1') == $index + 1 ? 'checked' : '' }}>
                            {{ $option }}
                        </label><br>
                    @endforeach
                </div>
                @error('c1_1')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="c1_2" :value="__('Did you find the information you were looking for?')" />
                <div>
                    @foreach(['Yes, easily', 'Yes, but with some difficulty', 'No'] as $index => $option)
                        <label>
                            <input type="radio" name="c1_2" value="{{ $index + 1 }}" {{ old('c1_2') == $index + 1 ? 'checked' : '' }}>
                            {{ $option }}
                        </label><br>
                    @endforeach
                </div>
                @error('c1_2')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="c1_3" :value="__('How visually appealing do you find the website design?')" />
                <div>
                    @foreach(['Excellent', 'Good', 'Average', 'Poor', 'Very Poor'] as $index => $option)
                        <label>
                            <input type="radio" name="c1_3" value="{{ $index + 1 }}" {{ old('c1_3') == $index + 1 ? 'checked' : '' }}>
                            {{ $option }}
                        </label><br>
                    @endforeach
                </div>
                @error('c1_3')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="c1_4" :value="__('How quickly does the website load for you?')" />
                <div>
                    @foreach(['Very Fast', 'Fast', 'Neutral', 'Slow', 'Very Slow'] as $index => $option)
                        <label>
                            <input type="radio" name="c1_4" value="{{ $index + 1 }}" {{ old('c1_4') == $index + 1 ? 'checked' : '' }}>
                            {{ $option }}
                        </label><br>
                    @endforeach
                </div>
                @error('c1_4')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="c1_5" :value="__('How likely are you to recommend this website to others?')" />
                <div>
                    @foreach(['Very Likely', 'Likely', 'Neutral', 'Unlikely', 'Very Unlikely'] as $index => $option)
                        <label>
                            <input type="radio" name="c1_5" value="{{ $index + 1 }}" {{ old('c1_5') == $index + 1 ? 'checked' : '' }}>
                            {{ $option }}
                        </label><br>
                    @endforeach
                </div>
                @error('c1_5')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category 2: Content -->
            <h3 class="text-lg font-semibold mb-4">Category 2: Content</h3>

            <div class="mb-4">
                <x-input-label for="c2_1" :value="__('Is the content on the website relevant to your needs?')" />
                <div>
                    @foreach(['Highly Relevant', 'Relevant', 'Neutral', 'Irrelevant', 'Highly Irrelevant'] as $index => $option)
                        <label>
                            <input type="radio" name="c2_1" value="{{ $index + 1 }}" {{ old('c2_1') == $index + 1 ? 'checked' : '' }}>
                            {{ $option }}
                        </label><br>
                    @endforeach
                </div>
                @error('c2_1')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="c2_2" :value="__('How well-organized is the content on the website?')" />
                <div>
                    @foreach(['Excellent', 'Good', 'Average', 'Poor', 'Very Poor'] as $index => $option)
                        <label>
                            <input type="radio" name="c2_2" value="{{ $index + 1 }}" {{ old('c2_2') == $index + 1 ? 'checked' : '' }}>
                            {{ $option }}
                        </label><br>
                    @endforeach
                </div>
                @error('c2_2')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="c2_3" :value="__('How satisfied are you with the coverage of topics on the website?')" />
                <div>
                    @foreach(['Very Satisfied', 'Satisfied', 'Neutral', 'Dissatisfied', 'Very Dissatisfied'] as $index => $option)
                        <label>
                            <input type="radio" name="c2_3" value="{{ $index + 1 }}" {{ old('c2_3') == $index + 1 ? 'checked' : '' }}>
                            {{ $option }}
                        </label><br>
                    @endforeach
                </div>
                @error('c2_3')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>          <div class="mb-4">
                <x-input-label for="c2_4" :value="__('How accurate do you find the information on the website?')" />
                <div>
                    @foreach(['Very Accurate', 'Accurate', 'Neutral', 'Inaccurate', 'Very Inaccurate'] as $index => $option)
                        <label>
                            <input type="radio" name="c2_4" value="{{ $index + 1 }}" {{ old('c2_4') == $index + 1 ? 'checked' : '' }}>
                            {{ $option }}
                        </label><br>
                    @endforeach
                </div>
                @error('c2_4')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="c2_5" :value="__('How engaging is the content presented?')" />
                <div>
                    @foreach(['Very Engaging', 'Engaging', 'Neutral', 'Unengaging', 'Very Unengaging'] as $index => $option)
                        <label>
                            <input type="radio" name="c2_5" value="{{ $index + 1 }}" {{ old('c2_5') == $index + 1 ? 'checked' : '' }}>
                            {{ $option }}
                        </label><br>
                    @endforeach
                </div>
                @error('c2_5')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category 3: Technical Performance -->
            <h3 class="text-lg font-semibold mb-4">Category 3: Technical Performance</h3>

            <div class="mb-4">
                <x-input-label for="c3_1" :value="__('How often did you encounter errors or bugs while using the website?')" />
                <div>
                    @foreach(['Never', 'Rarely', 'Sometimes', 'Often', 'Very Often'] as $index => $option)
                        <label>
                            <input type="radio" name="c3_1" value="{{ $index + 1 }}" {{ old('c3_1') == $index + 1 ? 'checked' : '' }}>
                            {{ $option }}
                        </label><br>
                    @endforeach
                </div>
                @error('c3_1')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <x-input-label for="c3_2" :value="__('How satisfied are you with the website\'s mobile responsiveness?')" />
                <div>
                    @foreach(['Very Satisfied', 'Satisfied', 'Neutral', 'Dissatisfied', 'Very Dissatisfied'] as $index => $option)
                        <label>
                            <input type="radio" name="c3_2" value="{{ $index + 1 }}" {{ old('c3_2') == $index + 1 ? 'checked' : '' }}>
                            {{ $option }}
                        </label><br>
                    @endforeach
                </div>
                @error('c3_2')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="c3_3" :value="__('How secure do you feel using this website?')" />
                <div>
                    @foreach(['Very Secure', 'Secure', 'Neutral', 'Insecure', 'Very Insecure'] as $index => $option)
                        <label>
                            <input type="radio" name="c3_3" value="{{ $index + 1 }}" {{ old('c3_3') == $index + 1 ? 'checked' : '' }}>
                            {{ $option }}
                        </label><br>
                    @endforeach
                </div>
                @error('c3_3')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="c3_4" :value="__('How often does the website crash or fail to load?')" />
                <div>
                    @foreach(['Never', 'Rarely', 'Sometimes', 'Often', 'Always'] as $index => $option)
                        <label>
                            <input type="radio" name="c3_4" value="{{ $index + 1 }}" {{ old('c3_4') == $index + 1 ? 'checked' : '' }}>
                            {{ $option }}
                        </label><br>
                    @endforeach
                </div>
                @error('c3_4')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="c3_5" :value="__('How much improvement do you think the website features and functionalities need?')" />
                <div>
                    @foreach(['No Improvement Needed', 'Minor Improvements', 'Neutral', 'Significant Improvements', 'Major Improvements'] as $index => $option)
                        <label>
                            <input type="radio" name="c3_5" value="{{ $index + 1 }}" {{ old('c3_5') == $index + 1 ? 'checked' : '' }}>
                            {{ $option }}
                        </label><br>
                    @endforeach
                </div>
                @error('c3_5')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>       
            
            <!-- Message/Comment Users Feedback About the System -->
            <h3 class="text-lg font-semibold mb-4">Category 3: Technical Performance</h3>

            <div class="mb-4">
                <x-input-label for="message" :value="__('Additional Comments or Suggestions')" />
                <textarea 
                    id="comment" 
                    name="comment" 
                    rows="4" 
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Please share any additional feedback or suggestions you have for improving our system..."
                >{{ old('comment') }}</textarea>
                @error('message')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Submit') }}
                </x-primary-button>
            </div>
        </form>