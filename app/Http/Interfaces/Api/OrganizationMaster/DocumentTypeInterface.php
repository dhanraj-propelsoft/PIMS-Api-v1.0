<?php

namespace App\Http\Interfaces\Api\OrganizationMaster;

interface DocumentTypeInterface
{
    public function index();
    public function store($model);
    public function getDocumentTypeById($id);
    public function destroyDocumentType($id);

}