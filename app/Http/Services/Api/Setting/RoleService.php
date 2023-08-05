<?php
namespace App\Http\Services\Api\Setting;

use App\Http\Interfaces\Api\Setting\RoleInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsRoleMaster;
use App\Models\PimsRoles;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class RoleService
{
    protected $RoleInterface;
    public function __construct(RoleInterface $RoleInterface)
    {
        $this->RoleInterface = $RoleInterface;
    }
    public function index()
    {
        $models = $this->RoleInterface->index();
        return new SuccessApiResponse($models, 200);
    }

    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'roles' => 'required',
            'permission' => 'required_without_all:admin',
            'admin' => 'required_without_all:permission',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $convert = $this->convertRoleMaster($datas);
        $roleStore = $this->RoleInterface->storeRoleMaster($convert);
        $perviousData = $this->RoleInterface->perviousPermissionId($datas['roleId'] ?? null);
        if (isset($datas['permission'])) {
            $permission = $this->convertPermissionId($roleStore['id'], $datas);
            $PermissionStore = $this->RoleInterface->storePermissionId($permission);
        }
        return new SuccessApiResponse($roleStore, 200);
    }
    public function convertRoleMaster($datas)
{
    $datas = (object) $datas;
    $model = isset($datas->roleId) ? $this->RoleInterface->getRoleMasterById($datas->roleId) : new PimsRoleMaster();
    $model->name = $datas->roles;
    $model->as_admin = $datas->admin ?? '0';
    $model->active_status = $datas->active_status ?? '0';

    return $model;
}
    public function convertPermissionId($id, $datas)
    {
        $orgModel = collect($datas['permission'])->map(function ($permissionId) use ($id) {
            $model = new PimsRoles();
            $model->role_id = $id;
            $model->permission_id = $permissionId;
            return $model;
        });

        return $orgModel;
    }
    public function getRoleMaster()
    {
        $models = $this->RoleInterface->getRoleMaster();
        return new SuccessApiResponse($models, 200);
    }
    public function getRoleAllDetails($id)
    {
        $roles = $this->RoleInterface->getRoleAllData($id);
        $permission = $this->RoleInterface->index();
        $roleId = $roles['id'];
        $roleName = $roles['name'];
        $admin = $roles['as_admin'];
        $permissionId = $roles['permission'];
        $datas = ['admin' => $admin, 'roleId' => $roleId, 'roleName' => $roleName, 'permissionId' => $permissionId, 'permission' => $permission];
        return new SuccessApiResponse($datas, 200);
    }
    public function destoryRoleById($id)
    {
        $destory = $this->RoleInterface->destroyRole($id);
        return new SuccessApiResponse($destory, 200);
    }
}
