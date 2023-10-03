<?php

namespace App\Http\Repositories\Api\PFM;

use App\Http\Interfaces\Api\PFM\OriginInterface;
use App\Models\Origin;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OriginRepository implements OriginInterface
{
    public function index()
    {
        return Origin::
            whereNull('deleted_at')
            ->whereNull('deleted_flag')
            ->get();
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
    public function getOriginById($id)
    {
        return Origin::where('id', $id)
            ->whereNull('deleted_at')
            ->whereNull('deleted_flag')->first();

    }
    public function destroyOrigin($id)
    {
        return Origin::where('id', $id)->update(['deleted_at' => Carbon::now(), 'deleted_flag' => 1]);
    }
}
