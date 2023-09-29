<?php

namespace App\Http\Repositories\Api\PFM;

use App\Http\Interfaces\Api\PFM\CachetInterface;
use App\Models\Cachet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CachetRepository implements CachetInterface
{
    public function index()
    {
        return Cachet::whereNull('deleted_at')->get();
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
    public function getCachetById($id)
    {
        return Cachet::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyCachet($id)
    {
        return Cachet::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}
