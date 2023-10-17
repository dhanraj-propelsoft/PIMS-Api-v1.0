<?php

namespace App\Http\Repositories\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\CategoryInterface;
use App\Models\Organization\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements CategoryInterface
{
    public function index()
    {

        return Category::with('activeStatus')
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
    public function getCategoryById($categoryId)
    {
        return Category::with('activeStatus')->where('id',$categoryId)
        ->whereNull('deleted_flag')->first();


    }
    public function destroyCategory($categoryId)
    {
        return Category::where('id', $categoryId)->update(['deleted_at' => Carbon::now(),'deleted_flag'=>1]);
    }
}
