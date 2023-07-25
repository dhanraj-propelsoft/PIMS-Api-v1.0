<?php

namespace App\Http\Interfaces\Api\OrganizationMaster;

interface OrgCategoryInterface
{
    public function index();
    public function store($model);
    public function getOrgCategoryById($id);
    public function destroyOrgCategory($id);

}