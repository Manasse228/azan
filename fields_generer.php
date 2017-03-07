<?php 
/* 
* ******* Table abonnement ******* 
*/ 

$param[abonnement][id][type] = "int"; 
$param[abonnement][id][length] = "11"; 

$param[abonnement][type_eve][type] = "int"; 
$param[abonnement][type_eve][length] = "11"; 

$param[abonnement][user][type] = "int"; 
$param[abonnement][user][length] = "11"; 


/* 
* ******* Table droit ******* 
*/ 

$param[droit][id][type] = "int"; 
$param[droit][id][length] = "11"; 

$param[droit][libelle][type] = "varchar"; 
$param[droit][libelle][length] = "70"; 


/* 
* ******* Table droit_profil ******* 
*/ 

$param[droit_profil][id_user][type] = "int"; 
$param[droit_profil][id_user][length] = "11"; 

$param[droit_profil][id_profil][type] = "int"; 
$param[droit_profil][id_profil][length] = "11"; 

$param[droit_profil][id_droit][type] = "int"; 
$param[droit_profil][id_droit][length] = "11"; 

$param[droit_profil][id][type] = "int"; 
$param[droit_profil][id][length] = "11"; 


/* 
* ******* Table evenement ******* 
*/ 

$param[evenement][id][type] = "int"; 
$param[evenement][id][length] = "11"; 

$param[evenement][nom][type] = "varchar"; 
$param[evenement][nom][length] = "200"; 

$param[evenement][lieu][type] = "text"; 

$param[evenement][date_pub][type] = "date"; 

$param[evenement][date_db][type] = "datetime"; 

$param[evenement][date_fn][type] = "datetime"; 

$param[evenement][contact][type] = "varchar"; 
$param[evenement][contact][length] = "200"; 

$param[evenement][prix][type] = "int"; 
$param[evenement][prix][length] = "11"; 

$param[evenement][description][type] = "text"; 

$param[evenement][user][type] = "int"; 
$param[evenement][user][length] = "11"; 

$param[evenement][type][type] = "int"; 
$param[evenement][type][length] = "11"; 


/* 
* ******* Table photo ******* 
*/ 

$param[photo][id][type] = "int"; 
$param[photo][id][length] = "11"; 

$param[photo][libelle][type] = "varchar"; 
$param[photo][libelle][length] = "200"; 

$param[photo][lien][type] = "varchar"; 
$param[photo][lien][length] = "255"; 

$param[photo][type_photo][type] = "int"; 
$param[photo][type_photo][length] = "11"; 

$param[photo][id_eve][type] = "int"; 
$param[photo][id_eve][length] = "11"; 


/* 
* ******* Table profil ******* 
*/ 

$param[profil][id][type] = "int"; 
$param[profil][id][length] = "11"; 

$param[profil][libelle][type] = "varchar"; 
$param[profil][libelle][length] = "100"; 


/* 
* ******* Table sous_type_evenement ******* 
*/ 

$param[sous_type_evenement][id][type] = "int"; 
$param[sous_type_evenement][id][length] = "11"; 

$param[sous_type_evenement][libelle][type] = "varchar"; 
$param[sous_type_evenement][libelle][length] = "200"; 


/* 
* ******* Table type_evenement ******* 
*/ 

$param[type_evenement][id][type] = "int"; 
$param[type_evenement][id][length] = "11"; 

$param[type_evenement][libelle][type] = "varchar"; 
$param[type_evenement][libelle][length] = "200"; 

$param[type_evenement][description][type] = "text"; 

$param[type_evenement][type][type] = "int"; 
$param[type_evenement][type][length] = "11"; 


/* 
* ******* Table type_photo ******* 
*/ 

$param[type_photo][id][type] = "int"; 
$param[type_photo][id][length] = "11"; 

$param[type_photo][libelle][type] = "varchar"; 
$param[type_photo][libelle][length] = "200"; 


/* 
* ******* Table user ******* 
*/ 

$param[user][id][type] = "int"; 
$param[user][id][length] = "11"; 

$param[user][nom][type] = "varchar"; 
$param[user][nom][length] = "200"; 

$param[user][prenom][type] = "varchar"; 
$param[user][prenom][length] = "200"; 

$param[user][pseudo][type] = "varchar"; 
$param[user][pseudo][length] = "200"; 

$param[user][sexe][type] = "char"; 
$param[user][sexe][length] = "1"; 

$param[user][telephone][type] = "varchar"; 
$param[user][telephone][length] = "50"; 

$param[user][date_creation][type] = "date"; 

$param[user][email][type] = "varchar"; 
$param[user][email][length] = "255"; 

$param[user][password][type] = "varchar"; 
$param[user][password][length] = "255"; 

$param[user][active][type] = "int"; 
$param[user][active][length] = "11"; 

$param[user][code_activation][type] = "varchar"; 
$param[user][code_activation][length] = "200"; 

$param[user][photo][type] = "int"; 
$param[user][photo][length] = "11"; 

$param[user][profil][type] = "int"; 
$param[user][profil][length] = "11"; 


?>