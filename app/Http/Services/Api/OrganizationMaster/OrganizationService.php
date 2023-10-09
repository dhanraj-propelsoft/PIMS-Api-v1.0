<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OrganizationInterface;
use App\Http\Responses\SuccessApiResponse;
use Illuminate\Support\Facades\Log;

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
            $orgDetails = json_decode($tempOrgItem->organization_detail, true);
            $orgDocuments = json_decode($tempOrgItem->organization_doc_type, true);
            $orgAddress = json_decode($tempOrgItem->organization_address, true);
            return ['orgDetails' => $orgDetails, 'orgDocuments' => $orgDocuments, 'orgAddress' => $orgAddress];
        });
        Log::info('OrganizationService >Store Return.' . json_encode($tempOrganization));
        return new SuccessApiResponse($tempOrganization, 200);
    }
}
