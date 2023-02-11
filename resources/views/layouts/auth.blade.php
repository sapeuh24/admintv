<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminTv</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href=" {{ asset('assets/css/bootstrap.css') }} ">
    <link rel="stylesheet" href=" {{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }} ">
    <link rel="stylesheet" href=" {{ asset('assets/css/app.css') }} ">
    <link rel="stylesheet" href=" {{ asset('assets/css/pages/auth.css') }} ">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @yield('content')
</body>

</html>
