<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = [
        'filiere', 'niveau', 'intitule', 'etudiant_id', 'ecole_id', 'user_id','file','signedfile','confidentiel',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id');
    }

    public function ecole()
    {
        return $this->belongsTo(Ecole::class, 'ecole_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function document()
    {
        return $this->hasMany(Document::class,'document_id');
    }

    public function getSignedfileAttribute($val){
        if($val)
        return str_replace(DIRECTORY_SEPARATOR,'/',$val);
    }
}   

