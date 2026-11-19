{# Champs du formulaire d'un formateur : partagés par create.php et edit.php #}
<div class="grille-champs">
    <div class="champ">
        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" value="{{ formateur.prenom }}">
        {% if errors.prenom is defined %}<span class="erreur-champ">{{ errors.prenom }}</span>{% endif %}
    </div>
    <div class="champ">
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" value="{{ formateur.nom }}">
        {% if errors.nom is defined %}<span class="erreur-champ">{{ errors.nom }}</span>{% endif %}
    </div>
    <div class="champ">
        <label for="email">Courriel</label>
        <input type="text" id="email" name="email" value="{{ formateur.email }}">
        {% if errors.email is defined %}<span class="erreur-champ">{{ errors.email }}</span>{% endif %}
    </div>
    <div class="champ">
        <label for="specialite">Spécialité</label>
        <input type="text" id="specialite" name="specialite" value="{{ formateur.specialite }}">
        {% if errors.specialite is defined %}<span class="erreur-champ">{{ errors.specialite }}</span>{% endif %}
    </div>
    <div class="champ champ-large">
        <label for="biographie">Biographie</label>
        <textarea id="biographie" name="biographie">{{ formateur.biographie }}</textarea>
        <span class="aide">Facultatif.</span>
        {% if errors.biographie is defined %}<span class="erreur-champ">{{ errors.biographie }}</span>{% endif %}
    </div>
</div>