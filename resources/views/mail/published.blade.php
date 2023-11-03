<!DOCTYPE html>
<html lang="en">

<head>
    {{-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title> --}}

    {{-- nelle email dobbiamo includere tutto nello stesso file, l0unica cosa che posso dichiarare nella head è lo style --}}
    <style>
        body {
            background-color: bisque;
            color: brown;
            text-align: center;
        }
    </style>
</head>

<body>

    <h1>è stato {{ $project->published ? 'pubblicato' : ' rimosso' }} un nuovo post</h1>
    <h3>{{ $project->name }}</h3>
</body>

</html>
