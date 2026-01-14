<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;

class PropertyPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function isSeller(User $user)
    {
        return $user->role === 'seller';
    }

    public function isBuyer(User $user)
    {
        return $user->role === 'buyer';
    }

    public function update(User $user, Property $property)
    {
        return $user->id === $property->seller_id;
    }

    public function delete(User $user, Property $property)
    {
        return $user->id === $property->seller_id;
    }
}
