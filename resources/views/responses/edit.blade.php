@extends('layouts.app')

@section('title', 'Editar Respuesta')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-edit"></i> Editar Respuesta
                </h4>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">
                    Editando respuesta para el ticket: <strong>{{ $ticket->subject }}</strong>
                </p>
                
                <form method="POST" action="{{ route('responses.update', ['ticket' => $ticket, 'response' => $response]) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Respuesta *</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="8" required>{{ old('content', $response->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar Respuesta
                        </button>
                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection