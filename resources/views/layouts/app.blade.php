<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Livewire Styles -->
    @livewireStyles
    <!-- Vite Integration for JS and CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">


    <!-- Layout Wrapper -->
    <div class="d-flex flex-column min-vh-100 bg-gray-100 dark:bg-gray-900">

        <!-- Navigation Bar -->
        @include('layouts.navigation')

        <!-- Header Section -->
        @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow sticky-top">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Main Content Wrapper -->
        <div class="d-flex flex-grow-1" style="height: calc(90vh - 100px);">
            <!-- Fixed Sidebar -->
            <aside class="bg-white p-3 w-64">
                <x-mary-menu active-bg-color="bg-purple-500/20">
                    <!-- Dashboard Menu Item -->
                    <x-mary-menu-item
                        title="Theme"  @click="$dispatch('mary-toggle-theme')"
                        :href="route('dashboard')"
                        title="Dashboard"
                        icon="o-home"
                        :active="request()->routeIs('dashboard')"
                        class="{{ request()->routeIs('dashboard') ? 'text-black' : 'text-purple-500 font-bold' }}" />

                    <!-- Student Menu Item -->
                    <x-mary-menu-item
                        :href="route('student-list')"
                        title="Student"
                        icon="o-user-group"
                        :active="request()->routeIs('student-list')"
                        class="{{ request()->routeIs('student-list') ? 'text-black' : 'text-purple-500 font-bold' }}" />
                </x-mary-menu>
            </aside>

            <!-- Main Content (Scrollable) -->
            <main class="flex-grow-1 p-4 overflow-auto">
                <!-- Page Content -->
                {{ $slot }}

            </main>
        </div>

        <!-- Footer Section (Fixed) -->
        <footer class="bg-white dark:bg-gray-800 shadow py-3 mt-auto">
            <div class="container-fluid text-center">
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