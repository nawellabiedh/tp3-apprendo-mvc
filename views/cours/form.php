{# Champs du formulaire d'un cours : partagés par create.php et edit.php #}
<div class="grille-champs">
    <div class="champ champ-large">
        <label for="titre">Titre</label>
        <input type="text" id="titre" name="titre" value="{{ cours.titre }}">
        {% if errors.titre is defined %}<span class="erreur-champ">{{ errors.titre }}</span>{% endif %}
    </div>
    <div class="champ champ-large">
        <label for="description">Description</label>
        <textarea id="description" name="description">{{ cours.description }}</textarea>
        {% if errors.description is defined %}<span class="erreur-champ">{{ errors.description }}</span>{% endif %}
    </div>
    <div class="champ">
        <label for="categorie">Catégorie</label>
        <select id="categorie" name="categorie_idcategorie">
            <option value="">Choisir une catégorie</option>
            {% for cat in categories %}
                <option value="{{ cat.idcategorie }}" {% if cat.idcategorie == cours.categorie_idcategorie %}selected{% endif %}>{{ cat.nom }}</option>
            {% endfor %}
        </select>
        {% if errors.categorie_idcategorie is defined %}<span class="erreur-champ">{{ errors.categorie_idcategorie }}</span>{% endif %}
    </div>
    <div class="champ">
        <label for="formateur">Formateur</label>
        <select id="formateur" name="formateur_idformateur">
            <option value="">Choisir un formateur</option>
            {% for f in formateurs %}
                <option value="{{ f.idformateur }}" {% if f.idformateur == cours.formateur_idformateur %}selected{% endif %}>{{ f.prenom }} {{ f.nom }}</option>
            {% endfor %}
        </select>
        {% if errors.formateur_idformateur is defined %}<span class="erreur-champ">{{ errors.formateur_idformateur }}</span>{% endif %}
    </div>
    <div class="champ">
        <label for="niveau">Niveau</label>
        <select id="niveau" name="niveau">
            {% for n in niveaux %}
                <option value="{{ n }}" {% if n == cours.niveau %}selected{% endif %}>{{ n }}</option>
            {% endfor %}
        </select>
        {% if errors.niveau is defined %}<span class="erreur-champ">{{ errors.niveau }}</span>{% endif %}
    </div>
    <div class="champ">
        <label for="duree">Durée (heures)</label>
        <input type="number" id="duree" name="duree_heures" value="{{ cours.duree_heures }}">
        {% if errors.duree_heures is defined %}<span class="erreur-champ">{{ errors.duree_heures }}</span>{% endif %}
    </div>
    <div class="champ">
        <label for="prix">Prix ($)</label>
        <input type="number" id="prix" name="prix" step="0.01" value="{{ cours.prix is defined ? cours.prix : 0 }}">
        <span class="aide">Mettez 0 pour un cours gratuit.</span>
        {% if errors.prix is defined %}<span class="erreur-champ">{{ errors.prix }}</span>{% endif %}
    </div>
     <div class="champ champ-large">
        <label for="image">Image du cours</label>
        {% if cours.image %}
            <img src="{{ asset }}/uploads/{{ cours.image }}" alt="Image actuelle" class="cours-image-apercu">
        {% endif %}
        <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/webp">
        <span class="aide">Facultatif. JPG, PNG ou WEBP, 2 Mo au maximum.{% if cours.image %} Choisissez un fichier seulement pour remplacer l'image actuelle.{% endif %}</span>
        {% if errors.image is defined %}<span class="erreur-champ">{{ errors.image }}</span>{% endif %}
    </div>
</div>