<div>
    <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
        <x-mary-card class="col-span-12 lg:col-span-4 relative flex flex-col" title="Profile">
            <x-slot:menu>
                <x-mary-button wire:click="profileclick" icon="o-cog-8-tooth" class="btn-circle btn-ghost btn-sm" />
                <x-mary-icon name="o-heart" class="cursor-pointer text-pink-500" />
            </x-slot:menu>
            <x-mary-card class="bg-blue-500 relative z-10">
                <div class="flex flex-col items-center text-white  font-bold text-center space-y-2">
                    <img src="../pugal-profile.jpg" class="h-40 w-40 rounded-full object-cover" />
                    <p class="text-xl">{{ $name }}</p>
                    <p class="text-md">{{ $position }}</p>
                </div>
            </x-mary-card>
            <x-mary-card class="shadow-lg relative z-20 -mt-3 p-6 bg-white  rounded-lg mx-4">
                <ul class="space-y-2">
                    <li class="flex items-center gap-5 text-lg font-medium">
                        <div class="bg-blue-100 w-10 h-10 flex items-center justify-center rounded-md">
                            <x-heroicon-o-envelope class="w-6 h-6 text-blue-500" />
                        </div>
                        <span>{{ $email }}</span>
                    </li>
                    <li class="flex items-center gap-5 text-lg font-medium">
                        <div class="bg-blue-100 w-10 h-10 flex items-center justify-center rounded-md">
                            <x-heroicon-o-phone-arrow-down-left class="w-6 h-6 text-blue-500" />
                        </div>
                        <span>{{ $number }}</span>
                    </li>
                    <li class="flex items-center gap-5 text-lg font-medium">
                        <div class="bg-blue-100 w-10 h-10 flex items-center justify-center rounded-md">
                            <x-heroicon-o-map-pin class="w-6 h-6 text-blue-500" />
                        </div>
                        <span>{{ $state }}</span>
                    </li>
                    <li class="flex items-center gap-5 text-lg font-medium">
                        <div class="bg-blue-100 w-10 h-10 flex items-center justify-center rounded-md">
                            <x-heroicon-o-globe-americas class="w-6 h-6 text-blue-500" />
                        </div>
                        <span>{{ $country }}</span>
                    </li>
                </ul>
            </x-mary-card>
            <x-mary-card class="bg-blue-50 min-h-96  relative z-10 -mt-52">
            </x-mary-card>
        </x-mary-card>

        <x-mary-card title="About Me" class="col-span-12 lg:col-span-8">

            <p class="text-justify leading-relaxed text-gray-700">
                {{ $about_me }}
            </p>


            <div class="mt-5">
                <strong>Personal Skills</strong>
                <ul class="space-y-2 text-gray-700 dark:text-gray-300  mt-2">
                    <li class="flex items-center gap-2 text-md font-medium">
                        <x-heroicon-o-check-badge class="w-6 h-6 text-blue-500" />
                        <span>Leadership Qualities</span>
                    </li>
                    <li class="flex items-center gap-2 text-md font-medium">
                        <x-heroicon-o-check-badge class="w-6 h-6 text-blue-500" />
                        <span>Strong Teamwork</span>
                    </li>
                    <li class="flex items-center gap-2 text-md font-medium">
                        <x-heroicon-o-check-badge class="w-6 h-6 text-blue-500" />
                        <span>Self-Learner</span>
                    </li>

                    <li class="flex items-center gap-2 text-md font-medium">
                        <x-heroicon-o-check-badge class="w-6 h-6 text-blue-500" />
                        <span>Problem Solving</span>
                    </li>
                    <li class="flex items-center gap-2 text-md font-medium">
                        <x-heroicon-o-check-badge class="w-6 h-6 text-blue-500" />
                        <span>Gamer</span>
                    </li>
                </ul>
            </div>


            <div class="mt-5">
                <strong>Professional Skills</strong>
                <div class="mt-2">
                    <div class="flex justify-between mb-1">
                        <span class="text-md font-medium text-gray-700">React</span>
                        <span class="text-sm font-medium text-gray-700">76%</span>
                    </div>
                    <x-mary-progress value="70" max="100" class="h-3 progress-accent" />
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-md font-medium text-gray-700">Node Js</span>
                        <span class="text-sm font-medium text-gray-700">65%</span>
                    </div>
                    <x-mary-progress value="65" max="100" class="progress-warning h-3" />
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-md font-medium text-gray-700">Laravel</span>
                        <span class="text-sm font-medium text-gray-700">50%</span>
                    </div>
                    <x-mary-progress value="50" max="100" class="h-3" />
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-md font-medium text-gray-700">Livewire</span>
                        <span class="text-sm font-medium text-gray-700">40%</span>
                    </div>
                    <x-mary-progress value="40" max="100" class="h-3 progress-primary" />
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-md font-medium text-gray-700">Java</span>
                        <span class="text-sm font-medium text-gray-700">30%</span>
                    </div>
                    <x-mary-progress value="30" class="progress-error h-3" />

                </div>
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
                    <h2 class="text-3xl font-semibold text-gray-800">{{ $experience }}</h2>
                </div>
            </x-mary-card>
            <x-mary-card class="flex items-center justify-center ">
                <div class="text-center">
                    <div class="bg-green-100 p-4 rounded-full w-fit mx-auto mb-2">
                        <x-heroicon-o-hand-raised class="w-8 h-8 text-green-500" />
                    </div>
                    <h2 class="text-3xl font-semibold text-green-500 ">Projects</h2>
                    <h2 class="text-3xl font-semibold text-gray-800">{{ $projects }}</h2>
                </div>
            </x-mary-card>
            <x-mary-card class="flex items-center justify-center ">
                <div class="text-center">
                    <div class="bg-orange-100 p-4 rounded-full w-fit mx-auto mb-2">
                        <x-heroicon-o-trophy class="w-8 h-8 text-orange-500" />
                    </div>
                    <h2 class="text-3xl font-semibold text-orange-500">Awards</h2>
                    <h2 class="text-3xl font-semibold text-gray-800">{{ $awards }}</h2>
                </div>
            </x-mary-card>
        </div>

        <x-mary-card title="Education" class="col-span-12 lg:col-span-4 ">
            <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                <li class="flex items-center gap-4 text-lg font-medium">
                    <div class="bg-red-100 p-4 rounded-full w-fit mb-2">
                        <x-heroicon-o-home-modern class="w-6 h-6 text-red-500" />
                    </div>
                    <p class=""><strong>MCA</strong> - Bishop Heber College Trichy.
                        <br />
                        2022-2024
                    </p>
                </li>
                <li class="flex items-center gap-4 text-lg font-medium">
                    <div class="bg-blue-100 p-4 rounded-full w-fit mb-2">
                        <x-heroicon-o-home-modern class="w-6 h-6 text-blue-500" />
                    </div>
                    <p class=""><strong>BCA</strong> - Bishop Heber College Trichy.
                        <br />
                        2019-2022
                    </p>
                </li>
                <li class="flex items-center gap-4 text-lg font-medium">
                    <div class="bg-amber-100 p-4 rounded-full w-fit mb-2">
                        <x-heroicon-o-building-library class="w-6 h-6 text-amber-500" />
                    </div>
                    <p class=""><strong>HSC</strong> - Bishop Heber Hr Sec School Trichy.
                        <br />
                        2018-2019
                    </p>
                </li>
                <li class="flex items-center gap-4 text-lg font-medium">
                    <div class="bg-lime-100 p-4 rounded-full w-fit mb-2">
                        <x-heroicon-o-building-library class="w-6 h-6 text-lime-500" />
                    </div>
                    <p class=""><strong>SSLC</strong> - Bishop Heber Hr Sec School Trichy.
                        <br />
                        2016-2017
                    </p>
                </li>

            </ul>
        </x-mary-card>

        <x-mary-card title="Experience" class="col-span-12 lg:col-span-4 ">
            <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                <li class="flex items-center gap-4 text-lg font-medium">
                    <div class="bg-red-100 p-4 rounded-full w-fit mb-2">
                        <x-heroicon-o-home-modern class="w-6 h-6 text-red-500" />
                    </div>
                    <p class=""><strong>Techcmantix</strong> - Technology Pvt Ltd Trichy.
                        <br />
                        2024-Present
                    </p>
                </li>
                <li class="flex items-center gap-4 text-lg font-medium">
                    <div class="bg-blue-100 p-4 rounded-full w-fit mb-2">
                        <x-heroicon-o-home-modern class="w-6 h-6 text-blue-500" />
                    </div>
                    <p class=""><strong>RockG</strong> - Micro Technology Pvt Ltd Trichy.
                        <br />
                        2023-2024
                    </p>
                </li>
            </ul>
        </x-mary-card>
    </div>


    <x-mary-drawer wire:model="openProfile" class="w-full lg:w-1/2" title="Info" separator with-close-button
        close-on-escape right>
        <x-mary-form wire:submit.prevent="save" class="grid grid-cols-3">
            <x-mary-input label="Name" wire:model="name" placeholder="Enter Name" />
            <x-mary-input label="Email" type="email" wire:model="email" placeholder="Enter Email" />
            <x-mary-input label="Position" wire:model="position" placeholder="Enter Position" />
            <x-mary-input label="Phone" type="number" wire:model="number" min="0" 
                placeholder="Enter Ph.No" />
            <x-mary-input label="State" wire:model="state" placeholder="Enter State" />
            <x-mary-input label="Country" wire:model="country" placeholder="Enter Country" />
            <x-mary-input label="Experience" type="number" wire:model="experience" min="0" />
            <x-mary-input label="Projects" type="number" wire:model="projects" min="0" />
            <x-mary-input label="Awards" type="number" wire:model="awards" min="0" />

            <x-mary-textarea label="About Me" wire:model="about_me" placeholder="Enter " />


            <x-slot:actions>
                <x-mary-button type="button" wire:click="openProfile=false">
                    Cancel
                </x-mary-button>
                <x-mary-button class="btn-primary" type="submit">
                    Save
                </x-mary-button>
            </x-slot:actions>
        </x-mary-form>
    </x-mary-drawer>
</div>
