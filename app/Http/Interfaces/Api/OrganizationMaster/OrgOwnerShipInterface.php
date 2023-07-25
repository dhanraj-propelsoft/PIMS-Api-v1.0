<?php

namespace App\Http\Interfaces\Api\OrganizationMaster;

interface OrgOwnerShipInterface
{
    public function index();
    public function store($model);
    public function getOrgOwnerShipById($id);
    public function destroyOrgOwnerShip($id);

}