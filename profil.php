<?php

require_once('inc/init.php');

if ( !estConnecte() ){
    header('location:connexion.php');
    exit();
}

$membre_actif = $_SESSION['membre']['id_membre'];


//--------------------INFOS ANNONCES-------------------------
$infos = $pdo->query("SELECT * FROM annonces WHERE id_membre =".$membre_actif);
$infos->execute();


//--------------------INFOS NOTES-------------------------
$note = $pdo->query("SELECT AVG(note) FROM note WHERE id_membre1 =".$membre_actif);
$notes = $note->execute();

require_once('inc/haut-site.php');

$contenu_gauche.= '<h2>Bonjour '.ucfirst($_SESSION['membre']['pseudo']).'</h2>'; // ucfirst met la première lettre en maj

if ( $_SESSION['membre']['statut'] == 1 ){
    $contenu_gauche.='<p>Vous êtes connecté en tant qu\'Administrateur</p>';
}

$contenu_gauche.= '<h3>NOTE : '.$notes['note'].'/5</h3>';

$contenu_droite.="<div><h3><p>".$_SESSION['membre']['prenom']." ".$_SESSION['membre']['nom']."</p></h3></div>";

$contenu_droite.="<h3>Vos annonces</h3>";

$contenu_droite.="<table class='table-striped'>
                <tr>";
        // Les en-têtes
        for( $i=0; $i<($infos->columnCount()); $i++){
            $colonne = $infos->getColumnMeta($i);
            if ( ($colonne['name'] != 'photo') && ($colonne['name'] != 'description_longue') && ($colonne['name'] != 'cp') && ($colonne['name'] != 'adresse') && ($colonne['name'] != 'id_membre') && ($colonne['name'] != 'id_photo'))
            {
                $contenu_droite.='<th class="text-center">'.ucfirst($colonne['name']).'</th>';
            }
        }

$contenu_droite.="</tr>";
        // Les données
        while ( $ligne = $infos->fetch(PDO::FETCH_ASSOC) ){
            $contenu_droite.="<tr>";
            
            foreach( $ligne as $indice => $information ){
                if(( $indice != 'photo') && ( $indice != 'description_longue') && ($indice != 'cp') && ($indice != 'adresse') && ($indice != 'id_membre') && ($indice != 'id_photo') ){
                    $contenu_droite.="<td class='text-center'>".$information."</td>";
                }
            }

        $contenu_droite.="</tr>";
    }
    $contenu_droite.="</table>";
;

echo '<div class="row">
        <div class="col-md-4">';
echo $contenu_gauche;
echo    '</div>
    <div class="col-md-6">';
echo $contenu_droite;
echo    '</div>
    </div>';

require_once('inc/bas-site.php');