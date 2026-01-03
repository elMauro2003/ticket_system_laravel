@extends('layouts.app')

@section('title', $ticket->subject)

@section('content')
<div class="row">
    <!-- Ticket Details -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ $ticket->subject }}</h4>
                <div>
                    <span class="badge status-badge status-{{ $ticket->status }}">
                        @if($ticket->status == 'open') Abierto
                        @elseif($ticket->status == 'in_progress') En Progreso
                        @elseif($ticket->status == 'resolved') Resuelto
                        @elseif($ticket->status == 'closed') Cerrado
                        @endif
                    </span>
                    <span class="priority-{{ $ticket->priority }} ms-2">
                        <i class="fas fa-exclamation-circle"></i>
                        @if($ticket->priority == 'low') Baja
                        @elseif($ticket->priority == 'medium') Media
                        @elseif($ticket->priority == 'high') Alta
                        @endif
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <p class="text-muted mb-1">
                        <i class="far fa-calendar"></i> Creado: {{ $ticket->created_at->format('d/m/Y H:i') }}
                        @if($ticket->updated_at != $ticket->created_at)
                            | <i class="fas fa-edit"></i> Actualizado: {{ $ticket->updated_at->format('d/m/Y H:i') }}
                        @endif
                    </p>
                    <p class="text-muted mb-1">
                        <i class="fas fa-user"></i> Por: {{ $ticket->user->name }}
                    </p>
                </div>
                
                <div class="mb-4">
                    <h5>Descripción:</h5>
                    <p class="card-text">{{ $ticket->description }}</p>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar Ticket
                    </a>
                    <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" 
                          onsubmit="return confirm('¿Estás seguro de eliminar este ticket?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Eliminar Ticket
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Responses Section -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-comments"></i> Respuestas
                    <span class="badge bg-secondary">{{ $ticket->responses->count() }}</span>
                </h5>
            </div>
            <div class="card-body">
                @if($ticket->responses->isEmpty())
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle"></i> No hay respuestas aún.
                    </div>
                @else
                    <div class="responses-list">
                        @foreach($ticket->responses as $response)
                        <div class="response-item mb-4 pb-4 border-bottom" id="response-{{ $response->id }}">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <strong>{{ $response->user->name }}</strong>
                                    <small class="text-muted ms-2">
                                        <i class="far fa-clock"></i> {{ $response->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                                @if($response->user_id == auth()->id())
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('responses.edit', ['ticket' => $ticket, 'response' => $response]) }}" 
                                       class="btn btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('responses.destroy', ['ticket' => $ticket, 'response' => $response]) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" 
                                                onclick="return confirm('¿Eliminar esta respuesta?');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                            <p class="mb-0">{{ $response->content }}</p>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Add Response Form -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-reply"></i> Agregar Respuesta</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('responses.store', $ticket) }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Tu respuesta *</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="5" required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-paper-plane"></i> Enviar Respuesta
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Ticket Status Update -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-cogs"></i> Cambiar Estado</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('tickets.update', $ticket) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="subject" value="{{ $ticket->subject }}">
                    <input type="hidden" name="description" value="{{ $ticket->description }}">
                    <input type="hidden" name="priority" value="{{ $ticket->priority }}">
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Estado del Ticket</label>
                        <select class="form-select" id="status" name="status">
                            <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Abierto</option>
                            <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                            <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resuelto</option>
                            <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Cerrado</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-warning w-100">
                        <i class="fas fa-sync-alt"></i> Actualizar Estado
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection