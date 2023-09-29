<?php

namespace App\Http\Interfaces\Api\PFM;

interface CachetInterface
{

    public function index();
    public function store($model);
    public function getCachetById($id);
    public function destroyCachet($id);

}
