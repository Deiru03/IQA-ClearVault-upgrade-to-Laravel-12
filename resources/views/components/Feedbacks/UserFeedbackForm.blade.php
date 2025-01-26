
        <form method="POST" action="{{ route('user-feedback.store') }}">
            @csrf

            <!-- Category 1: User Experience -->
            <h3 class="text-lg font-semibold mb-4">Category 1: User Experience</h3>

            <div class="mb-4">
                <x-input-label for="c1_1" :value="__('The website is easy to navigate.')" />
                <div>
                    @foreach(['Strongly Disagree', 'Disagree', 'Neutral', 'Agree', 'Strongly Agree'] as $index => $option)
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
                <x-input-label for="c1_2" :value="__('I can easily find what I need on the website.')" />
                <div>
                    @foreach(['Strongly Disagree', 'Disagree', 'Neutral', 'Agree', 'Strongly Agree'] as $index => $option)
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
                <x-input-label for="c1_3" :value="__('The design of the website is user-friendly.')" />
                <div>
                    @foreach(['Strongly Disagree', 'Disagree', 'Neutral', 'Agree', 'Strongly Agree'] as $index => $option)
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
                    @foreach(['Very Slow', 'Slow', 'Neutral', 'Fast', 'Very Fast'] as $index => $option)
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
                    @foreach(['Very Unlikely','Not Likely', 'Neutral', 'Likely', 'Very Likely'] as $index => $option)
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
                    @foreach(['Poor', 'Average','Fair', 'Good', 'Excellent'] as $index => $option)
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
                    @foreach(['Very Unorganized', 'Unorganized', 'Neutral', 'Organized', 'Very Organized'] as $index => $option)
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
                <x-input-label for="c2_3" :value="__('How satisfied are you with the clearance process on the website?')" />
                <div>
                    @foreach(['Not Satisfied', 'Slightly Satisfied', 'Neutral', 'Satisfied', 'Very Satisfied'] as $index => $option)
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
                <x-input-label for="c2_4" :value="__('How helpful is do you think is the IQA Clearance process?')" />
                <div>
                    @foreach(['Not Helpful', 'Slightly Helpful', 'Neutral', 'Helpful', 'Very Helpful'] as $index => $option)
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
                <x-input-label for="c2_5" :value="__('How engaging is the IQA CLearVault system?')" />
                <div>
                    @foreach(['Not Engaging', 'Slightly Engaging', 'Neutral', 'Engaging', 'Very Engaging'] as $index => $option)
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
                <x-input-label for="c3_1" :value="__('I did not encounter any technical issues or errors.')" />
                <div>
                    @foreach(['Strongly Disagree', 'Disagree', 'Neutral', 'Agree', 'Strongly Agree'] as $index => $option)
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
                <x-input-label for="c3_2" :value="__('I am satisfied of the user experience on the website.')" />
                <div>
                    @foreach(['Not Satisfied', 'Slightly Satisfied', 'Neutral', 'Satisfied', 'Very Satisfied'] as $index => $option)
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
                <x-input-label for="c3_3" :value="__('I feel secure using this website?')" />
                <div>
                    @foreach(['Very Unsecure', 'Unsecure', 'Neutral', 'Secure', 'Very Secure'] as $index => $option)
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
                    @foreach(['Ver Often', 'Often', 'Neutral', 'Rarely', 'Never'] as $index => $option)
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
                    @foreach(['Extensive', 'Moderate', 'Neutral', 'Minimal', 'None'] as $index => $option)
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