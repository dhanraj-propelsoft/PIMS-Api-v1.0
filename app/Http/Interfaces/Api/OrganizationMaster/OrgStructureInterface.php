<?php

namespace App\Http\Interfaces\Api\OrganizationMaster;

interface OrgStructureInterface
{
    public function index();
    public function store($model);
    public function getOrgStructureById($id);
    public function destroyOrgStructure($id);

}
