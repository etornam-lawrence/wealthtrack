<x-layout>
    <x-slot:pagename>
      Edit Budget
    </x-slot:pagename>

    <div class="max-w-2xl mx-auto p-8">
      <!-- Back Navigation -->
      <div class="mb-6">
        <a href="{{ route('budgets.index') }}" class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          Back to Budgets
        </a>
      </div>

      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
        <div class="p-6">
          @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500">
              <div class="flex">
                <div class="flex-shrink-0">
                  <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                  </svg>
                </div>
                <div class="ml-3">
                  <h3 class="text-sm font-medium text-red-800 dark:text-red-200">There were errors with your submission</h3>
                  <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                    <ul class="list-disc pl-5 space-y-1">
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          @endif

          <form action="{{ route('budgets.update', $budget) }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')
            
            <div>
              <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
              <select name="category" id="category" required 
                      class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400">
                <option value="">Select a category</option>
                <option value="Housing" {{ (old('category', $budget->category) == 'Housing') ? 'selected' : '' }}>Housing</option>
                <option value="Transportation" {{ (old('category', $budget->category) == 'Transportation') ? 'selected' : '' }}>Transportation</option>
                <option value="Food" {{ (old('category', $budget->category) == 'Food') ? 'selected' : '' }}>Food</option>
                <option value="Utilities" {{ (old('category', $budget->category) == 'Utilities') ? 'selected' : '' }}>Utilities</option>
                <option value="Insurance" {{ (old('category', $budget->category) == 'Insurance') ? 'selected' : '' }}>Insurance</option>
                <option value="Healthcare" {{ (old('category', $budget->category) == 'Healthcare') ? 'selected' : '' }}>Healthcare</option>
                <option value="Savings" {{ (old('category', $budget->category) == 'Savings') ? 'selected' : '' }}>Savings</option>
                <option value="Entertainment" {{ (old('category', $budget->category) == 'Entertainment') ? 'selected' : '' }}>Entertainment</option>
                <option value="Personal" {{ (old('category', $budget->category) == 'Personal') ? 'selected' : '' }}>Personal</option>
                <option value="Debt" {{ (old('category', $budget->category) == 'Debt') ? 'selected' : '' }}>Debt</option>
                <option value="Other" {{ (old('category', $budget->category) == 'Other') ? 'selected' : '' }}>Other</option>
              </select>
            </div>

            <div>
              <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount</label>
              <div class="mt-1 relative rounded-lg shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <span class="text-gray-500 dark:text-gray-400 sm:text-sm">₵</span>
                </div>
                <input type="number" name="amount" id="amount" step="0.01" min="0" required 
                       value="{{ old('amount', $budget->amount) }}"
                       class="block w-full pl-7 pr-12 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                  <span class="text-gray-500 dark:text-gray-400 sm:text-sm">GHS</span>
                </div>
              </div>
            </div>

            <div>
              <label for="period" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Period</label>
              <select name="period" id="period" required 
                      class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400">
                <option value="">Select a period</option>
                <option value="daily" {{ (old('period', $budget->period) == 'daily') ? 'selected' : '' }}>Daily</option>
                <option value="weekly" {{ (old('period', $budget->period) == 'weekly') ? 'selected' : '' }}>Weekly</option>
                <option value="monthly" {{ (old('period', $budget->period) == 'monthly') ? 'selected' : '' }}>Monthly</option>
                <option value="quarterly" {{ (old('period', $budget->period) == 'quarterly') ? 'selected' : '' }}>Quarterly</option>
                <option value="yearly" {{ (old('period', $budget->period) == 'yearly') ? 'selected' : '' }}>Yearly</option>
              </select>
            </div>

            <div>
              <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
              <input type="date" name="start_date" id="start_date" required 
                     value="{{ old('start_date', $budget->start_date->format('Y-m-d')) }}"
                     class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400">
            </div>

            <div>
              <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
              <input type="date" name="end_date" id="end_date" required 
                     value="{{ old('end_date', $budget->end_date->format('Y-m-d')) }}"
                     class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400">
            </div>

            <div>
              <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description (Optional)</label>
              <textarea name="description" id="description" rows="3" 
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400">{{ old('description', $budget->description) }}</textarea>
            </div>

            <div>
              <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
              <select name="status" id="status" required 
                      class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400">
                <option value="">Select a status</option>
                <option value="active" {{ (old('status', $budget->status) == 'active') ? 'selected' : '' }}>Active</option>
                <option value="closed" {{ (old('status', $budget->status) == 'closed') ? 'selected' : '' }}>Closed</option>
              </select>
            </div>

            <div class="flex items-center justify-end space-x-4">
              <a href="{{ route('budgets.index') }}" 
                 class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 transition-colors duration-200">
                Cancel
              </a>
              <button type="submit" 
                      class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 transition-colors duration-200">
                Update Budget
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
</x-layout> 