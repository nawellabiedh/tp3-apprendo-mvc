{{ include('layouts/header.php', {title: 'Accueil', page: 'accueil'}) }}

<section class="accueil">
    <h1 class="titre-page accueil-titre"><span>Apprendre à son rythme, avec les bons formateurs.</span></h1>
    <p class="accueil-texte">
        Apprendo est une plateforme de cours en ligne. Elle permet de gérer les cours offerts,
        les formateurs qui les donnent, les étudiants et leurs inscriptions, avec le suivi de la progression de chacun.
    </p>
    <div class="actions">
        <a href="{{ base }}/cours" class="btn btn-primaire">Voir les cours</a>
        {% if admin %}
            <a href="{{ base }}/inscription/create" class="btn btn-secondaire">Inscrire un étudiant</a>
        {% endif %}
    </div>
</section>

<section class="section">
    <h2 class="section-titre">Ce que vous pouvez faire</h2>
    <div class="rubriques">
        <a class="rubrique" href="{{ base }}/cours">
            <strong>Cours</strong>
            <span>Ajouter un cours, choisir sa catégorie et son formateur, voir qui y est inscrit.</span>
        </a>
        {% if admin %}
        <a class="rubrique" href="{{ base }}/categories">
            <strong>Catégories</strong>
            <span>Regrouper les cours par domaine : programmation, design, langues…</span>
        </a>
        <a class="rubrique" href="{{ base }}/formateurs">
            <strong>Formateurs</strong>
            <span>Gérer les personnes qui donnent les cours et leur spécialité.</span>
        </a>
        <a class="rubrique" href="{{ base }}/etudiants">
            <strong>Étudiants</strong>
            <span>Consulter la fiche de chaque étudiant et les cours qu'il suit.</span>
        </a>
        <a class="rubrique" href="{{ base }}/inscriptions">
            <strong>Inscriptions</strong>
            <span>Inscrire un étudiant à un cours et mettre à jour sa progression.</span>
        </a>
        {% endif %}
    </div>
</section>

{{ include('layouts/footer.php') }}