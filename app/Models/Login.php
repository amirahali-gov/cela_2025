<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Login extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'logins';
    protected $primaryKey = 'LGN_ID'; // Add this if your primary key is LGN_ID
    
    // If your password field isn't 'password', specify it:
    public function getAuthPassword()
    {
        return $this->LGN_Password;
    }
    
    // If your username field isn't 'email', you might want to override:
    public function getAuthIdentifierName()
    {
        return 'LGN_Username';
    }
}
