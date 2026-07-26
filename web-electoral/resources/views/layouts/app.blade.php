<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>TSE 2026</title>

    @vite(['resources/css/app.css'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans:ital,wght@0,100;0,300;0,400;0,500;0,700;0,800;0,900;1,100;1,300;1,400;1,500;1,700;1,800;1,900&family=Prosto+One&display=swap" rel="stylesheet">


</head>

<body>
      <div class="progress-top">
        <div class="container">
            @php
                // detecta paso automáticamente
                $ruta = request()->path();
                $paso_actual = 1;
                
                if (str_contains($ruta, 'identificacion')) {
                    $paso_actual = 2;
                } elseif (str_contains($ruta, 'votacion')) {
                    $paso_actual = 3;
                } elseif (str_contains($ruta, 'confirmacion')) {
                    $paso_actual = 4;
                }
            @endphp
            
             @include('partials.progreso', ['paso_actual' => $paso_actual])
        </div>
    </div>
    @yield('contenido')
    

</body>
</html>