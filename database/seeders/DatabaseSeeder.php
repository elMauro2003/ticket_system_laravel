<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Response;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear 10 usuarios
        $users = User::factory(10)->create();
        
        // Crear un usuario específico para pruebas
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        
        // Crear tickets para cada usuario
        foreach ($users as $user) {
            $tickets = Ticket::factory(rand(2, 5))->create([
                'user_id' => $user->id,
            ]);
            
            // Crear respuestas de otros usuarios a estos tickets
            foreach ($tickets as $ticket) {
                // Varios usuarios responden a cada ticket
                $responders = $users->where('id', '!=', $user->id)->random(rand(1, 3));
                
                foreach ($responders as $responder) {
                    Response::factory()->create([
                        'ticket_id' => $ticket->id,
                        'user_id' => $responder->id,
                    ]);
                }
            }
        }
        
        // Crear algunos tickets para el usuario de prueba
        $testTickets = Ticket::factory(3)->create([
            'user_id' => $testUser->id,
        ]);
        
        foreach ($testTickets as $ticket) {
            // Otros usuarios responden a los tickets del usuario de prueba
            $responders = $users->random(rand(1, 3));
            
            foreach ($responders as $responder) {
                Response::factory(rand(1, 2))->create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $responder->id,
                ]);
            }
        }
    }
}