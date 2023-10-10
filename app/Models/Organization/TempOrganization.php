<?php

namespace App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TempOrganization extends Model
{
    use HasFactory;

    protected $table = 'temp_organizations';
}
