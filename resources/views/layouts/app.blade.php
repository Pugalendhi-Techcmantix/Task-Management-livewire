<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Task-Management') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    {{-- Vanilla Calendar --}}
    <script src="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro@2.9.6/build/vanilla-calendar.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro@2.9.6/build/vanilla-calendar.min.css"
        rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <!-- Livewire Styles -->
    @livewireStyles
    <!-- Vite Integration for JS and CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <x-mary-toast />

    <!-- Layout Wrapper -->
    <div class="flex flex-col min-h-screen">

        <!-- Navigation Bar -->
        @include('layouts.navigation')



        <!-- Main Content Wrapper -->
        <div class="flex flex-grow" style="height: calc(90vh - 100px);">

            <!-- Fixed Sidebar -->
            <aside class="bg-white dark:bg-gray-800 p-4 w-64 flex-shrink-0 sm:block hidden">
                <x-mary-menu active-bg-color="bg-error text-white">
                    <x-mary-menu-item :href="route('dashboard')" title="Dashboard" icon="o-home" :active="request()->routeIs('dashboard')"
                        class="{{ request()->routeIs('dashboard') ? 'text-black font-bold' : '' }}" />
                    @if ($role == 1)
                        <x-mary-menu-item :href="route('employee-list')" title="Employees" icon="o-user-group" :active="request()->routeIs('employee-list')"
                            class="{{ request()->routeIs('employee-list') ? 'text-black font-bold' : '' }}" />
                        <x-mary-menu-item :href="route('role-list')" title="Roles" icon="o-user" :active="request()->routeIs('role-list')"
                            class="{{ request()->routeIs('role-list') ? 'text-black font-bold' : '' }}" />
                        <x-mary-menu-item :href="route('task-list')" title="Tasks" icon="o-bars-4" :active="request()->routeIs('task-list')"
                            class="{{ request()->routeIs('task-list') ? 'text-black font-bold' : '' }}" />
                        <x-mary-menu-item :href="route('support-list')" title="Support Messages" :badge="$supportMsg"
                            badge-classes="!badge-warning float-right" icon="o-phone-arrow-down-left" :active="request()->routeIs('support-list')"
                            class="{{ request()->routeIs('support-list') ? 'text-black font-bold' : '' }}" />
                    @endif
                    @if ($role == 2)
                        <x-mary-menu-item :href="route('pending')" title="Pending" :badge="$pending"
                            badge-classes="!badge-warning float-right" icon="o-exclamation-triangle" :active="request()->routeIs('pending')"
                            class="{{ request()->routeIs('pending') ? 'text-black font-bold' : '' }}" />

                        <x-mary-menu-item :href="route('progress')" title="Progress" :badge="$progress"
                            badge-classes="!badge-info float-right" icon="o-clock" :active="request()->routeIs('progress')"
                            class="{{ request()->routeIs('progress') ? 'text-black font-bold' : '' }}" />

                        <x-mary-menu-item :href="route('hold')" title="Hold" :badge="$hold"
                            badge-classes="!badge-error float-right" icon="o-pause-circle" :active="request()->routeIs('hold')"
                            class="{{ request()->routeIs('hold') ? 'text-black font-bold' : '' }}" />

                        <x-mary-menu-item :href="route('completed')" title="Completed" :badge="$completed"
                            badge-classes="!badge-success float-right" icon="o-check-circle" :active="request()->routeIs('completed')"
                            class="{{ request()->routeIs('completed') ? 'text-black font-bold' : '' }}" />

                        <x-mary-menu-item :href="route('support-page')" title="Support" badge-classes="!badge-success float-right"
                            icon="o-phone-arrow-up-right" :active="request()->routeIs('support-page')"
                            class="{{ request()->routeIs('support-page') ? 'text-black font-bold' : '' }}" />
                    @endif

                </x-mary-menu>

                <!-- Gemini AI Button at the Bottom -->
                <x-mary-button label="GeminiAi"
                    class="w-full mt-auto bg-gradient-to-r from-blue-500 to-purple-600 text-white font-bold py-2 rounded-lg transition hover:scale-105" />
            </aside>

            <!-- Main Content (Scrollable) -->
            <main class="flex-grow p-6 overflow-auto">
                <!-- Page Content -->
                {{ $slot }}
            </main>
        </div>

        <!-- Footer Section (Fixed) -->
        <footer class="bg-white dark:bg-gray-800 shadow py-3">
            <div class="text-center text-gray-500 dark:text-gray-400">
                <p class="mb-0">© {{ date('Y') }} {{ config('app.name', 'Task-Management') }}. All rights
                    reserved.</p>
            </div>
        </footer>
    </div>

    <!-- Common JS File -->
    <script src="{{ asset('js/common.js') }}"></script>
    @livewire('livewire-ui-modal')
    <!-- Livewire Scripts -->
    @livewireScripts
    @livewireCalendarScripts

</body>
<!-- Floating Chat Button -->
<div class="fixed bottom-16 right-10 z-50">
    <x-mary-popover position="top-start" offset="10">
        <x-slot:trigger>
            <x-mary-button icon="o-chat-bubble-bottom-center-text" class="btn-error btn-circle shadow-lg" />
        </x-slot:trigger>
        <x-slot:content>
            <div class="w-[430px] h-[550px]  rounded-lg overflow-hidden">
                @livewire('support.chat-box')
            </div>
        </x-slot:content>
    </x-mary-popover>
</div>

</html>
