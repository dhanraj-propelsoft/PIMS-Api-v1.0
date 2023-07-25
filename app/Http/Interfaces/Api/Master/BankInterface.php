<?php

namespace App\Http\Interfaces\Api\Master;

interface BankInterface
{
    public function index();
    public function store($model);
    public function getBankById($id);
    public function destroyBank($id);

}
