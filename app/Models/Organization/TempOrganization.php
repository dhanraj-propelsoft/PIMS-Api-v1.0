<?php

namespace App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class TempOrganization extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'temp_organizations';
}
