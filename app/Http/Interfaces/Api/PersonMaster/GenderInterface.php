<?php

namespace App\Http\Interfaces\Api\PersonMaster;

interface GenderInterface
{

    public function index();
    public function store($model);
    public function getGenderById($id);
    public function destroyGender($id);

}