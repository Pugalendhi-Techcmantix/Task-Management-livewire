<div class="container mt-3">
    @if ($role == 2)
        <div class="mt-4 grid grid-cols-3 gap-5">
            @foreach ($myTasks as $index => $task)
                <x-mary-card class="p-4 shadow-lg" title="Task #{{ $index + 1 }}">
                    <x-slot:menu>
                        <div class="flex items-center">
                            <x-heroicon-o-pause-circle class="w-6 h-6 text-red-500 mr-2" />
                            <span class="text-sm font-semibold text-red-500">Hold</span>
                        </div>
                        <x-mary-dropdown icon="o-pencil" class="btn-circle btn-ghost btn-sm">
                            <x-mary-menu-item title="Progress" icon="o-clock"
                                wire:click="updateTaskStatus({{ $task->id }}, 2)" />
                        </x-mary-dropdown>
                    </x-slot:menu>
                    <!-- Task Details -->
                    <div>
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
                            {{ \Carbon\Carbon::parse($task->created_at)->format('d-m-Y') }}
                        </div>
                        <div class="mt-2 flex items-center">
                            <x-heroicon-o-clock class="w-5 h-5 text-gray-500 mr-2" />
                            <strong class=" text-red-500 ">Due Date:</strong>
                            {{ \Carbon\Carbon::parse($task->due_date)->format('d-m-Y') }}
                        </div>
                    </div>
                </x-mary-card>
            @endforeach
        </div>
    @endif
</div>
