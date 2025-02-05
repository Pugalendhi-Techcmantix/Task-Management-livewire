{{-- <div class="row d-flex gap-10 grid grid-cols-4">
    <x-mary-card>
        Pending
        <x-mary-card class="border-2 border-s-yellow-500">
            <h1>Project name:</h1>
            <h1>Taks name:</h1>
        </x-mary-card>
    </x-mary-card>
    <x-mary-card>
        Progress
        <x-mary-card class="border-2 border-s-blue-500">
            <h1>Project name:</h1>
            <h1>Taks name:</h1>
        </x-mary-card>
    </x-mary-card>
    <x-mary-card>
        Hold
        <x-mary-card class="border-2 border-s-red-500">
            <h1>Project name:</h1>
            <h1>Taks name:</h1>
        </x-mary-card>
    </x-mary-card>
    <x-mary-card>
        Completed
        <x-mary-card class="border-2 border-s-green-500">
            <h1>Project name:</h1>
            <h1>Taks name:</h1>
        </x-mary-card>
    </x-mary-card>
</div> --}}
<div class="row d-flex gap-10 grid grid-cols-4">
    @foreach ($statuses as $statusId => $statusName)
        <x-mary-card class="w-full" id="status-{{ $statusId }}">
            <h2>{{ $statusName }}</h2>
            <div id="task-list-{{ $statusId }}" class="space-y-4">
                @foreach ($tasks->where('status', $statusId) as $task)
                    <x-mary-card class="border-2" data-task-id="{{ $task->id }}">
                        <h1>Project name: {{ $task->project_name }}</h1>
                        <h1>Task name: {{ $task->task_name }}</h1>
                    </x-mary-card>
                @endforeach
            </div>
        </x-mary-card>
    @endforeach




    <div class="p-6 bg-white rounded shadow-md">
        <h2 class="text-xl font-bold mb-4">User List</h2>

        <!-- Button to Manually Fetch Users -->
        <button wire:click="loadUsers" class="bg-blue-500 text-white px-4 py-2 rounded">
            Load Users
        </button>

        <!-- Show Loading Message -->
        <div wire:loading class="text-red-500 mt-2">
            Loading users... Please wait.
        </div>

        <!-- Lazy Load Users When Component Loads -->
        <div wire:init="loadUsers">
            @if (empty($users))
                <p class="text-gray-500 mt-2">No users found.</p>
            @else
                <ul class="mt-4">
                    @foreach ($users as $user)
                        <li class="border-b py-2">{{ $user->name }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="p-6 bg-white rounded shadow-md">
        <h2 class="text-xl font-bold mb-4">Lazy Search</h2>

        <!-- Input field with wire:lazy -->
        <input type="text" wire:model.lazy="query" placeholder="Search users..."
            class="border p-2 rounded w-full mb-4">

        <!-- Display search results -->
        <ul>
            @foreach ($usersearch as $user)
                <li class="border-b py-2">{{ $user->name }}</li>
            @endforeach
        </ul>
    </div>



    <div class="overflow-x-auto relativ bg-white">
        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead class="bg-gray-200 sticky top-0 z-10">
                <tr>
                    <th class="border p-2">Project Name</th>
                    <th class="border p-2">Area</th>
                    <th class="border p-2">Task Name</th>
                    <th class="border p-2">Assigned To</th>
                </tr>
            </thead>
        </table>

        <!-- Table Body with Scrolling -->
        <div class="max-h-[400px] overflow-auto">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <tbody>
                    @foreach ($tasksjoin as $task)
                        <tr class="border-b">
                            <td class="border p-2">{{ $task->project_name }}</td>
                            <td class="border p-2">{{ $task->area }}</td>
                            <td class="border p-2">{{ $task->task_name }}</td>
                            <td class="border p-2">{{ $task->employee_name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


</div>
