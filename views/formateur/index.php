{{ include('layouts/header.php', {title: 'Formateurs', page: 'formateur'}) }}

<div class="entete-page">
    <div>
        <h1 class="titre-page"><span>Formateurs</span></h1>
        <p class="sous-titre">Les personnes qui donnent les cours.</p>
    </div>
    <a href="{{ base }}/formateur/create" class="btn btn-primaire">Ajouter un formateur</a>
</div>

<div class="tableau-conteneur">
    <table class="tableau">
        <thead>
            <tr>
                <th>Formateur</th>
                <th>Spécialité</th>
                <th>Courriel</th>
                <th class="nombre">Cours</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {% for f in formateurs %}
            <tr>
                <td>
                    <div class="personne">
                        <span class="avatar">{{ f.prenom|first }}{{ f.nom|first }}</span>
                        <strong>{{ f.prenom }} {{ f.nom }}</strong>
                    </div>
                </td>
                <td>{{ f.specialite }}</td>
                <td class="texte-gris">{{ f.email }}</td>
                <td class="nombre">{{ f.nb_cours }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ base }}/formateur/edit?id={{ f.idformateur }}" class="btn btn-secondaire btn-petit">Modifier</a>
                        <form action="{{ base }}/formateur/delete" method="post" onsubmit="return confirm('Supprimer ce formateur ?');">
                            <input type="hidden" name="idformateur" value="{{ f.idformateur }}">
                            <input type="submit" value="Supprimer" class="btn btn-danger btn-petit">
                        </form>
                    </div>
                </td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>

{{ include('layouts/footer.php') }}