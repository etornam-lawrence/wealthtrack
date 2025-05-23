<x-layout>
    <x-slot:pagename>
      Edit Savings Plan
    </x-slot:pagename>
  
    <div class="max-w-2xl mx-auto p-8">
      <!-- Back Navigation -->
      <div class="mb-6">
        <a href="{{ route('savings.show', $savings->id) }}" class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          Back to Savings Plan
        </a>
      </div>

      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
      <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Edit Savings Plan</h2>

      @if(session('error'))
          <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded relative" role="alert">
              <strong class="font-bold">Error!</strong>
              <span class="block sm:inline">{{ session('error') }}</span>
          </div>
      @endif

      @if(session('success'))
          <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded relative" role="alert">
              <strong class="font-bold">Success!</strong>
              <span class="block sm:inline">{{ session('success') }}</span>
          </div>
      @endif
  
      <form action="{{ route('savings.update', $savings->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PATCH')

        <div>
          <x-form-label for="planName">Plan Name</x-form-label>
          <x-form-input 
            type="text" 
            name="planName" 
            id="planName" 
            value="{{ old('planName', $savings->planName) }}" 
            required 
            maxlength="255"
            class="@error('planName') border-red-500 @enderror"
          />
          <x-form-error name="planName"></x-form-error>
        </div>
  
        <div>
          <x-form-label for="savings_account_id">Select Account <small>(Only change to link to a new account)</small></x-form-label>
          <select 
            name="savings_account_id" 
            id="savings_account_id" 
            required
            class="w-full rounded-md border-gray-300 @error('savings_account_id') border-red-500 @enderror"
          >
            <option value="">Choose an account</option>
            @foreach ($accounts as $account)
              <option value="{{ $account->id }}" {{ (old('savings_account_id', $savings->savings_account_id) == $account->id) ? 'selected' : '' }}>
                {{ $account->account_number }} (Balance: ₵{{ number_format($account->balance, 2) }})
              </option>
            @endforeach
          </select>
          <x-form-error name="savings_account_id"></x-form-error>
        </div>
  
        <div>
          <x-form-label for="desiredAmount">Target Amount (₵)</x-form-label>
          <x-form-input 
            type="number" 
            name="desiredAmount" 
            id="desiredAmount" 
            step="0.01" 
            min="0.01"
            max="999999999.99"
            value="{{ old('desiredAmount', $savings->desiredAmount) }}" 
            required 
            class="@error('desiredAmount') border-red-500 @enderror"
          />
          <x-form-error name="desiredAmount"></x-form-error>
        </div>

        

        <div>
          <x-form-label for="status">Status</x-form-label>
          <select 
            name="status" 
            id="status" 
            required
            class="w-full rounded-md border-gray-300 @error('status') border-red-500 @enderror"
          >
            <option value="active" {{ old('status', $savings->status) == 'active' ? 'selected' : '' }}>Active</option>
            <option value="paused" {{ old('status', $savings->status) == 'paused' ? 'selected' : '' }}>Paused</option>
          </select>
          <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
            Note: To mark a savings plan as completed, reach your target amount.
          </p>
          <x-form-error name="status"></x-form-error>
        </div>
  
        <div>
          <x-form-label for="regularity">Saving Regularity</x-form-label>
          <select 
            name="regularity" 
            id="regularity" 
            required
            class="w-full rounded-md border-gray-300 @error('regularity') border-red-500 @enderror"
          >
            <option value="">Select interval</option>
            <option value="daily" {{ old('regularity', $savings->regularity) == 'daily' ? 'selected' : '' }}>Daily</option>
            <option value="weekly" {{ old('regularity', $savings->regularity) == 'weekly' ? 'selected' : '' }}>Weekly</option>
            <option value="biweekly" {{ old('regularity', $savings->regularity) == 'biweekly' ? 'selected' : '' }}>Biweekly</option>
            <option value="monthly" {{ old('regularity', $savings->regularity) == 'monthly' ? 'selected' : '' }}>Monthly</option>
            <option value="quarterly" {{ old('regularity', $savings->regularity) == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
            <option value="yearly" {{ old('regularity', $savings->regularity) == 'yearly' ? 'selected' : '' }}>Yearly</option>
          </select>
          <x-form-error name="regularity"></x-form-error>
        </div>
  
        <div>
          <x-form-label for="amount_per_interval">Amount Per Interval (₵)</x-form-label>
          <x-form-input 
            type="number" 
            step="0.01" 
            name="amount_per_interval" 
            id="amount_per_interval" 
            min="0.01"
            max="999999999.99"
            value="{{ old('amount_per_interval', $savings->amount_per_interval) }}"
            class="@error('amount_per_interval') border-red-500 @enderror"
          />
          <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
            Leave empty for manual savings or enter amount for scheduled savings
          </p>
          <x-form-error name="amount_per_interval"></x-form-error>
        </div>
  
        <div>
          <x-form-label for="start_date">Start Date</x-form-label>
          <x-form-input 
            type="date" 
            name="start_date" 
            id="start_date" 
            value="{{ old('start_date', $savings->start_date) }}" 
            required 
            class="@error('start_date') border-red-500 @enderror"
          />
          <x-form-error name="start_date"></x-form-error>
        </div>
  
        <div>
          <x-form-label for="end_date">End Date</x-form-label>
          <x-form-input 
            type="date" 
            name="end_date" 
            id="end_date" 
            value="{{ old('end_date', $savings->end_date) }}" 
            required 
            class="@error('end_date') border-red-500 @enderror"
          />
          <x-form-error name="end_date"></x-form-error>
        </div>
  
        
  
        <div>
          <x-form-label for="description">Description (optional)</x-form-label>
          <textarea 
            name="description" 
            id="description" 
            rows="4" 
            maxlength="1000"
            class="w-full rounded-md px-2 border-gray-300 dark:bg-gray-700 dark:text-gray-100 @error('description') border-red-500 @enderror"
          >{{ old('description', $savings->description) }}</textarea>
          <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
            Maximum 1000 characters
          </p>
          <x-form-error name="description"></x-form-error>
        </div>

        <div class="flex justify-between">
          <a 
            href="{{ route('savings.index') }}" 
            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md transition"
          >
            Cancel
          </a>
          <x-form-button type="submit">
            Update Savings Plan
          </x-form-button>
        </div>
      </form>
      </div>
    </div>
  </x-layout>
