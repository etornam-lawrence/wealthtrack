<x-layout>
  <x-slot:pagename>
    New Transaction
  </x-slot:pagename>

  <div class="max-w-lg mx-auto p-8">
    <!-- Back Navigation -->
    <div class="mb-6">
      <a href="{{ route('transactions.index') }}" class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Transactions
      </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
      <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">New Transaction <small style="font-size: 10px;">(For Current Accounts Only!)</small></h2>
      <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        <div>
          <x-form-label for="amount">Amount (₵)</x-form-label>
          <x-form-input 
            type="number" 
            step="0.01" 
            min="0.01"
            max="999999999.99"
            name="amount" 
            id="amount" 
            required 
            placeholder="Enter amount" 
          />
        </div>
        <x-form-error name="amount" />

        <x-form-select
                    name="current_account_id"
                    label="Select Account"
                    :options="$accounts->mapWithKeys(function($account) {
                        return [$account->id => $account->alias . ' - ' . $account->account_number];
                    })"
                    required
                    :error="$errors->first('current_account_id')"
                />
                    
        <x-form-select
          name="budget_id"
          label="Budget (Optional: Only use for withdrawals)." 
          :options="$budgets->pluck('category', 'id')"
          :error="$errors->first('budget_id')"
        />
        

        <x-form-select
          name="transaction_type"
          label="Transaction Type"
          :options="['deposit' => 'Deposit', 'withdrawal' => 'Withdrawal']"
          required
          :error="$errors->first('transaction_type')"
        />

        <div>
          <x-form-label for="description">Description <small>Advisable for tracking expenses<small></x-form-label>
          <x-form-textarea 
            name="description" 
            id="description" 
            rows="3" 
            placeholder="Enter a brief description.(Optional)"
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          ></x-form-textarea>
        </div>

        <div>
          <button 
            type="submit"
            id="submitBtn"
            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-sm font-medium transition duration-300"
          >
            Submit Transaction
          </button>
        </div>
      </form>
    </div>
  </div>
</x-layout>
