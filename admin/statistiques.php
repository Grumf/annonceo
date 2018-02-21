<?php

require_once('../inc/init.php');

if ( !estConnecteEtAdmin() ){
    header("location:../connexion.php");
    exit();
}

$notes = $pdo->prepare("SELECT m.pseudo, COUNT(avis), ROUND(AVG(note)) FROM note n, membre m WHERE n.id_membre2 = m.id_membre ORDER BY AVG(note) ASC LIMIT 0,5");
$notes->execute();

$nbcolonnes = $notes->columnCount();

$contenu.= '<h4>Moyenne des membres</h4>';

$contenu.="<table class='table-striped montableau'>";

        // Les données
        while ( $ligne = $notes->fetch(PDO::FETCH_ASSOC) ){
            $contenu.="<tr>";
            foreach( $ligne as $indice => $information ){
            $contenu.="<td class='text-center'>".$information."</td>";
            
        }
        $contenu.="</tr>";
    }
    $contenu.="</table>";


$actif = $pdo->prepare("SELECT m.pseudo, COUNT(a.id_annonce) FROM annonces a, membre m, note n WHERE n.id_membre2 = m.id_membre LIMIT 0,5");
$actif->execute();

$nbcolonnes = $actif->columnCount();

$contenu.= '<h4>Membres les plus actifs</h4>';

$contenu.="<table class='table-striped montableau'>";

        // Les données
        while ( $ligne = $actif->fetch(PDO::FETCH_ASSOC) ){
            $contenu.="<tr>";
            foreach( $ligne as $indice => $information ){
            $contenu.="<td class='text-center'>".$information."</td>";
            
        }
        $contenu.="</tr>";
    }
    $contenu.="</table>";


$date = $pdo->prepare("SELECT titre, date_enregistrement FROM annonces ORDER BY date_enregistrement DESC LIMIT 0,5");
$date->execute();

$nbcolonnes = $actif->columnCount();

$contenu.= '<h4>Annonces les plus anciennes</h4>';

$contenu.="<table class='table-striped montableau'>";

        // Les données
        while ( $ligne = $date->fetch(PDO::FETCH_ASSOC) ){
            $contenu.="<tr>";
            foreach( $ligne as $indice => $information ){
            $contenu.="<td class='text-center'>".$information."</td>";
            
        }
        $contenu.="</tr>";
    }
    $contenu.="</table>";



$cat = $pdo->prepare("SELECT DISTINCT c.titre, COUNT(a.titre) FROM annonces a, categorie c WHERE c.id_categorie = a.id_categorie ORDER BY COUNT(a.id_annonce) DESC LIMIT 0,5");
$cat->execute();

$nbcolonnes = $cat->columnCount();

$contenu.= '<h4>Categories les plus populaires</h4>';

$contenu.="<table class='table-striped montableau'>";

        // Les données
        while ( $ligne = $cat->fetch(PDO::FETCH_ASSOC) ){
            $contenu.="<tr>";
            foreach( $ligne as $indice => $information ){
            $contenu.="<td class='text-center'>".$information."</td>";
            
        }
        $contenu.="</tr>";
    }
    $contenu.="</table>";



require_once('../inc/haut-site.php');
echo $contenu;

require_once('../inc/bas-site.php');
?>