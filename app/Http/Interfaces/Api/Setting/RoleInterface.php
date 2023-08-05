<?php

namespace App\Http\Interfaces\Api\Setting;

interface RoleInterface
{
    public function index();
    public function storeRoleMaster($model);
    public function storePermissionId($model);
    public function getRoleMaster();
    public function getRoleAllData($id);
    public function getRoleMasterById($id);
    public function perviousPermissionId($id);
    public function destroyRole($id);
}
