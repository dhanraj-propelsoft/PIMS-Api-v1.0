<?php

namespace App\Http\Interfaces\Api\Master;

interface CommonCityInterface
{

    public function index();
    public function store($model);
    public function getCityById($id);
    public function destroyCity($id);

}