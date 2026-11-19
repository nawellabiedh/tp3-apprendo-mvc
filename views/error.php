{{ include('layouts/header.php', {title: 'Erreur', page: ''}) }}

<div class="entete-page">
    <div>
        <h1 class="titre-page"><span>Oups…</span></h1>
        <p class="sous-titre">{{ msg }}</p>
    </div>
</div>
<a href="{{ base }}/" class="btn btn-primaire">Retour à l'accueil</a>

{{ include('layouts/footer.php') }}