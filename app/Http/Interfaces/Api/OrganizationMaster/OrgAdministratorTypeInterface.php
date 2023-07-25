<?php

namespace App\Http\Interfaces\Api\OrganizationMaster;

interface OrgAdministratorTypeInterface
{

    public function index();
    public function store($model);
    public function getOrgAdministratorTypeById($id);
    public function destroyOrgAdministratorType($id);

}