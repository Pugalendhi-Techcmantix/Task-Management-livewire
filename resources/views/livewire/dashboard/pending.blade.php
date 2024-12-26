<div class="container mt-3">
    @if ($role == 2)
        <div class="mt-4 grid grid-cols-3 gap-5">
            @foreach ($myTasks as $index => $task)
                <x-mary-card class="p-4 shadow-lg">
                    <div class="flex justify-between items-center">
                        <!-- Task Number with Icon -->
                        <div class="flex items-center">
                            <span class="font-semibold text-lg text-gray-800 dark:text-white">Task
                                #{{ $index + 1 }}</span>
                        </div>
                        <!-- Status -->
                        <div class="flex items-center">
                            <x-heroicon-o-exclamation-triangle class="w-6 h-6 text-yellow-500 mr-2" />
                            <span class="text-sm font-semibold text-yellow-500">Pending</span>
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
        </div>
    @endif
</div>
