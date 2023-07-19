<?php
namespace App\Http\Services\Api\Users;

use App\Http\Interfaces\Api\Users\UserInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
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
        $admin = $this->UserInterface->admin();
        if (Hash::check($datas->password, $admin->password)) {
            $result = ['type' => 1, 'status' => 'Admin'];
        } else {
            $result = ['type' => 2, 'status' => 'Worng Password'];
        }
        return new SuccessApiResponse($result, 200);
    }
}
