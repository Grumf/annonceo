<?php

require_once('../inc/init.php');

if ( !estConnecteEtAdmin() ){
    header("location:../connexion.php");
    exit();
}

// Suppression
if (isset($_GET['action']) && $_GET['action'] == 'suppression' && !empty($_GET['id_commentaire']) ){
        $resul = $pdo->prepare("DELETE FROM commentaire WHERE id_commentaire = :id_commentaire");
        $resul->execute(array('id_commentaire' => $_GET['id_commentaire']));
        $contenu.="<div class='alert alert-success'>Ce commentaire à été supprimée</div>";
}

$comment = $pdo->prepare("SELECT * FROM commentaire");
$comment->execute();

$nbcolonnes = $comment->columnCount();

$contenu.="<h3>Les Commentaires</h3>";

$contenu.="<table class='table-striped'>
                <tr>";
        // Les en-têtes
        for( $i=0; $i<$nbcolonnes; $i++){
            $colonne = $comment->getColumnMeta($i);
                $contenu.='<th class="texte-center">'.ucfirst($colonne['name']).'</th>';
        }
            $contenu.='<th colspan="2">Actions</th>';

$contenu.="</tr>";
        // Les données
        while ( $ligne = $comment->fetch(PDO::FETCH_ASSOC) ){
            $contenu.="<tr>";
            foreach( $ligne as $indice => $information ){
                if($indice != 'mdp'){
                    $contenu.="<td class='text-center'>".$information."</td>";
                }
            }
            
            $contenu.="<td><a href='?action=suppression&id_commentaire=".$ligne['id_commentaire']."'onclick='return(confirm('Êtes-vous certain de vouloir supprimer ce commentaire ?'))'>supprimer</a></td>";
            
        }
        $contenu.="</tr>";

    $contenu.="</table>";


require_once('../inc/haut-site.php');
echo $contenu;

require_once('../inc/bas-site.php');
?>