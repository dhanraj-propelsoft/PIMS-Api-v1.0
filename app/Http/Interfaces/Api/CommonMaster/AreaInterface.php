<?php

namespace App\Http\Interfaces\Api\CommonMaster;

interface AreaInterface
{

    public function index();
    public function store($model);
    public function getAreaById($id);
    public function destroyArea($id);

}
