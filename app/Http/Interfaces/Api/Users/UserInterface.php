<?php

namespace App\Http\Interfaces\Api\Users;

interface UserInterface
{
    public function userLogin($datas);
    public function sotreUser($model);
}
