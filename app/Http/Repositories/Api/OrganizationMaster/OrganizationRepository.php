<?php

namespace App\Http\Repositories\Api\OrganizationMaster;
use App\Http\Interfaces\Api\OrganizationMaster\OrganizationInterface;
use App\Models\Organization\TempOrganization;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrganizationRepository implements OrganizationInterface
{
    public function tempOrganizationList()
    {
        return TempOrganization::
        whereNull('deleted_flag')
        ->get();   
    }
}
