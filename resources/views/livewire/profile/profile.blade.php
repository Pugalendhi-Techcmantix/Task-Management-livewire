<div>
    <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
        <x-mary-card class="col-span-12 lg:col-span-4 relative flex flex-col" title="Profile">
            <x-slot:menu>
                <x-mary-button wire:click="profileclick" icon="o-cog-8-tooth" class="btn-circle btn-ghost btn-sm" />
                <x-mary-icon name="o-heart" class="cursor-pointer text-pink-500" />
            </x-slot:menu>
            <x-mary-card class="bg-blue-500 relative z-10">
                <div class="flex flex-col items-center text-white  font-bold text-center space-y-2">
                    @if ($this->photo)
                        <img src="{{ asset('storage/' . $this->photo) }}" class="w-40 h-40 rounded-full object-cover">
                    @else
                        <img src="{{ asset('storage/profile_images/no-image.png') }}"
                            class="w-40 h-40 rounded-full object-cover">
                    @endif

                    <p class="text-xl">{{ $name }}</p>
                    <p class="text-md">{{ $position }}</p>
                </div>
            </x-mary-card>
            <x-mary-card class="shadow-lg relative z-20 -mt-3 p-6 bg-white  rounded-lg mx-4">
                <ul class="space-y-2 ">
                    <li class="flex items-center gap-5 text-lg font-medium whitespace-nowrap">
                        <div class="bg-blue-100 w-10 h-10 flex items-center justify-center rounded-md">
                            <x-heroicon-o-envelope class="w-6 h-6 text-blue-500" />
                        </div>
                        <span class="truncate">{{ $email }}</span>
                    </li>
                    <li class="flex items-center gap-5 text-lg font-medium whitespace-nowrap">
                        <div class="bg-blue-100 w-10 h-10 flex items-center justify-center rounded-md">
                            <x-heroicon-o-phone-arrow-down-left class="w-6 h-6 text-blue-500" />
                        </div>
                        <span class="truncate">{{ $number ?? 'Not filled' }}</span>
                    </li>
                    <li class="flex items-center gap-5 text-lg font-medium whitespace-nowrap">
                        <div class="bg-blue-100 w-10 h-10 flex items-center justify-center rounded-md">
                            <x-heroicon-o-map-pin class="w-6 h-6 text-blue-500" />
                        </div>
                        <span class="truncate">{{ $state ?? 'Not filled' }}</span>
                    </li>
                    <li class="flex items-center gap-5 text-lg font-medium whitespace-nowrap">
                        <div class="bg-blue-100 w-10 h-10 flex items-center justify-center rounded-md">
                            <x-heroicon-o-globe-americas class="w-6 h-6 text-blue-500" />
                        </div>
                        <span class="truncate">{{ $country ?? 'Not filled' }}</span>
                    </li>
                </ul>
            </x-mary-card>
            <x-mary-card class="bg-blue-50 min-h-96  relative z-10 -mt-52">
            </x-mary-card>
        </x-mary-card>

        <x-mary-card title="About Me" class="col-span-12 lg:col-span-8">
            <p class="text-justify leading-relaxed text-gray-700">
                {{ $about_me ?? 'No about  added yet.' }}
            </p>

            <div class="mt-5">
                <strong>Personal Skills</strong>
                @if (!empty($personal_skills) && is_array($personal_skills))
                    <ul class="space-y-2 text-gray-700 dark:text-gray-300 mt-2">
                        @foreach ($personal_skills as $skill)
                            <li class="flex items-center gap-2 text-md font-medium">
                                <x-heroicon-o-check-badge class="w-6 h-6 text-blue-500" />
                                <span>{{ $skill }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">No skills added yet.</p>
                @endif


            </div>

            <div class="mt-5">
                <strong>Professional Skills</strong>
                @if ($professional_skills)
                    @php
                        // Sort the skills array in descending order by value
                        $sorted_skills = collect($professional_skills)
                            ->map(function ($skill) {
                                // Clean up spaces and split the skill into name and value
                                $skill = trim($skill); // Remove extra spaces

                                // Try splitting by ' - ', else split by '-'
                                $parts = explode(' - ', $skill);

                                // If ' - ' did not split, try splitting by '-'
                                if (count($parts) == 1) {
                                    $parts = explode('-', $skill);
                                }
                                $name = $parts[0] ?? 'Unknown';
                                $value = isset($parts[1]) ? trim($parts[1]) : 0; // Trim the value to remove any extra spaces

                                return ['name' => $name, 'value' => $value];
                            })
                            ->sortByDesc('value'); // Sort by value in descending order
                    @endphp

                    @foreach ($sorted_skills as $skill)
                        @php
                            // Determine the class based on value range
                            if ($skill['value'] >= 90) {
                                $progressClass = 'progress-success';
                            } elseif ($skill['value'] >= 70) {
                                $progressClass = 'progress-info';
                            } elseif ($skill['value'] >= 60) {
                                $progressClass = 'progress-accent';
                            } elseif ($skill['value'] >= 50) {
                                $progressClass = 'progress-error';
                            } elseif ($skill['value'] >= 30) {
                                $progressClass = 'progress-primary';
                            } elseif ($skill['value'] >= 10) {
                                $progressClass = 'progress';
                            } else {
                                $progressClass = 'progress-warning'; // For values below 30
                            }
                        @endphp

                        <div class="mt-2">
                            <div class="flex justify-between mb-1">
                                <span class="text-md font-medium text-gray-700">{{ $skill['name'] }}</span>
                                <span class="text-sm font-medium text-gray-700">{{ $skill['value'] }}%</span>
                            </div>
                            <x-mary-progress value="{{ $skill['value'] }}" max="100"
                                class="h-3 {{ $progressClass }}" />
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500">No skills added yet.</p>
                @endif
            </div>

        </x-mary-card>
    </div>




    <div class="grid grid-cols-1 md:grid-cols-12 gap-5 mt-5">
        <div class="col-span-12 lg:col-span-4 relative flex flex-col gap-5 ">
            <x-mary-card class="flex items-center justify-center ">
                <div class="text-center">
                    <div class="bg-blue-100 p-4 rounded-full w-fit mx-auto mb-2">
                        <x-heroicon-o-code-bracket-square class="w-8 h-8 text-blue-500" />
                    </div>
                    <h2 class="text-3xl font-semibold text-blue-500">Experience</h2>
                    <h2 class="text-3xl font-semibold text-gray-800">{{ $job_experience }}+</h2>
                </div>
            </x-mary-card>
            <x-mary-card class="flex items-center justify-center ">
                <div class="text-center">
                    <div class="bg-green-100 p-4 rounded-full w-fit mx-auto mb-2">
                        <x-heroicon-o-hand-raised class="w-8 h-8 text-green-500" />
                    </div>
                    <h2 class="text-3xl font-semibold text-green-500 ">Projects</h2>
                    <h2 class="text-3xl font-semibold text-gray-800">{{ $projects }}+</h2>
                </div>
            </x-mary-card>
            <x-mary-card class="flex items-center justify-center ">
                <div class="text-center">
                    <div class="bg-orange-100 p-4 rounded-full w-fit mx-auto mb-2">
                        <x-heroicon-o-trophy class="w-8 h-8 text-orange-500" />
                    </div>
                    <h2 class="text-3xl font-semibold text-orange-500">Awards</h2>
                    <h2 class="text-3xl font-semibold text-gray-800">{{ $awards }}+</h2>
                </div>
            </x-mary-card>
        </div>

        <x-mary-card title="Education" class="col-span-12 lg:col-span-4">
            <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                @foreach ($education as $edu)
                    <li class="flex items-center gap-4 text-lg font-medium">
                        <div class="bg-lime-100 p-4 rounded-full w-fit mb-2">
                            <x-heroicon-o-building-library class="w-6 h-6 text-lime-500" />
                        </div>
                        <p>
                            <strong>{{ $edu['degree'] }}</strong> - {{ $edu['institution'] }}.
                            <br />
                            {{ $edu['year'] }}
                        </p>
                    </li>
                @endforeach
            </ul>
        </x-mary-card>
        <x-mary-card title="Experience" class="col-span-12 lg:col-span-4">
            <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                @foreach ($experience as $exp)
                    <li class="flex items-center gap-4 text-lg font-medium">
                        <div class="bg-red-100 p-4 rounded-full w-fit mb-2">
                            <x-heroicon-o-home-modern class="w-6 h-6 text-red-500" />
                        </div>
                        <p>
                            <strong>{{ $exp['role'] }}</strong> - {{ $exp['company'] }}.
                            <br />
                            {{ $exp['year'] }}
                        </p>
                    </li>
                @endforeach
            </ul>
        </x-mary-card>

    </div>


    <x-mary-drawer wire:model="openProfile" class="w-full lg:w-1/2" title="Info" separator with-close-button
        close-on-escape right>
        <x-mary-form wire:submit.prevent="save">
            <div class="grid grid-cols-1 md:grid-cols-12 lg:grid-cols-3 gap-3">
                <x-mary-input label="Name" wire:model="name" placeholder="Enter Name" />
                <x-mary-input label="Email" type="email" wire:model="email" placeholder="Enter Email" />
                <x-mary-input label="Position" wire:model="position" placeholder="Enter Position" />
                <x-mary-input label="Phone" type="number" wire:model="number" min="0"
                    placeholder="Enter Ph.No" />
                <x-mary-input label="State" wire:model="state" placeholder="Enter State" />
                <x-mary-input label="Country" wire:model="country" placeholder="Enter Country" />
                <x-mary-input label="Job Experience" type="number" wire:model="job_experience" min="0" />
                <x-mary-input label="Projects" type="number" wire:model="projects" min="0" />
                <x-mary-input label="Awards" type="number" wire:model="awards" min="0" />
            </div>
            <x-mary-tags label="Personal Skills" wire:model="personal_skills"
                hint="example : Hard worker , Problem solver" />
            <x-mary-tags label="Professional Skills" wire:model="professional_skills"
                hint="example : React - 70 , Java - 90" />

            <x-mary-textarea label="About Me" wire:model="about_me" placeholder="Your story ..." rows="3" />
            <div class="flex  justify-start flex-wrap gap-2 mb-3">
                @if ($this->photo)
                    <img src="{{ asset('storage/' . $this->photo) }}" class="w-30 h-20 rounded-full object-cover">
                @else
                    <img src="{{ asset('storage/profile_images/no-image.png') }}"
                        class="w-30 h-20 rounded-full object-cover">
                @endif
                <x-mary-file wire:model="photo" accept="image/png, image/jpeg"
                    hint="Only png/jpeg .. Please wait for the image to upload. This might take up to 1 minute. " />
            </div>
            <div>
                <div class="grid lg:grid-cols-4 gap-3 ">
                    @foreach ($education as $index => $edu)
                        <x-mary-input wire:model="education.{{ $index }}.degree" placeholder="Degree" />
                        <x-mary-input wire:model="education.{{ $index }}.institution"
                            placeholder="Institution" />
                        <x-mary-input wire:model="education.{{ $index }}.year" placeholder="Year" />
                        <x-mary-button wire:click="removeEducation({{ $index }})"
                            class="btn-square btn-outline">-</x-mary-button>
                    @endforeach
                </div>

                <button type="button" wire:click="addEducation"
                    class="mt-3 px-4 py-2 bg-blue-500 text-white rounded">+ Add Education</button>
            </div>
            <div>
                <div class="grid lg:grid-cols-4 gap-3 ">
                    @foreach ($experience as $index => $exp)
                        <x-mary-input wire:model="experience.{{ $index }}.role" placeholder="role" />
                        <x-mary-input wire:model="experience.{{ $index }}.company" placeholder="company" />
                        <x-mary-input wire:model="experience.{{ $index }}.year" placeholder="Year" />
                        <x-mary-button wire:click="removeExperience({{ $index }})"
                            class="btn-square btn-outline">-</x-mary-button>
                    @endforeach
                </div>

                <button type="button" wire:click="addExperience"
                    class="mt-3 px-4 py-2 bg-blue-500 text-white rounded">+ Add Experience</button>
            </div>



            <x-mary-button label="Save"
                class="bg-gradient-to-r border-0 from-red-500 to-blue-500 text-white w-52 flex shadow-lg"
                type="submit" />

        </x-mary-form>
    </x-mary-drawer>
</div>
