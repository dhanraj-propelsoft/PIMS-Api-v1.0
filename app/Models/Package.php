<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'packages';

    public function activeStatus()
    {
        return $this->hasOne(ActiveStatus::class, 'id', 'pfm_active_status_id');
    }
}
