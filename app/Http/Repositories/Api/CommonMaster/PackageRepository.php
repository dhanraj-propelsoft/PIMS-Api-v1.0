<?php

namespace App\Http\Repositories\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\PackageInterface;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PackageRepository implements PackageInterface
{
    public function index()
    {

        return Package::with('activeStatus')
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
    public function getPackageById($packageId)
    {
        return Package::with('activeStatus')->where('id',$packageId)

        ->whereNull('deleted_flag')->first();

    }
    public function destroyPackage($packageId)
    {
        return Package::where('id', $packageId)->update(['deleted_at' => Carbon::now(),'deleted_flag'=>1]);
    }
}
