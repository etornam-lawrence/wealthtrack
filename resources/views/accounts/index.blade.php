<x-layout>
  <x-slot:pagename>
    Accounts
  </x-slot:pagename>

  <!-- Navbar -->
  <nav class="bg-white dark:bg-gray-800 shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <a href="/dashboard" 
           class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          Back to Dashboard
        </a>
        <a href="{{ route('accounts.create') }}" 
           class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg shadow-md transition focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
          </svg>
          New Account
        </a>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <section class="text-center py-8 px-4">
    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-3">Your Accounts</h1>
    <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300">
      Manage and monitor your savings and current accounts.
    </p>
  </section>

  <!-- Accounts Sections -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @php
      $savings = $accounts->filter(fn($a) => str_starts_with($a->account_number, 'SAV-'));
      $current = $accounts->filter(fn($a) => str_starts_with($a->account_number, 'CURR-'));
    @endphp

    @if($savings->count() || $current->count())
      <div class="space-y-12">

        @if($savings->count())
          <section>
            <h2 class="text-2xl font-semibold mb-4 border-b-4 border-indigo-600 pb-2 text-indigo-600 dark:text-indigo-400">
              Savings Accounts
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
              @foreach($savings as $account)
                <!-- Account Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-indigo-200 dark:border-indigo-700 hover:shadow-xl transition-all transform hover:-translate-y-1">
                  <div class="p-6 relative">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">#{{ $account->account_number }}</h2>
                    <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                      <div class="flex justify-between">
                        <span>Alias:</span>
                        <span class="font-medium">{{ $account->alias }}</span>
                      </div>
                      <div class="flex justify-between">
                        <span>Balance:</span>
                        <span class="font-medium">GH₵{{ number_format($account->balance, 2) }}</span>
                      </div>
                      <div class="flex justify-between">
                        <span>Created:</span>
                        <span class="font-medium">{{ $account->created_at->format('M d, Y') }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="p-4 bg-indigo-50 dark:bg-indigo-900/50 border-t border-indigo-200 dark:border-indigo-700">
                    <a href="{{ route('accounts.savings.show', $account->id) }}" 
                       class="flex items-center justify-center px-3 py-2 text-sm font-medium text-indigo-700 hover:text-indigo-900 dark:text-indigo-300 dark:hover:text-indigo-100 bg-white dark:bg-gray-800 rounded-lg border border-indigo-300 dark:border-indigo-600 hover:bg-indigo-100 dark:hover:bg-indigo-700 transition">
                      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                      </svg>
                      View
                    </a>
                  </div>
                </div>
              @endforeach
            </div>
          </section>
        @endif

        @if($current->count())
          <section>
            <h2 class="text-2xl font-semibold mb-4 border-b-4 border-green-600 pb-2 text-green-600 dark:text-green-400">
              Current Accounts
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
              @foreach($current as $account)
                <!-- Account Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-green-200 dark:border-green-700 hover:shadow-xl transition-all transform hover:-translate-y-1">
                  <div class="p-6 relative">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">#{{ $account->account_number }}</h2>
                    <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                      <div class="flex justify-between">
                        <span>Alias:</span>
                        <span class="font-medium">{{ $account->alias }}</span>
                      </div>
                      <div class="flex justify-between">
                        <span>Balance:</span>
                        <span class="font-medium">GH₵{{ number_format($account->balance, 2) }}</span>
                      </div>
                      <div class="flex justify-between">
                        <span>Created:</span>
                        <span class="font-medium">{{ $account->created_at->format('M d, Y') }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="p-4 bg-green-50 dark:bg-green-900/50 border-t border-green-200 dark:border-green-700">
                    <a href="{{ route('accounts.current.show', $account->id) }}" 
                       class="flex items-center justify-center px-3 py-2 text-sm font-medium text-green-700 hover:text-green-900 dark:text-green-300 dark:hover:text-green-100 bg-white dark:bg-gray-800 rounded-lg border border-green-300 dark:border-green-600 hover:bg-green-100 dark:hover:bg-green-700 transition">
                      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                      </svg>
                      View
                    </a>
                  </div>
                </div>
              @endforeach
            </div>
          </section>
        @endif

      </div>
    @else
      <div class="text-center py-10">
        <p class="text-lg text-gray-500 dark:text-gray-400">
          You currently have no accounts.<br>Start by creating one!
        </p>
      </div>
    @endif
  </div>
</x-layout>
