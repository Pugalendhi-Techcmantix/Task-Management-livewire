<x-mary-card class="bg-black" title="ChatBox">
    <x-slot:title>
        <span class="text-white">ChatBox</span>
    </x-slot:title>
    <x-slot:menu>
        <span class="font-bold text-white">Members {{ $usersCount }}</span>
        <x-mary-dropdown icon="o-ellipsis-vertical" class="btn-xs btn-circle">
            <x-mary-menu-item title="info" icon="o-information-circle" />
            @if (Auth::user()->role_id == 1)
                <x-mary-menu-item title="Clear Chat" wire:click="deleteAllMessages" icon="o-trash" />
            @endif

        </x-mary-dropdown>
    </x-slot:menu>
    <div wire:poll.1s="chatget" class="min-h-96 max-h-96 overflow-auto  scrollbar-thin border-2  bg-gray-100 px-2 ">
        @php
            $colors = ['bg-red-500/40', 'bg-blue-500/40', 'bg-green-500/40', 'bg-yellow-500/40', 'bg-purple-500/40'];
        @endphp

        @foreach ($messages as $message)
            @php
                // Assign a consistent color based on the user ID (modulo operator ensures it cycles through the 5 colors)
                $colorIndex = $message->user_id % count($colors);
                $userColor = $colors[$colorIndex];

                $messageDate = $message->updated_at->format('Y-m-d');
                $today = now()->format('Y-m-d');
                $yesterday = now()->subDay()->format('Y-m-d');

                if ($messageDate == $today) {
                    $formattedDate = $message->updated_at->format('h:i A'); // Only time for today
                } elseif ($messageDate == $yesterday) {
                    $formattedDate = 'Yesterday, ' . $message->updated_at->format('h:i A');
                } elseif ($message->updated_at->greaterThanOrEqualTo(now()->startOfWeek())) {
                    $formattedDate = $message->updated_at->format('l, h:i A'); // Day name + time for current week
                } else {
                    $formattedDate = $message->updated_at->format('d-m-y, h:i A'); // Full date + time for previous weeks
                }
            @endphp
            <div class="py-2 flex {{ $message->user_id == Auth::id() ? 'justify-end' : '' }}">
                <div class="{{ $message->user_id == Auth::id() ? 'bg-green-300' : 'bg-white' }} p-2 rounded-md">
                    @if ($message->user_id != Auth::id())
                        <x-mary-badge :value="$message->user->name" class="{{ $userColor }}"></x-mary-badge>
                    @endif
                    <p>{{ $message->message }}</p>
                    <span class="text-gray-500 text-xs block text-right">
                        {{-- {{ $message->updated_at->format('d-m-y h:i A') }} --}}
                        {{ $formattedDate }}
                    </span>
                </div>
            </div>
        @endforeach

    </div>
    @if (session()->has('error'))
        <div class="text-yellow-300 text-center mt-2">
            <x-mary-alert title="{{ session('error') }}" icon="o-exclamation-triangle" class="alert-warning"
                dismissible />
        </div>
    @endif

    <x-slot:actions>    
        <x-mary-textarea wire:model="newMessage" class="border-0 focus:outline-none size-8" placeholder="Type a message"
            autocomplete="off" />
        <x-mary-button wire:click="sendMessage" icon-right="m-arrow-right-circle" class="btn-sm" >Send</x-mary-button>
    </x-slot:actions>
</x-mary-card>
