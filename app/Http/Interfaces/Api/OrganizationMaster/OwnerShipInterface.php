<?php

namespace App\Http\Interfaces\Api\OrganizationMaster;

interface OwnerShipInterface
{
    public function index();
    public function store($model);
    public function getOwnerShipById($ownershipId);
    public function destroyOwnerShip($ownershipId);

}
