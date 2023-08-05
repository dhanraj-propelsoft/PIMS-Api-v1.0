<?php
namespace App\Http\Services\Api\Setting;

use App\Http\Interfaces\Api\Setting\UserInterface;
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
    public function index()
    {
        $models = $this->UserInterface->getAllUsers();
        $entities = $models->map(function ($model) {
            $name = $model->name;
            $email = $model->email;
            $mobile = $model->mobile;
            $roleId = $model->role_id;
            $id = $model->id;
            $datas = ['name' => $name, 'email' => $email, 'mobile' => $mobile, 'id' => $id, 'roleId' => $roleId];
            return $datas;
        });
        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {

        Log::info('userService > store function Inside.' . json_encode($datas));

        $validator = Validator::make($datas, [
            'email' => 'required|string|max:255',
            'password' => 'required',
            'mobile' => 'required',
            'userName' => 'required',
            'roleId' => 'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convertUser = $this->convertPimsUser($datas);
        $storeUser = $this->UserInterface->storePimsUser($convertUser);
        return new SuccessApiResponse($storeUser, 200);
    }
    public function convertPimsUser($datas)
    {
        $model = isset($datas->userId) ? $this->UserInterface->getUserDataById($datas->userId) : new PimsUser();
        $model->name = $datas->userName;
        $model->email = $datas->email;
        $model->mobile = $datas->mobile;
        $model->password = $password = Hash::make($datas->password);
        $model->role_id = $datas->roleId;
        return $model;

    }
    public function getUserById($id)
    {
        $model = $this->UserInterface->getUserDataById($id);

        $datas = [
            'name' => $model->name,
            'email' => $model->email,
            'mobile' => $model->mobile,
            'id' => $model->id,
            'roleId' => $model->role_id,
        ];

        return new SuccessApiResponse($datas, 200);
    }

    public function destroyUserById($id)
    {
        $destoryUser = $this->UserInterface->destroyUserById($id);
        return new SuccessApiResponse($destoryUser, 200);
    }
    public function userAccess($datas)
    {
        Log::info('UserService > userAccess function Inside.' . json_encode($datas));
        $validator = Validator::make($datas, [

            'mobile' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $checkUser = $this->UserInterface->userAccess($datas);
        return new SuccessApiResponse($checkUser, 200);
    }

}
