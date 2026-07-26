
@props(['paso_actual' => 1])

<div class="steps-container">
    <div class="steps-wrapper">
        <div class="steps-header">
            <div class="tse-logo">
                <div class="tse-text">
                    <span class="tse-title">TSE</span>
                    <span class="tse-subtitle">ELECCIONES 2026</span>
                </div>
            </div>
        </div>

        <div class="steps-progress">
            
            <!-- inicio -->
            <div class="step-item 
                {{ $paso_actual >= 1 ? 'active' : '' }} 
                {{ $paso_actual > 1 ? 'completed' : '' }}">
                
                <div class="step-circle">
                    @if($paso_actual > 1)
                        <span class="step-check">1</span>
                    @else
                        <span class="step-number">1</span>
                    @endif
                </div>
                
                <div class="step-label">Inicio</div>
            </div>
            
            <!-- linea de paso -->
            <div class="step-line {{ $paso_actual > 1 ? 'active' : '' }}"></div>
            
            <!-- identificacion-->
            <div class="step-item 
                {{ $paso_actual >= 2 ? 'active' : '' }} 
                {{ $paso_actual > 2 ? 'completed' : '' }}">
                
                <div class="step-circle">
                    @if($paso_actual > 2)
                        <span class="step-check">2</span>
                    @else
                        <span class="step-number">2</span>
                    @endif
                </div>
                
                <div class="step-label">Identificación</div>
            </div>
            
            <!-- linea de paso -->
            <div class="step-line {{ $paso_actual > 2 ? 'active' : '' }}"></div>
            
            <!-- votacion -->
            <div class="step-item 
                {{ $paso_actual >= 3 ? 'active' : '' }} 
                {{ $paso_actual > 3 ? 'completed' : '' }}">
                
                <div class="step-circle">
                    @if($paso_actual > 3)
                        <span class="step-check">3</span>
                    @else
                        <span class="step-number">3</span>
                    @endif
                </div>
                
                <div class="step-label">Votación</div>
            </div>
            
            <!-- linea de paso -->
            <div class="step-line {{ $paso_actual > 3 ? 'active' : '' }}"></div>
            
            <!-- confirmacion -->
            <div class="step-item 
                {{ $paso_actual >= 4 ? 'active' : '' }} 
                {{ $paso_actual > 4 ? 'completed' : '' }}">
                
                <div class="step-circle">
                    @if($paso_actual > 4)
                        <span class="step-check">4</span>
                    @else
                        <span class="step-number">4</span>
                    @endif
                </div>
                
                <div class="step-label">Confirmación</div>
            </div>
            
        </div>
        
        
    </div>
</div>