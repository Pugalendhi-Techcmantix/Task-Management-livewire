<div class="mt-3 grid grid-cols-1 lg:grid-cols-2 gap-5">
    <x-mary-card title="Support">
        <x-mary-form wire:submit.prevent="save" class="p-5">
            <x-mary-input label="Subject" wire:model="subject" placeholder="Enter Subject " />
            <x-mary-select label="Category" wire:model="category" :options="$categoryOptions" placeholder="Enter Category " />
            <x-mary-textarea label="Message" wire:model="message" placeholder="Enter message " />
            <x-mary-select label="Priority" wire:model="priority" :options="$priorityOptions" placeholder="Select Priority" />

            <x-slot:actions>
                <x-mary-button class="btn-primary" type="submit" spinner>
                    Submit
                </x-mary-button>
            </x-slot:actions>
        </x-mary-form>
    </x-mary-card>
</div>
