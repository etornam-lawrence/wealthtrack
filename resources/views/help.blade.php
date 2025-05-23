<x-layout>
    <x-slot:pagename>
        Help Center
    </x-slot:pagename>

    <section class="max-w-3xl mx-auto px-4 py-10 text-center">
        <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white">Welcome to WealthTrack Help Center</h1>
        <p class="text-lg text-gray-600 dark:text-gray-300">
            Simplified guidance to make the most of your financial journey.
        </p>
    </section>

    <section class="max-w-3xl mx-auto px-4 py-8 bg-white dark:bg-gray-900 rounded-lg shadow">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">WealthTrack v1.0</h2>
        <p class="text-gray-700 dark:text-gray-300 mb-4">
            This first release equips you with tools to track expenses, manage savings, and plan budgets. Your input shapes our future.
        </p>
        <div class="bg-gray-100 dark:bg-gray-800 rounded-md p-4">
            <h3 class="font-medium text-gray-800 dark:text-gray-200 mb-2">Upcoming Features</h3>
            <ul class="list-disc list-inside text-gray-700 dark:text-gray-300">
                <li>Multiple payment method integration</li>
                <li>Advanced analytics and reporting</li>
                <li>Investment tracking</li>
                <li>Enhanced security</li>
            </ul>
        </div>
    </section>

    <section class="max-w-3xl mx-auto px-4 py-8">
        <div class="grid gap-6">
            <div class="bg-white dark:bg-gray-900 rounded-lg p-6 shadow">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Getting Started</h2>
                <ol class="list-decimal list-inside text-gray-700 dark:text-gray-300 space-y-2">
                    <li><strong>Create your main account</strong> – your base for tracking expenses and income.</li>
                    <li><strong>Set up savings goals</strong> – build funds for emergencies, vacations, and more.</li>
                    <li><strong>Start tracking</strong> – log transactions, monitor budgets, and grow wealth.</li>
                </ol>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-lg p-6 shadow">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Key Benefits</h2>
                <ul class="list-disc list-inside text-gray-700 dark:text-gray-300">
                    <li>Clear, intuitive interface</li>
                    <li>Fully responsive design</li>
                    <li>Privacy-focused features</li>
                    <li>Dark mode ready</li>
                </ul>
            </div>
        </div>
    </section>

    <footer class="text-center text-sm text-gray-500 dark:text-gray-400 mt-12">
        <p>&copy; {{ date('Y') }} WealthTrack. All rights reserved.</p>
    </footer>
</x-layout>
