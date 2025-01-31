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
</div>
