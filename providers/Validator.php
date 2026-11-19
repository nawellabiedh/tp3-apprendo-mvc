<?php
namespace App\Providers;

// Classe Validator : vérifie les données d'un formulaire avant l'enregistrement
// Exemple : $val->field('titre', $data['titre'], 'Le titre')->required()->max(150);
class Validator {

    private $errors = array();
    private string $key;
    private string $value;
    private string $name;

    // Choisit le champ à vérifier
    public function field(string $key, string $value, $name = null){
        $this->key = $key;
        $this->value = trim($value);
        if($name == null){
            $this->name = ucfirst($key);
        }else{
            $this->name = ucfirst($name);
        }
        return $this;
    }

    // ---------- Règles ----------
    // (un champ vide est vérifié seulement par required)

    // Le champ ne doit pas être vide
    public function required(){
        if($this->value === ''){
            $this->errors[$this->key] = "$this->name est obligatoire.";
        }
        return $this;
    }

    // Longueur minimale
    public function min(int $length){
        if($this->value !== '' && mb_strlen($this->value) < $length){
            $this->errors[$this->key] = "$this->name doit contenir au moins $length caractères.";
        }
        return $this;
    }

    // Longueur maximale
    public function max(int $length){
        if(mb_strlen($this->value) > $length){
            $this->errors[$this->key] = "$this->name doit contenir au maximum $length caractères.";
        }
        return $this;
    }

    // Nombre entier
    public function int(){
        if($this->value !== '' && filter_var($this->value, FILTER_VALIDATE_INT) === false){
            $this->errors[$this->key] = "$this->name doit être un nombre entier.";
        }
        return $this;
    }

    // Nombre (entier ou décimal)
    public function number(){
        if($this->value !== '' && !is_numeric($this->value)){
            $this->errors[$this->key] = "$this->name doit être un nombre.";
        }
        return $this;
    }

    // Valeur minimale d'un nombre
    public function minValue(float $min){
        if(is_numeric($this->value) && $this->value < $min){
            $this->errors[$this->key] = "$this->name doit valoir au moins $min.";
        }
        return $this;
    }

    // Valeur maximale d'un nombre
    public function maxValue(float $max){
        if(is_numeric($this->value) && $this->value > $max){
            $this->errors[$this->key] = "$this->name doit valoir au plus $max.";
        }
        return $this;
    }

    // Adresse courriel valide
    public function email(){
        if(!empty($this->value) && !filter_var($this->value, FILTER_VALIDATE_EMAIL)){
            $this->errors[$this->key] = "$this->name n'est pas valide.";
        }
        return $this;
    }

    // Date valide au format AAAA-MM-JJ
    public function date(){
        $d = \DateTime::createFromFormat('Y-m-d', $this->value);
        if($this->value !== '' && (!$d || $d->format('Y-m-d') != $this->value)){
            $this->errors[$this->key] = "$this->name doit être une date valide.";
        }
        return $this;
    }

    // La valeur doit faire partie d'une liste (ex. : les niveaux)
    public function in(array $list){
        if($this->value !== '' && !in_array($this->value, $list)){
            $this->errors[$this->key] = "$this->name contient une valeur non permise.";
        }
        return $this;
    }

    // Ajoute une erreur personnalisée (ex. : inscription en double)
    public function addError(string $key, string $message){
        $this->errors[$key] = $message;
        return $this;
    }

    // ---------- Résultat ----------
    public function isSuccess(){
        if(empty($this->errors)) return true;
        return false;
    }

    public function getErrors(){
        return $this->errors;
    }
}