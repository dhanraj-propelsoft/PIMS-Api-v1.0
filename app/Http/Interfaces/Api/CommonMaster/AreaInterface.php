<?php

namespace App\Http\Interfaces\Api\CommonMaster;

interface AreaInterface
{

    public function index();
    public function store($model);
    public function getAreaById($areaId);
    public function destroyArea($areaId);
    public function checkAreaForCityId($cityId);

}
