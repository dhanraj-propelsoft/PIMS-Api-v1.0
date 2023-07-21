<?php

namespace App\Http\Repositories\Api\Users;

use App\Http\Interfaces\Api\Users\UserInterface;
use App\Models\PimsUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{
    public function userLogin($datas)
    {
        $email = $datas->email;
        $password = $datas->password;
        $model = PimsUser::where('email', $email)->first();
        if ($model && Hash::check($password, $model->password)) {
            return true;
        } else {
            return false;
        }
    }

    public function sotreUser($model)
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
}
