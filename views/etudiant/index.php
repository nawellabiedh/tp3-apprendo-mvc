{{ include('layouts/header.php', {title: 'Étudiants', page: 'etudiant'}) }}

<div class="entete-page">
    <div>
        <h1 class="titre-page"><span>Étudiants</span></h1>
        <p class="sous-titre">{{ etudiants|length }} personnes inscrites sur la plateforme.</p>
    </div>
    <a href="{{ base }}/etudiant/create" class="btn btn-primaire">Ajouter un étudiant</a>
</div>

<div class="tableau-conteneur">
    <table class="tableau">
        <thead>
            <tr>
                <th>Étudiant</th>
                <th>Courriel</th>
                <th>Membre depuis</th>
                <th class="nombre">Cours suivis</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {% for e in etudiants %}
            <tr>
                <td>
                    <div class="personne">
                        <span class="avatar">{{ e.prenom|first }}{{ e.nom|first }}</span>
                        <a class="titre-ligne" href="{{ base }}/etudiant/show?id={{ e.idetudiant }}">{{ e.prenom }} {{ e.nom }}</a>
                    </div>
                </td>
                <td class="texte-gris">{{ e.email }}</td>
                <td class="texte-gris">{{ e.date_creation|date('d/m/Y') }}</td>
                <td class="nombre">{{ e.nb_cours }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ base }}/etudiant/show?id={{ e.idetudiant }}" class="btn btn-secondaire btn-petit">Voir</a>
                        <a href="{{ base }}/etudiant/edit?id={{ e.idetudiant }}" class="btn btn-secondaire btn-petit">Modifier</a>
                    </div>
                </td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>

{{ include('layouts/footer.php') }}