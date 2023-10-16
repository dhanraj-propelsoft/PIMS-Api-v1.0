<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessActivities extends Model
{
    use HasFactory;
    protected $table = 'pims_org_business_activities';
    public function activeStatus()
    {
        return $this->hasOne('App\Models\ActiveStatus'::class, 'id', 'pfm_active_status_id');
    }

}
