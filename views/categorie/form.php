{# Champs du formulaire d'une catégorie : partagés par create.php et edit.php #}
<div class="grille-champs">
    <div class="champ champ-large">
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" value="{{ categorie.nom }}">
        {% if errors.nom is defined %}<span class="erreur-champ">{{ errors.nom }}</span>{% endif %}
    </div>
    <div class="champ champ-large">
        <label for="description">Description</label>
        <textarea id="description" name="description">{{ categorie.description }}</textarea>
        <span class="aide">Facultatif, 255 caractères au maximum.</span>
        {% if errors.description is defined %}<span class="erreur-champ">{{ errors.description }}</span>{% endif %}
    </div>
</div>