<?php

require_once('inc/init.php');


if ( $_POST ){
    $motdepassecrypte = md5($_POST['mdp']); 

    $resul = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo AND mdp = :mdp");
    $resul->execute(array( 'pseudo' => $_POST['pseudo'],
                                            'mdp' => $motdepassecrypte
                                        ));

    if ( $resul->rowCount() == 1 ){

        $membre = $resul->fetch(PDO::FETCH_ASSOC);
        $_SESSION['membre'] = $membre;
        header('location:profil.php');
        exit();
    }
    
    else{
        $contenu.="<div class='bg-danger'>Erreur sur les identifiants</div>";
    }
}

if ( isset($_GET['action']) && $_GET['action'] ='deconnexion'){

    session_destroy();

}

require_once('inc/haut-site.php');
echo $contenu;
?>

<!-- Créer le formulaire de connexion -->
<h2 class="text-center">Connexion</h2>
<form method="post" class="form-horizontal col-md-offset-4 col-md-4">
  <div class="form-group">
    <label for="login" class="control-label">Login</label>
    <div class="">
      <input type="text" class="form-control" id="login" placeholder="Entrez votre login" name='pseudo' required>
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword" class="control-label">Mot de passe</label>
    <div class="">
      <input type="password" class="form-control" id="inputPassword" placeholder="Password" name='mdp' required>
    </div>
  </div>
  <div class="form-group">
    <div class="col-md-offset-4">
      <button type="submit" class="btn btn-default">Connexion</button>
    </div>
  </div>
</form>

<?php

require_once('inc/bas-site.php');