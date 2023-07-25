<?php

namespace App\Http\Interfaces\Api\Master;

interface DocumentTypeInterface
{

    public function index();
    public function store($model);
    public function getDocumentTypeById($id);
    public function destroyDocumentType($id);

}