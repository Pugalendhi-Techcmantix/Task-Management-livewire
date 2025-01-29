<div class="container mt-3">
    <div class="mb-5 font-bold ">
        <h1>Welcome {{ $username }} <x-mary-loading class="loading-ring text-success" /></h1>
        <div wire:poll.1s="updateTime">
            {{ $currentTime }}
        </div>
    </div>
    <div class="grid gap-5 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
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

    </div>


    <div class="grid grid-cols-1 md:grid-cols-12 mt-10 gap-5">
        <x-mary-card wire:ignore class="col-span-12 lg:col-span-4">
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


        <x-mary-card title="Send Task Reminder" class="col-span-12 lg:col-span-8">
            <x-slot:menu>
                <span class="font-semibold">Total:</span>
                <span class="text-lg font-semibold text-red-500">{{ $totalCount }}</span>
            </x-slot:menu>
            @foreach ($tasks as $task)
                <x-mary-list-item :item="$task">
                    <x-slot:value class="flex justify-between flex-wrap">
                        <p>Task: {{ $task->task_name }}</p>
                        <p>Project: {{ $task->project_name }}</p>
                    </x-slot:value>
                    <x-slot:sub-value class="flex justify-between flex-wrap">
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



    <div class="grid grid-cols-1 md:grid-cols-12  mt-10 gap-5 ">
        <x-mary-card class="col-span-12 lg:col-span-4" title="Employees Progress" separator>
            <x-slot:menu>
                <span class="font-semibold">Total Employees:</span>
                <span class="text-lg font-semibold text-red-500">{{ $employeescount }}</span>
            </x-slot:menu>
            <x-mary-carousel :slides="$slides" without-indicators>
                @scope('content', $slide)
                    <div class="bg-white rounded-lg  ">
                        <!-- Name and Description -->
                        <div class="flex justify-between mx-12">
                            <h2 class="text-2xl font-bold text-error">{{ $slide['name'] }}</h2>

                            {{-- <h2 class="text-2xl font-bold text-success">{{ $slide['total'] }}</h2> --}}
                            <x-mary-button label="Task Total:" :badge="$slide['total']" class="btn-sm btn-ghost" />
                        </div>

                        <!-- Progress Bars -->
                        <div class="mx-14 py-5">
                            <!-- Pending Progress -->
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Pending</span>
                                    <span
                                        class="text-sm font-medium text-gray-700">{{ $slide['progress']['pending'] }}</span>
                                </div>
                                <x-mary-progress value="{{ $slide['progress']['pending'] }}" max="100"
                                    class="progress-warning h-3 " />
                            </div>

                            <!-- Hold Progress -->
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Hold</span>
                                    <span class="text-sm font-medium text-gray-700">{{ $slide['progress']['hold'] }}</span>
                                </div>
                                <x-mary-progress value="{{ $slide['progress']['hold'] }}" max="100"
                                    class="progress-error h-3" />
                            </div>

                            <!-- Process Progress -->
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Process</span>
                                    <span
                                        class="text-sm font-medium text-gray-700">{{ $slide['progress']['process'] }}</span>
                                </div>
                                <x-mary-progress value="{{ $slide['progress']['process'] }}" max="100"
                                    class="progress-info h-3" />
                            </div>

                            <!-- Completed Progress -->
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Completed</span>
                                    <span
                                        class="text-sm font-medium text-gray-700">{{ $slide['progress']['completed'] }}</span>
                                </div>
                                <x-mary-progress value="{{ $slide['progress']['completed'] }}" max="100"
                                    class="progress-success  h-3" />
                            </div>
                        </div>
                    </div>
                @endscope
            </x-mary-carousel>
        </x-mary-card>
        <x-mary-card class="col-span-12 lg:col-span-8">
            
        </x-mary-card>
    </div>

</div>
