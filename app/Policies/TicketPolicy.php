<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ticket;

class TicketPolicy
{
    public function view(User $user, Ticket $ticket): bool
    {
        // Permitir a cualquier usuario autenticado ver los tickets
        // (no solo el creador) para poder responder
        return true; // Modificar esto para permitir acceso público
    }

    public function viewAny(User $user): bool
    {
        // Solo mostrar los tickets del usuario en el index
        return true;
    }

    public function update(User $user, Ticket $ticket): bool
    {
        // Solo el creador puede editar el ticket
        return $user->id === $ticket->user_id;
    }

    public function delete(User $user, Ticket $ticket): bool
    {
        // Solo el creador puede eliminar el ticket
        return $user->id === $ticket->user_id;
    }
}