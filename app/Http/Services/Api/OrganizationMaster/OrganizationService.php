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
            $orgId=$tempOrgItem->id;
            $orgDetails = json_decode($tempOrgItem->organization_detail, true);
            $orgDocuments = json_decode($tempOrgItem->organization_doc_type, true);
            $orgAddress = json_decode($tempOrgItem->organization_address, true);
            $orgName = $orgDetails['orgName'];
            $orgEmail = $orgDetails['orgEmail'];
            $orgwebsite = $orgDetails['orgwebsite'];
            $orgStructureId = $orgDetails['orgStructureId'];
            $orgCategoryId = $orgDetails['orgCategoryId'];
            $orgOwnershipId = $orgDetails['orgOwnershipId'];
            $doorNo = $orgAddress['doorNo'];
            $buildingName = $orgAddress['buildingName'];
            $street = $orgAddress['street'];
            $landMark = $orgAddress['landMark'];
            $pinCode = $orgAddress['pinCode'];
            $districtId = $orgAddress['districtId'];
            $stateId = $orgAddress['stateId'];
            $cityId = $orgAddress['CityId'];
            $area = $orgAddress['area'];
            $location = $orgAddress['location'];

            $mappedDocuments = [];
            if ($orgDocuments) {
                foreach ($orgDocuments as $document) {
                    $docTypeId = $document['doctypeId'];
                    $docNo = $document['docNo'];
                    $docValid = $document['docValid'];
                    $docFilePath = $document['docFilePath'];

                    $mappedDocument = [
                        'docTypeId' => $docTypeId,
                        'docNo' => $docNo,
                        'docValid' => $docValid,
                        'docFilePath' => $docFilePath,
                    ];

                    $mappedDocuments[] = $mappedDocument;
                }
            }
            return [
                'orgId' =>$orgId,
                'orgName' => $orgName,
                'orgEmail' => $orgEmail,
                'orgwebsite' => $orgwebsite,
                'orgStructureId' => $orgStructureId,
                'orgCategoryId' => $orgCategoryId,
                'orgOwnershipId' => $orgOwnershipId,
                'orgDocuments' => $mappedDocuments,
                'doorNo' => $doorNo,
                'buildingName' => $buildingName,
                'street' => $street,
                'landMark' => $landMark,
                'pinCode' => $pinCode,
                'districtId' => $districtId,
                'stateId' => $stateId,
                'CityId' => $cityId,
                'area' => $area,
                'location' => $location,
            ];
        });
        Log::info('OrganizationService >Store Return.' . json_encode($tempOrganization));
        return new SuccessApiResponse($tempOrganization, 200);
    }
}
