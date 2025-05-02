<x-layout>
  <section class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 px-4 py-16">
      <div class="w-full max-w-3xl bg-white dark:bg-gray-800 p-10 rounded-2xl shadow-xl">
          <h2 class="text-3xl font-extrabold text-center text-gray-900 dark:text-white">
              Create an Account
          </h2>
          <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-300">
              Sign up to get started with <span class="font-semibold text-indigo-600">WealthTrack</span>
          </p>

          {{-- Register Form --}}
          <form method="POST" action="{{ route('register') }}" class="mt-10 space-y-6">
              @csrf

              {{-- Grid for first half --}}
              <div class="grid md:grid-cols-2 gap-6">
                  <div>
                      <x-form-label for="first_name" />
                      <x-form-input id="first_name" name="first_name" type="text" required placeholder="Jon" />
                      <x-form-error name="first_name" />
                  </div>
                  <div>
                      <x-form-label for="last_name" />
                      <x-form-input id="last_name" name="last_name" type="text" required placeholder="Doe" />
                      <x-form-error name="last_name" />
                  </div>

                  <div>
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
                              'Guinea Bissau' => 'Guinea-Bissau',
                              'Gambia' => 'The Gambia',
                              'Cape Verde' => 'Cape Verde',
                              'Niger' => 'Niger'
                          ]"
                          required
                          :error="$errors->first('location')"
                          :selected="old('location')"
                      />
                  </div>
                  <div>
                      <x-form-label for="phone" />
                      <x-form-input id="phone" name="phone" type="tel" required placeholder="+233 050 673 4362" />
                      <x-form-error name="phone" />
                  </div>
              </div>

              {{-- Single column for email/passwords --}}
              <div>
                  <x-form-label for="email" />
                  <x-form-input id="email" name="email" type="email" required placeholder="your@email.com" />
                  <x-form-error name="email" />
              </div>

              <div class="grid md:grid-cols-2 gap-6">
                  <div>
                      <x-form-label for="password" />
                      <x-form-input id="password" name="password" type="password" required placeholder="Password" />
                      <x-form-error name="password" />
                  </div>
                  <div>
                      <x-form-label for="password_confirmation" />
                      <x-form-input id="password_confirmation" name="password_confirmation" type="password" required placeholder="Confirm Password" />
                      <x-form-error name="password_confirmation" />
                  </div>
              </div>

              {{-- Submit --}}
              <div>
                  <button type="submit"
                      class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-md shadow transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                      Register
                  </button>
              </div>
          </form>

          {{-- Link to login --}}
          <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
              Already have an account?
              <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                  Sign in
              </a>
          </p>
      </div>
  </section>
</x-layout>

@vite(['resources/js/country-phone.js'])
