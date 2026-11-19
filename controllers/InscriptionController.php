<?php
namespace App\Controllers;

use App\Models\Inscription;
use App\Models\Etudiant;
use App\Models\Cours;
use App\Providers\View;
use App\Providers\Validator;
use App\Providers\Auth;

// Contrôleur des inscriptions (relation plusieurs-à-plusieurs entre etudiant et cours)
class InscriptionController {

    // Tout ce contrôleur est réservé à l'administrateur
    public function __construct(){
        Auth::privilege(Auth::ADMIN);
    }

    public function index(){
        $inscription = new Inscription;
        $inscriptions = $inscription->selectDetails();
        return View::render('inscription/index', ['inscriptions' => $inscriptions]);
    }

    // Formulaire d'inscription
    // Présélection possible : inscription/create?cours=3 ou ?etudiant=2
    public function create($data = []){
        $inscription = [
            'cours_idcours'       => $data['cours'] ?? '',
            'etudiant_idetudiant' => $data['etudiant'] ?? '',
            'date_inscription'    => date('Y-m-d'),
            'progression'         => 0
        ];
        return View::render('inscription/create', array_merge($this->listes(), ['inscription' => $inscription]));
    }

    public function store(array $data){
        $val = $this->valider($data);

        // Un étudiant ne peut pas être inscrit deux fois au même cours
        $inscription = new Inscription;
        if(!empty($data['etudiant_idetudiant']) && !empty($data['cours_idcours'])
            && $inscription->existe($data['etudiant_idetudiant'], $data['cours_idcours'])){
            $val->addError('cours_idcours', 'Cet étudiant est déjà inscrit à ce cours.');
        }

        if($val->isSuccess()){
            $inscription->insert($data);
            return View::redirect('cours/show?id='.$data['cours_idcours'].'&message=inscrit');
        }else{
            return View::render('inscription/create', array_merge($this->listes(), ['errors' => $val->getErrors(), 'inscription' => $data]));
        }
    }

    // Modification de la date et de la progression
    public function edit($data = []){
        if(isset($data['id'])){
            $inscription = new Inscription;
            $uneInscription = $inscription->selectIdDetails($data['id']);
            if($uneInscription){
                return View::render('inscription/edit', ['inscription' => $uneInscription]);
            }
        }
        return View::render('error', ['msg' => 'Cette inscription est introuvable.']);
    }

    public function update(array $data, $get = []){
        if(isset($get['id'])){
            $inscription = new Inscription;
            $uneInscription = $inscription->selectIdDetails($get['id']);
            if($uneInscription){
                $val = new Validator;
                $val->field('date_inscription', $data['date_inscription'] ?? '', "La date d'inscription")->required()->date();
                $val->field('progression', $data['progression'] ?? '', 'La progression')->required()->int()->minValue(0)->maxValue(100);

                if($val->isSuccess()){
                    // On modifie seulement la date et la progression
                    $modif = ['date_inscription' => $data['date_inscription'], 'progression' => $data['progression']];
                    $inscription->update($modif, $get['id']);
                    return View::redirect('inscriptions?message=modifie');
                }else{
                    $uneInscription['date_inscription'] = $data['date_inscription'] ?? '';
                    $uneInscription['progression'] = $data['progression'] ?? '';
                    return View::render('inscription/edit', ['errors' => $val->getErrors(), 'inscription' => $uneInscription]);
                }
            }
        }
        return View::render('error', ['msg' => 'Cette inscription est introuvable.']);
    }

    // Retirer un étudiant d'un cours
    public function delete($data){
        $inscription = new Inscription;
        $inscription->delete($data['idinscription']);
        return View::redirect('inscriptions?message=retire');
    }

    // ---------- Méthodes privées ----------

    // Règles de validation d'une nouvelle inscription
    private function valider($data){
        $val = new Validator;
        $val->field('etudiant_idetudiant', $data['etudiant_idetudiant'] ?? '', "L'étudiant")->required()->int();
        $val->field('cours_idcours', $data['cours_idcours'] ?? '', 'Le cours')->required()->int();
        $val->field('date_inscription', $data['date_inscription'] ?? '', "La date d'inscription")->required()->date();
        $val->field('progression', $data['progression'] ?? '', 'La progression')->required()->int()->minValue(0)->maxValue(100);

        // L'étudiant et le cours choisis doivent exister (clés étrangères)
        $etudiant = new Etudiant;
        if(!empty($data['etudiant_idetudiant']) && !$etudiant->selectId($data['etudiant_idetudiant'])){
            $val->addError('etudiant_idetudiant', "Cet étudiant n'existe pas.");
        }
        $cours = new Cours;
        if(!empty($data['cours_idcours']) && !$cours->selectId($data['cours_idcours'])){
            $val->addError('cours_idcours', "Ce cours n'existe pas.");
        }
        return $val;
    }

    // Données des listes déroulantes
    private function listes(){
        $etudiant = new Etudiant;
        $cours = new Cours;
        return [
            'etudiants'  => $etudiant->select('nom'),
            'listeCours' => $cours->select('titre')
        ];
    }
}