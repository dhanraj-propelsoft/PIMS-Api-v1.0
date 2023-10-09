<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OrganizationInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrganizationService
{
    protected $OrganizationInterface;
    public function __construct(OrganizationInterface $OrganizationInterface)
    {
        $this->OrganizationInterface = $OrganizationInterface;
    }

    public function tempOrganizationList()
    {
        $model = $this->OrganizationInterface->tempOrganizationList();
        $tempOrganization = $model->map(function ($tempOrgItem) {
            $tempOrgId=$tempOrgItem->id;
            $orgDetails = json_decode($tempOrgItem->organization_detail, true);
            $orgName=$orgDetails['orgName'];
            return ['tempOrgName'=> $orgName,'tempOrgId'=>$tempOrgId];
        });
        Log::info('OrganizationService >Store Return.' . json_encode($model));
        return new SuccessApiResponse($model, 200);
    }
}