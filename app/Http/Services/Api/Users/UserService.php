<?php
namespace App\Http\Services\Api\Users;

use App\Http\Interfaces\Api\Users\UserInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserService
{
    protected $UserInterface;
    public function __construct(UserInterface $UserInterface)
    {
        $this->UserInterface = $UserInterface;
    }
    public function userLogin($datas)
    {
        Log::info('UserService > userLogin function Inside.' . json_encode($datas));
        $validator = Validator::make($datas, [

            'email' => 'required|string|max:255',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $checkUser = $this->UserInterface->userLogin($datas);
        return new SuccessApiResponse($checkUser, 200);
    }
    public function userRegister($datas)
    {
        Log::info('UserService > userLogin function Inside.' . json_encode($datas));
        $validator = Validator::make($datas, [
            'userName' => 'required',
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $users = $this->convertToUser($datas);
        $sotreUser = $this->UserInterface->sotreUser($users);
        return new SuccessApiResponse($sotreUser, 200);

    }
    public function convertToUser($datas)
    {
        $model = new PimsUser();
        $model->name = $datas->userName;
        $model->email = $datas->email;
        $model->mobile = $datas->mobile;
        $model->password = $password = Hash::make($datas->password);
        return $model;
    }
}
