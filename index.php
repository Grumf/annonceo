<?php

require_once('inc/init.php');

$requete="";
$ordre="";
$param = array();


if ( isset($_GET['plus'])){
    $ordre=" ORDER BY prix";
} elseif ( isset($_GET['moins'])){
    $ordre=" ORDER BY prix DESC";
};

if ( isset($_GET['id_categorie'])){

    $requete=" AND id_categorie= :id_categorie";
    $param = array('id_categorie' => $_GET['id_categorie']);

}

if ( isset($_GET['ville'])){

    $requete=" AND ville= :ville";
    $param = array('ville' => $_GET['ville']);

}


$donnees = $pdo->prepare("SELECT * FROM annonces WHERE id_annonce > 0".$requete.$ordre);
$donnees->execute($param);

while ( $annonce = $donnees->fetch(PDO::FETCH_ASSOC)){
    
    $contenu.= "<div class='col-md-12 hauteur'>
                            <div class='thumbnail'>
                            <a href='fiche_annonce.php?id_annonce=".$annonce['id_annonce']."'><img src='".$annonce['photo']."' class='img-responsive'>
                                <div class='caption'>
                                <h4 class='pull-right'>".$annonce['prix']." €</h4>
                                <h4>".$annonce['titre']."</h4></a>
                                <p>".$annonce['description_courte']."</p>
                                </div>
                            </div>
                        </div>";
                            
}

$categories = $pdo->query("SELECT DISTINCT c.titre, a.id_categorie FROM annonces a, categorie c WHERE c.id_categorie=a.id_categorie");

$aside.='<div class="row">
            <div class="btn-group col-md-12">
                <button id="monbouton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Categories <span class="caret"></span>
                </button>
            <ul class="dropdown-menu" aria-labelledby="monbouton">';
    while ( $categorie = $categories->fetch(PDO::FETCH_ASSOC)){
            $aside.='<li><a href="?id_categorie='.$categorie['id_categorie'].'">'.$categorie['titre'].'</a></li>';
        };
        $aside.='</ul>
            </div>
        </div>';


$villes = $pdo->query("SELECT DISTINCT ville FROM annonces");

$aside.='<div class="row">
        <div class="btn-group col-md-12">
            <button id="villes" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Villes <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="villes">';
    while ( $ville = $villes->fetch(PDO::FETCH_ASSOC)){
            $aside.='<li><a href="?ville='.$ville['ville'].'">'.$ville['ville'].'</a></li>';
    };
    $aside.='</ul>
        </div>
        </div>';

        $aside.="<h4>Prix</h4>
        <div class='list-group'>
        <a href='?moins'>Du - cher au + cher</a><br>
        <a href='?plus'>Du + cher au - cher</a>
        </div>";

require_once('inc/haut-site.php');
?>
<div class="row">
    
    <div class="col-md-3 aside">
        <?= $aside; ?>
    </div>
    <div class="col-md-9">
        <h2 class="text-center">Les dernières annonces</h2>
        <?= $contenu; ?>
    </div>
    
</div>


<?php



require_once('inc/bas-site.php');