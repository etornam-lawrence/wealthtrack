<x-layout>
    <x-slot:pagename>
        Create Account
    </x-slot:pagename>

    <div class="container mx-auto mt-8">
        <h2 class="text-3xl font-semibold mb-6 text-gray-800 dark:text-gray-100">Open a New Account</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Savings Account Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Savings Account</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Start saving for your goals. A savings account helps you grow your money safely by linking it to a savings plan
                    </p>
                    <a 
                    href="{{ route('accounts.savings.create') }}" 
                    class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        Create Savings Account
                    </a>
                </div>
            </div>

            <!-- Current Account Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Current Account</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        For your everyday transactions. A current account provides easy access to your funds.
                    </p>
                    <a 
                    href="{{ route('accounts.current.create') }}"
                     class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        Create Current Account
                    </a>
                </div>
            </div>

            <!-- Investment Account Card -->
            {{-- <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Investment Account</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Grow your wealth with our investment options.
                    </p>
                    <a href="{{ route('accounts.create.investment') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        Create Investment Account
                    </a>
                </div>
            </div> --}}

            <!-- Fixed Deposit Account Card -->
            {{-- <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Fixed Deposit Account</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Lock in your savings for higher returns with a fixed deposit account.
                    </p>
                    <a href="{{ route('accounts.create.fixed_deposit') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        Create Fixed Deposit Account
                    </a>
                </div>
            </div> --}}
        </div>
    </div>
</x-layout>