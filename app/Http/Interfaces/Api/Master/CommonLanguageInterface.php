<?php

namespace App\Http\Interfaces\Api\Master;

interface CommonLanguageInterface
{

    public function index();
    public function store($model);
    public function getCommonLanguageById($id);
    public function destroyCommonLanguage($id);

}