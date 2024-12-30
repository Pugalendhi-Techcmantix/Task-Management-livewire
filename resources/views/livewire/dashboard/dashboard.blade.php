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

            <x-mary-card class="border-r-4 border-b-4 border-green-300 shadow-xl flex items-center justify-center">
                <div class="text-center">

                    <div class="bg-green-100 p-4 rounded-full w-fit mx-auto mb-2">
                        <x-heroicon-o-check-circle class="w-8 h-8 text-green-500" />
                    </div>

                    <h2 class="text-xl font-semibold text-gray-800">Completed</h2>

                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalcompleted }}</p>
                </div>
            </x-mary-card>
            <x-mary-card class="border-r-4 border-b-4 border-yellow-300 shadow-xl flex items-center justify-center">
                <div class="text-center">

                    <div class="bg-yellow-100 p-4 rounded-full w-fit mx-auto mb-2">
                        <x-heroicon-c-exclamation-circle class="w-8 h-8 text-yellow-500" />
                    </div>

                    <h2 class="text-xl font-semibold text-gray-800">In Completed</h2>

                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalincompleted }}</p>
                </div>
            </x-mary-card>
        @endif


    </div>

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
