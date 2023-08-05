<?php

namespace App\Http\Repositories\Api\Setting;

use App\Http\Interfaces\Api\Setting\UserInterface;
use App\Models\PimsUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class UserRepository implements UserInterface
{
    public function userAccess($datas)
    {
        $mobile = $datas->mobile;
        $password = $datas->password;
        $model = PimsUser::where('mobile', $mobile)->whereNull('deleted_at')->first();
        if ($model && Hash::check($password, $model->password)) {
            $response = ['type' => 1, 'status' => 'success'];
        } else {
            $response = ['type' => 2, 'status' => 'failed'];
        }
        return $response;
    }

    public function storePimsUser($model)
    {
        try {
            $result = DB::transaction(function () use ($model) {

                $model->save();
                return [
                    'message' => "Success",
                    'data' => $model,
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
        public function getAllUsers()
        {
            return PimsUser::whereNull('deleted_at')->get();
        }
        public function getUserDataById($id)
        {
            return PimsUser::where('id',$id)->whereNull('deleted_at')->first();
        }
        public function destroyUserById($id)
        {
            return PimsUser::where('id',$id)->update(['deleted_at' => Carbon::now()]);

        }

}
