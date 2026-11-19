<?php
namespace App\Models;
use App\Models\CRUD;

// Modèle Categorie : table categorie
class Categorie extends CRUD{
    protected $table = 'categorie';
    protected $primaryKey = 'idcategorie';
    protected $fillable = ['nom', 'description'];

    // Nombre de cours dans une catégorie
    public function compterCours($id){
        $stmt = $this->prepare("SELECT COUNT(*) FROM cours WHERE categorie_idcategorie = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}