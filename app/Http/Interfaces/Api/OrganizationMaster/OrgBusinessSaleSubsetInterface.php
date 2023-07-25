<?php

namespace App\Http\Interfaces\Api\OrganizationMaster;

interface OrgBusinessSaleSubsetInterface
{

    public function index();
    public function store($model);
    public function getOrgBusinessSaleSubsetById($id);
    public function destroyOrgBusinessSaleSubset($id);

}