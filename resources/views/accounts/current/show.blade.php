<x-layout>
    <x-slot:pagename>
      Account Details
    </x-slot:pagename>
  
    <div class="max-w-4xl mx-auto p-6">
      <!-- Back Button -->
      <div class="mb-6">
        <a href="/accounts" class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          Back to Accounts
        </a>
      </div>

      <!-- Account Summary Card -->
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden mb-6">
        <div class="p-6">
          <div class="flex items-center justify-between mb-6">
            <div>
              <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100"></h1>
              <p class="text-gray-600 dark:text-gray-400"></p>
            </div>
            <span class="px-4 py-2 text-sm font-semibold rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200">
              Current Account
            </span>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Account Details -->
            <div class="space-y-4">
              <div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Account Alias</h3>
                <p class="mt-1 text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $account->alias }}</p>
              </div>
              <div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Account Number</h3>
                <p class="mt-1 text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $account->account_number }}</p>
              </div>
              <div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Created On</h3>
                <p class="mt-1 text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $account->created_at->format('F d, Y') }}</p>
              </div>
            </div>

            <!-- Balance Card -->
            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4">
              <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Current Balance</h3>
              <p class="mt-2 text-3xl font-bold text-indigo-600 dark:text-indigo-400">₵{{ number_format($account->balance, 2) }}</p>
            </div>
          </div>
        </div>


        <!-- Edit Account Button -->
        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex justify-end space-x-4">
          <a href="{{ route('accounts.current.edit', $account->id) }}" 
             class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white font-semibold rounded-lg shadow-md transition duration-200 ease-in-out transform hover:scale-105">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Rename Account
          </a>
          <form action="{{ route('accounts.current.destroy', $account->id) }}" method="POST" class="inline-block"
                onsubmit="return confirm('Are you sure you want to delete this account?');">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 text-white font-semibold rounded-lg shadow-md transition duration-200 ease-in-out transform hover:scale-105">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
              </svg>
              Delete Account
            </button>
          </form>
        </div>
      </div>

      <!-- Transactions Section -->
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
        <div class="p-6">
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Recent Transactions</h3>
            <a href="{{ route('transactions.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white font-semibold rounded-lg shadow-md transition duration-200 ease-in-out transform hover:scale-105">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
              </svg>
              Top Up/Withdraw
            </a>
          </div>

          @if($account->transactions->count() > 0)
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                <thead>
                  <tr class="bg-gray-50 dark:bg-gray-700">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                  </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                  @foreach($account->transactions as $transaction)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-300">
                        {{ $transaction->created_at->format('M d, Y') }}
                      </td>
                      <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-300">
                        {{ $transaction->description }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-800 dark:text-gray-300">
                        ₵{{ number_format($transaction->amount, 2) }}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="text-center py-12">
              <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
              <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No transactions</h3>
              <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new transaction.</p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </x-layout>
  