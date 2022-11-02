<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    @vite(['resources/js/app.js'])

</head>

<body class="antialiased">

    <div id="app"></div>

    <script src="js/my-echo.js" defer></script>

</body>

</html>
