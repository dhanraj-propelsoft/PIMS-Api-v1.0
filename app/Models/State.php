<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class State extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'pims_com_states';
    public function activeStatus()
    {
        return $this->hasOne(ActiveStatus::class, 'id', 'pfm_active_status_id'); 
    }

}
