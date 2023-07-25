<?php

namespace App\Http\Interfaces\Api\OrganizationMaster;

interface OrgBusinessSectorInterface
{

    public function index();
    public function store($model);
    public function getOrgBusinessSectorById($id);
    public function destroyOrgBusinessSector($id);

}