<?php

namespace App\Http\Repositories\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\StateInterface;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StateRepository implements StateInterface
{
    public function index()
    {
        return State::with('activeStatus','country')
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
    public function getStateById($stateId)
    {
        return State::with('activeStatus','country')->where('id', $stateId)
            ->whereNull('deleted_flag')->first();

    }
    public function destroyState($stateId)
    {
        return State::where('id', $stateId)->update(['deleted_at' => Carbon::now(), 'deleted_flag' => 1]);

    }
    public function getStateForCountryId($countryId)
    {
        return State::where('country_id', $countryId)
            ->whereNull('deleted_flag')->get();
    }
    public function getAllState()
    {
        return State::
        whereNull('deleted_flag')
        ->get();
    }
   

}
