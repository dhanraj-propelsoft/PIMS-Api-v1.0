<?php

namespace App\Http\Interfaces\Api\PersonMaster;

interface RelationShipInterface
{
    public function index();
    public function store($model);
    public function getRelationShipById($id);
    public function destroyRelationShip($id);
}