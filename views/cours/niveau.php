{# Étiquette de couleur selon le niveau du cours #}
{% if niveau == 'Débutant' %}
    <span class="badge badge-debutant">{{ niveau }}</span>
{% elseif niveau == 'Intermédiaire' %}
    <span class="badge badge-intermediaire">{{ niveau }}</span>
{% else %}
    <span class="badge badge-avance">{{ niveau }}</span>
{% endif %}