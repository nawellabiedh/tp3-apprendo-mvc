{{ include('layouts/header.php', {title: 'Mon espace', page: 'espace'}) }}

<div class="entete-page">
    <div>
        <h1 class="titre-page"><span>Mon espace</span></h1>
        <p class="sous-titre">Bienvenue {{ etudiant.prenom }}, voici vos cours et votre progression.</p>
    </div>
</div>

<div class="fiche">
    <div>
        <div class="section-entete">
            <h2 class="section-titre">Mes cours ({{ coursSuivis|length }})</h2>
        </div>
        <div class="tableau-conteneur">
            {% if coursSuivis is empty %}
                <div class="vide"><p>Vous ne suivez encore aucun cours.</p></div>
            {% else %}
            <table class="tableau">
                <thead>
                    <tr>
                        <th>Cours</th>
                        <th>Inscrit le</th>
                        <th>Progression</th>
                    </tr>
                </thead>
                <tbody>
                    {% for i in coursSuivis %}
                    <tr>
                        <td><a class="titre-ligne" href="{{ base }}/cours/show?id={{ i.cours_idcours }}">{{ i.titre }}</a></td>
                        <td class="texte-gris">{{ i.date_inscription|date('d/m/Y') }}</td>
                        <td>{{ include('inscription/progression.php', {valeur: i.progression}) }}</td>
                    </tr>
                    {% endfor %}
                </tbody>
            </table>
            {% endif %}
        </div>
    </div>

    <div class="bloc">
        <div class="personne" style="margin-bottom: 18px;">
            <span class="avatar">{{ etudiant.prenom|first }}{{ etudiant.nom|first }}</span>
            <strong>{{ etudiant.prenom }} {{ etudiant.nom }}</strong>
        </div>
        <dl class="infos">
            <dt>Courriel</dt>
            <dd>{{ etudiant.email }}</dd>
            <dt>Membre depuis</dt>
            <dd>{{ etudiant.date_creation|date('d/m/Y') }}</dd>
        </dl>
    </div>
</div>

{{ include('layouts/footer.php') }}