<?php

namespace App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'pims_org_categories';
    public function activeStatus()
    {
        return $this->hasOne('App\Models\ActiveStatus'::class, 'id', 'pfm_active_status_id');
    }

}
