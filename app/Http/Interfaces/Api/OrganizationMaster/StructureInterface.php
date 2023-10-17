<?php

namespace App\Http\Interfaces\Api\OrganizationMaster;

interface StructureInterface
{
    public function index();
    public function store($model);
    public function getStructureById($structureId);
    public function destroyStructure($structureId);

}
