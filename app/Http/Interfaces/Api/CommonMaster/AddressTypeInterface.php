<?php

namespace App\Http\Interfaces\Api\CommonMaster;

interface AddressTypeInterface
{

    public function index();
    public function store($model);
    public function getAddressTypeById($id);
    public function destroyAddressType($id);

}