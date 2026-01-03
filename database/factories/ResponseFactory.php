<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ResponseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ticket_id' => \App\Models\Ticket::factory(),
            'user_id' => \App\Models\User::factory(),
            'content' => $this->faker->paragraph(),
        ];
    }
}