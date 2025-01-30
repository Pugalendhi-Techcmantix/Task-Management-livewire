<div>
    <x-mary-tabs wire:model="selectedTab" active-class="bg-error rounded text-white " label-class="font-semibold"
        label-div-class="bg-error/5 p-2 rounded">
        @foreach ($projectNames as $projectName)
            <x-mary-tab name="{{ $projectName }}-tab" :active="$selectedTab === $projectName" label="{{ $projectName }}">
                <x-mary-card title="{{ $projectName }}" separator class="border-2 border-red-500/20">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="mb-3">Project name: {{ $projectName }}</h1>
                            <h1 class="mb-3">Total Modules and Tasks within the project:
                                {{ $projects[$projectName]['totalTasks'] }}
                            </h1>
                            <h1 class="mb-3">Developers: {{ $projects[$projectName]['totalEmployees'] }}</h1>
                            <div class="">
                                {{-- <x-mary-drawer wire:model="showDrawer1" class="w-11/12 lg:w-1/3" title="Hello"
                                subtitle="Livewire" separator with-close-button>
                            </x-mary-drawer> --}}

                                @foreach ($projects[$projectName]['users'] as $user)
                                    <x-mary-button :label="$user" class="bg-red-500/10 border-0 btn-sm "
                                        :tooltip="$user"
                                        wire:click="loadUserTasks('{{ $projectName }}', '{{ $user }}')" />
                                @endforeach

                            </div>
                        </div>
                        <div>
                            @php
                                // Determine progress color based on percentage
                                if (
                                    $projects[$projectName]['progress'] >= 81 &&
                                    $projects[$projectName]['progress'] <= 100
                                ) {
                                    $progressColor = 'text-success'; // 81-100% Completed
                                } elseif (
                                    $projects[$projectName]['progress'] >= 31 &&
                                    $projects[$projectName]['progress'] <= 80
                                ) {
                                    $progressColor = 'text-info'; // 31-80% In Progress
                                } elseif (
                                    $projects[$projectName]['progress'] >= 11 &&
                                    $projects[$projectName]['progress'] <= 30
                                ) {
                                    $progressColor = 'text-primary'; // 11-30% Some Progress
                                } else {
                                    $progressColor = 'text-warning'; // 0-10% Warning (Low Progress)
                                }
                            @endphp

                            <x-mary-progress-radial value="{{ $projects[$projectName]['progress'] }}"
                                class="{{ $progressColor }}" />
                            <p class="{{ $progressColor }} mt-3">{{ $projects[$projectName]['progress'] }}% Completed
                            </p>
                        </div>
                    </div>
                </x-mary-card>
            </x-mary-tab>
        @endforeach
    </x-mary-tabs>

    <!-- Drawer to Show User Tasks -->
    <x-mary-drawer wire:model="showDrawer1" class="w-11/12 lg:w-1/3" title="Tasks for {{ $selectedUser }}" separator
        with-close-button without-trap-focus>

        <div>
            @if (!empty($selectedUserTasks))
                <ul class="list-disc pl-5">
                    @foreach ($selectedUserTasks as $task)
                        <li class="mb-2 border-b pb-2">
                            <p><strong>Project:</strong> {{ $task->project_name }}</p>
                            <p><strong>Task:</strong> {{ $task->task_name }}</p>
                            <p><strong>Status:</strong> {{ $statusLabels[$task->status] ?? 'Unknown' }}</p>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">No tasks found for {{ $selectedUser }} in this project.</p>
            @endif
        </div>

    </x-mary-drawer>
</div>
