{{ include('layouts/header.php', {title: 'Modifier un formateur', page: 'formateur'}) }}

<div class="entete-page">
    <h1 class="titre-page"><span>Modifier le formateur</span></h1>
</div>

<form method="post" class="formulaire">
    {{ include('formateur/form.php') }}
    <div class="formulaire-actions">
        <input type="submit" class="btn btn-primaire" value="Enregistrer les modifications">
        <a href="{{ base }}/formateurs" class="btn btn-secondaire">Annuler</a>
    </div>
</form>

{{ include('layouts/footer.php') }}