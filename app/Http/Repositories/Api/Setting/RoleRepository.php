<?php

namespace App\Http\Repositories\Api\Setting;

use App\Http\Interfaces\Api\Setting\RoleInterface;
use App\Models\PimsPermission;
use App\Models\PimsRoleMaster;
use App\Models\PimsRoles;
use App\Models\PimsUser;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleRepository implements RoleInterface
{
    public function index()
    {
        return PimsPermission::whereNull('deleted_at')->get();
    }
    public function getRoleMaster()
    {
        return PimsRoleMaster::whereNull('deleted_at')->get();
    }
    public function storeRoleMaster($model)
    {
        try {
            $result = DB::transaction(function () use ($model) {

                $model->save();
                return [
                    'message' => "Success",
                    'id' => $model->id,
                ];
            });

            return $result;
        } catch (\Exception $e) {

            return [

                'message' => "failed",
                'data' => $e,
            ];
        }
    }
    public function storePermissionId($models)
    {
        foreach ($models as $model) {
            $model->save();
        }
        return $models;
    }
    public function getRoleAllData($id)
    {
        return PimsRoleMaster::with('permission')->where('id', $id)->whereNull('deleted_at')->first()->toArray();
    }
    public function getRoleMasterById($id)
    {
        return PimsRoleMaster::where('id', $id)->whereNull('deleted_at')->first();
    }
    public function perviousPermissionId($id)
    {
            return PimsRoles::where('role_id', $id)->delete();
    }
    public function destroyRole($id)
    {
        try {
            $model = PimsUser::where('role_id', $id)->whereNull('deleted_at')->firstOrFail();
            return ['type' => 2, 'message' => 'Failed'];
        } catch (ModelNotFoundException $e) {
            PimsRoleMaster::where('id', $id)->update(['deleted_at' => Carbon::now()]);
            return ['type' => 1, 'message' => 'Success'];
        }
}
}