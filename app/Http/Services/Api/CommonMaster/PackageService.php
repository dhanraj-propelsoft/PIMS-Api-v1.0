<?php
namespace App\Http\Services\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\PackageInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Package;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PackageService
{
    protected $PackageInterface, $ActiveStatusInterface;
    public function __construct(PackageInterface $PackageInterface,ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->PackageInterface = $PackageInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;
    }

    public function index()
    {
        $models = $this->PackageInterface->index();

        $entities = $models->map(function ($model) {
            $name = $model->name;
            $status = $model->activeStatus->active_type;
            $description=$model->description;
            $packageId = $model->id;
            $datas = ['name' => $name, 'description'=>$description,'status' => $status,  'packageId' => $packageId];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForPackage($datas);
        if ($validation->data['errors'] === false) {
        $datas = (object) $datas;
        $convert = $this->convertPackage($datas);
        $storeModel = $this->PackageInterface->store($convert);
        Log::info('PackageService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    } else {
        return $validation->data['errors'];
    }
    }
    public function ValidationForPackage($datas)
    {
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'name') {
                $rules['name'] = [
                    'required',
                    'string',
                    Rule::unique('packages', 'name')->where(function ($query) use ($datas) {
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
    public function getPackageById($packageId )
    {
        $model = $this->PackageInterface->getPackageById($packageId);
        $activeStatus =$this->ActiveStatusInterface->index();
        $datas = array();
        if ($model) {
            $name = $model->name;
            $status = $model->activeStatus->active_type;
            $activeStatusId = $model->pfm_active_status_id;
            $description=$model->description;
            $packageId = $model->id;
            $datas = ['name' => $name,'description'=>$description, 'status' => $status, 'activeStatusId' => $activeStatusId, 'packageId' => $packageId,'activeStatus'=>$activeStatus];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertPackage($datas)
    {

        if (isset($datas->id)) {
            $model = $this->PackageInterface->getPackageById($datas->id);
            $model->last_updated_by=auth()->user()->id;
        } else {
            $model = new Package();
            $model->created_by=auth()->user()->id;

        }
        $model->name = $datas->name;
        $model->description = isset($datas->description) ? $datas->description :null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyPackageById($packageId)
    {
        $destroy = $this->PackageInterface->destroyPackage($packageId);
        if ($destroy) {
            return response()->json(['Success' => true, 'Message' => 'Record Deleted Successfully']);
        } else {
            return response()->json(['Success' => false, 'Message' => 'Record Not Deleted']);
        }
    }
}
