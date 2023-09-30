<?php

namespace App\Http\Interfaces\Api\OrganizationMaster;

interface CategoryInterface
{
    public function index();
    public function store($model);
    public function getCategoryById($id);
    public function destroyCategory($id);

}