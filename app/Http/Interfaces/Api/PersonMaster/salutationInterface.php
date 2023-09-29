<?php

namespace App\Http\Interfaces\Api\PersonMaster;

interface salutationInterface
{

    public function index();
    public function store($model);
    public function getSalutationById($id);
    public function destroySalutation($id);

}