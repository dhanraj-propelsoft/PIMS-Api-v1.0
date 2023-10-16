<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationOwnership extends Model
{
    use HasFactory;
    protected $connection;
    
    public function __construct(){
        parent::__construct();
        $this->connection = "mysql_external";
    }
    use HasFactory;
    protected $table = 'organization_ownerships';
    public function activeStatus()
    {
        return $this->hasOne('App\Models\ActiveStatus'::class, 'id', 'pfm_active_status_id');
    }
}
