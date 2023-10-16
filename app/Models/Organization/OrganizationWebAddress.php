<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationWebAddress extends Model
{
    use HasFactory;
    public function ParentOrganization()
    {
        return $this->belongsTo(Organization::class, 'org_id', 'id');
    }
    public function activeStatus()
    {
        return $this->hasOne('App\Models\ActiveStatus'::class, 'id', 'pfm_active_status_id');
    }
}
