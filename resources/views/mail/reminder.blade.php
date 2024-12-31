<!DOCTYPE html>
<html>

<head>
    <title>Task Reminder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #3498db;
        }

        .task-list {
            list-style: none;
            padding: 0;
        }

        .task-item {
            background-color: #ffffff;
            margin: 10px 0;
            padding: 15px;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #3498db;
        }

        .task-item h2 {
            color: #3498db;
            margin: 0 0 5px;
        }

        .task-details {
            margin: 0;
            padding: 0;
            color: #555;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }

        .highlight {
            color: #e74c3c;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Task Reminder</h1>
        </div>

        <p>Dear <span class="highlight">{{ $userName }}</span>,</p>

        <p>This is a reminder for the following tasks due today:</p>

        <ol class="task-list">
            @foreach ($taskDetails as $task)
                <li class="task-item">
                    <h2>{{ $task['task_name'] }}</h2>
                    <p class="task-details">
                        <strong>Project:</strong> {{ $task['project_name'] }} <br>
                        <strong>Area:</strong> {{ $task['area'] ?? 'N/A' }} <br>
                        <strong>Assigned At:</strong> {{ \Carbon\Carbon::parse($task['created_at'])->format('d-m-y') }}
                        <br>
                        <strong>Due Date:</strong> {{ \Carbon\Carbon::parse($task['due_date'])->format('d-m-y') }}
                    </p>
                </li>
            @endforeach
        </ol>

        <p>Please ensure that these tasks are completed on time.</p>

        <p>Best regards,<br><strong>Techcmantix Team</strong></p>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Techcmantix. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
