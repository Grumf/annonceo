<?php
require_once("inc/init.php");

if ( $_POST ){

    $photo_bdd='';

    if ( !empty($_FILES['photo1']['name'])){
        $nom_photo = $_POST['id_categorie'].'-'.$_FILES['photo1']['name'];
        $photo_bdd = '/php/annonceo/inc/photo/'.$nom_photo;
        $photo_dossier= $_SERVER['DOCUMENT_ROOT'].$photo_bdd;

        copy($_FILES['photo1']['tmp_name'], $photo_dossier);
    }


    $result = $pdo->prepare("REPLACE INTO annonces VALUES (NULL,:titre,:description_courte,:description_longue,:prix,:photo,:ville,:adresse,:cp,:id_membre,:id_photo,:id_categorie, NOW())");
    $result->execute(array( 'titre'                 => $_POST['titre'],   
                            'description_courte'    => $_POST['description_courte'],       
                            'description_longue'    => $_POST['description_longue'],       
                            'prix'                  => $_POST['prix'],       
                            'photo'                 => $photo_bdd,
                            'ville'                 => $_POST['ville'],       
                            'adresse'               => $_POST['adresse'],       
                            'cp'                    => $_POST['cp'],       
                            'id_membre'             => $_SESSION['id_membre'],       
                            'id_photo'              => $_POST['id_photo'],       
                            'id_categorie'          => $_POST['id_categorie']
    ));


}

require_once("inc/haut-site.php");
echo $contenu;

// $result = $pdo->query("SELECT * FROM annonce");
// $result->

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
            <div>
            <label for="id_categorie" >Catégorie</label>
                <select class="form-control" name="id_categorie" id="id_categorie" required>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                </select>
            </div>
        </div>

        <?php
$result1 = $pdo->prepare("REPLACE INTO photo VALUES (:id_photo,:photo1,:photo2,:photo3,:photo4,:photo5)");
$result1->execute(array( 'id_photo' => ':id_photo',
                        'photo1' => $_POST['photo1'],
                        'photo2' => $_POST['photo2'],
                        'photo3' => $_POST['photo3'],
                        'photo4' => $_POST['photo4'],
                        'photo5' => $_POST['photo5']
                    ));

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