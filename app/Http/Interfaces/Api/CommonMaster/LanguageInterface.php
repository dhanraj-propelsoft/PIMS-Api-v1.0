<?php

namespace App\Http\Interfaces\Api\CommonMaster;

interface LanguageInterface
{

    public function index();
    public function store($model);
    public function getLanguageById($id);
    public function destroyLanguage($id);

}