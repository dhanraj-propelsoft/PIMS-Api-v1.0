<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'pims_com_countries';
    public function getPfmStatus()
    {
        return $this->hasOne(DocumentType::class, 'id', 'document_type_id');
    }
}
