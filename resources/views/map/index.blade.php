<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Школьные музеи</title>
    <link rel="icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" rel="preload">
</head>
<body>
<div id="app">
</div>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=6e34736c-2933-4bcc-9407-5da11fd2d9fa&load=package.map"
        type="text/javascript"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
