<?php

namespace App\Http\Repositories\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\CountryInterface;
use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CountryRepository implements CountryInterface
{
    public function index()
    {
        return Country::with('activeStatus')
            
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
    public function getCountryById($countryId)
    {
        return Country::where('id', $countryId)
            
            ->whereNull('deleted_flag')->first();

    }
    public function destroyCountry($countryId)
    {
        return Country::where('id', $countryId)->update(['deleted_at' => Carbon::now(), 'deleted_flag' => 1]);
    }
    public function getAllCountry()
    {
        return Country::
       
       whereNull('deleted_flag')
       ->get();
    }
}
