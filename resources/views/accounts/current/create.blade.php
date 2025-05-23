
<x-layout>
    <x-slot:pagename>
      Create Account
    </x-slot:pagename>
  
    <div class="max-w-2xl mx-auto p-8">
      <!-- Back Navigation -->
      <div class="mb-6">
        <a href="{{ route('accounts.index') }}" class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          Back to Accounts
        </a>
      </div>

      <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-8 mt-10 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Open New Current Account</h2>
  
        <form action="{{ route('accounts.current.store') }}" method="POST" class="space-y-6">
          @csrf
            <div>
              <x-form-label>Account alias <small>Your account nickname</small></x-form-label>
              <x-form-input type="text" name="alias" id="alias" required />
              <x-form-error name="alias" />
            </div>
            
            <div class="flex justify-end">
              <x-form-button type="submit" >
                Create Account
              </x-form-button>
            </div>
        </form>
      </div>
    </div>
  </x-layout>
  