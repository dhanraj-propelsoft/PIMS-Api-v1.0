<?php

namespace App\Http\Controllers\Api\OrganizationMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Services\Api\OrganizationMaster\OrganizationService;

class OrganizationController extends Controller
{
    protected $OrganizationService;
    public function __construct(OrganizationService $OrganizationService)
    {
        $this->OrganizationService = $OrganizationService;
    }
    public function tempOrganizationList()
    {
        $response = $this->OrganizationService->tempOrganizationList();
        Log::info('OrganizationController -> index Return.' . json_encode($response));
        return $response;
    }
    public function organizationStore($tempId)
    {
   
        Log::info('OrganizationController > store function Inside.' . json_encode($tempId));
        $response = $this->OrganizationService->organizationStore($tempId);
        Log::info('OrganizationController > store function Return.' . json_encode($response));
        return $response;
    }
}
