{{ include('layouts/header.php', {title: 'Ajouter un cours', page: 'cours'}) }}

<div class="entete-page">
    <div>
        <h1 class="titre-page"><span>Ajouter un cours</span></h1>
        <p class="sous-titre">Choisissez la catégorie et le formateur qui donnera ce cours.</p>
    </div>
</div>

<form action="{{ base }}/cours/create" method="post" enctype="multipart/form-data" class="formulaire">
    {{ include('cours/form.php') }}
    <div class="formulaire-actions">
        <input type="submit" class="btn btn-primaire" value="Ajouter le cours">
        <a href="{{ base }}/cours" class="btn btn-secondaire">Annuler</a>
    </div>
</form>

{{ include('layouts/footer.php') }}