<?php
namespace App\Models;
use App\Models\CRUD;

// Modèle Formateur : table formateur
class Formateur extends CRUD{
    protected $table = 'formateur';
    protected $primaryKey = 'idformateur';
    protected $fillable = ['nom', 'prenom', 'specialite', 'biographie', 'email'];

    // Nombre de cours donnés par un formateur
    public function compterCours($id){
        $stmt = $this->prepare("SELECT COUNT(*) FROM cours WHERE formateur_idformateur = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}