<x-app-layout>

    @if (Auth::user()->role_id == 1)
        {{-- Load Admin Dashboard --}}
        @livewire('dashboard.dashboard')
    @else
        {{-- Load User Dashboard --}}
        @livewire('dashboard.user-dashboard')
    @endif
</x-app-layout>
    