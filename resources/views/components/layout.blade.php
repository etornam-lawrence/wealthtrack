<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'WealthTrack - Your Personal Finance Tracker') }}</title>

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900">

  <!-- Header -->
  <header class="bg-white dark:bg-gray-800 shadow sticky top-0 z-50 animate-fadeInUp">
    <nav class="container mx-auto flex items-center justify-between p-6">
      <a href="{{ route('home') }}" class="flex items-center transition transform hover:scale-105">
        @auth
          <span class="ml-3 text-2xl font-bold text-gray-900 dark:text-gray-100">
            WealthTrack - {{ Auth::user()->first_name }}
          </span>
        @endauth
      </a>

      <!-- Desktop Navigation -->
      <div class="hidden lg:flex items-center space-x-8">
        @auth
          <x-nav-link href="{{ route('dashboard') }}" :active="request()->is('dashboard')">Dashboard</x-nav-link>
          <x-nav-link href="{{ route('savings.index') }}" :active="request()->is('savings')">Savings</x-nav-link>
          <x-nav-link href="{{ route('budgets.index') }}" :active="request()->is('budgets')">Budgets</x-nav-link>
          <x-nav-link href="{{ route('profile') }}" :active="request()->is('profile')">Profile</x-nav-link>
          <x-nav-link href="{{ route('help') }}" :active="request()->is('help')">Help</x-nav-link>
          <form action="{{ route('logout') }}" method="POST" id="logout">
            @csrf
            <button type="submit" form="logout" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">Logout</button>
          </form>
        @endauth

        @guest
          <x-nav-link href="{{ route('home') }}" :active="request()->is('home')">Home</x-nav-link>
          <x-nav-link href="{{ route('login') }}">Login</x-nav-link>
          <x-nav-link href="{{ route('register') }}">Register</x-nav-link>
        @endguest
      </div>

      <!-- Mobile Toggle Button -->
      <div class="lg:hidden">
        <button onclick="toggleMobileMenu()" class="text-gray-700 dark:text-gray-300 focus:outline-none">
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16m-7 6h7" />
          </svg>
        </button>
      </div>
    </nav>

    <!-- Mobile Navigation Menu -->
    <div id="mobileMenu" class="lg:hidden hidden px-6 pb-4">
      @auth
        <x-nav-link href="{{ route('dashboard') }}" :active="request()->is('dashboard')">Dashboard</x-nav-link>
        <x-nav-link href="{{ route('savings.index') }}" :active="request()->is('savings')">Savings</x-nav-link>
        <x-nav-link href="{{ route('budgets.index') }}" :active="request()->is('budgets')">Budgets</x-nav-link>
        <x-nav-link href="{{ route('profile') }}" :active="request()->is('profile')">Profile</x-nav-link>
        <x-nav-link href="{{ route('help') }}" :active="request()->is('help')">Help</x-nav-link>
        <form action="{{ route('logout') }}" method="POST" id="logoutMobile">
          @csrf
          <button type="submit" form="logoutMobile" class="block w-full text-left text-red-500">Logout</button>
        </form>
      @endauth

      @guest
        <x-nav-link href="{{ route('home') }}" :active="request()->is('home')">Home</x-nav-link>
        
        <x-nav-link href="{{ route('login') }}">Login</x-nav-link>
        <x-nav-link href="{{ route('register') }}">Register</x-nav-link>
      @endguest
    </div>
  </header>

  <!-- Session Messages -->
  @if (session('success'))
    <div class="fixed top-20 right-4 z-50 animate-fadeInUp">
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg" role="alert">
        <div class="flex items-center">
          <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          <p class="font-medium">{{ session('success') }}</p>
        </div>
      </div>
    </div>
  @endif

  @if (session('error'))
    <div class="fixed top-20 right-4 z-50 animate-fadeInUp">
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg" role="alert">
        <div class="flex items-center">
          <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
          <p class="font-medium">{{ session('error') }}</p>
        </div>
      </div>
    </div>
  @endif

  <!-- Main Content -->
  <main class="container mx-auto px-6 py-10 animate-fadeInUp">
    {{ $slot }}
  </main>

  <!-- Footer -->
  <footer class="bg-gray-800 dark:bg-gray-700 py-8">
    <div class="container mx-auto px-6 text-center">
      <p class="text-gray-400">&copy; 2025 WealthTrack. All rights reserved.</p>
    </div>
  </footer>

  <!-- JS: Toggle Mobile Menu -->
  <script>
    function toggleMobileMenu() {
      const menu = document.getElementById('mobileMenu');
      menu.classList.toggle('hidden');
    }

    // Auto-hide flash messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
      const messages = document.querySelectorAll('[role="alert"]');
      messages.forEach(message => {
        setTimeout(() => {
          message.parentElement.remove();
        }, 5000);
      });
    });
  </script>
</body>
</html>
