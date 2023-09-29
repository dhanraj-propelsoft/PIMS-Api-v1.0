<?php

namespace App\Http\Interfaces\Api\PFM;

interface PersonStageInterface
{

    public function index();
    public function store($model);
    public function getPersonStageById($id);
    public function destroyPersonStage($id);

}
