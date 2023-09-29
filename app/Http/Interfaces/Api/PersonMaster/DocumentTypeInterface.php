<?php

namespace App\Http\Interfaces\Api\PersonMaster;

interface DocumentTypeInterface
{

    public function index();
    public function store($model);
    public function getDocumentTypeById($id);
    public function destroyDocumentType($id);

}