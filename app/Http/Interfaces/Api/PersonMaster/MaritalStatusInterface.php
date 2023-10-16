<?php

namespace App\Http\Interfaces\Api\PersonMaster;

interface MaritalStatusInterface
{
    public function index();
    public function store($model);
    public function getMaritalStatusById($maritalId);
    public function destroyMaritalStatus($maritalId);
}