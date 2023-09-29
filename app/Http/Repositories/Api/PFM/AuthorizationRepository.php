<?php

namespace App\Http\Repositories\Api\PFM;

use App\Http\Interfaces\Api\PFM\AuthorizationInterface;
use App\Models\Authorization;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AuthorizationRepository implements AuthorizationInterface
{
    public function index()
    {
        return Authorization::whereNull('deleted_at')->get();
    }
    public function store($model)
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
    public function getAuthorizationById($id)
    {
        return Authorization::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyAuthorization($id)
    {
        return Authorization::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}
