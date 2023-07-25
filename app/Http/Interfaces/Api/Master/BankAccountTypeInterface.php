<?php

namespace App\Http\Interfaces\Api\Master;

interface BankAccountTypeInterface
{
    public function index();
    public function store($model);
    public function getBankAccountTypeById($id);
    public function destroyBankAccountType($id);
}
