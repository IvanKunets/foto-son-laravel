<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="0;url={{ url('/') }}">
    <title>Перенаправление…</title>
    <script>
        location.replace({{ json_encode(url('/')) }});
    </script>
    </head>
<body>
<p><a href="{{ url('/') }}">Перейти на главную</a></p>
    </body>
</html>
