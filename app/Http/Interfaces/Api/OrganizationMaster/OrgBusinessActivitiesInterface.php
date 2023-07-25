<?php

namespace App\Http\Interfaces\Api\OrganizationMaster;

interface OrgBusinessActivitiesInterface
{

    public function index();
    public function store($model);
    public function getOrgBusinessActivitiesById($id);
    public function destroyOrgBusinessActivities($id);

}