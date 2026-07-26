@extends('layouts.app')

@section('contenido')
<div class="container">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <h1 class="mb-4">Elige tu candidato</h1>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <div class="btn-group mb-4" role="group">
        <button type="button" class="btn btn-primary active" id="btnRostro" onclick="cambiarVista('rostro')">
            <i></i> Por rostro
        </button>
        <button type="button" class="btn btn-outline-primary" id="btnBandera" onclick="cambiarVista('bandera')">
            <i></i> Por bandera
        </button>
    </div>

    <!-- contenedor de las vistas -->
    <div id="vistaCandidatos">
        <div id="contenidoRostro" style="display: block;">
            @include('partials.vista_rostro')
        </div>
        <div id="contenidoBandera" style="display: none;">
            @include('partials.vista_bandera')
        </div>
    </div>
    
    <div id="resultado" class="mt-4 p-3 bg-light rounded" style="display: none;">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4>Candidato seleccionado:</h4>
                <p id="infoCandidato" class="mb-0"></p>
            </div>
            <div class="col-md-4 text-end">
                <a href="#" id="btnContinuar" class="btn btn-primary">
                    Continuar <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
let candidatoSeleccionado = null;
let vistaActual = 'rostro'; // Variable global para guardar la vista actual

function cambiarVista(tipo) {
    const botonRostro = document.getElementById('btnRostro');
    const botonBandera = document.getElementById('btnBandera');
    const contenidoRostro = document.getElementById('contenidoRostro');
    const contenidoBandera = document.getElementById('contenidoBandera');
    
    // este guarda la vista actual
    vistaActual = tipo;
    
    // limpia la selección actual
    candidatoSeleccionado = null;
    const resultado = document.getElementById('resultado');
    if (resultado) resultado.style.display = 'none';
    
    if (tipo === 'rostro') {
        botonRostro.className = 'btn btn-primary active';
        botonBandera.className = 'btn btn-outline-primary';
        contenidoRostro.style.display = 'block';
        contenidoBandera.style.display = 'none';
    } else {
        botonBandera.className = 'btn btn-primary active';
        botonRostro.className = 'btn btn-outline-primary';
        contenidoRostro.style.display = 'none';
        contenidoBandera.style.display = 'block';
    }
    
    // actualiza la url sin recargar
    const url = new URL(window.location);
    url.searchParams.set('vista', tipo);
    window.history.pushState({}, '', url);
}

function seleccionarCandidato(elemento) {
    // remueve la seleccion de todos
    document.querySelectorAll('.candidato-card').forEach(card => {
        card.style.border = 'none';
        card.style.transform = 'scale(1)';
        card.style.boxShadow = 'none';
        const badge = card.querySelector('.selected-badge');
        if (badge) badge.style.display = 'none';
    });
    
    // seleccionador
    elemento.style.border = '3px solid #6d98bd';
    elemento.style.transform = 'scale(1.05)';
    elemento.style.boxShadow = '0 10px 30px rgba(14, 18, 238, 0.3)';
    const badge = elemento.querySelector('.selected-badge');
    if (badge) badge.style.display = 'block';
    
    // guarda la seleccion
    const id = elemento.dataset.id;
    const nombre = elemento.dataset.nombre;
    const partido = elemento.dataset.partido;
    candidatoSeleccionado = { id, nombre, partido };
    
    // muestra el resultado
    const resultado = document.getElementById('resultado');
    resultado.style.display = 'block';
    document.getElementById('infoCandidato').innerHTML = `
        <strong>${nombre}</strong> - ${partido}
    `;
    
    // variable global vistaActual
    const btnContinuar = document.getElementById('btnContinuar');
    btnContinuar.href = `/confirmacion/${id}?vista=${vistaActual}`;
    btnContinuar.style.display = 'inline-block';
    
}

// cuando carga la pagina obtiene la vista de la url
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const vista = urlParams.get('vista') || 'rostro';
    vistaActual = vista;
    cambiarVista(vista);
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
@endsection