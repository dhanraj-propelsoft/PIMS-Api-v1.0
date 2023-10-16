<?php

namespace App\Http\Interfaces\Api\PersonMaster;

interface QualificationInterface
{

    public function index();
    public function store($model);
    public function getQualificationById($qualifiactionId);
    public function destroyQualification($qualifiactionId);

}