<x-layout>
    <x-slot:pagename>Create New Budget</x-slot:pagename>

    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">Create New Budget</h2>
            <a href="{{ route('budgets.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">
                Back to Budgets
            </a>
        </div>

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

        <form action="{{ route('budgets.store') }}" method="POST" class="space-y-6">
            @csrf
            <x-form-input name="user_id" type="hidden" value="{{ $user->id }}" />
            <x-form-select
                name="category"
                label="Category"
                :options="[
                    'housing' => 'Housing',
                    'transportation' => 'Transportation',
                    'food' => 'Food',
                    'utilities' => 'Utilities',
                    'insurance' => 'Insurance',
                    'healthcare' => 'Healthcare',
                    'debt' => 'Debt',
                    'entertainment' => 'Entertainment',
                    'personal' => 'Personal',
                    'education' => 'Education',
                    'savings' => 'Savings',
                    'other' => 'Other'
                ]"
                required
                :error="$errors->first('category')"
                :selected="old('category')"
            />

            <x-form-select
                name="current_account_id"
                label="Account"
                :options="$accounts->mapWithKeys(function($account) {
                    return [$account->id => $account->alias . ' - ' . $account->account_number];
                })"
                required
                :error="$errors->first('current_account_id')"
                :selected="old('current_account_id')"
            />

            <div>
                <x-form-label for="amount">Amount</x-form-label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 dark:text-gray-400 sm:text-sm">₵</span>
                    </div>
                    <x-form-input type="number" name="amount" id="amount" step="0.01" min="0" required 
                        value="{{ old('amount') }}" class="pl-7" />
                </div>
                <x-form-error name="amount" />
            </div>

            <x-form-select
                name="period"
                label="Period"
                :options="['daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly', 'yearly' => 'Yearly']"
                required
                :error="$errors->first('period')"
                :selected="old('period')"
            />

            <div>
                <x-form-label for="start_date">Start Date</x-form-label>
                <x-form-input type="date" name="start_date" id="start_date" required 
                    value="{{ old('start_date') }}" />
                <x-form-error name="start_date" />
            </div>

            <div>
                <x-form-label for="end_date">End Date</x-form-label>
                <x-form-input type="date" name="end_date" id="end_date" required 
                    value="{{ old('end_date') }}" />
                <x-form-error name="end_date" />
            </div>

            <div class="flex justify-end">
                <x-form-button type="submit">
                    Create Budget
                </x-form-button>
            </div>
        </form>
    </div>
</x-layout> 