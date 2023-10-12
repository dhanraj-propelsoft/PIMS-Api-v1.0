<?php

namespace App\Http\Repositories\Api\PFM;

use App\Http\Interfaces\Api\PFM\ExistenceInterface;
use App\Models\Existence;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExistenceRepository implements ExistenceInterface
{
    public function index()
    {
        return Existence::with('activeStatus')->whereNull('deleted_at')->whereNull('deleted_flag')->get();

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
    public function getExistenceById($id)
    {
        return Existence::where('id', $id)
            ->whereNull('deleted_at')
            ->whereNull('deleted_flag')->first();
    }
    public function destroyExistence($id)
    {
        return Existence::where('id', $id)->update(['deleted_at' => Carbon::now(), 'deleted_flag' => 1]);
    }
}
