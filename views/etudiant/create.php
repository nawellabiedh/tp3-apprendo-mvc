{{ include('layouts/header.php', {title: 'Ajouter un étudiant', page: 'etudiant'}) }}

<div class="entete-page">
    <h1 class="titre-page"><span>Ajouter un étudiant</span></h1>
</div>

<form action="{{ base }}/etudiant/create" method="post" class="formulaire">
    {{ include('etudiant/form.php') }}
    <div class="formulaire-actions">
        <input type="submit" class="btn btn-primaire" value="Ajouter l'étudiant">
        <a href="{{ base }}/etudiants" class="btn btn-secondaire">Annuler</a>
    </div>
</form>

{{ include('layouts/footer.php') }}