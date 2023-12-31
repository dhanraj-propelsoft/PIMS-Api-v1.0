<?php

namespace App\Http\Repositories\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\LanguageInterface;
use App\Models\Language;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LanguageRepository implements LanguageInterface
{
    public function index()
    {

        return Language::with('activeStatus')
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
    public function getLanguageById($languageId)
    {
        return Language::with('activeStatus')->where('id',$languageId)
        
        ->whereNull('deleted_flag')->first();

    }
    public function destroyLanguage($languageId)
    {
        return Language::where('id', $languageId)->update(['deleted_at' => Carbon::now(),'deleted_flag'=>1]);
    }
}
