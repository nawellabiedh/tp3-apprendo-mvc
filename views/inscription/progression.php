{# Barre de progression (0 à 100 %) #}
<div class="progression">
    <div class="progression-barre">
        <div class="progression-remplie {% if valeur >= 100 %}terminee{% endif %}" style="width: {{ valeur }}%"></div>
    </div>
    <span class="progression-valeur">{{ valeur }} %</span>
</div>