<?php

namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\CategoryInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Organization\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryService
{
    protected $CategoryInterface, $ActiveStatusInterface;
    public function __construct(CategoryInterface $CategoryInterface, ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->CategoryInterface = $CategoryInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;
    }

    public function index()
    {
        $models = $this->CategoryInterface->index();
        $entities = $models->map(function ($model) {
            $category = $model->org_category;
            $status = $model->activeStatus->active_type;
            $description = $model->description;
            $categoryId = $model->id;
            $datas = ['category' => $category, 'description' => $description, 'status' => $status, 'categoryId' => $categoryId];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForCategory($datas);
        if ($validation->data['errors'] === false) {
            $datas = (object) $datas;
            $convert = $this->convertCategory($datas);
            $storeModel = $this->CategoryInterface->store($convert);
            Log::info('CategoryService >Store Return.' . json_encode($storeModel));
            return new SuccessApiResponse($storeModel, 200);
        } else {
            return $validation->data['errors'];
        }
    }
    public function ValidationForCategory($datas)
    {

        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'category') {
                $rules['category'] = [
                    'required',
                    'string',
                    Rule::unique('pims_org_categories', 'org_category')->where(function ($query) use ($datas) {
                        $query->whereNull('deleted_flag');
                        if (isset($datas['id'])) {
                            $query->where('id', '!=', $datas['id']);
                        }
                    }),

                ];
            }
        }
        $validator = Validator::make($datas, $rules);
        if ($validator->fails()) {

            $resStatus = ['errors' => $validator->errors()];
            $resCode = 400;
        } else {

            $resStatus = ['errors' => false];
            $resCode = 200;
        }
        return new SuccessApiResponse($resStatus, $resCode);
    }
    public function getCategoryById($categoryId)
    {
        $model = $this->CategoryInterface->getCategoryById($categoryId);
        $activeStatus = $this->ActiveStatusInterface->index();

        $datas = array();
        if ($model) {
            $category = $model->org_category;
            $status = $model->activeStatus->active_type;
            $activeStatusId = $model->pfm_active_status_id;
            $description = $model->description;
            $categoryId = $model->id;
            $datas = ['category' => $category, 'description' => $description, 'status' => $status, 'activeStatusId' => $activeStatusId, 'categoryId' => $categoryId, 'activeStatus' => $activeStatus];
        }
        return new SuccessApiResponse($datas, 200);
    }
    public function convertCategory($datas)
    {
        if (isset($datas->id)) {
            $model = $this->CategoryInterface->getCategoryById($datas->id);
            $model->last_updated_by = auth()->user()->id;
        } else {
            $model = new Category();
            $model->created_by = auth()->user()->id;
        }
        $model->org_category = $datas->category;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyCategoryById($categoryId)
    {
        $destory = $this->CategoryInterface->destroyCategory($categoryId);
        return new SuccessApiResponse($destory, 200);
    }
}
