<?php

namespace App\Http\Repositories\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\CountryInterface;
use App\Models\Country;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class CountryRepository implements CountryInterface
{
    public function index()
    {
        return Country::
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
    public function getCountryById($id)
    {
        return Country::where('id',$id)
            ->whereNull('deleted_at')
            ->whereNull('deleted_flag')->first();

    }
    public function destroyCountry($id)
    {
        try {
            $model = State::where('country_id', $id)->whereNull('deleted_at')->firstOrFail();
            return ['type' => 2, 'message' => 'Failed', 'status' => 'This Country Dependent on State'];
        } catch (ModelNotFoundException $e) {
            Country::where('id', $id)->update(['deleted_at' => Carbon::now(), 'deleted_flag' => 1]);
            return ['type' => 1, 'message' => 'Success'];
        }
    }
}
