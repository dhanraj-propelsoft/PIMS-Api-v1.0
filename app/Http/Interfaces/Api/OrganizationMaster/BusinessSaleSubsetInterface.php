<?php

namespace App\Http\Interfaces\Api\OrganizationMaster;

interface BusinessSaleSubsetInterface
{

    public function index();
    public function store($model);
    public function getBusinessSaleSubsetById($id);
    public function destroyBusinessSaleSubset($id);

}