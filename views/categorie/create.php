{{ include('layouts/header.php', {title: 'Ajouter une catégorie', page: 'categorie'}) }}

<div class="entete-page">
    <h1 class="titre-page"><span>Ajouter une catégorie</span></h1>
</div>

<form action="{{ base }}/categorie/create" method="post" class="formulaire">
    {{ include('categorie/form.php') }}
    <div class="formulaire-actions">
        <input type="submit" class="btn btn-primaire" value="Ajouter la catégorie">
        <a href="{{ base }}/categories" class="btn btn-secondaire">Annuler</a>
    </div>
</form>

{{ include('layouts/footer.php') }}