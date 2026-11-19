<?php
namespace App\Models;
use App\Models\CRUD;

// Modèle Cours : table cours
// Un cours a une catégorie et un formateur (deux clés étrangères)
class Cours extends CRUD{
    protected $table = 'cours';
    protected $primaryKey = 'idcours';
    protected $fillable = ['titre', 'description', 'niveau', 'duree_heures', 'prix', 'categorie_idcategorie', 'formateur_idformateur', 'image'];

    // Les valeurs permises pour la colonne niveau (ENUM)
    public $niveaux = ['Débutant', 'Intermédiaire', 'Avancé'];

    // Tous les cours avec le nom de la catégorie, du formateur et le nombre d'inscrits
    // Si $idcategorie est donné, seulement les cours de cette catégorie
    public function selectDetails($idcategorie = null){
        $sql = "SELECT cours.*, categorie.nom AS categorie, formateur.prenom, formateur.nom AS formateur_nom,
                       (SELECT COUNT(*) FROM inscription WHERE inscription.cours_idcours = cours.idcours) AS inscrits
                FROM cours
                INNER JOIN categorie ON cours.categorie_idcategorie = categorie.idcategorie
                INNER JOIN formateur ON cours.formateur_idformateur = formateur.idformateur";
        if($idcategorie != null){
            $sql .= " WHERE cours.categorie_idcategorie = :idcategorie";
        }
        $sql .= " ORDER BY cours.titre";

        $stmt = $this->prepare($sql);
        if($idcategorie != null){
            $stmt->bindValue(':idcategorie', $idcategorie);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Un cours avec le nom de sa catégorie et de son formateur
    public function selectIdDetails($id){
        $sql = "SELECT cours.*, categorie.nom AS categorie, formateur.prenom, formateur.nom AS formateur_nom
                FROM cours
                INNER JOIN categorie ON cours.categorie_idcategorie = categorie.idcategorie
                INNER JOIN formateur ON cours.formateur_idformateur = formateur.idformateur
                WHERE cours.idcours = :id";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
}