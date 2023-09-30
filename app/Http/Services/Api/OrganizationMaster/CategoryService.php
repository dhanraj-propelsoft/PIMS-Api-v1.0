<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\CategoryInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Organization\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CategoryService
{
    protected $CategoryInterface;
    public function __construct(CategoryInterface $CategoryInterface)
    {
        $this->CategoryInterface = $CategoryInterface;
    }

    public function index()
    {
        $models = $this->CategoryInterface->index();
        $entities = $models->map(function ($model) {
            $category = $model->org_category;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['category' => $category, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertCategory($datas);
        $storeModel = $this->CategoryInterface->store($convert);
        Log::info('CategoryService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getCategoryById($id)
    {
        $model = $this->CategoryInterface->getCategoryById($id);
        $datas = array();
        if ($model) {
            $category = $model->org_category;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['category' => $category, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertCategory($datas)
    {
        $model = $this->CategoryInterface->getCategoryById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
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

    public function destroyCategoryById($id)
    {
        $destory = $this->CategoryInterface->destroyCategory($id);
        return new SuccessApiResponse($destory, 200);
    }
}
