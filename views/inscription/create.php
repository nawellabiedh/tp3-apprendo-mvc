{{ include('layouts/header.php', {title: 'Inscrire un étudiant', page: 'inscription'}) }}

<div class="entete-page">
    <div>
        <h1 class="titre-page"><span>Inscrire un étudiant</span></h1>
        <p class="sous-titre">Un étudiant ne peut être inscrit qu'une seule fois au même cours.</p>
    </div>
</div>

<form action="{{ base }}/inscription/create" method="post" class="formulaire">
    <div class="grille-champs">
        <div class="champ">
            <label for="etudiant">Étudiant</label>
            <select id="etudiant" name="etudiant_idetudiant">
                <option value="">Choisir un étudiant</option>
                {% for e in etudiants %}
                    <option value="{{ e.idetudiant }}" {% if e.idetudiant == inscription.etudiant_idetudiant %}selected{% endif %}>{{ e.prenom }} {{ e.nom }}</option>
                {% endfor %}
            </select>
            {% if errors.etudiant_idetudiant is defined %}<span class="erreur-champ">{{ errors.etudiant_idetudiant }}</span>{% endif %}
        </div>
        <div class="champ">
            <label for="cours">Cours</label>
            <select id="cours" name="cours_idcours">
                <option value="">Choisir un cours</option>
                {% for c in listeCours %}
                    <option value="{{ c.idcours }}" {% if c.idcours == inscription.cours_idcours %}selected{% endif %}>{{ c.titre }}</option>
                {% endfor %}
            </select>
            {% if errors.cours_idcours is defined %}<span class="erreur-champ">{{ errors.cours_idcours }}</span>{% endif %}
        </div>
        <div class="champ">
            <label for="date">Date d'inscription</label>
            <input type="date" id="date" name="date_inscription" value="{{ inscription.date_inscription }}">
            {% if errors.date_inscription is defined %}<span class="erreur-champ">{{ errors.date_inscription }}</span>{% endif %}
        </div>
        <div class="champ">
            <label for="progression">Progression (%)</label>
            <input type="number" id="progression" name="progression" value="{{ inscription.progression }}">
            <span class="aide">De 0 (pas commencé) à 100 (terminé).</span>
            {% if errors.progression is defined %}<span class="erreur-champ">{{ errors.progression }}</span>{% endif %}
        </div>
    </div>
    <div class="formulaire-actions">
        <input type="submit" class="btn btn-primaire" value="Inscrire">
        <a href="{{ base }}/inscriptions" class="btn btn-secondaire">Annuler</a>
    </div>
</form>

{{ include('layouts/footer.php') }}