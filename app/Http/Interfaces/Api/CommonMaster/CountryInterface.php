<?php

namespace App\Http\Interfaces\Api\CommonMaster;

interface CountryInterface
{

    public function index();
    public function store($model);
    public function getCountryById($id);
    public function destroyCountry($id);

}