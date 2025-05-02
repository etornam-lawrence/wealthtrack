<x-layout>
    <x-slot:pagename>Edit My Profile</x-slot:pagename>

    <div class="max-w-2xl mx-auto p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Name -->
                <div>
                    <x-form-label for="first_name">First Name</x-form-label>
                    <x-form-input type="text" name="first_name" id="first_name" value="{{ old('first_name', auth()->user()->first_name) }}" />
                    <x-form-error name="first_name" />
                </div>

                <!-- Last Name -->
                <div>
                    <x-form-label for="last_name">Last Name</x-form-label>
                    <x-form-input type="text" name="last_name" id="last_name" value="{{ old('last_name', auth()->user()->last_name) }}" />
                    <x-form-error name="last_name" />
                </div>

                <!-- Email -->
                <div class="md:col-span-2">
                    <x-form-label for="email">Email Address</x-form-label>
                    <x-form-input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" />
                    <x-form-error name="email" />
                </div>

                <!-- Phone -->
                <div class="md:col-span-2">
                    <x-form-label for="phone">Phone Number</x-form-label>
                    <x-form-input type="tel" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone) }}" />
                    <x-form-error name="phone" />
                </div>

                <!-- Location -->
                <div class="md:col-span-2">
                    <x-form-select
                        id="location"
                        name="location"
                        label="Location"
                        :options="[
                            'Ghana' => 'Ghana',
                            'Nigeria' => 'Nigeria',
                            'Ivory Coast' => 'Ivory Coast',
                            'Senegal' => 'Senegal',
                            'Togo' => 'Togo',
                            'Benin' => 'Benin',
                            'Liberia' => 'Liberia',
                            'Sierra Leone' => 'Sierra Leone',
                            'Burkina Faso' => 'Burkina Faso',
                            'Mali' => 'Mali',
                            'Guinea' => 'Guinea',
                            'Guinea-Bissau' => 'Guinea-Bissau',
                            'The Gambia' => 'The Gambia',
                            'Cape Verde' => 'Cape Verde',
                            'Niger' => 'Niger'
                        ]"
                        :selected="old('location', auth()->user()->location)"
                        :error="$errors->first('location')"
                    />
                </div>

                <!-- Password -->
                <div class="md:col-span-2">
                    <x-form-label for="password">New Password (leave blank to keep current)</x-form-label>
                    <x-form-input type="password" name="password" id="password" />
                    <x-form-error name="password" />
                </div>

                <!-- Confirm Password -->
                <div class="md:col-span-2">
                    <x-form-label for="password_confirmation">Confirm New Password</x-form-label>
                    <x-form-input type="password" name="password_confirmation" id="password_confirmation" />
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4">
                <button type="button" 
                    onclick="document.getElementById('delete-account-modal').classList.remove('hidden')"
                    class="inline-flex items-center px-4 py-2 border border-red-300 dark:border-red-600 rounded-lg shadow-sm text-sm font-medium text-red-700 dark:text-red-300 bg-white dark:bg-gray-700 hover:bg-red-50 dark:hover:bg-red-900/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                    Delete Account
                </button>
                <a href="{{ route('profile') }}" 
                    class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    Cancel
                </a>
                <x-form-button type="submit">
                    Save Changes
                </x-form-button>
            </div>
        </form>
    </div>

    <!-- Delete Account Modal -->
    <div id="delete-account-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Delete Account</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                Are you sure you want to delete your account? This action cannot be undone. All your data will be permanently deleted.
            </p>
            <div class="flex justify-end space-x-4">
                <button type="button" 
                    onclick="document.getElementById('delete-account-modal').classList.add('hidden')"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">
                    Cancel
                </button>
                <form action="{{ route('profile.destroy') }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layout>

@push('scripts')
<script src="{{ asset('js/country-phone.js') }}"></script>
@endpush