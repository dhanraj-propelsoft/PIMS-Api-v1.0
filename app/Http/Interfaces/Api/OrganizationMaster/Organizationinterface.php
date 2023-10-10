<?php

namespace App\Http\Interfaces\Api\OrganizationMaster;

interface OrganizationInterface
{
    public function tempOrganizationList();
    public function getTempOrganizationDataByTempId($id);
    public function saveOrganization($orgModel,$orgDetailModel,$orgEmailModel,$orgWebLinkModel,$propertyAddressModel,$orgDBModel);
    public  function getDataBaseNameByOrgId($id);
    public function dynamicOrganizationData($orgDocId,$orgOwnershipId,$orgCategoryId,$orgStructureId);
    public function destoryTempOrganizationForId($tempId);
    public function UserOrganizationRelational($model);



   

}