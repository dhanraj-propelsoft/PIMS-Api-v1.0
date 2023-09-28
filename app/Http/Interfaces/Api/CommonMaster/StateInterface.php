<?php

namespace App\Http\Interfaces\Api\CommonMaster;

interface StateInterface
{

    public function index();
    public function store($model);
    public function getStateById($id);
    public function destroyState($id);

}