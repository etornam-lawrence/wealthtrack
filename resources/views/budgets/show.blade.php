<x-layout>
    <x-slot:pagename>
      Budget Details
    </x-slot:pagename>
  
    <div class="max-w-4xl mx-auto p-8">
      <!-- Back Navigation -->
      <div class="mb-6">
        <a href="{{ route('budgets.index') }}" class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          Back to Budgets
        </a>
      </div>

      @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border-l-4 border-emerald-500">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
              </svg>
            </div>
            <div class="ml-3">
              <p class="text-sm text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
              </p>
            </div>
          </div>
        </div>
      @endif

      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
          <div class="flex justify-between items-start">
            <div>
              <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $budget->category }} - <a href="{{ route('accounts.current.show', $budget->currentAccount->id) }}"  class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ $budget->currentAccount->account_number }}</a></h2>
              <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($budget->period) }}</p>
            </div>
            <div class="flex space-x-3">
              <a href="{{ route('budgets.edit', $budget) }}" 
                 class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-md transition focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Budget
              </a>
            </div>
          </div>
        </div>

        <!-- Progress Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
          <div class="mb-4">
            <div class="flex justify-between items-baseline mb-2">
              <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Progress</span>
              <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ number_format($budget->progress_percentage, 1) }}%</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
              <div class="bg-indigo-600 h-2 rounded-full transition-all duration-500" style="width: {{ min($budget->progress_percentage, 100) }}%"></div>
            </div>
          </div>
        </div>

        <!-- Details Grid -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Budget Information -->
          <div class="space-y-6">
            <div>
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Budget Information</h3>
              <dl class="space-y-4">
                <div>
                  <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                  <dd class="mt-1">
                    <span class="px-3 py-1 text-sm font-medium rounded-full 
                      {{ $budget->status === 'active' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-400' : 
                         ($budget->status === 'completed' ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/50 dark:text-blue-400' : 
                         'bg-amber-50 text-amber-700 dark:bg-amber-900/50 dark:text-amber-400') }}">
                      {{ ucfirst($budget->status) }}
                    </span>
                  </dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date Range</dt>
                  <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                    {{ $budget->start_date->format('M d, Y') }} - {{ $budget->end_date->format('M d, Y') }}
                  </dd>
                </div>
                @if($budget->description)
                  <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $budget->description }}</dd>
                  </div>
                @endif
              </dl>
            </div>
          </div>

          <!-- Financial Summary -->
          <div class="space-y-6">
            <div>
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Financial Summary</h3>
              <dl class="space-y-4">
                <div>
                  <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Budget</dt>
                  <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">₵{{ number_format($budget->amount, 2) }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Amount Spent</dt>
                  <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">₵{{ number_format($budget->amount - $budget->remaining_amount, 2) }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Remaining</dt>
                  <dd class="mt-1 text-lg font-semibold {{ $budget->remaining_amount < 0 ? 'text-red-600 dark:text-red-400' : 'text-emerald-600 dark:text-emerald-400' }}">
                    ₵{{ number_format($budget->remaining_amount, 2) }}
                  </dd>
                </div>
              </dl>
            </div>
          </div>
        </div>

        <!-- Delete Section -->
        <div class="p-6 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-700">
          <div class="flex items-center justify-between">
            <div>
              <h3 class="text-lg font-medium text-gray-900 dark:text-white">Delete this budget</h3>
              <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Once you delete a budget, there is no going back. Please be certain.
              </p>
            </div>
            <form action="{{ route('budgets.destroy', $budget) }}" method="POST" class="inline">
              @csrf
              @method('DELETE')
              <button type="submit" 
                      onclick="return confirm('Are you sure you want to delete this budget?')"
                      class="inline-flex items-center px-4 py-2 border border-red-200 dark:border-red-800 text-sm font-medium rounded-lg text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-900/50 hover:bg-red-100 dark:hover:bg-red-900/75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Delete Budget
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
</x-layout> 