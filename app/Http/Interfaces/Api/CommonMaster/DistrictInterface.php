<?php

namespace App\Http\Interfaces\Api\CommonMaster;

interface DistrictInterface
{

    public function index();
    public function getAllDistrict();
    public function store($model);
    public function getDistrictById($districtId);
    public function destroyDistrict($districtId);
    public function checkDistrictForStateId($stateId);

}
