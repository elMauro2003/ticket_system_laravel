@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 text-center">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h1 class="mb-0">
                    <i class="fas fa-ticket-alt"></i> Sistema de Tickets
                </h1>
            </div>
            <div class="card-body">
                <p class="lead">
                    Bienvenido a nuestro sistema de atención al cliente. 
                    Gestiona tus tickets de soporte técnico de manera eficiente.
                </p>
                
                @auth
                    <div class="mt-4">
                        <a href="{{ route('tickets.index') }}" class="btn btn-primary btn-lg me-2">
                            <i class="fas fa-list"></i> Ver Tickets
                        </a>
                        <a href="{{ route('tickets.create') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-plus-circle"></i> Crear Nuevo Ticket
                        </a>
                    </div>
                @else
                    <div class="mt-4">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">
                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-user-plus"></i> Registrarse
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection