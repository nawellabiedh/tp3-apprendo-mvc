{{ include('layouts/header.php', {title: 'Catégories', page: 'categorie'}) }}

<div class="entete-page">
    <div>
        <h1 class="titre-page"><span>Catégories</span></h1>
        <p class="sous-titre">Les domaines qui regroupent les cours.</p>
    </div>
    <a href="{{ base }}/categorie/create" class="btn btn-primaire">Ajouter une catégorie</a>
</div>

<div class="tableau-conteneur">
    <table class="tableau">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th class="nombre">Cours</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {% for cat in categories %}
            <tr>
                <td><a class="titre-ligne" href="{{ base }}/cours?categorie={{ cat.idcategorie }}">{{ cat.nom }}</a></td>
                <td class="texte-gris">{{ cat.description }}</td>
                <td class="nombre">{{ cat.nb_cours }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ base }}/categorie/edit?id={{ cat.idcategorie }}" class="btn btn-secondaire btn-petit">Modifier</a>
                        <form action="{{ base }}/categorie/delete" method="post" onsubmit="return confirm('Supprimer cette catégorie ?');">
                            <input type="hidden" name="idcategorie" value="{{ cat.idcategorie }}">
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