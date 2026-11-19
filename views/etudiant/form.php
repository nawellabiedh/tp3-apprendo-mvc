{# Champs du formulaire d'un étudiant : partagés par create.php et edit.php #}
<div class="grille-champs">
    <div class="champ">
        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" value="{{ etudiant.prenom }}">
        {% if errors.prenom is defined %}<span class="erreur-champ">{{ errors.prenom }}</span>{% endif %}
    </div>
    <div class="champ">
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" value="{{ etudiant.nom }}">
        {% if errors.nom is defined %}<span class="erreur-champ">{{ errors.nom }}</span>{% endif %}
    </div>
    <div class="champ champ-large">
        <label for="email">Courriel</label>
        <input type="text" id="email" name="email" value="{{ etudiant.email }}">
        {% if errors.email is defined %}<span class="erreur-champ">{{ errors.email }}</span>{% endif %}
    </div>
</div>