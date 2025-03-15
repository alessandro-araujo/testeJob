<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminPolicy
{
    protected $user;
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        $user = Auth::user();
        $user = User::find($user->id);
        $this->user = $user;
    }

    public function checkAdmin()
    {
        return in_array($this->user->role, ['admin']);
    }

    public function checkStudent()
    {
        return in_array($this->user->role, ['student']);
    }

    public function checkTeacher()
    {
        return in_array($this->user->role, ['teacher']);
    }

}
