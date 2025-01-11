<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\JsonResponse;

class CartPolicy
{
    public function order(User $user): Response
    {
        if ($user->cart->items->isEmpty()) {
            return Response::deny("emptyCart");
        }

        return Response::allow();
    }
}
