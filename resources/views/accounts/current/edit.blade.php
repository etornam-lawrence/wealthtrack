<x-layout>
    <x-slot:pagename>
      New Account Settings
    </x-slot:pagename>
  
    <div class="max-w-xl mx-auto mt-10 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
      <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Update Account Details</h2>
  
      <form action="{{ route('accounts.current.update', $account) }}" method="POST" class="space-y-6">
        @csrf
        @method('PATCH')
        <div>
          <x-form-label for="name" >First Name</x-form-label>
          <x-form-input type="text" name="alias" id="name" value="{{ old('alias', $account->alias) }}" required />
          <x-form-error name="first_name" />
        </div>
  
        
        <!-- Submit Button -->
        <div class="flex justify-between items-center">
          <a href="{{ '/accounts' }}" class="text-sm text-indigo-600 hover:underline">← Back to Accounts</a>
          <x-form-button type="submit">Save Changes</x-form-button>
        </div>
      </form>
    </div>
  </x-layout>
  