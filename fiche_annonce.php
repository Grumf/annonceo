<?php

require_once('inc/init.php');
require_once('inc/haut-site.php');

$result = $pdo->prepare("SELECT id_membre FROM annonces WHERE id_annonce=:id_annonce");
$result->execute(array('id_annonce' => $_GET['id_annonce']));
$membre_annonce = $result->fetch(PDO::FETCH_ASSOC);


if (isset($_POST['commentaire'])){

    $result = $pdo->prepare("REPLACE INTO commentaire VALUES (NULL, :id_membre, :id_annonce, :commentaire, NOW())");
    $result->execute(array( 'id_membre' => $_SESSION['membre']['id_membre'],
                            'id_annonce' => $_GET['id_annonce'],
                            'commentaire' => $_POST['commentaire']
));
}

if (isset($_POST['note'])){

    $note = $pdo->prepare("REPLACE INTO note VALUES (NULL, :id_membre1, :id_membre2, :note, :avis, NOW())");
    $note->execute(array( 'id_membre1' => $_SESSION['membre']['id_membre'],
                            'id_membre2' => $membre_annonce['id_membre'],
                            'note' => $_POST['note'],
                            'avis' => $_POST['avis']
));
}

//1-contrôler l'existence de l'annonce
if (isset($_GET['id_annonce'])):
    $resul= $pdo->prepare ("SELECT *,a.titre AS titre_annonce FROM annonces a, membre m, photo p WHERE id_annonce = :id_annonce AND a.id_membre=m.id_membre AND a.id_photo = p.id_photo");
    $resul->execute(array('id_annonce'=>$_GET['id_annonce']));
    if ( $resul->rowCount() == 0):
        header('location:index.php');
        exit (); 
    endif;


     //2-affichage et mise en forme de la fiche annonce
    $annonce=$resul->fetch(PDO::FETCH_ASSOC);
    
    $contenu.='<div class="row">
                    <div class="col-md-8">
                        <h1 class="page-header">'.$annonce['titre_annonce'].'</h1>
                    </div>
                    <div class="col-md-4">
                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modalContact">Contacter '
                            .$annonce['pseudo'].'</button>
                            <div class="modal fade" id="modalContact" role="dialog">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Contact</h4>
                                </div>
                                <div class="modal-body">
                                    <p>N° de tél.'.$annonce['telephone'].'</p>
                                    <p>
                                    <textarea class="form-control" rows="3" placeholder="laissez votre message ici"></textarea>
                                    <button type="submit" class="btn btn-default">Envoyer</button>
                                    </p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                </div>
                              </div>
                              
                            </div>
                          </div>
                    </div>
                </div>';

    $contenu.='<div class="row">
                    <div class="col-md-10">
                        <a class="thumbnail fancybox" rel="ligthbox" href="'.$annonce['photo'].'">
                            <img class="img-responsive" alt="" src="'.$annonce['photo'].'" />
                            <div class="text-right">
                                <small class="text-muted">Image Title</small>
                            </div> <!-- text-right / end -->
                        </a>
                    </div>

                    <div class="col-md-2">
                        <a class="thumbnail fancybox" rel="ligthbox" href="'.$annonce['photo2'].'">
                            <img class="img-responsive" alt="" src="'.$annonce['photo2'].'" />
                        </a>
                    </div>

                    <div class="col-md-2">
                        <a class="thumbnail fancybox" rel="ligthbox" href="'.$annonce['photo3'].'">
                            <img class="img-responsive" alt="" src="'.$annonce['photo3'].'" />
                        </a>
                    </div>

                    <div class="col-md-2">
                        <a class="thumbnail fancybox" rel="ligthbox" href="'.$annonce['photo4'].'">
                            <img class="img-responsive" alt="" src="'.$annonce['photo4'].'" />
                        </a>
                    </div>

                    <div class="col-md-2">
                        <a class="thumbnail fancybox" rel="ligthbox" href="'.$annonce['photo5'].'">
                            <img class="img-responsive" alt="" src="'.$annonce['photo5'].'" />
                        </a>
                    </div>
                </div>';
