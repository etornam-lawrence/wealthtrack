<x-layout>
  <x-slot:pagename>
    Dashboard
  </x-slot:pagename>

  <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <header class="bg-white dark:bg-gray-800 shadow-md">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Dashboard</h1>
        <a href="/profile" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
          Profile
        </a>
      </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 grid grid-cols-1 lg:grid-cols-4 gap-8">
      <!-- Sidebar -->
      <aside class="hidden lg:block bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Navigation</h2>
        <nav>
          <ul class="space-y-4">
            @foreach (['accounts' => 'Accounts', 'budgets' => 'Budgets', 'savings' => 'Savings Plan'] as $route => $label)
              <li>
                <a href="/{{ $route }}" class="block px-4 py-2 rounded text-gray-800 dark:text-gray-100 hover:bg-indigo-600 hover:text-white transition">
                  {{ $label }}
                </a>
              </li>
            @endforeach
          </ul>
        </nav>
      </aside>

      <!-- Main Content -->
      <main class="col-span-3">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
          @foreach ([['Total Expenses (Withdrawals)', $totalExpenses], ['Budget Utilization', 'Budgets: ' . $budget->count()], ['Savings', $totalSavings]] as [$title, $value])
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
              <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ $title }}</h3>
              <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $value }}</p>
            </div>
          @endforeach
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">Recent Transactions <small class="font-medium">(For current accounts only)</small></h3>
            <a href="/transactions" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
              View All
            </a>
          </div>

          @if ($accounts->count() > 0)
            <div class="overflow-x-auto">
              <table class="min-w-full text-sm">
                <thead>
                  <tr class="bg-gray-100 dark:bg-gray-700">
                    <th class="px-4 py-2 text-left font-medium text-gray-600 dark:text-gray-300">Date</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-600 dark:text-gray-300">Description</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-600 dark:text-gray-300">Account</th>
                    <th class="px-4 py-2 text-right font-medium text-gray-600 dark:text-gray-300">Amount</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($accounts as $account)
                    @foreach ($account->transactions->take(3) as $transaction)
                      <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-2 text-gray-800 dark:text-gray-300">{{ $transaction->created_at }}</td>
                        <td class="px-4 py-2 text-gray-800 dark:text-gray-300">{{ $transaction->description }}</td>
                        <td class="px-4 py-2 text-gray-800 dark:text-gray-300">
                          <a href="{{ route('accounts.current.show', $account->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                            {{ $account->account_number }}
                          </a>
                        </td>
                        <td class="px-4 py-2 text-right text-gray-800 dark:text-gray-300">₵{{ number_format($transaction->amount, 2) }}</td>
                      </tr>
                    @endforeach
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <p class="text-center text-gray-500 dark:text-gray-400">No recent transactions available.</p>
          @endif
        </div>

        <!-- Add New Transaction -->
        <div class="mt-6 flex justify-end">
          @if ($accounts->count() > 0)
            <a href="/transactions/create" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition text-sm">
              Top Up/Withdraw
            </a>
          @else
            <p class="text-gray-500 dark:text-gray-400">No accounts available. Please create an account to add transactions.</p>
          @endif
        </div>
      </main>
    </div>
  </div>
</x-layout>
