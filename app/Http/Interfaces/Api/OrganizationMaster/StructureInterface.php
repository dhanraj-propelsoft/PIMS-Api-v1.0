<?php

namespace App\Http\Interfaces\Api\OrganizationMaster;

interface StructureInterface
{
    public function index();
    public function store($model);
    public function getStructureById($id);
    public function destroyStructure($id);

}
