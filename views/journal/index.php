{{ include('layouts/header.php', {title: 'Journal de bord', page: 'journal'}) }}

<div class="entete-page">
    <div>
        <h1 class="titre-page"><span>Journal de bord</span></h1>
        <p class="sous-titre">{{ visites|length }} visites enregistrées.</p>
    </div>
</div>

<div class="tableau-conteneur">
    {% if visites is empty %}
        <div class="vide"><p>Aucune visite enregistrée pour l'instant.</p></div>
    {% else %}
    <table class="tableau">
        <thead>
            <tr>
                <th>Date et heure</th>
                <th>Adresse IP</th>
                <th>Utilisateur</th>
                <th>Page visitée</th>
            </tr>
        </thead>
        <tbody>
            {% for v in visites %}
            <tr>
                <td class="texte-gris">{{ v.date_visite|date('d/m/Y H:i:s') }}</td>
                <td>{{ v.ip }}</td>
                <td>{{ v.utilisateur }}</td>
                <td>{{ v.page }}</td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
    {% endif %}
</div>

{{ include('layouts/footer.php') }}