$contenu.='<div class="col-md-6">
                        <p>'.$annonce['description_longue'].'</p>
                </div>';
    $contenu.='<div class="row" id="info">
                    <div class="col-md-3">
                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> 
                        <span>Date de publication :'.$annonce['date_enregistrement'].'</span>
                    </div>
                    <div class="col-md-3">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>  
                        <span>Pseudo : '.$annonce['pseudo'].'</span>
                    </div>
                    <div class="col-md-3">
                        <span class="glyphicon glyphicon-eur" aria-hidden="true"></span> 
                        <span>Prix : '.$annonce['prix'].'</span>
                    </div>
                    <div class="col-md-3">
                        <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> 
                        <span>Ville : '.$annonce['ville'].'</span>
                    </div>
                </div>';

    //---GoggleMap
    $contenu.=' <div class="row">
                  
                 <div id="googleMap"></div>
                 <script src="https://maps.googleapis.com/maps/api/js?&language=fr&key=AIzaSyB9v_LVILYi16Ejhv0jKuAEl6Ar797SK04"></script>
                 <script src="inc/js/annonce.js"></script>
                 <script> 

                 var adresse= \''.$annonce['ville'].'\';
                 TrouverADR(adresse); 
                </script>
                
                </div>';
               
    $contenu.='<div class="row">
    <span class="navbar-text navbar-right"><a href="index.php" class="navbar-link">Retour vers les annonces</a></span>
    <span class="navbar-text navbar-left"><button type="button" class="btn btn-default btn-lg" id="myBtn">Déposer un commentaire</button><button type="button" class="btn btn-default btn-lg" id="myBtn2">Laisser une note</button></span>
                </div>';
//----- COMMENTAIRE
    $contenu.='<div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="padding:35px 50px;">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="text-center">Poster un commentaire</h4>
                            </div>
                            <div class="modal-body" style="padding:40px 50px;">
                            <form method="post" role="form">
                                <div class="form-group">
                                <label for="commentaire"><span class="glyphicon glyphicon-user"></span> Username</label>
                                <textarea class="form-control" id="commentaire" name="commentaire" placeholder="Enter email"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success btn-block">Poster un commentaire</button>
                            </form>
                            </div>
                        </div>
                        </div>
                    </div>';

//----- NOTE
    $contenu.='<div class="modal fade" id="myModal2" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="padding:35px 50px;">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="text-center">Laisser une note</h4>
                            </div>
                            <div class="modal-body" style="padding:40px 50px;">
                            <form method="post" role="form">
                                <div class="form-group">
                                <label for="note">Note</label>
                                <input type="text" class="form-control" id="note" name="note" placeholder="Note entre 1 et 5">
                                </div>
                                <div class="form-group">
                                <label for="avis">Avis</label>
                                <textarea class="form-control" id="avis" name="avis" placeholder="Laisser un avis..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-success btn-block">Evaluer</button>
                            </form>
                            </div>
                        </div>
                        
                        </div>
                    </div>';


                    //-------------SUGGESTION

$resul2 = $pdo->prepare("SELECT * FROM annonces WHERE id_annonce != :id_annonce AND id_categorie = :id_categorie ORDER BY RAND() LIMIT 0,4");
$resul2->execute( array('id_annonce' => $_GET['id_annonce'],
                        'id_categorie'=> $annonce['id_categorie']
));


while ( $suggestion = $resul2->fetch(PDO::FETCH_ASSOC) ){ // tant qu'il y a des produit qui                                                                      répondent à la requête

    $aside.='<div class="col-md-3">
                <div class="thumbnail">
                    <a href="?id_annonce='.$suggestion['id_annonce'].'">
                        <img src="'.$suggestion['photo'].'" class="img-responsive">
                        <div class="caption">
                            <h4 class="text-center">'.$suggestion['titre'].'</h4>
                        </div>
                    </a>
                </div>
            </div>';

}
          

endif;
echo $contenu;
echo $aside;

require_once('inc/bas-site.php');
?>
        <script>
        $(document).ready(function(){
            $("#myBtn").click(function(){
                $("#myModal").modal();
            });
        });

        $(document).ready(function(){
            $("#myBtn2").click(function(){
                $("#myModal2").modal();
            });
        });

        $(document).ready(function(){
            //FANCYBOX
            //https://github.com/fancyapps/fancyBox
            $(".fancybox").fancybox({
                openEffect: "none",
                closeEffect: "none"
            });
        });
        </script>

<?php