<div class="container mt-3">
    <div class="grid grid-cols-3 gap-5">
        @if ($role == 1)
            <x-mary-card class="border-r-4 border-b-4 border-orange-300 shadow-xl flex items-center justify-center">
                <div class="text-center">

                    <div class="bg-orange-100 p-4 rounded-full w-fit mx-auto mb-2">
                        <x-heroicon-o-user class="w-8 h-8 text-orange-500" />
                    </div>

                    <h2 class="text-xl font-semibold text-gray-800">Admin</h2>

                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $adminCount }}</p>
                </div>
            </x-mary-card>
            <x-mary-card class="border-r-4 border-b-4 border-blue-300 shadow-xl flex items-center justify-center">
                <div class="text-center">

                    <div class="bg-blue-100 p-4 rounded-full w-fit mx-auto mb-2">
                        <x-heroicon-o-users class="w-8 h-8 text-blue-500" />
                    </div>

                    <h2 class="text-xl font-semibold text-gray-800">Employees</h2>

                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $employeeCount }}</p>
                </div>
            </x-mary-card>
            <x-mary-card class="border-r-4 border-b-4 border-red-300 shadow-xl flex items-center justify-center">
                <div class="text-center">

                    <div class="bg-red-100 p-4 rounded-full w-fit mx-auto mb-2">
                        <x-heroicon-o-clipboard-document-list class="w-8 h-8 text-red-500" />
                    </div>

                    <h2 class="text-xl font-semibold text-gray-800">Tasks</h2>

                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $taskCount }}</p>
                </div>
            </x-mary-card>
        @endif
    </div>


    @if ($role == 1)
        <div class="grid grid-cols-12 mt-5 gap-5">
            <x-mary-card wire:ignore class="col-span-4">
                <canvas id="myChart"></canvas>
                <script>
                    const ctx = document.getElementById('myChart');
                    new Chart(ctx, {
                        type: 'doughnut', // Change the chart type to "doughnut"
                        data: {
                            labels: @json($chartData['labels']), // Labels for each segment
                            datasets: [{
                                label: 'Task Status', // Optional, appears in the tooltip
                                data: @json($chartData['series']), // Example data (replace with dynamic data if needed)
                                backgroundColor: ['#2ECC71', '#E74C3C', '#F4D03F', '#3498DB', '#E67E22'],
                                hoverOffset: 10
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom', // Position of the legend
                                    onHover: handleHover, // Attach hover handler
                                    onLeave: handleLeave // Attach leave handler
                                },
                                title: {
                                    display: true,
                                    text: 'Overall Task Status'
                                }
                            },
                        }
                    });
                    // Append '4d' to the colors (alpha channel), except for the hovered index
                    function handleHover(evt, item, legend) {
                        legend.chart.data.datasets[0].backgroundColor.forEach((color, index, colors) => {
                            colors[index] = index === item.index || color.length === 9 ? color : color +
                                '4D'; // Add transparency
                        });
                        legend.chart.update();
                    }

                    // Removes the alpha channel from background colors
                    function handleLeave(evt, item, legend) {
                        legend.chart.data.datasets[0].backgroundColor.forEach((color, index, colors) => {
                            colors[index] = color.length === 9 ? color.slice(0, -2) : color; // Remove transparency
                        });
                        legend.chart.update();
                    }
                </script>
            </x-mary-card>


            <x-mary-card title="Send Task Reminder" class="col-span-8">
                <x-slot:menu>
                    <span class="font-semibold">Total:</span>
                    <span class="text-lg font-semibold text-red-500">{{ $totalCount }}</span>
                </x-slot:menu>
                @foreach ($tasks as $task)
                    <x-mary-list-item :item="$task">
                        <x-slot:value class="flex justify-between">
                            <p>Task: {{ $task->task_name }}</p>
                            <p>Project: {{ $task->project_name }}</p>
                        </x-slot:value>
                        <x-slot:sub-value class="flex justify-between">
                            <p class="text-success">
                                Assigned:{{ \Carbon\Carbon::parse($task->created_at)->format('d-m-y') }}
                            </p>
                            <p class="text-error">
                                Due Date:{{ \Carbon\Carbon::parse($task->due_date)->format('d-m-y') }}
                            </p>
                        </x-slot:sub-value>
                        <x-slot:avatar>
                            <x-mary-badge value="{{ $task->employee->name }}" class="badge-info" />
                        </x-slot:avatar>
                        <x-slot:actions>
                            <x-mary-button icon="o-envelope-open" class="text-info btn-sm btn-ghost btn-circle"
                                tooltip="Send Mail" wire:click="openModal({{ $task->employee->id }})" spinner />
                        </x-slot:actions>
                    </x-mary-list-item>
                @endforeach
            </x-mary-card>
            <x-mary-modal wire:model="confirm" title="Are you sure?">
                <div>Click 'Confirm' to Sent Task Reminder.</div>
                <x-slot:actions>
                    <x-mary-button label="{{ __('Cancel') }}" wire:click="$set('confirm', false)" spinner />
                    <x-mary-button label="{{ __('Confirm') }}" wire:click="sendReminder" class="btn-primary" spinner />
                </x-slot>
            </x-mary-modal>
        </div>
    @endif

    @if ($role == 2)
        <div class="grid grid-cols-3 gap-5">
            <x-mary-card class="border-r-4 border-b-4 border-blue-300 shadow-xl flex items-center justify-center">
                <div class="text-center">

                    <div class="bg-blue-100 p-4 rounded-full w-fit mx-auto mb-2">
                        <x-heroicon-o-clipboard-document-list class="w-8 h-8 text-blue-500" />
                    </div>

                    <h2 class="text-xl font-semibold text-gray-800">My Tasks</h2>

                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $mytaskCount }}</p>
                </div>
            </x-mary-card>
            <x-mary-card class="border-r-4 border-b-4 border-green-300 shadow-xl flex items-center justify-center">
                <div class="text-center">

                    <div class="bg-green-100 p-4 rounded-full w-fit mx-auto mb-2">
                        <x-heroicon-o-check-circle class="w-8 h-8 text-green-500" />
                    </div>

                    <h2 class="text-xl font-semibold text-gray-800">Completed</h2>

                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $completed }}</p>
                </div>
            </x-mary-card>
            <x-mary-card class="border-r-4 border-b-4 border-yellow-300 shadow-xl flex items-center justify-center">
                <div class="text-center">

                    <div class="bg-yellow-100 p-4 rounded-full w-fit mx-auto mb-2">
                        <x-heroicon-c-exclamation-circle class="w-8 h-8 text-yellow-500" />
                    </div>

                    <h2 class="text-xl font-semibold text-gray-800">In Completed</h2>

                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $incompleted }}</p>
                </div>
            </x-mary-card>
        </div>
        {{-- <div class="mt-4 grid grid-cols-3 gap-5">
            @foreach ($myTasks as $index => $task)
                <x-mary-card class="p-4 shadow-lg  ">
                    <div class="flex justify-between items-center">
                        <!-- Task Number with Icon -->
                        <div class="flex items-center">
                            <span class="font-semibold text-lg text-gray-800 dark:text-white">Task
                                #{{ $index + 1 }}</span>
                        </div>
                        <!-- Status with Icon -->
                        <div class="flex items-center">
                            @if ($task->status == 1)
                                <x-heroicon-o-exclamation-triangle class="w-6 h-6 text-yellow-500 mr-2" />
                                <span class="text-sm font-semibold text-yellow-500">Pending</span>
                            @elseif ($task->status == 2)
                                <x-heroicon-o-clock class="w-6 h-6 text-blue-500 mr-2" />
                                <span class="text-sm font-semibold text-blue-500">In Progress</span>
                            @elseif ($task->status == 3)
                                <x-heroicon-o-pause-circle class="w-6 h-6 text-red-500 mr-2" />
                                <span class="text-sm font-semibold text-red-500">On Hold</span>
                            @elseif ($task->status == 4)
                                <x-heroicon-o-check-circle class="w-6 h-6 text-green-500 mr-2" />
                                <span class="text-sm font-semibold text-green-500">Completed</span>
                            @else
                                <x-heroicon-o-user class="w-6 h-6 text-gray-500 mr-2" />
                                <span class="text-sm font-semibold text-gray-500">Unknown</span>
                            @endif
                        </div>
                    </div>
                    <!-- Task Details -->
                    <div class="mt-4">
                        <div class="flex items-center">
                            <x-heroicon-o-briefcase class="w-5 h-5 text-gray-500 mr-2" />
                            <strong class="text-gray-700 dark:text-gray-200">Project:</strong> {{ $task->project_name }}
                        </div>
                        <div class="mt-2 flex items-center">
                            <x-heroicon-o-document-text class="w-5 h-5 text-gray-500 mr-2" />
                            <strong class="text-gray-700 dark:text-gray-200">Task Name:</strong> {{ $task->task_name }}
                        </div>
                        <div class="mt-2 flex items-center">
                            <x-heroicon-o-user class="w-5 h-5 text-gray-500 mr-2" />
                            <strong class="text-gray-700 dark:text-gray-200">Area:</strong> {{ $task->area }}
                        </div>
                        <div class="mt-2 flex items-center">
                            <x-heroicon-o-clock class="w-5 h-5 text-gray-500 mr-2" />
                            <strong class="text-blue-500">Assigned At:</strong>
                            {{ $task->created_at->format('d-m-Y') }}
                        </div>
                        <div class="mt-2 flex items-center">
                            <x-heroicon-o-clock class="w-5 h-5 text-gray-500 mr-2" />
                            <strong class=" text-red-500 ">Due Date:</strong>
                            {{ $task->due_date->format('d-m-Y') }}
                        </div>
                    </div>
                </x-mary-card>
            @endforeach
        </div> --}}
    @endif

</div>
