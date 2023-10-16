<?php

namespace App\Http\Interfaces\Api\PersonMaster;

interface DocumentTypeInterface
{

    public function index();
    public function store($model);
    public function getDocumentTypeById($docTypeId);
    public function destroyDocumentType($docTypeId);

}