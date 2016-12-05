<?php

namespace App\Observers;

class User
{
    public function updating(\App\Models\User $user)
    {
        dd($user);
    }
}