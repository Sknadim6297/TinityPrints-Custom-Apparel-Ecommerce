<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="htmlElement">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin Login - {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script>
            // Initialize dark mode IMMEDIATELY to prevent flash
            (function() {
                const html = document.documentElement;
                const storedDarkMode = localStorage.getItem('adminDarkMode');
                
                if (storedDarkMode === 'true') {
                    html.classList.add('dark');
                } else if (storedDarkMode === 'false') {
                    html.classList.remove('dark');
                } else {
                    if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        html.classList.add('dark');
                    }
                }
            })();
        </script>
    </head>
    <body class="font-sans antialiased transition-colors duration-200"
          x-data="{ 
              darkMode: (() => {
                  const stored = localStorage.getItem('adminDarkMode');
                  if (stored !== null) return stored === 'true';
                  return window.matchMedia('(prefers-color-scheme: dark)').matches;
              })()
          }" 
          x-init="
              $watch('darkMode', val => {
                  localStorage.setItem('adminDarkMode', val);
                  const html = document.documentElement;
                  if (val) {
                      html.classList.add('dark');
                  } else {
                      html.classList.remove('dark');
                  }
              });
          "
          :class="darkMode ? 'bg-gray-900' : 'bg-gradient-to-br from-yellow-50 via-red-50 to-yellow-100'"
          x-cloak>
        
        <div class="min-h-screen flex flex-col justify-center items-center px-4 py-12 sm:px-6 lg:px-8">
            <!-- Dark Mode Toggle -->
            <div class="absolute top-4 sm:top-6 right-4 sm:right-6 z-10">
                <button @click="darkMode = !darkMode" 
                        type="button"
                        class="p-2 sm:p-3 rounded-full bg-white dark:bg-gray-800 shadow-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200 hover:scale-110 border border-gray-200 dark:border-gray-700">
                    <svg x-show="!darkMode" class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="darkMode" class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
            </div>

            <div class="w-full max-w-md">
                <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-2xl sm:rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-700">
                    <!-- Logo Section -->
                    <div class="px-6 sm:px-8 pt-8 sm:pt-10 pb-6 sm:pb-8 text-center bg-gradient-to-br from-yellow-400 via-red-500 to-yellow-600">
                        <img src="{{ asset('frontend/assets/img/logo/logo.png') }}" alt="Tinnity" class="mx-auto h-16 sm:h-20 mb-4">
                        <p class="text-yellow-100 text-xs sm:text-sm font-medium">Admin Portal</p>
                    </div>

                    <!-- Form Section -->
                    <div class="px-6 sm:px-8 py-6 sm:py-8">
                        @if (session('error'))
                            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 text-red-700 dark:text-red-300 rounded">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-medium">{{ session('error') }}</span>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.login') }}" class="space-y-5 sm:space-y-6">
                            @csrf

                            <!-- Email Address -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Email Address
                                </label>
                                <input id="email" 
                                       type="email" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       required 
                                       autofocus 
                                       autocomplete="username"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-transparent transition-all duration-200"
                                       placeholder="admin@tinnity.com">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Password
                                </label>
                                <input id="password" 
                                       type="password" 
                                       name="password" 
                                       required 
                                       autocomplete="current-password"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-transparent transition-all duration-200"
                                       placeholder="••••••••">
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="flex items-center">
                                <input id="remember_me" 
                                       type="checkbox" 
                                       name="remember"
                                       class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-red-600 focus:ring-red-500 dark:focus:ring-red-400 dark:bg-gray-700">
                                <label for="remember_me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    Remember me for 30 days
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div>
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-yellow-400 via-red-500 to-yellow-600 hover:from-yellow-500 hover:via-red-600 hover:to-yellow-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 text-base sm:text-lg">
                                    Sign in to Dashboard
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Footer -->
                <p class="text-center mt-4 sm:mt-6 text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                    © 2026 Tinnity E-commerce. All rights reserved.
                </p>
            </div>
        </div>

        <style>
            [x-cloak] { display: none !important; }
            html, body { transition: background-color 0.2s ease, color 0.2s ease; }
        </style>
    </body>
</html>
