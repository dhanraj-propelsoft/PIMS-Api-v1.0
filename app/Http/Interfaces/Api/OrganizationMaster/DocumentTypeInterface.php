<?php

namespace App\Http\Interfaces\Api\OrganizationMaster;

interface DocumentTypeInterface
{
    public function index();
    public function store($model);
    public function getDocumentTypeById($docTypeId);
    public function destroyDocumentType($docTypeId);

}
