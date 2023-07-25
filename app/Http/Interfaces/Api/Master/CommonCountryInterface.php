<?php

namespace App\Http\Interfaces\Api\Master;

interface CommonCountryInterface
{

    public function index();
    public function store($model);
    public function getCountryById($id);
    public function destroyCountry($id);

}