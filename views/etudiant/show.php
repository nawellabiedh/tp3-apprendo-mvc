{{ include('layouts/header.php', {title: etudiant.prenom ~ ' ' ~ etudiant.nom, page: 'etudiant'}) }}

<div class="entete-page">
    <div>
        <p class="sous-titre fil"><a class="lien-simple" href="{{ base }}/etudiants">Étudiants</a></p>
        <h1 class="titre-page"><span>{{ etudiant.prenom }} {{ etudiant.nom }}</span></h1>
    </div>
    <div class="actions">
        <a href="{{ base }}/etudiant/edit?id={{ etudiant.idetudiant }}" class="btn btn-secondaire">Modifier</a>
        <form action="{{ base }}/etudiant/delete" method="post" onsubmit="return confirm('Supprimer cet étudiant et ses inscriptions ?');">
            <input type="hidden" name="idetudiant" value="{{ etudiant.idetudiant }}">
            <input type="submit" value="Supprimer" class="btn btn-danger">
        </form>
    </div>
</div>

<div class="fiche">
    <div>
        <div class="section-entete">
            <h2 class="section-titre">Cours suivis ({{ coursSuivis|length }})</h2>
            <a href="{{ base }}/inscription/create?etudiant={{ etudiant.idetudiant }}" class="lien-simple">Inscrire à un cours</a>
        </div>
        <div class="tableau-conteneur">
            {% if coursSuivis is empty %}
                <div class="vide"><p>Cet étudiant ne suit encore aucun cours.</p></div>
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