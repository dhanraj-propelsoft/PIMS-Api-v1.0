<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;
    protected $table = 'pims_person_genders';
    public function activeStatus()
    {
        return $this->hasOne(ActiveStatus::class, 'id', 'pfm_active_status_id');
    }
}
