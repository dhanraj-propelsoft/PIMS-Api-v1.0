<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $table = 'pims_com_districts';
    public function activeStatus()
    {
        return $this->hasOne(ActiveStatus::class, 'id', 'pfm_active_status_id'); 
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id'); 
    }
}
