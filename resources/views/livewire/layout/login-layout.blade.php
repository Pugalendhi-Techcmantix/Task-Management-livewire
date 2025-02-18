<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task-Management</title>
    @vite('resources/css/app.css') <!-- If using Vite for assets -->
    @livewireStyles
</head>

<body class="bg-gray-100">
    <div class="container mx-auto">
        @yield('content')
    </div>
    @livewireScripts
</body>

</html>
