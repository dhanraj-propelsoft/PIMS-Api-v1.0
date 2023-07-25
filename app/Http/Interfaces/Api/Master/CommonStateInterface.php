<?php

namespace App\Http\Interfaces\Api\Master;

interface CommonStateInterface
{

    public function index();
    public function store($model);
    public function getStateById($id);
    public function destroyState($id);

}