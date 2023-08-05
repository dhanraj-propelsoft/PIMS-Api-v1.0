<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PimsRoleMaster extends Model
{
    use HasFactory;
    public function permission()
    {
        return $this->hasMany(PimsRoles::class,'role_id','id');
    }
}
