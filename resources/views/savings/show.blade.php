<x-layout>
  <x-slot:pagename>
    Savings Plan Details
  </x-slot:pagename>

  <div class="max-w-4xl mx-auto p-8">
    
  <!-- Modal -->
  <div id="depositModal" class="fixed inset-0 bg-opacity-10 backdrop-blur-sm overflow-y-auto h-full w-full hidden target:flex items-center justify-center z-50 p-4 sm:p-6 md:p-8">
    <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-lg w-full mx-auto transform transition-all duration-300 scale-95 target:scale-100">
      <div class="flex justify-between items-center p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white">Make a Deposit</h3>
          <a href="#" class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white px-3 sm:px-4 py-2 rounded-lg shadow-md transition text-sm sm:text-base">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </a>
      </div>
      
        <form action="{{ route('savings.deposit.process', $savings->id) }}" method="POST" class="p-4 sm:p-6">
        @csrf
        <div class="space-y-4">
          <div>
            <x-form-label for="amount">Deposit Amount (₵)</x-form-label>
            <x-form-input 
              type="number" 
              name="amount" 
              id="amount" 
              step="0.01" 
              min="0.01"
              max="999999999.99"
              required 
              class="@error('amount') border-red-500 @enderror"
              placeholder="Enter amount to deposit"
            />
            <x-form-error name="amount"></x-form-error>
          </div>

          <div class="flex items-center justify-end space-x-3 pt-6">
            <a href="#" 
               class="px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200 text-sm font-medium">
              Cancel
            </a>
            <x-form-button type="submit" class="bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500">
              Make Deposit
            </x-form-button>
          </div>
        </div>
      </form>
    </div>
  </div>

  {{-- withdrawal modal --}}
   <div id="withdrawalModal" class="fixed inset-0 bg-opacity-10 backdrop-blur-sm overflow-y-auto h-full w-full hidden target:flex items-center justify-center z-50 p-4 sm:p-6 md:p-8">
    <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-lg w-full mx-auto transform transition-all duration-300 scale-95 target:scale-100">
      <div class="flex justify-between items-center p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white">Withdraw money</h3>
          <a href="#" class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white px-3 sm:px-4 py-2 rounded-lg shadow-md transition text-sm sm:text-base">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </a>
      </div>
      
        <form action="{{ route('savings.withdraw.process', $savings->id) }}" method="POST" class="p-4 sm:p-6">
        @csrf
        <div class="space-y-4">
          <div>
            <x-form-label for="amount"> Amount (₵)</x-form-label>
            <x-form-input 
              type="number" 
              name="amount" 
              id="amount" 
              step="0.01" 
              min="0.01"
              max="999999999.99"
              required 
              class="@error('amount') border-red-500 @enderror"
              placeholder="Enter amount to withdraw"
            />
            <x-form-error name="amount"></x-form-error>
          </div>

          <div class="flex items-center justify-end space-x-3 pt-6">
            <a href="#" 
               class="px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200 text-sm font-medium">
              Cancel
            </a>
            <x-form-button type="submit" class="bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500">
              Cash Out
            </x-form-button>
          </div>
        </div>
      </form>
    </div>
  </div>


  <!-- Navigation Bar -->
  <nav class="bg-white dark:bg-gray-800 shadow sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <a href="{{ route('savings.index') }}" 
           class="text-gray-800 dark:text-gray-100 font-bold text-lg hover:text-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 rounded transition flex items-center">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          Back to Savings
        </a>
        <div class="flex items-center space-x-2 sm:space-x-4">
          <a href="#depositModal" 
             class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white px-3 sm:px-4 py-2 rounded-lg shadow-md transition text-sm sm:text-base">
            
            <span class="hidden sm:inline">Top Up</span>
            <span class="sm:hidden">+</span>
          </a>
          {{-- edit for withdrawal --}}
          <a href="#withdrawalModal" 
             class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white px-3 sm:px-4 py-2 rounded-lg shadow-md transition text-sm sm:text-base">
            
            <span class="hidden sm:inline">Withdraw</span>
            <span class="sm:hidden">-</span>
          </a>
        </div>
      </div>
    </div>
  </nav>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
      <!-- Header Section -->
      <div class="relative border-b border-gray-200 dark:border-gray-700 p-6">
        <div class="flex justify-between items-start">
          <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $savings->planName }}</h1>
          </div>
          <span class="px-4 py-2 text-sm font-medium rounded-full 
            {{ $savings->status === 'active' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-400' : 
               ($savings->status === 'completed' ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/50 dark:text-blue-400' : 
               'bg-amber-50 text-amber-700 dark:bg-amber-900/50 dark:text-amber-400') }}">
            {{ ucfirst($savings->status) }}
          </span>
        </div>
      </div>

      <!-- Progress Section -->
      <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <div class="mb-6">
          <div class="flex justify-between items-baseline mb-2">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Progress</h2>
            <span class="text-sm text-gray-500 dark:text-gray-400">
              {{ number_format(min(($savings->savedAmount / $savings->desiredAmount) * 100, 100), 1) }}%
            </span>
          </div>
          <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
            <div class="bg-blue-600 h-3 rounded-full transition-all duration-500" 
                 style="width: {{ min(($savings->savedAmount / $savings->desiredAmount) * 100, 100) }}%">
            </div>
          </div>
          <div class="flex justify-between mt-2 text-sm">
            <div>
              <span class="text-gray-500 dark:text-gray-400">Saved</span>
              <p class="text-lg font-semibold text-gray-900 dark:text-white">₵{{ number_format($savings->savedAmount, 2) }}</p>
            </div>
            <div class="text-right">
              <span class="text-gray-500 dark:text-gray-400">Target</span>
              <p class="text-lg font-semibold text-gray-900 dark:text-white">₵{{ number_format($savings->desiredAmount, 2) }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Details Grid -->
      <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Saving Details -->
        <div class="space-y-6">
          <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Saving Details</h3>
            <div class="space-y-3">
              <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                <span class="text-gray-600 dark:text-gray-400">Debit Account</span>
                <span class="font-medium text-gray-900 dark:text-white">
                  <a href="{{ route('accounts.savings.show', $account->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                            {{ $savings->savings_account->account_number }}
                          </a>
                </span>
              </div>
              <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                <span class="text-gray-600 dark:text-gray-400">Regularity</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst($savings->regularity) }}</span>
              </div>
              <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                <span class="text-gray-600 dark:text-gray-400">Amount per Interval</span>
                <span class="font-medium text-gray-900 dark:text-white">
                  {{ $savings->amount_per_interval ? '₵' . number_format($savings->amount_per_interval, 2) : 'Manual Savings' }}
                </span>
              </div>
              <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                <span class="text-gray-600 dark:text-gray-400">Description</span>
                <span class="font-medium text-gray-900 dark:text-white">
                  {{ $savings->description ?: 'No description added' }}
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Timeline -->
        <div class="space-y-6">
          <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Timeline</h3>
            <div class="space-y-3">
              <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                <span class="text-gray-600 dark:text-gray-400">Start Date</span>
                <span class="font-medium text-gray-900 dark:text-white">
                  {{ \Carbon\Carbon::parse($savings->start_date)->format('M d, Y') }}
                </span>
              </div>
              <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                <span class="text-gray-600 dark:text-gray-400">End Date</span>
                <span class="font-medium text-gray-900 dark:text-white">
                  {{ \Carbon\Carbon::parse($savings->end_date)->format('M d, Y') }}
                </span>
              </div>
              <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                <span class="text-gray-600 dark:text-gray-400">Duration</span>
                <span class="font-medium text-gray-900 dark:text-white">
                  {{ \Carbon\Carbon::parse($savings->start_date)->diffForHumans($savings->end_date, ['parts' => 2]) }}
                </span>
              </div>
              <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                <span class="text-gray-600 dark:text-gray-400">Time Remaining</span>
                @if ($savings->status == 'completed')
                  <span class="font-medium text-gray-900 dark:text-white">Savings Completed </span>
                @else
                  <span class="font-medium text-gray-900 dark:text-white">
                    {{ \Carbon\Carbon::now()->diffForHumans($savings->end_date, ['parts' => 2]) }}
                  </span>
                @endif
                
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Delete Section -->
      <div class="p-6 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-700">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
          <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Delete this Savings Plan</h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
          Once you delete a savings plan, there is no going back. Please be certain.
        </p>
          </div>
          <div class="flex items-center gap-2 sm:gap-4">
        <a href="{{ route('savings.edit', $savings->id) }}" 
           class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-3 sm:px-4 py-2 rounded-lg shadow-md transition text-sm sm:text-base">
          <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
          </svg>
          <span class="hidden sm:inline">Edit Plan</span>
          <span class="sm:hidden">Edit</span>
        </a>
        <form action="{{ route('savings.destroy', $savings->id) }}" method="POST" class="inline">
          @csrf
          @method('DELETE')
          <button type="submit" 
              onclick="return confirm('Are you sure you want to delete this savings plan?')"
              class="inline-flex items-center px-3 sm:px-4 py-2 border border-red-200 dark:border-red-800 text-sm sm:text-base font-medium rounded-lg text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-900/50 hover:bg-red-100 dark:hover:bg-red-900/75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
            <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            <span class="hidden sm:inline">Delete Plan</span>
            <span class="sm:hidden">Delete</span>
          </button>
        </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-layout>
