<?php
namespace App\Models;
use App\Models\CRUD;

// Modèle Etudiant : table etudiant
// (date_creation est remplie automatiquement par MySQL)
class Etudiant extends CRUD{
    protected $table = 'etudiant';
    protected $primaryKey = 'idetudiant';
    protected $fillable = ['nom', 'prenom', 'email'];

    // Nombre de cours suivis par un étudiant
    public function compterCours($id){
        $stmt = $this->prepare("SELECT COUNT(*) FROM inscription WHERE etudiant_idetudiant = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}