<?php

namespace App\Http\Interfaces\Api\OrganizationMaster;

interface OrgDocumentTypeInterface
{
    public function index();
    public function store($model);
    public function getOrgDocumentTypeById($id);
    public function destroyOrgDocumentType($id);

}