<?php

namespace App\Http\Interfaces\Api\PFM;

interface SurvivalInterface
{

    public function index();
    public function store($model);
    public function getSurvivalById($id);
    public function destroySurvival($id);

}
