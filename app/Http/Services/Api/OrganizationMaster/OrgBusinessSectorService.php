<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OrgBusinessSectorInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsOrgBusinessSector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrgBusinessSectorService
{
    protected $OrgBusinessSectorInterface;
    public function __construct(OrgBusinessSectorInterface $OrgBusinessSectorInterface)
    {
        $this->OrgBusinessSectorInterface = $OrgBusinessSectorInterface;
    }

    public function index()
    {
        $models = $this->OrgBusinessSectorInterface->index();
        $entities = $models->map(function ($model) {
            $name = $model->business_sector;
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
            'businessSector' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertOrgBusinessSector($datas);
        $storeModel = $this->OrgBusinessSectorInterface->store($convert);
        Log::info('OrgBusinessSectorService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getOrgBusinessSectorById($id )
    {
        $model = $this->OrgBusinessSectorInterface->getOrgBusinessSectorById($id);
        $datas = array();
        if ($model) {
            $name = $model->business_sector;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertOrgBusinessSector($datas)
    {
        $model = $this->OrgBusinessSectorInterface->getOrgBusinessSectorById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new PimsOrgBusinessSector();
        }
        $model->business_sector = $datas->businessSector;
        $model->active_status = isset($datas->active_status) ? $datas->active_status : '0';
        return $model;
    }

    public function destroyOrgBusinessSectorById($id)
    {
        $destory = $this->OrgBusinessSectorInterface->destroyOrgBusinessSector($id);
        return new SuccessApiResponse($destory, 200);
    }
}