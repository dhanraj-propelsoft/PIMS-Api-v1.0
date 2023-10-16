<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationCategory extends Model
{
    use HasFactory;
    protected $connection;
    
    public function __construct(){
        parent::__construct();
        $this->connection = "mysql_external";
    }
    use HasFactory;
    protected $table = 'organization_categories';

    public function ParentOrganization()
    {
        return $this->belongsTo(Organization::class, 'org_id', 'id');

    }
    public function activeStatus()
    {
        return $this->hasOne('App\Models\ActiveStatus'::class, 'id', 'pfm_active_status_id');
    }
}
