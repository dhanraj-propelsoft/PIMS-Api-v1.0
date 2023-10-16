<?php

namespace App\Http\Interfaces\Api\PersonMaster;

interface BankInterface
{
    public function index();
    public function store($model);
    public function getBankById($bankId);
    public function destroyBank($bankId);

}
