{{ include('layouts/header.php', {title: 'Modifier un cours', page: 'cours'}) }}

<div class="entete-page">
    <div>
        <h1 class="titre-page"><span>Modifier le cours</span></h1>
    </div>
</div>

{# Sans action : le formulaire est envoyé à la même adresse (cours/edit?id=...) #}
<form method="post" enctype="multipart/form-data" class="formulaire">
    {{ include('cours/form.php') }}
    <div class="formulaire-actions">
        <input type="submit" class="btn btn-primaire" value="Enregistrer les modifications">
        <a href="{{ base }}/cours/show?id={{ cours.idcours }}" class="btn btn-secondaire">Annuler</a>
    </div>
</form>

{{ include('layouts/footer.php') }}