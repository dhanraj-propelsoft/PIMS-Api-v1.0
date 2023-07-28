<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OrgCategoryInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsOrgCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrgCategoryService
{
    protected $OrgCategoryInterface;
    public function __construct(OrgCategoryInterface $OrgCategoryInterface)
    {
        $this->OrgCategoryInterface = $OrgCategoryInterface;
    }

    public function index()
    {
        $models = $this->OrgCategoryInterface->index();
        $entities = $models->map(function ($model) {
            $name = $model->org_category;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'orgCategory' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertOrgCategory($datas);
        $storeModel = $this->OrgCategoryInterface->store($convert);
        Log::info('OrgCategoryService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getOrgCategoryById($id)
    {
        $model = $this->OrgCategoryInterface->getOrgCategoryById($id);
        $datas = array();
        if ($model) {
            $name = $model->org_category;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertOrgCategory($datas)
    {
        $model = $this->OrgCategoryInterface->getOrgCategoryById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new PimsOrgCategory();
        }
        $model->org_category = $datas->orgCategory;
        $model->active_status = isset($datas->active_status) ? $datas->active_status : '0';
        return $model;
    }

    public function destroyOrgCategoryById($id)
    {
        $destory = $this->OrgCategoryInterface->destroyOrgCategory($id);
        return new SuccessApiResponse($destory, 200);
    }
}