<?php
namespace App\Models;
use App\Models\CRUD;

// Modèle User : table user (les comptes qui peuvent se connecter)
class User extends CRUD{
    protected $table = 'user';
    protected $primaryKey = 'iduser';
    protected $fillable = ['nom', 'username', 'password', 'privilege_idprivilege', 'etudiant_idetudiant'];

    // Hache le mot de passe avant de l'enregistrer (jamais en clair)
    public function hashPassword(string $password, $cost = 10):string{
        $options = [
            'cost' => $cost
        ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    // Vérifie le courriel et le mot de passe, puis crée la session
    public function checkUser(string $username, string $password):bool{
        // 1) Le compte existe-t-il ?
        $user = $this->unique('username', $username);
        if($user){
            // 2) Le mot de passe saisi correspond-il au mot de passe haché ?
            if(password_verify($password, $user['password'])){
                // 3) Nouvel identifiant de session (protège contre la fixation de session)
                session_regenerate_id(true);
                // 4) On garde les informations utiles dans la session
                $_SESSION['user_id'] = $user['iduser'];
                $_SESSION['user_name'] = $user['nom'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_privilege'] = $user['privilege_idprivilege'];
                $_SESSION['etudiant_id'] = $user['etudiant_idetudiant'];
                $_SESSION['fingerPrint'] = md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']);
                return true;
            }
        }
        return false;
    }

    // Tous les utilisateurs avec le nom de leur rôle (pour l'administrateur)
    public function selectDetails(){
        $sql = "SELECT user.iduser, user.nom, user.username, privilege.privilege,
                       etudiant.prenom, etudiant.nom AS etudiant_nom
                FROM user
                INNER JOIN privilege ON user.privilege_idprivilege = privilege.idprivilege
                LEFT JOIN etudiant ON user.etudiant_idetudiant = etudiant.idetudiant
                ORDER BY user.nom";
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }
}