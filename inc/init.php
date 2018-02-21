<?php

session_start();

$pdo = new PDO('mysql:host=localhost;dbname=annonceo','root','',
array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
));



require_once('fonction.php');

$contenu='';
$contenu_gauche='';
$contenu_droite='';
$aside='';