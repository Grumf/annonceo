<?php
require_once("../inc/init.php");


$annonce = $pdo->query("SELECT * FROM annonces");

$photos = $pdo->query("SELECT * FROM photo p, annonces a WHERE a.id_photo = p.id_photo");


// Suppression
if (isset($_GET['action']) && $_GET['action'] == 'suppression' && !empty($_GET['id_annonce']) ){
        $del = $pdo->prepare("DELETE FROM annonces WHERE id_annonce = :id_annonce");
        $del->execute( array('id_annonce' => $_GET['id_annonce']));
        $contenu.="<div class='alert alert-success'>Annonce supprimée</div>";
}

$nbcolonnes = $annonce->columnCount();

$contenu.="<h3>Annonces</h3>";

$contenu.="<table class='table-striped tabannonces'>
                <tr>";
        // Les en-têtes
        for( $i=0; $i<$nbcolonnes; $i++){
            $colonne = $annonce->getColumnMeta($i);
            if ( ($colonne['name'] != 'photo') && ($colonne['name'] != 'description_longue'))
            {
                $contenu.='<th class="text-center">'.ucfirst($colonne['name']).'</th>';
            }
        }
            $contenu.='<th class="text-center">Photo</th><th class="text-center">Description longue</th><th colspan="2">Actions</th>';

$contenu.="</tr>";
        // Les données
        while ( $ligne = $annonce->fetch(PDO::FETCH_ASSOC) ){
            $contenu.="<tr>";
            
            foreach( $ligne as $indice => $information ){
                if(( $indice != 'photo') && ( $indice != 'description_longue') ){
                    $contenu.="<td class='text-center'>".$information."</td>";
                }
            }


            $contenu.="<td><img class='img-tab-princip' src=".$ligne['photo'].">";
            $contenu.="<td class='text-center'>".substr($ligne['description_longue'],0,80)."</td>";
 

            $contenu.="</td><td><a href='?action=suppression&id_annonce=".$ligne['id_annonce']."'onclick='return(confirm('Êtes-vous certain de vouloir supprimer cette annonce :".$ligne['titre']." ?'))'>supprimer</a></td>";

        $contenu.="</tr>";
    }
    $contenu.="</table>";


require_once("../inc/haut-site.php");


echo $contenu;



require_once("../inc/bas-site.php");
?>