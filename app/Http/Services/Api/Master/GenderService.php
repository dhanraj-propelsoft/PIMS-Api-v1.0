<?php
namespace App\Http\Services\Api\Master;

use App\Http\Interfaces\Api\Master\GenderInterface;
use App\Models\PimsPersonGender;
use Illuminate\Support\Facades\Log;


class GenderService
{
    public function __construct(GenderInterface $GenderInterface)
    {
        $this->GenderInterface = $GenderInterface;
    }

    public function index()
    {
        $datas = $this->GenderInterface->index();

        return $datas;

    }
    public function store($datas)
    {
        $datas = (object) $datas;
        $convert = $this->convertGender($datas);
        $storeModel = $this->GenderInterface->store($convert);
        Log::info('GenderService >Store Return.' . json_encode($storeModel));
        return $storeModel;

    }
    public function getGenderById($id = null)
    {
        $model = $this->GenderInterface->getGenderById($id);
        return $model;

    }
    public function convertGender($datas)
    {
        $model = $this->getGenderById(isset($datas->id) ? $datas->id : '');
        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new PimsPersonGender();
        }
        $model->gender = $datas->gender;
        $model->active_status = $datas->active_status;
        return $model;
    }
    public function destroyGenderById($id)
    {
        $destory = $this->GenderInterface->destroyGender($id);
        return $destory;
    }
}
