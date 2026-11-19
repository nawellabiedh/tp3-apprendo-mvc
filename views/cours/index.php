{{ include('layouts/header.php', {title: 'Cours', page: 'cours'}) }}

<div class="entete-page">
    <div>
        <h1 class="titre-page"><span>Cours</span></h1>
        <p class="sous-titre">{{ listeCours|length }} cours offerts sur la plateforme.</p>
    </div>
    {% if admin %}
        <a href="{{ base }}/cours/create" class="btn btn-primaire">Ajouter un cours</a>
    {% endif %}
</div>

{# Filtre par catégorie (clé étrangère categorie_idcategorie) #}
<div class="filtres">
    <a href="{{ base }}/cours" class="filtre {% if categorieChoisie is null %}actif{% endif %}">Toutes</a>
    {% for cat in categories %}
        <a href="{{ base }}/cours?categorie={{ cat.idcategorie }}" class="filtre {% if categorieChoisie == cat.idcategorie %}actif{% endif %}">{{ cat.nom }}</a>
    {% endfor %}
</div>

<div class="tableau-conteneur">
    {% if listeCours is empty %}
        <div class="vide">
            <p>Aucun cours dans cette catégorie pour l'instant.</p>
            {% if admin %}
                <a href="{{ base }}/cours/create" class="btn btn-primaire">Ajouter un cours</a>
            {% endif %}
        </div>
    {% else %}
    <table class="tableau">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Catégorie</th>
                <th>Formateur</th>
                <th>Niveau</th>
                <th class="nombre">Durée</th>
                <th class="nombre">Prix</th>
                <th class="nombre">Inscrits</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {% for c in listeCours %}
            <tr>
                <td><a class="titre-ligne" href="{{ base }}/cours/show?id={{ c.idcours }}">{{ c.titre }}</a></td>
                <td>{{ c.categorie }}</td>
                <td>{{ c.prenom }} {{ c.formateur_nom }}</td>
                <td>{{ include('cours/niveau.php', {niveau: c.niveau}) }}</td>
                <td class="nombre">{{ c.duree_heures }} h</td>
                <td class="nombre">{% if c.prix == 0 %}Gratuit{% else %}{{ c.prix|number_format(2, ',', ' ') }} ${% endif %}</td>
                <td class="nombre">{{ c.inscrits }}</td>
                <td>
                        <div class="actions">
                        <a href="{{ base }}/cours/show?id={{ c.idcours }}" class="btn btn-secondaire btn-petit">Voir</a>
                        {% if admin %}
                            <a href="{{ base }}/cours/edit?id={{ c.idcours }}" class="btn btn-secondaire btn-petit">Modifier</a>
                        {% endif %}
                    </div>
                </td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
    {% endif %}
</div>

{{ include('layouts/footer.php') }}