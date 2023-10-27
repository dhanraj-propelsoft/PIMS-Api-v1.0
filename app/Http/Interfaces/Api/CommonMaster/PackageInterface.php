<?php

namespace App\Http\Interfaces\Api\CommonMaster;

interface PackageInterface
{

    public function index();
    public function store($model);
    public function getPackageById($packageId);
    public function destroyPackage($packageId);

}
