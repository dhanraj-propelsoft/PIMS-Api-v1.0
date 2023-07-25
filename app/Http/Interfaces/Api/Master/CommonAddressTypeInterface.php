<?php

namespace App\Http\Interfaces\Api\Master;

interface CommonAddressTypeInterface
{

    public function index();
    public function store($model);
    public function getCommonAddressTypeById($id);
    public function destroyCommonAddressType($id);

}