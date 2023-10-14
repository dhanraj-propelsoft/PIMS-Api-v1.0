<?php

namespace App\Http\Interfaces\Api\CommonMaster;

interface LanguageInterface
{

    public function index();
    public function store($model);
    public function getLanguageById($languageId);
    public function destroyLanguage($languageId);

}