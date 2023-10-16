<?php

namespace App\Http\Interfaces\Api\OrganizationMaster;

interface BusinessActivitiesInterface
{

    public function index();
    public function store($model);
    public function getBusinessActivitiesById($businessActivityId);
    public function destroyBusinessActivities($businessActivityId);

}