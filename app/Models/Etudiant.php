<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom', 'prenom', 'genre', 'date_de_naissance', 'annee_dentree', 'photo', 'user_id'
    ];

    public function getPhotoAttribute($val){
        if($val==null)
           $val="student_default.png";
        return env('FLUTTER_URL').'/'.str_replace(DIRECTORY_SEPARATOR,'/',$val);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
