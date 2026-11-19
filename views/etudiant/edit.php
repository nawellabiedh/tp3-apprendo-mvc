{{ include('layouts/header.php', {title: 'Modifier un étudiant', page: 'etudiant'}) }}

<div class="entete-page">
    <h1 class="titre-page"><span>Modifier l'étudiant</span></h1>
</div>

<form method="post" class="formulaire">
    {{ include('etudiant/form.php') }}
    <div class="formulaire-actions">
        <input type="submit" class="btn btn-primaire" value="Enregistrer les modifications">
        <a href="{{ base }}/etudiant/show?id={{ etudiant.idetudiant }}" class="btn btn-secondaire">Annuler</a>
    </div>
</form>

{{ include('layouts/footer.php') }}