<?php

namespace App\Http\Interfaces\Api\OrganizationMaster;
interface BusinessSectorInterface
{

    public function index();
    public function store($model);
    public function getBusinessSectorById($businessSectorId);
    public function destroyBusinessSector($businessSectorId);

}
