<?php
namespace App\Models;
use App\Models\CRUD;

// Modèle Inscription : table de liaison entre etudiant et cours
// (relation plusieurs-à-plusieurs)
class Inscription extends CRUD{
    protected $table = 'inscription';
    protected $primaryKey = 'idinscription';
    protected $fillable = ['date_inscription', 'cours_idcours', 'etudiant_idetudiant', 'progression'];

    // Toutes les inscriptions avec le nom de l'étudiant et le titre du cours
    public function selectDetails(){
        $sql = "SELECT inscription.*, etudiant.prenom, etudiant.nom, cours.titre
                FROM inscription
                INNER JOIN etudiant ON inscription.etudiant_idetudiant = etudiant.idetudiant
                INNER JOIN cours ON inscription.cours_idcours = cours.idcours
                ORDER BY inscription.date_inscription DESC";
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }

    // Une inscription avec le nom de l'étudiant et le titre du cours
    public function selectIdDetails($id){
        $sql = "SELECT inscription.*, etudiant.prenom, etudiant.nom, cours.titre
                FROM inscription
                INNER JOIN etudiant ON inscription.etudiant_idetudiant = etudiant.idetudiant
                INNER JOIN cours ON inscription.cours_idcours = cours.idcours
                WHERE inscription.idinscription = :id";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Les étudiants inscrits à un cours
    public function selectByCours($idcours){
        $sql = "SELECT inscription.*, etudiant.prenom, etudiant.nom
                FROM inscription
                INNER JOIN etudiant ON inscription.etudiant_idetudiant = etudiant.idetudiant
                WHERE inscription.cours_idcours = :idcours
                ORDER BY etudiant.nom";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':idcours', $idcours);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Les cours suivis par un étudiant
    public function selectByEtudiant($idetudiant){
        $sql = "SELECT inscription.*, cours.titre
                FROM inscription
                INNER JOIN cours ON inscription.cours_idcours = cours.idcours
                WHERE inscription.etudiant_idetudiant = :idetudiant
                ORDER BY inscription.date_inscription DESC";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':idetudiant', $idetudiant);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Vrai si l'étudiant est déjà inscrit à ce cours
    public function existe($idetudiant, $idcours){
        $stmt = $this->prepare("SELECT COUNT(*) FROM inscription WHERE etudiant_idetudiant = :e AND cours_idcours = :c");
        $stmt->bindValue(':e', $idetudiant);
        $stmt->bindValue(':c', $idcours);
        $stmt->execute();
        if($stmt->fetchColumn() > 0){
            return true;
        }else{
            return false;
        }
    }
}