<?php

namespace App\Http\Interfaces\Api\Setting;

interface UserInterface
{
    public function userAccess($datas);
    public function storePimsUser($model);
    public function getAllUsers();
    public function getUserDataById($id);
    public function destroyUserById($id);
}
