<?php

require_once('../inc/init.php');

if ( !estConnecteEtAdmin() ){
    header("location:../connexion.php");
    exit();
}

// Suppression
if (isset($_GET['action']) && $_GET['action'] == 'suppression' && !empty($_GET['id_categorie']) ){
        $resul = $pdo->prepare("DELETE FROM categorie WHERE id_categorie = :id_categorie");
        $resul->execute(array('id_categorie' => $_GET['id_categorie']));
        $contenu.="<div class='alert alert-success'>Cette catégorie à été supprimée</div>";
}

$categorie = $pdo->prepare("SELECT * FROM categorie");
$categorie->execute();

$nbcolonnes = $categorie->columnCount();

$contenu.="<h3>Les Catégories</h3>";

$contenu.="<table class='table-striped'>
                <tr>";
        // Les en-têtes
        for( $i=0; $i<$nbcolonnes; $i++){
            $colonne = $categorie->getColumnMeta($i);
                $contenu.='<th class="texte-center">'.ucfirst($colonne['name']).'</th>';
        }
            $contenu.='<th colspan="2">Actions</th>';

$contenu.="</tr>";
        // Les données
        while ( $ligne = $categorie->fetch(PDO::FETCH_ASSOC) ){
            $contenu.="<tr>";
            foreach( $ligne as $indice => $information ){
                if($indice != 'mdp'){
                    $contenu.="<td class='text-center'>".$information."</td>";
                }
            }
            
            $contenu.="<td><a href='?action=suppression&id_categorie=".$ligne['id_categorie']."'onclick='return(confirm('Êtes-vous certain de vouloir supprimer ce connard :".$ligne['titre']." ?'))'>supprimer</a></td>";
            
        }
        $contenu.="</tr>";

    $contenu.="</table>";


if ($_POST){
$resul = $pdo->prepare("REPLACE INTO categorie VALUES (NULL,:titre,:mots_cles)");
$resul->execute(array( 'titre' => $_POST['titre'],
                       'mots_cles' => $_POST['mots_cles']
));
}

require_once('../inc/haut-site.php');
echo $contenu;

?>
<pre>
<h2>Insérer une catégorie</h2>
<form action="#" method="post">
    <label for="titre">Nom de la catégorie</label>
    <input type="text" id="titre" name="titre" required>

    <label for="mots_cles">Mots-Clés</label>
    <textarea name="mots_cles" id="mots_cles" cols="30" rows="10" required></textarea>

    <input type="submit" value="Valider">
</form>
</pre>


<?php
require_once('../inc/bas-site.php');
?>