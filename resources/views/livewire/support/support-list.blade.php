<div class="mt-3 gap-5">

    <x-mary-card title="Incoming Support Messages!">
        <x-slot:menu class="flex-wrap">
            <x-mary-button class="btn-sm" label="OverAll" :badge="$overAllMsg" />
            <x-mary-button class="btn-sm" label="Today" :badge="$todayMsg" badge-classes="badge-warning" />
            <span class="font-semibold">Priority : </span>
            <x-mary-button wire:click="filterByPriority(1)" class="btn-success btn-xs" label="Low"
                tooltip="List Low" />
            <x-mary-button wire:click="filterByPriority(2)" class="btn-warning btn-xs" label="Medium"
                tooltip="List Medium" />
            <x-mary-button wire:click="filterByPriority(3)" class="btn-error btn-xs" label="High"
                tooltip="List High" />
            <x-mary-button wire:click="filterByPriority(null)" class="btn-outline btn-xs" label="All"
                tooltip="List All" />
        </x-slot:menu>
        @foreach ($messages as $msg)
            <x-mary-list-item :item="$msg">
                <x-slot:avatar class="flex  justify-between flex-wrap gap-3">
                    <x-mary-badge
                        class="{{ $msg->priority == 1 ? 'badge-success' : ($msg->priority == 2 ? 'badge-warning' : 'badge-error') }}" />
                    <x-mary-badge value="{{ $msg->user->name }}" class="badge-info" />

                </x-slot:avatar>
                <x-slot:value class="flex justify-between flex-wrap">
                    <p>Message: {{ $msg->message }}</p>
                    <p class="text-info"> Submitted:
                        {{ \Carbon\Carbon::parse($msg->created_at)->format('d-m-y h:m:s') }}</p>
                </x-slot:value>
                <x-slot:sub-value class="flex justify-between flex-wrap">
                    <p>Subject: {{ $msg->subject }}</p>

                    <p class="text-primary">
                        <span class="text-black "> Category:</span>
                        {{ $msg->category == 1 ? 'Bug' : ($msg->category == 2 ? 'Feature Request' : 'General Query') }}
                    </p>


                </x-slot:sub-value>
            </x-mary-list-item>
        @endforeach

    </x-mary-card>
</div>
