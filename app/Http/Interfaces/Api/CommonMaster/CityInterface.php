<?php

namespace App\Http\Interfaces\Api\CommonMaster;

interface CityInterface
{

    public function index();
    public function store($model);
    public function getCityById($id);
    public function destroyCity($id);

}