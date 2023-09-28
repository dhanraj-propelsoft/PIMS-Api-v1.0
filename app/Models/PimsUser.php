<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User  as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class PimsUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    use HasFactory;
    use Notifiable;
     protected $table = 'pims_users';
}
