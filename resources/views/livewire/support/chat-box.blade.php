<div class="grid  grid-cols-1 md:grid-cols-12">
    <x-mary-card class="bg-black col-span-12 lg:col-span-4" title="ChatBox">
        <x-slot:title>
            <span class="text-white">ChatBox</span>
        </x-slot:title>
        <x-slot:menu>
            <x-mary-input icon="o-magnifying-glass" placeholder="Search" wire:model.live="search"
                class="focus:outline-none border-0 size-8" />
            <x-mary-dropdown  icon="o-ellipsis-vertical" class="btn-xs btn-circle">
                <x-mary-menu-item title="Clear Chat" icon="o-trash" />
            </x-mary-dropdown>
        </x-slot:menu>
        <div class="text-white flex ">
            @foreach ($users as $user)
                <div>{{ $user->name }} , </div>
            @endforeach
        </div>
        <div wire:poll.1s="chatget" class="max-h-96 overflow-auto  scrollbar-thin border-2 bg-gray-100 px-10 ">
            @foreach ($messages as $message)
                <div class="py-2 flex {{ $message->user_id == Auth::id() ? 'justify-end' : '' }}">
                    <div class="{{ $message->user_id == Auth::id() ? 'bg-green-300' : 'bg-white' }} p-2 rounded-md">
                        @if ($message->user_id != Auth::id())
                            <x-mary-badge :value="$message->user->name" class="bg-red-500/10"></x-mary-badge>
                        @endif
                        <p>{{ $message->message }}</p>
                        <span
                            class="text-gray-500 text-xs block text-right">{{ $message->created_at->format('h:i A') }}</span>
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
            <x-mary-input type="text" wire:model="newMessage" class="border-0 focus:outline-none"
                placeholder="Type a message" />
            <x-mary-button wire:click="sendMessage" icon-right="m-arrow-right-circle">Send</x-mary-button>
        </x-slot:actions>
    </x-mary-card>
</div>
