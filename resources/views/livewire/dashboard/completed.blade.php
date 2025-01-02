<div class="container mt-3">
    @if ($role == 2)
        <div class="grid gap-5 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($myTasks as $index => $task)
                <x-mary-card class="p-4 shadow-lg" title="Task #{{ $index + 1 }}">
                    <x-slot:menu>
                        <x-heroicon-o-check-circle class="w-6 h-6 text-green-500" />
                        <span class="text-sm font-semibold text-green-500">Completed</span>
                    </x-slot:menu>
                    <!-- Task Details -->
                    <div>
                        <div class="flex items-center flex-wrap">
                            <x-heroicon-o-briefcase class="w-5 h-5 text-gray-500 mr-2" />
                            <strong class="text-gray-700 dark:text-gray-200">Project:</strong>
                            <span class="truncate">{{ $task->project_name }}</span>
                        </div>
                        <div class="mt-2 flex items-center flex-wrap">
                            <x-heroicon-o-document-text class="w-5 h-5 text-gray-500 mr-2" />
                            <strong class="text-gray-700 dark:text-gray-200">Task Name:</strong>
                            <span class="truncate">{{ $task->task_name }}</span>
                        </div>
                        <div class="mt-2 flex items-center flex-wrap">
                            <x-heroicon-o-code-bracket-square class="w-5 h-5 text-gray-500 mr-2" />
                            <strong class="text-gray-700 dark:text-gray-200">Area:</strong>
                            <span class="truncate">{{ $task->area }}</span>
                        </div>
                        <div class="mt-2 flex items-center flex-wrap">
                            <x-heroicon-o-clock class="w-5 h-5 text-gray-500 mr-2" />
                            <strong class="text-blue-500">Assigned At:</strong>
                            <span>{{ \Carbon\Carbon::parse($task->created_at)->format('d-m-Y') }}</span>
                        </div>
                        <div class="mt-2 flex items-center flex-wrap">
                            <x-heroicon-o-clock class="w-5 h-5 text-gray-500 mr-2" />
                            <strong class="text-red-500">Due Date:</strong>
                            <span>{{ \Carbon\Carbon::parse($task->due_date)->format('d-m-Y') }}</span>
                        </div>
                    </div>
                </x-mary-card>
            @endforeach
        </div>
    @endif
</div>
