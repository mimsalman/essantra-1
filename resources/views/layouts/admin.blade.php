<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">

    <x-navbar />

    <main class="max-w-6xl mx-auto px-6 py-10 min-h-[70vh]">
        @yield('content')
    </main>

    <x-footer />

</body>
</html>
