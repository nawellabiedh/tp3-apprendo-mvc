{{ include('layouts/header.php', {title: 'Modifier une inscription', page: 'inscription'}) }}

<div class="entete-page">
    <div>
        <h1 class="titre-page"><span>Modifier l'inscription</span></h1>
        <p class="sous-titre">{{ inscription.prenom }} {{ inscription.nom }} : {{ inscription.titre }}</p>
    </div>
</div>

<form method="post" class="formulaire">
    <div class="grille-champs">
        <div class="champ">
            <label for="date">Date d'inscription</label>
            <input type="date" id="date" name="date_inscription" value="{{ inscription.date_inscription }}">
            {% if errors.date_inscription is defined %}<span class="erreur-champ">{{ errors.date_inscription }}</span>{% endif %}
        </div>
        <div class="champ">
            <label for="progression">Progression (%)</label>
            <input type="number" id="progression" name="progression" value="{{ inscription.progression }}">
            {% if errors.progression is defined %}<span class="erreur-champ">{{ errors.progression }}</span>{% endif %}
        </div>
    </div>
    <div class="formulaire-actions">
        <input type="submit" class="btn btn-primaire" value="Enregistrer les modifications">
        <a href="{{ base }}/inscriptions" class="btn btn-secondaire">Annuler</a>
    </div>
</form>

{{ include('layouts/footer.php') }}