<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $appName }} - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 text-white">
        <h1>{{ $appName }} Navigation</h1>
    </nav>
    <main class="p-8">
        @yield('content')
    </main>
</body>
</html>
