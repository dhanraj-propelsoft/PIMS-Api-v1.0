<?php

namespace App\Http\Interfaces\Api\Master;

interface MaritalStatusInterface
{
    public function index();
    public function store($model);
    public function getMaritalStatusById($id);
    public function destroyMaritalStatus($id);
}