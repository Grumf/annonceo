<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/php/annonceo/inc/css/bootstrap.min.css">
    <link rel="stylesheet" href="/php/annonceo/inc/css/style.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <title>Annoncéo</title>
</head>
<body>
<header>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapse" data-toggle="collapse" data-target="#monmenu">
                        <span class="sr-only">Naviguer</span>
                        <span class="glyphicon glyphicon-menu-hamburger"></span> 
                    </button>
                    <a href="/php/annonceo/index.php" class="navbar-brand">Anoncéo</a>
                </div>
                <div class="collapse navbar-collapse" id="monmenu">
                    <ul class="nav navbar-nav">
                    <?php

                        if(estConnecteEtAdmin() ){
                            
                            echo '<li><a href="/php/annonceo/admin/gestion_annonce.php">Annonces</a></li>';
                            echo '<li><a href="/php/annonceo/admin/gestion_categorie.php">Catégories</a></li>';
                            echo '<li><a href="/php/annonceo/admin/gestion_commentaire.php">Commentaires</a></li>';
                            echo '<li><a href="/php/annonceo/admin/gestion_membre.php">Membres</a></li>';
                            echo '<li><a href="/php/annonceo/admin/gestion_notes.php">Notes</a></li>';
                            echo '<li><a href="/php/annonceo/admin/statistiques.php">Statistique</a></li>';
                        }
                        if ( estConnecte() ){

                            echo '<li><a href="/php/annonceo/profil.php">Espace membre</a></li>';
                            echo '<li><a href="/php/annonceo/depot_annonce.php">Déposer une annonce</a></li>';
                            echo '<li><a href="/php/annonceo/connexion.php?action=deconnexion">Déconnexion</a></li>';
                        }
                        else {

                            echo '<li><a href="/php/annonceo/inscription.php">Inscription</a></li>';
                            echo '<li><a href="/php/annonceo/connexion.php">Connexion</a></li>';

                        }


        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container main">