{{ include('layouts/header.php', {title: 'Créer un compte', page: 'user'}) }}

<div class="entete-page">
    <h1 class="titre-page"><span>Créer un compte</span></h1>
</div>

<form action="{{ base }}/user/create" method="post" class="formulaire">
    <div class="grille-champs">
        <div class="champ champ-large">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="{{ user.nom }}">
            {% if errors.nom is defined %}<span class="erreur-champ">{{ errors.nom }}</span>{% endif %}
        </div>
        <div class="champ">
            <label for="username">Courriel de connexion</label>
            <input type="email" id="username" name="username" value="{{ user.username }}">
            {% if errors.username is defined %}<span class="erreur-champ">{{ errors.username }}</span>{% endif %}
        </div>
        <div class="champ">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password">
            <span class="aide">Entre 6 et 20 caractères.</span>
            {% if errors.password is defined %}<span class="erreur-champ">{{ errors.password }}</span>{% endif %}
        </div>
        <div class="champ">
            <label for="privilege_idprivilege">Rôle</label>
            <select id="privilege_idprivilege" name="privilege_idprivilege">
                <option value="">Choisir un rôle</option>
                {% for p in privileges %}
                    <option value="{{ p.idprivilege }}" {% if p.idprivilege == user.privilege_idprivilege %}selected{% endif %}>{{ p.privilege }}</option>
                {% endfor %}
            </select>
            {% if errors.privilege_idprivilege is defined %}<span class="erreur-champ">{{ errors.privilege_idprivilege }}</span>{% endif %}
        </div>
        <div class="champ">
            <label for="etudiant_idetudiant">Étudiant lié</label>
            <select id="etudiant_idetudiant" name="etudiant_idetudiant">
                <option value="">Aucun (administrateur)</option>
                {% for e in etudiants %}
                    <option value="{{ e.idetudiant }}" {% if e.idetudiant == user.etudiant_idetudiant %}selected{% endif %}>{{ e.prenom }} {{ e.nom }}</option>
                {% endfor %}
            </select>
            <span class="aide">Obligatoire pour un compte client.</span>
            {% if errors.etudiant_idetudiant is defined %}<span class="erreur-champ">{{ errors.etudiant_idetudiant }}</span>{% endif %}
        </div>
    </div>
    <div class="formulaire-actions">
        <input type="submit" class="btn btn-primaire" value="Créer le compte">
        <a href="{{ base }}/users" class="btn btn-secondaire">Annuler</a>
    </div>
</form>

{{ include('layouts/footer.php') }}
