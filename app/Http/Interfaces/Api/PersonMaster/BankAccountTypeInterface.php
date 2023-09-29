<?php

namespace App\Http\Interfaces\Api\PersonMaster;

interface BankAccountTypeInterface
{
    public function index();
    public function store($model);
    public function getBankAccountTypeById($id);
    public function destroyBankAccountType($id);
}
