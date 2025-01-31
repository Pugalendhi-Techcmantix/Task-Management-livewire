<!DOCTYPE html>
<html>
<head>
    <title>Task Reminder</title>
</head>
<body>
    <h2>Hello, {{ $userName }}!</h2>
    <p>You have a task due today:</p>
    <strong>project Title:</strong> {{ $task->project_name }}<br>
    <strong>Description:</strong> {{ $task->task_name }}<br>
    <strong>Due Date:</strong> {{ $task->due_date }}<br>

    <p>Please complete your task on time.</p>

    <p>Thank you!</p>
</body>
</html>
