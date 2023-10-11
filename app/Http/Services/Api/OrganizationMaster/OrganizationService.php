<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OrganizationInterface;
use App\Http\Responses\SuccessApiResponse;
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
use App\Models\Organization\UserOrganizationRelational;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
            $orgId = $tempOrgItem->id;
            $orgDetails = json_decode($tempOrgItem->organization_detail, true);
            $orgDocuments = json_decode($tempOrgItem->organization_doc_type, true);
            $orgAddress = json_decode($tempOrgItem->organization_address, true);

            $orgName = $orgDetails['orgName'];

            $orgEmail = $orgDetails['orgEmail'];
            $orgwebsite = $orgDetails['orgwebsite'];
            $orgStructureId = $orgDetails['orgStructureId'];
            $orgCategoryId = $orgDetails['orgCategoryId'];
            $orgOwnershipId = $orgDetails['orgOwnershipId'];
            $buildingName = $orgAddress['buildingName'];
            $doorNo = $orgAddress['doorNo'];

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
                'orgId' => $orgId,
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
    public function organizationStore($tempOrgId)
    {

        Log::info('OrganizationService > store function Inside.' . json_encode($tempOrgId));
        $tempOrgData = $this->OrganizationInterface->getTempOrganizationDataByTempId($tempOrgId);
      
        $tempId = $tempOrgData->id;
        $uid = $tempOrgData->authorized_person_id;
        if ($tempOrgData) {
            $orgDetails = json_decode($tempOrgData->organization_detail, true);
            $orgDocuments = json_decode($tempOrgData->organization_doc_type, true);
            $orgAddress = (object) json_decode($tempOrgData->organization_address, true);
            $generateOrganizationModel = $this->convertToOrganizationModel();
            $generateOrganizationDetailModel = $this->convertToOrganizationDetailModel($orgDetails);
            $generateOrganizationEmailModel = $this->convertToOrganizationEmailModel($orgDetails);
            $generateOrganizationWebAddressModel = $this->convertToOrganizationWebAddressModel($orgDetails);
            $generatePropertyAddressModel = $this->convertToPropertyAddressModel($orgAddress);
            $generateOrganizationDatabaseModel = $this->convertToOrganizationDatabaseModel($orgDetails);
            $orgModel = $this->OrganizationInterface->saveOrganization($generateOrganizationModel, $generateOrganizationDetailModel, $generateOrganizationEmailModel, $generateOrganizationWebAddressModel, $generatePropertyAddressModel, $generateOrganizationDatabaseModel);
            $orgId = $orgModel->id;
            $orgName = $orgModel->db_name;
            $CreateDynamicDb = $this->createDynamicDatabase($orgName);
            $dbConnection = $this->getOrganizationDatabaseByOrgId($orgId);
            $generateOrganizationDocumentModel = $this->convertToOrganizationDocumentModel($orgDocuments, $orgId);
            $generateOrganizationOwnerShipIdModel = $this->convertOrganizationOwnerShipModel($orgDetails, $orgId);
            $generateOrganizationCategoryIdModel = $this->convertOrganizationCategoryModel($orgDetails, $orgId);
            $generateOrganizationStructureIdModel = $this->convertOrganizationStructureModel($orgDetails, $orgId);
            $model = $this->OrganizationInterface->dynamicOrganizationData($generateOrganizationDocumentModel, $generateOrganizationOwnerShipIdModel, $generateOrganizationCategoryIdModel, $generateOrganizationStructureIdModel);
            if ($model['message'] == "Success") {
                $destoryTempOrg = $this->OrganizationInterface->destoryTempOrganizationForId($tempId);
                $orgLinkUser = $this->convertOrgIdLinkUser($orgId, $uid);
                $result = $this->OrganizationInterface->UserOrganizationRelational($orgLinkUser);
            } else {
                $result = $model;
            }
            return new SuccessApiResponse($result, 200);

        }
    }
    public function convertOrgIdLinkUser($orgId, $uid)
    {
        if($orgId){
            $setDefault=$this->OrganizationInterface->checkDefaultOrganizationByUid($uid);
            $model = new UserOrganizationRelational();
            $model->uid = $uid;
            $model->organization_id = $orgId;
            $model->default_org=($setDefault)?0:1;
            $model->pfm_active_status_id = 1;
            return $model;
        }
        
    }
    public function convertToOrganizationModel()
    {
        $model = new Organization();
        $model->pfm_stage_id = 1;
        $model->pfm_authorization_id = 1;
        $model->pfm_origin_id = 1;
        return $model;
    }
    public function convertToOrganizationDetailModel($datas)
    {
        $datas = (object) $datas;
        $model = new OrganizationDetail();
        $model->title_id = (isset($datas->title_id) ? $datas->title_id : null);
        $model->org_name = $datas->orgName;
        $model->org_alias = (isset($datas->org_alias) ? $datas->org_alias : null);
        $model->started_date = (isset($datas->started_date) ? $datas->started_date : null);
        $model->year_of_establishment = (isset($datas->year_of_establishment) ? $datas->year_of_establishment : null);
        $model->is_registered_org = (isset($datas->is_registered_org) ? $datas->is_registered_org : null);
        $model->date_of_reg = (isset($datas->date_of_reg) ? $datas->date_of_reg : null);
        return $model;
    }
    public function convertToOrganizationEmailModel($datas)
    {
        $datas = (object) $datas;
        $model = new OrganizationEmail();
        $model->email = $datas->orgEmail;
        $model->pfm_active_status_id = 1;
        return $model;
    }
    public function convertToOrganizationWebAddressModel($datas)
    {
        $datas = (object) $datas;
        $model = new OrganizationWebAddress();
        $model->web_address = (isset($datas->orgwebsite) ? $datas->orgwebsite : null);
        $model->pfm_active_status_id = 1;
        return $model;

    }
    public function convertToPropertyAddressModel($datas)
    {

        $model = new PropertyAddress();
        $model->door_no = (isset($datas->door_no) ? $datas->door_no : null);
        $model->building_name = (isset($datas->building_name) ? $datas->building_name : null);
        $model->pin = (isset($datas->pincode) ? $datas->pincode : null);
        $model->pims_com_state_id = (isset($datas->state_id) ? $datas->state_id : null);
        $model->street = (isset($datas->street) ? $datas->street : null);
        $model->land_mark = (isset($datas->landmark) ? $datas->landmark : null);
        $model->pims_com_district_id = (isset($datas->district_id) ? $datas->district_id : null);
        $model->pims_com_city_id = (isset($datas->city_id) ? $datas->city_id : null);
        $model->area = (isset($datas->area) ? $datas->area : null);
        $model->location = (isset($datas->location) ? $datas->location : null);
        return $model;

    }
    public function convertToOrganizationDatabaseModel($datas)
    {
        $datas = (object) $datas;
        Log::info('OrganizationService > convertToOrganizationDatabaseModel function Inside.' . json_encode($datas));
        $dbName = now()->timestamp . preg_replace('/\s+/', '', $datas->orgName);
        $model = new OrganizationDatabase();
        $model->db_name = $dbName;
        $model->pfm_active_status_id = 1;
        return $model;
    }
    public function createDynamicDatabase($dbName)
    {
        $preDatabase = Config::get('database.connections.mysql.database');
        DB::statement("CREATE DATABASE IF NOT EXISTS $dbName");
        $new = Config::set('database.connections.mysql.database', $dbName);
        DB::purge('mysql');
        DB::reconnect('mysql');
        Artisan::call('migrate', [
            '--path' => 'database/migrations/DynamicOrganization',
        ]);
        Config::set('database.connections.mysql.database', $preDatabase);
        DB::purge('mysql');
        DB::reconnect('mysql');
        // $current = Config::set('database.connections.mysql.database', $preDatabase);
        // DB::purge('mysql');
        // DB::reconnect('mysql');
        return true;
    }
    public function getOrganizationDatabaseByOrgId($orgId)
    {

        //$databaseName = config('database.connections.mysql.database');

        $result = $this->OrganizationInterface->getDataBaseNameByOrgId($orgId);
        Session::put('currentDatabase', $result->db_name);
        Config::set('database.connections.mysql_external.database', $result->db_name);
        DB::purge('mysql');
        DB::reconnect('mysql');
        Log::info('CommonService > getOrganizationDatabaseByOrgId function Return.' . json_encode($result));
        return $result;
    }
    public function convertToOrganizationDocumentModel($datas, $orgId)
    {
        if ($datas) {
            $orgModel = [];
            for ($i = 0; $i < count($datas); $i++) {
                $model[$i] = new OrganizationDocument();
                $model[$i]->org_id = $orgId;
                $model[$i]->pims_org_doc_type_id = (isset($datas[$i]['doctypeId']) ? $datas[$i]['doctypeId'] : null);
                $model[$i]->doc_no = (isset($datas[$i]['docNo']) ? $datas[$i]['docNo'] : null);
                // $model[$i]->doc_validity = (isset($datas[$i]['docValid']) ? $datas[$i]['docValid'] : null);
                $model[$i]->doc_attachment = (isset($datas[$i]['docFilePath']) ? $datas[$i]['docFilePath'] : null);
                $model[$i]->pfm_active_status_id = (isset($datas[$i]['activeStatus']) ? $datas[$i]['activeStatus'] : null);
                array_push($orgModel, $model[$i]);

            }
            return $orgModel;
        }
    }
    public function convertOrganizationOwnerShipModel($datas, $orgId)
    {

        $datas = (object) $datas;
        $model = new OrganizationOwnership();
        $model->org_id = $orgId;
        $model->pims_org_ownership_id = (isset($datas->orgOwnershipId) ? $datas->orgOwnershipId : null);
        $model->pfm_active_status_id = (isset($datas->activeStatus) ? $datas->activeStatus : null);

        return $model;
    }
    public function convertOrganizationCategoryModel($datas, $orgId)
    {
        $datas = (object) $datas;
        $model = new OrganizationCategory();
        $model->org_id = $orgId;
        $model->pims_org_category_id = (isset($datas->orgCategoryId) ? $datas->orgCategoryId : null);
        $model->pfm_active_status_id = (isset($datas->activeStatus) ? $datas->activeStatus : null);

        return $model;
    }
    public function convertOrganizationStructureModel($datas, $orgId)
    {
        $datas = (object) $datas;
        $model = new OrganizationStructure();
        $model->org_id = $orgId;
        $model->pims_org_structure_id = (isset($datas->orgStructureId) ? $datas->orgStructureId : null);
        $model->pfm_active_status_id = (isset($datas->activeStatus) ? $datas->activeStatus : null);

        return $model;
    }
}
