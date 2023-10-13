<?php

namespace App\Http\Interfaces\Api\CommonMaster;

interface CountryInterface
{

    public function index();
    public function getAllCountry(); 
    public function store($model);
    public function getCountryById($countryId);
    public function destroyCountry($countryId);

}