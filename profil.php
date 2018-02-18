<?php

require_once('inc/init.php');

if ( !estConnecte() ){
    header('location:connexion.php');
    exit();
}

require_once('inc/haut-site.php');

$contenu.= '<h2>Bonjour '.ucfirst($_SESSION['membre']['pseudo']).'</h2>'; // ucfirst met la première lettre en maj

if ( $_SESSION['membre']['statut'] == 1 ){
    $contenu.='<p>Vous êtes connecté en tant qu\'Administrateur</p>';
}

$contenu.="<div><h3>Vos informations de profil</h3><p>Prénom, Nom : ".$_SESSION['membre']['prenom']." ".$_SESSION['membre']['nom']."</p></div>";
echo $contenu;

require_once('inc/bas-site.php');