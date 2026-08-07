<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>
        {{ $menu->name ?? 'Cardápio' }}
    </title>


    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">

    @vite(['resources/js/app.js'])

</head>


<body>


@yield('content')


</body>

</html>