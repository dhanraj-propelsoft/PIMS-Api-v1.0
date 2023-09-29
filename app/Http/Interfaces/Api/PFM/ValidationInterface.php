<?php

namespace App\Http\Interfaces\Api\PFM;

interface ValidationInterface
{

    public function index();
    public function store($model);
    public function getValidationById($id);
    public function destroyValidation($id);

}
