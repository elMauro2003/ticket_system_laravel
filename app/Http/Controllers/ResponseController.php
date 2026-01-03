<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Response as TicketResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResponseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $ticket->responses()->create([
            'user_id' => Auth::id(),
            'content' => $validated['content'],
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Respuesta agregada exitosamente.');
    }

    public function edit(Ticket $ticket, TicketResponse $response)
    {
        $this->authorize('update', $response);
        return view('responses.edit', compact('ticket', 'response'));
    }

    public function update(Request $request, Ticket $ticket, TicketResponse $response)
    {
        $this->authorize('update', $response);

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $response->update($validated);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Respuesta actualizada exitosamente.');
    }

    public function destroy(Ticket $ticket, TicketResponse $response)
    {
        $this->authorize('delete', $response);
        $response->delete();

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Respuesta eliminada exitosamente.');
    }
}