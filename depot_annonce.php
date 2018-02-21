<?php
require_once("inc/init.php");

if ( $_POST ){

    $photo_bdd1='';
    $photo_bdd2='';
    $photo_bdd3='';
    $photo_bdd4='';
    $photo_bdd5='';

    if ( !empty($_FILES['photo1']['name'])){
        $nom_photo = $_POST['id_categorie'].'-'.$_FILES['photo1']['name'];
        $photo_bdd1 = '/php/annonceo/inc/photo/'.$nom_photo;
        $photo_dossier= $_SERVER['DOCUMENT_ROOT'].$photo_bdd1;

        copy($_FILES['photo1']['tmp_name'], $photo_dossier);
    }

    if ( !empty($_FILES['photo2']['name'])){
        $nom_photo = $_POST['id_categorie'].'-'.$_FILES['photo2']['name'];
        $photo_bdd2 = '/php/annonceo/inc/photo/'.$nom_photo;
        $photo_dossier= $_SERVER['DOCUMENT_ROOT'].$photo_bdd2;

        copy($_FILES['photo2']['tmp_name'], $photo_dossier);
    }

    if ( !empty($_FILES['photo3']['name'])){
        $nom_photo = $_POST['id_categorie'].'-'.$_FILES['photo3']['name'];
        $photo_bdd3 = '/php/annonceo/inc/photo/'.$nom_photo;
        $photo_dossier= $_SERVER['DOCUMENT_ROOT'].$photo_bdd3;

        copy($_FILES['photo3']['tmp_name'], $photo_dossier);
    }

    if ( !empty($_FILES['photo4']['name'])){
        $nom_photo = $_POST['id_categorie'].'-'.$_FILES['photo4']['name'];
        $photo_bdd4 = '/php/annonceo/inc/photo/'.$nom_photo;
        $photo_dossier= $_SERVER['DOCUMENT_ROOT'].$photo_bdd4;

        copy($_FILES['photo4']['tmp_name'], $photo_dossier);
    }

    if ( !empty($_FILES['photo5']['name'])){
        $nom_photo = $_POST['id_categorie'].'-'.$_FILES['photo5']['name'];
        $photo_bdd5 = '/php/annonceo/inc/photo/'.$nom_photo;
        $photo_dossier= $_SERVER['DOCUMENT_ROOT'].$photo_bdd5;

        copy($_FILES['photo5']['tmp_name'], $photo_dossier);
    }

    $result1 = $pdo->prepare("INSERT INTO photo VALUES (NULL,:photo1,:photo2,:photo3,:photo4,:photo5)");
        $result1->execute(array(    'photo1' => $photo_bdd1,
                                    'photo2' => $photo_bdd2,
                                    'photo3' => $photo_bdd3,
                                    'photo4' => $photo_bdd4,
                                    'photo5' => $photo_bdd5
                        ));

    $assoc_photo = $pdo->lastInsertId();

    $result = $pdo->prepare("INSERT INTO annonces VALUES (NULL,:titre,:description_courte,:description_longue,:prix,:photo,:ville,:adresse,:cp,:id_membre,:photo_id,:id_categorie, NOW())");
    $result->execute(array( 'titre'                 => $_POST['titre'],
                            'description_courte'    => $_POST['description_courte'],       
                            'description_longue'    => $_POST['description_longue'],       
                            'prix'                  => $_POST['prix'],       
                            'photo'                 => $photo_bdd1,
                            'ville'                 => $_POST['ville'],       
                            'adresse'               => $_POST['adresse'],       
                            'cp'                    => $_POST['cp'],
                            'photo_id'              => $assoc_photo,
                            'id_membre'             => $_SESSION['membre']['id_membre'],          
                            'id_categorie'          => $_POST['id_categorie']
    ));



    


};

require_once("inc/haut-site.php");


?>


<form action="#" method="post" enctype="multipart/form-data">
    <div class="row">
    <div class="form-group col-md-6">
            <div>
                <label for="titre">Titre</label>
                <input type="text" class="form-control" name="titre" id="titre" placeholder="titre de l'annonce" required> 
            </div>
            <div>
                <label for="description_courte">Description courte</label>
                <input type="text" class="form-control" name="description_courte" id="description_courte" placeholder="Quelques mots sur l'objet...">
            </div>
            <div>
                <label for="description_longue">Description longue</label>
                <input type="text" class="form-control"  name="description_longue" id="description_longue" placeholder="Plus de détails...">
            </div>
            <div>
                <label for="prix">Prix</label>
                <input type="text" class="form-control" placeholder="euro(s)"  name="prix" id="prix" required>
            </div>

<?php  

$cat = $pdo->query("SELECT DISTINCT a.id_categorie, c.titre FROM annonces a, categorie c WHERE c.id_categorie = a.id_categorie");


            echo '<div>
            <label for="id_categorie" >Catégorie</label>
                <select class="form-control" name="id_categorie" id="id_categorie" required>';
                while ($categorie = $cat->fetch(PDO::FETCH_ASSOC)){
                    echo '<option value="'.$categorie['id_categorie'].'">'.$categorie['titre'].'</option>';
                        }
                echo '</select>
            </div>
        </div>';

?>

        <div class="form-group col-md-6">
            <div class="row">
                <div class="col-md-2 card">
                <input type="file" name="photo1" id="photo1">
                    
                </div>
                <div class="col-md-2 card">                   
                    <input type="file" name="photo2" id="photo2">
                </div>
                <div class="col-md-2 card">
                    <input type="file" name="photo3" id="photo3">
                </div>
                <div class="col-md-2 card">
                    <input type="file" name="photo4" id="photo4">
                </div>
                <div class="col-md-2 card">
                    <input type="file" name="photo5" id="photo5">
                </div>
            </div>

            <div>
                <label for="adresse">Adresse</label>
                <input type="text" class="form-control" name="adresse" id="adresse" placeholder="adresse complète">
            </div>
            <div>
                <label for="cp">Code postal</label>
                <input type="text" class="form-control" name="cp" id="cp" required>
            </div>
            <div>
                <label for="ville">Ville</label>
                <input type="text" class="form-control" name="ville" id="ville">
            </div>

        </div>
    </div>
    <div class="row">
        <input type="submit" class="btn btn-primary" id="enregistrement" value="Poster l'annonce">
    </div>
</form>

<?php
require_once("inc/bas-site.php");
?>