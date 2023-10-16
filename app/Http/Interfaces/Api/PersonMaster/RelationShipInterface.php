<?php

namespace App\Http\Interfaces\Api\PersonMaster;

interface RelationShipInterface
{
    public function index();
    public function store($model);
    public function getRelationShipById($relationshipId);
    public function destroyRelationShip($relationshipId);
}