<div class="relative">
    <!-- Header Section -->
    <div class="bg-slate-100 p-5 flex justify-between items-center h-16"> <!-- Set height here -->
        <p class="font-bold text-lg uppercase">Employee</p>
        <button class="text-gray-600 hover:text-gray-900"
            wire:click="$dispatch('closeModal', { component: 'employee.employee-modal' })">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <x-mary-form wire:submit.prevent="save" class="p-5">
        @csrf
        <div class="grid grid-cols-2 gap-3">
            <x-mary-input label="Name" wire:model="form.name" placeholder="Enter your name" name="name" />

            <x-mary-input label="Email" type="email" wire:model="form.email" placeholder="Enter your email"
                name="email" />

            <x-mary-input label="Age" type="number" min="1" wire:model="form.age"
                placeholder="Enter your age" name="age" />

            <x-mary-input label="Position" wire:model="form.position" placeholder="Enter your Position"
                name="position" />

            <x-mary-select label="Role" wire:model="form.role" :options="$roles" placeholder="Select Role"
                :disabled="isset($form->employee_id)" />

            <x-mary-input label="Salary" type="number" min="0" wire:model="form.salary"
                placeholder="Enter your Salary" name="salary" />

            <x-mary-datetime label="D.O.J" wire:model="form.joining_date" placeholder="Enter your D.O.J"
                name="joining_date" />

            @if ($form->employee_id)
                <x-mary-select label="Status" wire:model="form.status" :options="$statusOptions" placeholder="Select Status" />
            @endif
        </div>
        <x-slot:actions>
            <x-mary-button type="button"
                wire:click="$dispatch('closeModal', { component: 'employee.employee-modal' })">
                Cancel
            </x-mary-button>
            <x-mary-button class="btn-primary" type="submit">
                {{ $form->employee_id ? 'Update' : 'Save' }}
            </x-mary-button>
        </x-slot:actions>
    </x-mary-form>
    <div class="flex justify-end items-center h-full space-x-2"> <!-- Use h-full for alignment -->

    </div>

</div>
