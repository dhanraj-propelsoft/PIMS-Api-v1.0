<?php

namespace App\Http\Repositories\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\QualificationInterface;
use App\Models\Qualification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class QualificationRepository implements QualificationInterface
{
    public function index()
    {
        return Qualification::with('activeStatus')
       
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
    public function getQualificationById($qualifiactionId)
    {
        return Qualification::with('activeStatus')->where('id',$qualifiactionId)
        ->whereNull('deleted_flag')->first();

    }
    public function destroyQualification($qualifiactionId)
    {
        return Qualification::where('id', $qualifiactionId)->update(['deleted_at' => Carbon::now(),'deleted_flag' => 1]);
    }
}
