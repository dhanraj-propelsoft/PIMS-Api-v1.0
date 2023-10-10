<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class UserOrganizationRelational extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'user_organization_relationals';
}
