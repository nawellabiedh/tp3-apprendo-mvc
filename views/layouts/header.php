<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ title }} | Apprendo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:wght@400;700&family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset }}/css/style.css">
</head>
<body>
<div class="app">
    <aside class="barre-laterale">
        <a class="logo" href="{{ base }}/">
            <span class="logo-marque">A</span>
            Apprendo
        </a>
         <nav class="menu">
            {# Liens pour tout le monde #}
            <a href="{{ base }}/" class="menu-lien {% if page == 'accueil' %}actif{% endif %}">Accueil</a>
            <a href="{{ base }}/cours" class="menu-lien {% if page == 'cours' %}actif{% endif %}">Cours</a>

            {# Liens réservés à l'administrateur #}
            {% if admin %}
                <a href="{{ base }}/categories" class="menu-lien {% if page == 'categorie' %}actif{% endif %}">Catégories</a>
                <a href="{{ base }}/formateurs" class="menu-lien {% if page == 'formateur' %}actif{% endif %}">Formateurs</a>
                <a href="{{ base }}/etudiants" class="menu-lien {% if page == 'etudiant' %}actif{% endif %}">Étudiants</a>
                <a href="{{ base }}/inscriptions" class="menu-lien {% if page == 'inscription' %}actif{% endif %}">Inscriptions</a>
                <a href="{{ base }}/users" class="menu-lien {% if page == 'user' %}actif{% endif %}">Utilisateurs</a>
                <a href="{{ base }}/journal" class="menu-lien {% if page == 'journal' %}actif{% endif %}">Journal</a>
            {% endif %}
            
           {# Lien réservé au client (connecté, mais pas admin) #}
            {% if not guest and not admin %}
                <a href="{{ base }}/mon-espace" class="menu-lien {% if page == 'espace' %}actif{% endif %}">Mon espace</a>
            {% endif %}

            {# Connexion ou déconnexion #}
            {% if guest %}
                <a href="{{ base }}/login" class="menu-lien {% if page == 'login' %}actif{% endif %}">Connexion</a>
            {% else %}
                <span class="menu-lien">Bonjour, {{ session.user_name }}</span>
                <a href="{{ base }}/logout" class="menu-lien">Déconnexion</a>
            {% endif %}
        </nav>
    </aside>
    <main class="contenu">
        {# Message de confirmation (ex. : après un ajout) #}
        {% if message is defined %}
            <div class="alerte alerte-succes">{{ message }}</div>
        {% endif %}
        {# Message d'erreur (ex. : suppression refusée) #}
        {% if erreur is defined and erreur %}
            <div class="alerte alerte-erreur">{{ erreur }}</div>
        {% endif %}
        {# Résumé des erreurs de validation d'un formulaire #}
        {% if errors is defined and errors and page != 'login' %}
            <div class="alerte alerte-erreur">Rien n'a été enregistré. Corrigez les champs indiqués en rouge.</div>
        {% endif %}