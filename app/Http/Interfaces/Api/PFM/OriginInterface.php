<?php

namespace App\Http\Interfaces\Api\PFM;

interface OriginInterface
{

    public function index();
    public function store($model);
    public function getOriginById($id);
    public function destroyOrigin($id);

}
