<?php

namespace App\Http\Interfaces\Api\CommonMaster;

interface DistrictInterface
{

    public function index();
    public function store($model);
    public function getDistrictById($id);
    public function destroyDistrict($id);

}
