{{ include('layouts/header.php', {title: 'Connexion', page: 'login'}) }}

<div class="entete-page">
    <h1 class="titre-page"><span>Connexion</span></h1>
</div>

<form action="{{ base }}/login" method="post" class="formulaire">
    <div class="grille-champs">
        <div class="champ champ-large">
            <label for="username">Courriel</label>
            <input type="email" id="username" name="username" value="{{ user.username }}">
            {% if errors.username is defined %}<span class="erreur-champ">{{ errors.username }}</span>{% endif %}
        </div>
        <div class="champ champ-large">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password">
            {% if errors.password is defined %}<span class="erreur-champ">{{ errors.password }}</span>{% endif %}
        </div>
    </div>
    <div class="formulaire-actions">
        <input type="submit" class="btn btn-primaire" value="Se connecter">
    </div>
</form>

{{ include('layouts/footer.php') }}
