{{ include('layouts/header.php', {title: 'Inscriptions', page: 'inscription'}) }}

<div class="entete-page">
    <div>
        <h1 class="titre-page"><span>Inscriptions</span></h1>
        <p class="sous-titre">Qui suit quel cours, et où en est chaque étudiant.</p>
    </div>
    <a href="{{ base }}/inscription/create" class="btn btn-primaire">Inscrire un étudiant</a>
</div>

<div class="tableau-conteneur">
    <table class="tableau">
        <thead>
            <tr>
                <th>Étudiant</th>
                <th>Cours</th>
                <th>Inscrit le</th>
                <th>Progression</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {% for i in inscriptions %}
            <tr>
                <td><a class="titre-ligne" href="{{ base }}/etudiant/show?id={{ i.etudiant_idetudiant }}">{{ i.prenom }} {{ i.nom }}</a></td>
                <td><a class="titre-ligne" href="{{ base }}/cours/show?id={{ i.cours_idcours }}">{{ i.titre }}</a></td>
                <td class="texte-gris">{{ i.date_inscription|date('d/m/Y') }}</td>
                <td>{{ include('inscription/progression.php', {valeur: i.progression}) }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ base }}/inscription/edit?id={{ i.idinscription }}" class="btn btn-secondaire btn-petit">Modifier</a>
                        <form action="{{ base }}/inscription/delete" method="post" onsubmit="return confirm('Retirer cet étudiant du cours ?');">
                            <input type="hidden" name="idinscription" value="{{ i.idinscription }}">
                            <input type="submit" value="Retirer" class="btn btn-danger btn-petit">
                        </form>
                    </div>
                </td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>

{{ include('layouts/footer.php') }}