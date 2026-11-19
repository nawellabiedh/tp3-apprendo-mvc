{{ include('layouts/header.php', {title: 'Ajouter un formateur', page: 'formateur'}) }}

<div class="entete-page">
    <h1 class="titre-page"><span>Ajouter un formateur</span></h1>
</div>

<form action="{{ base }}/formateur/create" method="post" class="formulaire">
    {{ include('formateur/form.php') }}
    <div class="formulaire-actions">
        <input type="submit" class="btn btn-primaire" value="Ajouter le formateur">
        <a href="{{ base }}/formateurs" class="btn btn-secondaire">Annuler</a>
    </div>
</form>

{{ include('layouts/footer.php') }}
