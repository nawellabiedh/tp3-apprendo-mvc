{{ include('layouts/header.php', {title: 'Utilisateurs', page: 'user'}) }}

<div class="entete-page">
    <div>
        <h1 class="titre-page"><span>Utilisateurs</span></h1>
        <p class="sous-titre">{{ users|length }} comptes peuvent se connecter.</p>
    </div>
    <a href="{{ base }}/user/create" class="btn btn-primaire">Créer un compte</a>
</div>

<div class="tableau-conteneur">
    <table class="tableau">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Courriel de connexion</th>
                <th>Rôle</th>
                <th>Étudiant lié</th>
            </tr>
        </thead>
        <tbody>
            {% for u in users %}
            <tr>
                <td>{{ u.nom }}</td>
                <td class="texte-gris">{{ u.username }}</td>
                <td>{{ u.privilege }}</td>
                <td>{% if u.prenom %}{{ u.prenom }} {{ u.etudiant_nom }}{% else %}<span class="texte-gris">Aucun</span>{% endif %}</td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>

{{ include('layouts/footer.php') }}