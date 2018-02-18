<?php
require_once("inc/init.php");
require_once("inc/haut-site.php");
?>
<form method="post" action="" >
  <div class="form-group">
    <label for="exampleInputName1"></label>
    <input type="text" class="form-control" name="pseudo" id="exampleInputName1" placeholder="Votre pseudo" required value=<?=$_POST['pseudo']??''?>>
  </div>
  <div class="form-group">
    <input type="password" class="form-control" name="mdp" id="exampleInputPassword1" placeholder="Mot de passe" required value=<?=$_POST['mdp']??''?>>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" name="nom" id="exampleInputName1" placeholder="Nom" required value=<?=$_POST['nom']??''?>>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" name="prenom" id="exampleInputName1" placeholder="Prénom" required value=<?=$_POST['prenom']??''?>>
  </div>
  <div class="form-group">
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Nom@example.com" required value=<?=$_POST['email']??''?>>
  </div>
  <div class="form-group">
    <label for="exampleInputName1">N° de téléphone</label>
    <input type="text" id="exampleInputTel" class="input-medium bfh-phone" data-country="FR">
  </div>
  <div class="form-group">
    <select id="exampleInputEmail1" name="titre">
      <option value="Madame">Madame</option>
      <option value="Monsieur">Monsieur</option>
    </select>
</div>


  <button type="submit" class="btn btn-info">Inscription</button>
</form>

<?php
require_once("inc/bas-site.php");
?>