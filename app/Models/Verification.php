<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory;
    protected $fillable = [
        'diplome_id', 'nom_verif', 'email_verif'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class, 'diplome_id');
    }
}
