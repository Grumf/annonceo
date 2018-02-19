<?php

// COUCOU WESH

require_once('../inc/init.php');

if ( !estConnecteEtAdmin() ){
    header("location:../connexion.php");
    exit();
}

$membres = $pdo->query("SELECT * FROM membre");

$nbcolonnes = $membres->columnCount();

$contenu.="<h3>Les membres</h3>";
$contenu.="<p>Nombre de membres: ".$membres->rowCount()."</p>";
$contenu.="<table class='table-striped'>
                <tr>";
        // Les en-têtes
        for( $i=0; $i<$nbcolonnes; $i++){
            $colonne = $membres->getColumnMeta($i);
            if ( $colonne['name'] != 'mdp')
            {
                $contenu.='<th>'.ucfirst($colonne['name']).'</th>';
            }
        }
            $contenu.='<th colspan="2">Actions</th>';

$contenu.="</tr>";
        // Les données
        while ( $ligne = $membres->fetch(PDO::FETCH_ASSOC) ){
            $contenu.="<tr>";
            foreach( $ligne as $indice => $information ){
                if($indice != 'mdp'){
                    $contenu.="<td class='text-center'>".$information."</td>";
                }
            }
            if ($ligne['id_membre'] != $_SESSION['membre']['id_membre'])
        {
            $type_action = ($ligne['statut']==0 ? 'Promouvoir' : 'Dégrader');
            $contenu.="<td><a href='?action=changestatut&id_membre=".$ligne['id_membre']."'>".$type_action."</a>";
            $contenu.="<td><a href='?action=suppression&id_membre=".$ligne['id_membre']."'onclick='return(confirm('Êtes-vous certain de vouloir supprimer ce connard :".$ligne['nom']." ?'))'>supprimer</a></td>";
            
        }
        $contenu.="</tr>";
    }
    $contenu.="</table>";


require_once('../inc/haut-site.php');
echo $contenu;
require_once('../inc/bas-site.php');