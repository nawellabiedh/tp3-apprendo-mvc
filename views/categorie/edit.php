{{ include('layouts/header.php', {title: 'Modifier une catégorie', page: 'categorie'}) }}

<div class="entete-page">
    <h1 class="titre-page"><span>Modifier la catégorie</span></h1>
</div>

<form method="post" class="formulaire">
    {{ include('categorie/form.php') }}
    <div class="formulaire-actions">
        <input type="submit" class="btn btn-primaire" value="Enregistrer les modifications">
        <a href="{{ base }}/categories" class="btn btn-secondaire">Annuler</a>
    </div>
</form>

{{ include('layouts/footer.php') }}