<?php

namespace App\Http\Interfaces\Api\PFM;

interface DeponeStatusInterface
{

    public function index();
    public function store($model);
    public function getDeponeStatusById($id);
    public function destroyDeponeStatus($id);

}
