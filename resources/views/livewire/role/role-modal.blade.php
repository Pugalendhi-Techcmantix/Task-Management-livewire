<div class="relative">
    <!-- Header Section -->
    <div class="bg-slate-100 p-5 flex justify-between items-center h-16"> <!-- Set height here -->
        <p class="font-bold text-lg uppercase">Roles</p>
        <button class="text-gray-600 hover:text-gray-900"
            wire:click="$dispatch('closeModal', { component: 'role.role-modal' })">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <x-mary-form wire:submit.prevent="save" class="p-5">
        @csrf
        <x-mary-input label="Name" wire:model="form.name" placeholder="Enter name" name="name" />
        <x-slot:actions>
            <x-mary-button type="button" wire:click="$dispatch('closeModal', { component: 'role.role-modal' })">
                Cancel
            </x-mary-button>
            <x-mary-button class="btn-primary" type="submit">
                {{ $form->role_id ? 'Update' : 'Save' }}
            </x-mary-button>
        </x-slot:actions>
    </x-mary-form>
    <div class="flex justify-end items-center h-full space-x-2"> <!-- Use h-full for alignment -->

    </div>

</div>
