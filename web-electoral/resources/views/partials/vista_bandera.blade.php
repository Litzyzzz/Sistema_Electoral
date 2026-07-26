<div class="row">
    @foreach($partidos as $partido)
    <div class="col-md-4 mb-3">
        <div class="card h-100 candidato-card" 
             style="background-color: #0C0076; color: white;"
             data-id="{{ $partido->id_partido }}"
             data-nombre="{{ $partido->nombre_candidato }}"
             data-partido="{{ $partido->nombre_partido }}"
             onclick="seleccionarCandidato(this)">
            
            @if($partido->bandera)
                <img src="{{ asset('img/partidos/' . $partido->bandera) }}" 
                     class="card-img-top" 
                     style="height: 250px; object-fit: cover; width: 100%;" 
                     alt="Bandera {{ $partido->nombre_partido }}">
            @endif
            
            <div class="card-body text-center">
                <h5 class="card-title">{{ $partido->nombre_partido }}</h5>
                <p class="card-text">{{ $partido->nombre_candidato }}</p>
                
                @if($partido->descripcion)
                    <p class="card-text" style="font-size: 0.8rem; opacity: 0.8;">
                        {{ $partido->descripcion }}
                    </p>
                @endif
                
                <div class="selected-badge" style="display: none;">
                    <span style="background: #94a4cc; color: #0C0076; padding: 5px 15px; border-radius: 20px; font-weight: bold;">
                        SELECCIONADO
                    </span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>