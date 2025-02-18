@extends('livewire.layout.login-layout')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-6 sm:py-12">
        <div class="relative w-full max-w-xs sm:max-w-md mx-auto">

            <div
                class="absolute inset-0 bg-gradient-to-r from-red-50 via-red-100 to-red-200 transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl">
            </div>
            <!-- Login Form -->
            <form wire:submit.prevent="login" class="relative space-y-6 bg-white shadow-xl rounded-lg p-6 sm:p-8">

                <!-- Logo -->
                <div class="flex justify-center mb-4">
                    <img src="../techc.png" alt="Techcmantix" class="h-12 sm:h-16 object-contain">
                </div>

                @if (session()->has('error'))
                    <div class="bg-red-100 text-red-700 p-3 rounded-md mb-4 text-sm text-center">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="space-y-4">
                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                        <input type="email" id="email" wire:model="email" required
                            class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 text-gray-700">
                        @error('email')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                        <input type="password" id="password" wire:model="password" required
                            class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 text-gray-700">
                        @error('password')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Login Button -->
                <div>
                    <x-mary-button type="submit" icon-right="o-arrow-right-end-on-rectangle"
                        class="w-full bg-gradient-to-r from-red-500 to-blue-500 text-white py-2 px-4 rounded-md transition duration-300 shadow-md text-sm sm:text-base">
                        Login
                    </x-mary-button>
                </div>

                <!-- Footer -->
                <footer class="text-center text-gray-500 text-xs sm:text-sm mt-4">
                    © {{ date('Y') }} Techcmantix Technologies Pvt Ltd. All rights reserved.
                </footer>
            </form>
        </div>
    </div>
@endsection
