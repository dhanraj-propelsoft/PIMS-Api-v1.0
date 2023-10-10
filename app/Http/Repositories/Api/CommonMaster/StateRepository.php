<?php

namespace App\Http\Repositories\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\StateInterface;
use App\Models\State;
use App\Models\District;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StateRepository implements StateInterface
{
    public function index()
    {
        return State::with('activeStatus')
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
    public function getStateById($id)
    {
        return State::where('id',$id)
        ->whereNull('deleted_at')
        ->whereNull('deleted_flag')->first();


    }
    public function destroyState($id)
    {
        try {
            $model = District::where('state_id', $id)->whereNull('deleted_at')->firstOrFail();
            return ['type' => 2, 'message' => 'Failed','status'=>'This state dependent on District'];
        } catch (ModelNotFoundException $e) {
            State::where('id', $id)->update(['deleted_at' => Carbon::now(),'deleted_flag'=>1]);
            return ['type' => 1, 'message' => 'Success'];
        }
    }
}