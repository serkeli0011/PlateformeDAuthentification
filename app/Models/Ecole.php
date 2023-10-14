<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ecole extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_ecole', 'code_ecole', 'adresse_ecole', 
        // 'certificat',
        'parent_id'
    ];

    public function parent()
    {
        return $this->hasOne(Ecole::class,'id','parent_id');
    }
}
