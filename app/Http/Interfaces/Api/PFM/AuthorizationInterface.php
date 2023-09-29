<?php

namespace App\Http\Interfaces\Api\PFM;

interface AuthorizationInterface
{

    public function index();
    public function store($model);
    public function getAuthorizationById($id);
    public function destroyAuthorization($id);

}
