<?php

namespace App\Http\Interfaces\Api\OrganizationMaster;

interface AdministratorTypeInterface
{

    public function index();
    public function store($model);
    public function getAdministratorTypeById($adminTypeId);
    public function destroyAdministratorType($adminTypeId);

}