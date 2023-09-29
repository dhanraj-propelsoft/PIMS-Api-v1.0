<?php

namespace App\Http\Interfaces\Api\PFM;

interface ExistenceInterface
{

    public function index();
    public function store($model);
    public function getExistenceById($id);
    public function destroyExistence($id);

}
