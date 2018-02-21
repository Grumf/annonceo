<?php

function estConnecte(){
    
    if(isset($_SESSION['membre'])){
        return true;
    }
    else {
        return false;
    }

}

function estConnecteEtAdmin(){

    if ( estConnecte() && $_SESSION['membre']['statut']==1 ){
        return true;
    }
    else {
        return false;
    }
}

function moyenneNote($notes,$nbnotes){
    return $notes/$nbnotes;
}