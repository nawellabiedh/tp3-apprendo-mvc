<?php
namespace App\Models;
use App\Models\CRUD;

// Modèle Privilege : table privilege (1 = Administrateur, 2 = Client)
class Privilege extends CRUD{
    protected $table = 'privilege';
    protected $primaryKey = 'idprivilege';
    protected $fillable = ['privilege'];
}