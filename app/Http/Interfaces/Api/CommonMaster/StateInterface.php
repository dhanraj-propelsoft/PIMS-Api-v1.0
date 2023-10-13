<?php

namespace App\Http\Interfaces\Api\CommonMaster;

interface StateInterface
{

    public function index();
    public function getAllState();
    public function store($model);
    public function getStateById($stateId);
    public function destroyState($stateId);
    public function getStateForCountryId($countryId);


}