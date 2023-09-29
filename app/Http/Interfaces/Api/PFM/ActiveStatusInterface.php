<?php

namespace App\Http\Interfaces\Api\PFM;

interface ActiveStatusInterface
{

    public function index();
    public function store($model);
    public function getActiveStatusById($id);
    public function destroyActiveStatus($id);

}
