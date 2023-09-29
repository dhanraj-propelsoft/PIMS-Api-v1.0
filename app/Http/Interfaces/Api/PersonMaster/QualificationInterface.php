<?php

namespace App\Http\Interfaces\Api\PersonMaster;

interface QualificationInterface
{

    public function index();
    public function store($model);
    public function getQualificationById($id);
    public function destroyQualification($id);

}