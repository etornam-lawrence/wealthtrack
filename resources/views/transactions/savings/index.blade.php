<x-layout>
  <x-slot:pagename>
    Savings Transactions
  </x-slot:pagename>

  <!-- Navbar -->
  <nav class="bg-white dark:bg-gray-800 shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <a href="{{ route('accounts.savings.show', $accounts->id) }}" 
           class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          Back to Savings Account
        </a>
        <a href="{{ route('transactions.savings.create', $accounts->id) }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white font-semibold rounded-lg shadow-md transition duration-200 ease-in-out transform hover:scale-105">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
              </svg>
              Top Up/Withdraw
            </a>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <section class="text-center py-8 px-4">
    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-3">
      Savings Transactions
    </h1>
    <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300">
      View all deposits and withdrawals for savings account #{{ $accounts->account_number }}
    </p>
  </section>

  <!-- Transactions Table -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    @if($transactions->count())
      <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-2xl">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
          <thead class="bg-indigo-600 dark:bg-indigo-700 text-white">
            <tr>
              <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Date</th>
              <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Type</th>
              <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Amount (GH₵)</th>
              <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Description</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @foreach($transactions as $transaction)
              <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                  {{ \Carbon\Carbon::parse($transaction->created_at)->format('M d, Y h:i A') }}
                </td>
                <td class="px-6 py-4 font-medium">
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                    {{ $transaction->type === 'deposit' 
                        ? 'bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-300'
                        : 'bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-300' }}">
                    {{ ucfirst($transaction->type) }}
                  </span>
                </td>
                <td class="px-6 py-4 text-gray-800 dark:text-white font-semibold">
                  GH₵{{ $transaction->amount }}
                </td>
                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                  {{ $transaction->description ?? '—' }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <div class="text-center py-10">
        <p class="text-lg text-gray-500 dark:text-gray-400">
          No transactions found for this savings account.
        </p>
      </div>
    @endif
  </div>
</x-layout>
