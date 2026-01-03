<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Response;

class ResponsePolicy
{
    public function update(User $user, Response $response): bool
    {
        return $user->id === $response->user_id;
    }

    public function delete(User $user, Response $response): bool
    {
        return $user->id === $response->user_id;
    }
}