<?php
namespace App\Models;

// Classe abstraite CRUD : hérite de PDO
// C'est la classe parent de tous les modèles.
// Chaque modèle enfant définit $table, $primaryKey et $fillable.
abstract class CRUD extends \PDO {

    // Ouvre la connexion avec les valeurs de config.php
    final public function __construct(){
        parent::__construct('mysql:host='.DB_HOST.'; dbname='.DB_NAME.'; port=3306; charset=utf8', DB_USER, DB_PASS);
        $this->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    }

    // Toutes les lignes de la table, triées
    final public function select($field = null, $order = "ASC"):array{
        if($field == null){
            $field = $this->primaryKey;
        }
        $sql = "SELECT * FROM $this->table ORDER BY $field $order";
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }

    // Une seule ligne selon sa clé primaire
    final public function selectId(int|string $value):bool|array{
        $sql = "SELECT * FROM $this->table WHERE $this->primaryKey = :$this->primaryKey";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$this->primaryKey", $value);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count == 1){
            return $stmt->fetch();
        }else{
            return false;
        }
    }

    // Ajoute une ligne (seulement les champs de $fillable)
    final public function insert(array $data){
        $data_keys = array_fill_keys($this->fillable, '');
        $data = array_intersect_key($data, $data_keys);
        $fieldName = implode(', ', array_keys($data));
        $fieldBindValue = ":".implode(', :', array_keys($data));
        $sql = "INSERT INTO $this->table ($fieldName) VALUES ($fieldBindValue);";
        $stmt = $this->prepare($sql);
        foreach($data as $key=>$value){
            $stmt->bindValue(":$key", $value);
        }
        if($stmt->execute()){
            return $this->lastInsertId();
        }else{
            return false;
        }
    }

    // Modifie une ligne (seulement les champs de $fillable)
    final public function update(array $data, $id){
        $data_keys = array_fill_keys($this->fillable, '');
        $data = array_intersect_key($data, $data_keys);

        $fieldName = null;
        foreach($data as $key=>$value){
            $fieldName .= "$key = :$key, ";
        }
        $fieldName = rtrim($fieldName, ', ');
        $sql = "UPDATE $this->table SET $fieldName WHERE $this->primaryKey = :$this->primaryKey;";

        $data[$this->primaryKey] = $id;

        $stmt = $this->prepare($sql);
        foreach($data as $key=>$value){
            $stmt->bindValue(":$key", $value);
        }
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    // Supprime une ligne
    final public function delete(int|string $value):bool{
        $sql = "DELETE FROM $this->table WHERE $this->primaryKey = :$this->primaryKey";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$this->primaryKey", $value);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    // Compte les lignes de la table
    final public function count():int{
        $stmt = $this->query("SELECT COUNT(*) FROM $this->table");
        return $stmt->fetchColumn();
    }
        // Cherche une ligne selon la valeur d'un champ (ex. : un courriel)
    // Retourne la ligne si elle existe, sinon false
    final public function unique(string $field, string $value):array|bool{
        $sql = "SELECT * FROM $this->table WHERE $field = :$field";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$field", $value);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count === 1){
            return $stmt->fetch();
        }else{
            return false;
        }
    }
}