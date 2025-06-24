<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 220px;
            background: #343a40;
            color: #fff;
            min-height: 100vh;
        }

        .sidebar .nav-link {
            color: #adb5bd;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            color: #fff;
            background: #495057;
        }

        .header {
            height: 56px;
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
        }

        .content {
            flex: 1;
            background: #f8f9fa;
            min-height: 100vh;
            padding: 1.5rem;
        }
    </style>
    <script src="{{ asset('js/ziggy.js') }}"></script>
</head>

<body>
    @include('layouts.sidebar')
    <div class="flex-grow-1 d-flex flex-column">
        @inertia
    </div>
    @vite('resources/js/app.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
