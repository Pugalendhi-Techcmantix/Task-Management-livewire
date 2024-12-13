<div class="container mt-5 ">
    <x-mary-card shadow class="border border-dashed">
        <div class="row">
            <div class="col-md-6 col-12">
                <x-mary-form wire:submit.prevent="submit">
                    @csrf
                    <x-mary-header title="STUDENT ENTRIES" size="text-xl" class="text-primary" />
                    @if(session()->has('success'))
                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-init="setTimeout(() => show = false, 5000)"
                        x-transition
                        role="alert">
                        <x-mary-alert title="{{ session('success')}}" icon="o-check-badge" dismissible class="text-success" />
                    </div>
                    @endif
                    <x-mary-input
                        label="Name"
                        wire:model.defer="name"
                        placeholder="Enter your name"
                        icon="o-user"
                        name="name"
                        value="{{ old('name') }}"
                        error="{{ $errors->first('name') }}" />

                    <x-mary-input
                        label="Roll Number"
                        type="number"
                        min="1"
                        wire:model.defer="rollno"
                        placeholder="Enter your roll number"
                        icon="o-hashtag"
                        name="rollno"
                        value="{{ old('rollno') }}"
                        error="{{ $errors->first('rollno') }}" />

                    <x-mary-input
                        label="Age"
                        type="number"
                        min="1"
                        wire:model.defer="age"
                        placeholder="Enter your age"
                        icon="o-clock"
                        name="age"
                        value="{{ old('age') }}"
                        error="{{ $errors->first('age') }}" />
                    <div class="d-flex justify-center gap-2 mt-4">
                        <x-mary-button label="Back" wire:click="back" spinner />
                        <x-mary-button type="submit" class="btn-primary" spinner="submit">Register</x-mary-button>
                    </div>
                </x-mary-form>
            </div>
            <div class="col-md-6 d-none d-md-block">
                <div class="card">
                    <img src="/../regiter.jpg" alt="Student Image" class="img-fluid">
                </div>
            </div>
        </div>
    </x-mary-card>
</div>