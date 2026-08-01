@extends('layouts.app')

@section('contenido')
<div class="container">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div class="card-body text-center py-5">
                    <div style="font-size: 5rem; color: #28a745; margin-bottom: 20px;">
                        <i class="bi bi-check2-circle" style="font-size: 10rem; color:#0C0076; margin-bottom:20px; display:block;"></i>
                    </div>
                    <h2 style="color: #000000; font-weight: 700; margin-bottom: 15px;">
                        ¡Voto Registrado!
                    </h2>
                    <p style="font-size: 1rem; color: #000000; max-width: 500px; margin: 0 auto 30px;">
                        Su voto ha sido emitido y registrado de forma segura en el sistema electoral.
                    </p>
                    <p style="font-size: 0.95rem; color: #333333; margin: 0 auto;">
                        Esta pantalla se cerrara automaticamente en <strong><span id="contador-cierre">5</span></strong> segundos.
                    </p>
                </div>
           
        </div>
    </div>
</div>

<script>
    let segundosRestantes = 5;
    const contadorElemento = document.getElementById('contador-cierre');

    const intervalo = setInterval(() => {
        segundosRestantes -= 1;

        if (contadorElemento && segundosRestantes >= 0) {
            contadorElemento.textContent = segundosRestantes;
        }

        if (segundosRestantes <= 0) {
            clearInterval(intervalo);
        }
    }, 1000);

    setTimeout(async () => {
        try {
            await fetch("{{ route('finalizacion.cerrar') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        } catch (e) {
            // Continue with local cleanup and redirect even if the server call fails.
        }

        try {
            localStorage.clear();
            sessionStorage.clear();
        } catch (e) {
            // Ignore storage cleanup errors.
        }

        window.location.href = "{{ route('inicio') }}";
    }, 5000);
</script>
@endsection