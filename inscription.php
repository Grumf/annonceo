<?php
require_once("inc/init.php");

$inscription = false; // inscription pas faite, je m'en sers pour afficher le formulaire

if ( $_POST ){

    // je poste mon formulaire d'inscription

    // controles sur les champs
    $champs_vides = 0;
    foreach ( $_POST as $indice => $valeur )
    {
        if ( empty($valeur) )
        {
            $champs_vides++;
        }
    }

    if ($champs_vides > 0 )
    {
        $contenu .= '<div class="alert alert-danger">Il y a '.$champs_vides.' information(s) manquante(s)</div>';
    }

    // verifier qu'une chaine contient des caractères autorisés

    $verif_caractere = preg_match('#^[a-zA-Z0-9._-]{3,15}$#',$_POST['pseudo']);

    if ( !$verif_caractere){
        $contenu .= '<div class="alert alert-danger">Le pseudo doit contenir 3 à 15 caractères (lettres de a à Z, chiffres de 0 à 9, _.-)</div>';
    }


    if ( $_POST['titre'] !='m' &&  $_POST['titre'] !='f' )
    {
        $contenu .= '<div class="alert alert-danger">De quel genre êtes-vous?</div>';
    }

    // astuce de controle d'EMAIL avec filter_var, fonction qui vérifie la chaine de caractère par rapport à un format
    if ( !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) )
    {
        $contenu .= '<div class="alert alert-danger">Adresse mail invalide</div>';
    }


    $membre = $pdo->prepare("SELECT * FROM membre WHERE pseudo=:pseudo");
    $membre->execute(array('pseudo' => $_POST['pseudo']));

    if ( $membre->rowCount() > 0 )
    {
        $contenu .=  '<div class="alert alert-danger">Pseudo indisponible, merci d\'en choisir un autre</div>';
    }


    // Si tout va bien
    // j'insère le nouveau membre dans la table membre  (avec statut = 0)
    // je mets $inscription à true
    if ( empty($contenu) )
    {

        $result = $pdo->prepare("INSERT INTO membre
                        VALUES (NULL,:pseudo,:mdp,:nom,:prenom,:telephone,:email,:titre,0,NOW());");
           $result->execute(array( 'pseudo' => $_POST['pseudo'],
                                   'mdp'   => MD5($_POST['mdp']),
                                   'nom'   => $_POST['nom'],
                                   'prenom'   => $_POST['prenom'],
                                   'telephone'   => $_POST['telephone'],
                                   'email'   => $_POST['email'],
                                    'titre'   => $_POST['titre']
                                 ));
        $contenu .='<div class="alert alert-success">Vous êtes inscrit à notre site. <a href="connexion.php">Cliquer ici pour vous connecter</a></div>';
        $inscription = true;
    }
}

require_once("inc/haut-site.php");

echo $contenu;



if ( !$inscription ){
?>
<form method="post" action="#" >
  <div class="form-group">
    <label for="pseudo"></label>
    <input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Votre pseudo" required value=<?=$_POST['pseudo']??''?>>
  </div>
  <div class="form-group">
    <input type="password" class="form-control" name="mdp" id="mdp" placeholder="Mot de passe" required value=<?=$_POST['mdp']??''?>>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" required value=<?=$_POST['nom']??''?>>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prénom" required value=<?=$_POST['prenom']??''?>>
  </div>
  <div class="form-group">
    <input type="email" name="email" class="form-control" id="email" placeholder="Nom@example.com" required value=<?=$_POST['email']??''?>>
  </div>
  <div class="form-group">
    <label for="telephone">N° de téléphone</label>
    <input type="text" name="telephone" id="telephone" class="input-medium bfh-phone" data-country="FR">
  </div>
  <div class="form-group">
    <select id="titre" name="titre">
      <option value="f">Madame</option>
      <option value="m">Monsieur</option>
    </select>
</div>


  <input type="submit" class="btn btn-info" value="Inscription">
</form>

<?php

};
require_once("inc/bas-site.php");
?>