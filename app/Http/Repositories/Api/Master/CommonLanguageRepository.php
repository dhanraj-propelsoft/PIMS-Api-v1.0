<?php

namespace App\Http\Repositories\Api\Master;

use App\Http\Interfaces\Api\Master\CommonLanguageInterface;
use App\Models\PimsCommonLanguage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CommonLanguageRepository implements CommonLanguageInterface
{
    public function index()
    {

        return PimsCommonLanguage::whereNull('deleted_at')->get();
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
    public function getCommonLanguageById($id)
    {
        return PimsCommonLanguage::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyCommonLanguage($id)
    {
        return PimsCommonLanguage::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}
