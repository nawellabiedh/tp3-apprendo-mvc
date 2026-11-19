{{ include('layouts/header.php', {title: cours.titre, page: 'cours'}) }}

<div class="entete-page">
    <div>
        <p class="sous-titre fil"><a class="lien-simple" href="{{ base }}/cours">Cours</a></p>
        <h1 class="titre-page"><span>{{ cours.titre }}</span></h1>
    </div>
    {% if admin %}
    <div class="actions">
        <a href="{{ base }}/cours/edit?id={{ cours.idcours }}" class="btn btn-secondaire">Modifier</a>
        <form action="{{ base }}/cours/delete" method="post" onsubmit="return confirm('Supprimer ce cours et ses inscriptions ?');">
            <input type="hidden" name="idcours" value="{{ cours.idcours }}">
            <input type="submit" value="Supprimer" class="btn btn-danger">
        </form>
    </div>
    {% endif %}
</div>

<div class="fiche">
    <div>
        {% if cours.image %}
            <img src="{{ asset }}/uploads/{{ cours.image }}" alt="{{ cours.titre }}" class="cours-image">
        {% endif %}
        <div class="bloc">
            <h2 class="section-titre">Description</h2>
            <p class="description">{{ cours.description ? cours.description : 'Aucune description.' }}</p>
        </div>

        {# Liste des inscrits : réservée à l'administrateur (données privées) #}
        {% if admin %}
        <div class="section">
            <div class="section-entete">
                <h2 class="section-titre">Étudiants inscrits ({{ inscrits|length }})</h2>
                <a href="{{ base }}/inscription/create?cours={{ cours.idcours }}" class="lien-simple">Inscrire un étudiant</a>
            </div>
            <div class="tableau-conteneur">
                {% if inscrits is empty %}
                    <div class="vide"><p>Personne n'est encore inscrit à ce cours.</p></div>
                {% else %}
                <table class="tableau">
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>Inscrit le</th>
                            <th>Progression</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for i in inscrits %}
                        <tr>
                            <td><a class="titre-ligne" href="{{ base }}/etudiant/show?id={{ i.etudiant_idetudiant }}">{{ i.prenom }} {{ i.nom }}</a></td>
                            <td class="texte-gris">{{ i.date_inscription|date('d/m/Y') }}</td>
                            <td>{{ include('inscription/progression.php', {valeur: i.progression}) }}</td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
                {% endif %}
            </div>
        </div>
        {% endif %}
    </div>

    <div class="bloc">
        <h2 class="section-titre">Informations</h2>
        <dl class="infos">
            <dt>Catégorie</dt>
            <dd>{{ cours.categorie }}</dd>
            <dt>Formateur</dt>
            <dd>{{ cours.prenom }} {{ cours.formateur_nom }}</dd>
            <dt>Niveau</dt>
            <dd>{{ include('cours/niveau.php', {niveau: cours.niveau}) }}</dd>
            <dt>Durée</dt>
            <dd>{{ cours.duree_heures }} heures</dd>
            <dt>Prix</dt>
            <dd>{% if cours.prix == 0 %}Gratuit{% else %}{{ cours.prix|number_format(2, ',', ' ') }} ${% endif %}</dd>
        </dl>
    </div>
</div>

{{ include('layouts/footer.php') }}