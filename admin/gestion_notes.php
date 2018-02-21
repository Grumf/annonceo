<?php

require_once('../inc/init.php');

if ( !estConnecteEtAdmin() ){
    header("location:../connexion.php");
    exit();
}

// Suppression
if (isset($_GET['action']) && $_GET['action'] == 'suppression' && !empty($_GET['id_note']) ){
        $resul = $pdo->prepare("DELETE FROM note WHERE id_note = :id_note");
        $resul->execute(array('id_note' => $_GET['id_note']));
        $contenu.="<div class='alert alert-success'>Cet avis à été supprimée</div>";
}


$note = $pdo->prepare("SELECT n.id_note, n.note, n.avis, m.pseudo FROM note n, membre m WHERE n.id_membre1 = m.id_membre");
$note->execute();


$nbcolonnes = $note->columnCount();

$contenu.="<h3>Les notes et avis</h3>";

$contenu.="<table class='table-striped montableau'>
                <tr>";
        // Les en-têtes
        for( $i=0; $i<$nbcolonnes; $i++){
            $colonne = $note->getColumnMeta($i);
                $contenu.='<th class="texte-center">'.ucfirst($colonne['name']).'</th>';
        }
            $contenu.='<th colspan="2">Actions</th>';

$contenu.="</tr>";
        // Les données
        while ( $ligne = $note->fetch(PDO::FETCH_ASSOC) ){
            $contenu.="<tr>";
            foreach( $ligne as $indice => $information ){
                if($indice != 'mdp'){
                    $contenu.="<td class='text-center'>".$information."</td>";
                }
            }
            $contenu.="<td><a href='?action=suppression&id_note=".$ligne['id_note']."'onclick='return(confirm('Êtes-vous certain de vouloir supprimer cet avis ?'))'>supprimer</a></td>";
            
        }
        $contenu.="</tr>";

    $contenu.="</table>";


require_once('../inc/haut-site.php');
echo $contenu;

require_once('../inc/bas-site.php');
?>