<x-layout>
    <x-slot:pagename>Create New Savings Plan</x-slot:pagename>

    <div class="max-w-2xl mx-auto p-8">
        <!-- Back Navigation -->
        <div class="mb-6">
            <a href="{{ route('savings.index') }}" class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Savings
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Create New Savings Plan</h2>

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

            <form action="{{ route('savings.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <x-form-label for="planName">Plan Name</x-form-label>
                    <x-form-input type="text" name="planName" id="planName" required 
                        value="{{ old('planName') }}" />
                    <x-form-error name="planName" />
                </div>

                <x-form-select
                    name="savings_account_id"
                    label="Select Account"
                    :options="$accounts->mapWithKeys(function($account) {
                        return [$account->id => $account->alias . ' -  ' . $account->account_number];
                    })"
                    required
                    :error="$errors->first('savings_account_id')"
                />

                <div>
                    <x-form-label for="desiredAmount">Target Amount (₵)</x-form-label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 dark:text-gray-400 sm:text-sm">₵</span>
                        </div>
                        <x-form-input 
                            type="number" 
                            name="desiredAmount" 
                            id="desiredAmount" 
                            step="0.01" 
                            min="0.01"
                            max="999999999.99"
                            required 
                            value="{{ old('desiredAmount') }}" 
                            class="pl-7" 
                            placeholder="Enter target amount"
                        />
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
                        Maximum amount: ₵999,999,999.99
                    </p>
                    <x-form-error name="desiredAmount" />
                </div>

                <x-form-select
                    name="regularity"
                    label="Saving Regularity"
                    :options="['daily' => 'Daily', 'weekly' => 'Weekly', 'biweekly' => 'Biweekly', 'monthly' => 'Monthly', 'quarterly' => 'Quarterly', 'yearly' => 'Yearly']"
                    required
                    :error="$errors->first('regularity')"
                    :selected="old('regularity')"
                />

                <div>
                    <x-form-label for="amount_per_interval">Amount per Interval (₵)</x-form-label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 dark:text-gray-400 sm:text-sm">₵</span>
                        </div>
                        <x-form-input 
                            type="number" 
                            name="amount_per_interval" 
                            id="amount_per_interval" 
                            step="0.01" 
                            min="0.01"
                            max="999999999.99"
                            value="{{ old('amount_per_interval') }}" 
                            class="pl-7" 
                            placeholder="Enter amount per interval"
                        />
                    </div>
                    
                    <x-form-error name="amount_per_interval" />
                </div>

                <div>
                    <x-form-label for="start_date">Start Date</x-form-label>
                    <x-form-input 
                        type="date" 
                        name="start_date" 
                        id="start_date" 
                        required 
                        value="{{ old('start_date', date('Y-m-d')) }}" 
                        min="{{ date('Y-m-d') }}"
                    />
                    <x-form-error name="start_date" />
                </div>

                <div>
                    <x-form-label for="end_date">End Date</x-form-label>
                    <x-form-input 
                        type="date" 
                        name="end_date" 
                        id="end_date" 
                        required 
                        value="{{ old('end_date') }}" 
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                    />
                    <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
                        Must be after start date
                    </p>
                    <x-form-error name="end_date" />
                </div>

                
                

                <div>
                    <x-form-label for="description">Description (Optional)</x-form-label>
                    <x-form-textarea name="description" id="description" rows="3"
                        value="{{ old('description') }}" />
                    <x-form-error name="description" />
                </div>

                <div class="flex justify-end">
                    <x-form-button type="submit">
                        Create Savings Plan
                    </x-form-button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
  