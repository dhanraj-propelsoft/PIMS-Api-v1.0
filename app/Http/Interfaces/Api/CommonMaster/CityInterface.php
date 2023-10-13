<?php

namespace App\Http\Interfaces\Api\CommonMaster;

interface CityInterface
{

    public function index();
    public function getAllCity();
    public function store($model);
    public function getCityById($cityId);
    public function destroyCity($cityId);
    public function checkCityForDistrictId($districtId);

}