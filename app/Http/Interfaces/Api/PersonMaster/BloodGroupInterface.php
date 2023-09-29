<?php

namespace App\Http\Interfaces\Api\PersonMaster;

interface BloodGroupInterface
{
    public function index();
    public function store($model);
    public function getBloodGroupById($id);
    public function destroyBloodGroup($id);
}
