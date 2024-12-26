<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Livewire Styles -->
    @livewireStyles
    <!-- Vite Integration for JS and CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">

    <!-- Layout Wrapper -->
    <div class="flex flex-col min-h-screen">

        <!-- Navigation Bar -->
        @include('layouts.navigation')

        <!-- Header Section -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow sticky top-0 z-10">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset
        @php
            $role = Auth::user()->role_id;
        @endphp

        <!-- Main Content Wrapper -->
        <div class="flex flex-grow" style="height: calc(90vh - 100px);">
            <!-- Fixed Sidebar -->
            <aside class="bg-white dark:bg-gray-800 p-4 w-64 flex-shrink-0">
                <x-mary-menu active-bg-color="bg-info text-white">
                    <x-mary-menu-item :href="route('dashboard')" title="Dashboard" icon="o-home" :active="request()->routeIs('dashboard')"
                        class="{{ request()->routeIs('dashboard') ? 'text-black font-bold' : '' }}" />
                    @if ($role == 1)
                        <x-mary-menu-item :href="route('employee-list')" title="Employees" icon="o-user-group" :active="request()->routeIs('employee-list')"
                            class="{{ request()->routeIs('employee-list') ? 'text-black font-bold' : '' }}" />
                        <x-mary-menu-sub title="Master" icon="c-square-3-stack-3d">
                            <x-mary-menu-item :href="route('role-list')" title="Roles" icon="o-user" :active="request()->routeIs('role-list')"
                                class="{{ request()->routeIs('role-list') ? 'text-black font-bold' : '' }}" />
                            <x-mary-menu-item :href="route('task-list')" title="Tasks" icon="o-clock" :active="request()->routeIs('task-list')"
                                class="{{ request()->routeIs('task-list') ? 'text-black font-bold' : '' }}" />
                        </x-mary-menu-sub>
                    @endif
                </x-mary-menu>
            </aside>

            <!-- Main Content (Scrollable) -->
            <main class="flex-grow p-4 overflow-auto">
                <!-- Page Content -->
                {{ $slot }}
            </main>
        </div>

        <!-- Footer Section (Fixed) -->
        <footer class="bg-white dark:bg-gray-800 shadow py-3">
            <div class="text-center text-gray-500 dark:text-gray-400">
                <p class="mb-0">© {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <!-- Common JS File -->
    <script src="{{ asset('js/common.js') }}"></script>
    @livewire('livewire-ui-modal')
    <!-- Livewire Scripts -->
    @livewireScripts

</body>

</html>
