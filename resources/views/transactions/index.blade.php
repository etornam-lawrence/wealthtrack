<x-layout>
    <x-slot:pagename>
      Transactions
    </x-slot:pagename>
  
    <div class="max-w-7xl mx-auto px-6 py-10">
      <!-- Transactions Table -->
      <div class="mb-12">
        <div class="flex justify-between items-center mb-6">
          <a href="/dashboard" 
           class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          Back to Dashboard
        </a>
          <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">All Transactions for {{ $user->first_name }}</h2>
          <a href="/transactions/create" class="inline-block px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">Top Up/Withdraw</a>
        </div>
        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
              <tr>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Account</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Reason</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created At</th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
              @foreach ($accounts as $account)
                @foreach($account->transactions as $transaction)
                  <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 text-right">₵{{ number_format($transaction->amount, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($transaction->transaction_type) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-300">
                        <a href="{{ route('accounts.current.show', $account->id) }}"
                          class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 underline">
                            {{ $account->account_number }}
                        </a>
                    </td>


                    {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-300">
                      @if($accountType == 'current')
                        <a href="/accounts/current/{{ $account->id }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 underline">
                          {{ $account->account_number }}
                        </a>
                      @elseif($accountType == 'savings')
                        <a href="/accounts/savings/{{ $account->id }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 underline">
                          {{ $account->account_number }}
                        </a>
                      @endif
                    </td> --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-300">{{ $transaction->description }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $transaction->created_at }}</td>

                  </tr>
                @endforeach
              @endforeach
              
            </tbody>
          </table>
        </div>
      </div>
  
      
    </div>
  </x-layout>
  