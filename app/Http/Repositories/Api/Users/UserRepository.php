<?php

namespace App\Http\Repositories\Api\Users;

use App\Http\Interfaces\Api\Users\UserInterface;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserInterface
{
    public function admin()
    {
return  User::where('primary_email','admin@gmail.com')->first();
    }
}
