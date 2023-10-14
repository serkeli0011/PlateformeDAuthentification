<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->enum('filiere', ['asi','rsi','iabd']);
            $table->enum('niveau', ['bachelor3','master1','master2','doctorat']);
            $table->string('intitule');
            $table->enum('type',['diplome','bulletin','autre']);
            $table->string('file');
            $table->string('signedfile')->nullable();;
            $table->unsignedBigInteger('etudiant_id');
            $table->unsignedBigInteger('ecole_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('confidentiel')->default(true);
            $table->timestamps();
            
            $table->foreign('etudiant_id')->references('id')->on('etudiants')->onDelete('cascade');
            $table->foreign('ecole_id')->references('id')->on('ecoles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
