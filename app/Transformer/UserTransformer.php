<?php

namespace App\Transformer;

class UserTransformer
{
    function transform(User $user) {
        return[
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'password' => $user->password,
            'city' => $user->city,
            'status' => $user->status,
        ];
    }
}
