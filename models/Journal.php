<?php
namespace App\Models;
use App\Models\CRUD;

// Modèle Journal : table journal (une ligne par page visitée)
class Journal extends CRUD{
    protected $table = 'journal';
    protected $primaryKey = 'idjournal';
    protected $fillable = ['ip', 'utilisateur', 'page'];
}