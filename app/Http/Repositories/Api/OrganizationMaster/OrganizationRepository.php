<?php

namespace App\Http\Repositories\Api\OrganizationMaster;
use App\Http\Interfaces\Api\OrganizationMaster\OrganizationInterface;
use App\Models\Organization\TempOrganization;
use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationCategory;
use App\Models\Organization\OrganizationDatabase;
use App\Models\Organization\OrganizationDetail;
use App\Models\Organization\OrganizationDocument;
use App\Models\Organization\OrganizationEmail;
use App\Models\Organization\OrganizationOwnership;
use App\Models\Organization\OrganizationStructure;
use App\Models\Organization\OrganizationWebAddress;
use App\Models\Organization\PropertyAddress;
use App\Models\Organization\OrganizationAddress;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrganizationRepository implements OrganizationInterface
{
    public function tempOrganizationList()
    {
        return TempOrganization::
        whereNull('deleted_flag')
        ->get();   
    }
    public function getTempOrganizationDataByTempId($id)
    {
        return TempOrganization::where('id', $id)->whereNull('deleted_at')->first();
    }
    public function saveOrganization($orgModel, $orgDetailModel, $orgEmailModel, $orgWebLinkModel, $propertyAddressModel, $orgDBModel)
    {
        try {
            $result = DB::transaction(function () use ($orgModel, $orgDetailModel, $orgEmailModel, $orgWebLinkModel, $propertyAddressModel, $orgDBModel) {

                $orgModel->save();
                $orgDetailModel->ParentOrganization()->associate($orgModel, 'org_id', 'id');
                $orgEmailModel->ParentOrganization()->associate($orgModel, 'org_id', 'id');
                $orgWebLinkModel->ParentOrganization()->associate($orgModel, 'org_id', 'id');
                $orgDBModel->ParentOrganization()->associate($orgModel, 'org_id', 'id');
                $orgDetailModel->save();
                $orgEmailModel->save();
                $orgWebLinkModel->save();
                $orgDBModel->save();
                if ($propertyAddressModel) {
                    $propertyAddressModel->save();
                    $orgAddress = new OrganizationAddress();
                    $orgAddress->ParentOrganization()->associate($orgModel, 'org_id', 'id');
                    $orgAddress->ParentComAddress()->associate($propertyAddressModel, 'com_propertry_address_id', 'id');
                    $orgAddress->save();
                }
                return $orgDBModel;

            });
            return $result;
        } catch (\Exception $e) {
            return [
                'message' => "failed",
                'data' => $e,
            ];
        }
    }
   
    public function getDataBaseNameByOrgId($id)
    {
        return OrganizationDatabase::where('org_id', $id)->first();
    }
    public function dynamicOrganizationData($orgDocId, $orgOwnershipId, $orgCategoryId, $orgStructureId)
    {
    //   $db=config('database.connections.mysql_external.database');
   
        try {
            $result = DB::transaction(function () use ($orgDocId, $orgOwnershipId, $orgCategoryId, $orgStructureId) {
                if ($orgDocId) {  
                for ($i = 0; $i < count($orgDocId); $i++) {
                    $orgDocId[$i]->save();
                }
                }
                $orgOwnershipId->save();
                $orgCategoryId->save();
                $orgStructureId->save();

                return [
                    'message' => "Success",
                    'data' => $orgOwnershipId->org_id,
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
}
