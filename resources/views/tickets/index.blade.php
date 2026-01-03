@extends('layouts.app')

@section('title', 'Tickets')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="fas fa-ticket-alt"></i> Tickets
    </h1>
    <a href="{{ route('tickets.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuevo Ticket
    </a>
</div>

<!-- Filtros -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <h6 class="mb-2">Filtrar por:</h6>
                <div class="btn-group" role="group">
                    <a href="{{ route('tickets.index') }}?filter=all" 
                       class="btn {{ $filter == 'all' ? 'btn-primary' : 'btn-outline-secondary' }}">
                        Todos
                    </a>
                    <a href="{{ route('tickets.index') }}?filter=my_tickets" 
                       class="btn {{ $filter == 'my_tickets' ? 'btn-primary' : 'btn-outline-primary' }}">
                        Mis Tickets
                    </a>
                    <a href="{{ route('tickets.index') }}?filter=my_responses" 
                       class="btn {{ $filter == 'my_responses' ? 'btn-primary' : 'btn-outline-info' }}">
                        Mis Respuestas
                    </a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="alert alert-light mb-0 py-2">
                    <i class="fas fa-info-circle"></i>
                    @if($filter == 'all')
                        Mostrando <strong>todos los tickets</strong> del sistema.
                    @elseif($filter == 'my_tickets')
                        Mostrando solo los tickets <strong>creados por ti</strong>.
                    @elseif($filter == 'my_responses')
                        Mostrando tickets donde <strong>has participado con respuestas</strong>.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($allTickets->isEmpty())
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> 
        @if($filter == 'all')
            No hay tickets disponibles en el sistema.
        @elseif($filter == 'my_tickets')
            No has creado ningún ticket todavía.
        @elseif($filter == 'my_responses')
            No has respondido a ningún ticket todavía.
        @endif
        <a href="{{ route('tickets.create') }}" class="alert-link">Crea tu primer ticket</a>
    </div>
@else
    <div class="row">
        @foreach($allTickets as $ticket)
        <div class="col-md-6 col-lg-4">
            <div class="card ticket-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">{{ Str::limit($ticket->subject, 40) }}</h5>
                        <span class="badge status-badge status-{{ $ticket->status }}">
                            @if($ticket->status == 'open') Abierto
                            @elseif($ticket->status == 'in_progress') En Progreso
                            @elseif($ticket->status == 'resolved') Resuelto
                            @elseif($ticket->status == 'closed') Cerrado
                            @endif
                        </span>
                    </div>
                    
                    <p class="card-text text-muted small mb-2">
                        <i class="fas fa-user"></i> {{ $ticket->user->name }}<br>
                        <i class="far fa-calendar"></i> {{ $ticket->created_at->format('d/m/Y H:i') }}
                    </p>
                    
                    <p class="card-text mb-3">
                        {{ Str::limit($ticket->description, 100) }}
                    </p>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="priority-{{ $ticket->priority }}">
                                <i class="fas fa-exclamation-circle"></i>
                                @if($ticket->priority == 'low') Baja
                                @elseif($ticket->priority == 'medium') Media
                                @elseif($ticket->priority == 'high') Alta
                                @endif
                            </span>
                            <small class="text-muted ms-2">
                                <i class="fas fa-comments"></i> {{ $ticket->responses->count() }}
                            </small>
                        </div>
                        
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-outline-primary" 
                               title="Ver ticket">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($ticket->user_id == auth()->id())
                            <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-outline-warning"
                               title="Editar ticket">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                    
                    @if($ticket->user_id != auth()->id())
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> Ticket de {{ $ticket->user->name }}
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
        @if($allTickets->hasPages())
            <div class="mt-4">
                {{ $allTickets->appends(['filter' => $filter])->links() }}
            </div>
        @endif
    </div>
@endif
@endsection