<?php
session_start();
include_once 'mvc/controleur/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pdo = Connection::getConnexion();
$userManager = new UserManager($pdo);

if (isset($_GET['pcaisas'])) {

    $code = $_GET["pcaisas"];

    if ($userManager->exists($code, 'codeactivation') == false) {
        $user = $userManager->getUser('codeactivation', $code);
        if ($user->getActive() == 0) {
            //On procéde à l'activation du compte
            $userManager->updateUserByColumn('active', 1, $user->getId());

            Utilities::sendEmail($user->getEmail(), "Calentiel", "
<hr /> <br />
Votre Compte a été activé avec succès! . <br/>
<p></p><br/>

<hr />",
                "Confirmation d'activation", "contact@calentiel.info");

            $msg = new FlashMessages();
            $msg->success("<b>" . $user->getPseudo() . "</b> Votre compte vient d'être activé, il vous reste qu'à se connecter. Merci !", 'index.php');


        } else {
            //Ce compte est déja activé
            $msg = new FlashMessages();
            $msg->warning("<b>" . $user->getPseudo() . "</b> Votre compte est déjà activé par le passé, il vous reste qu'à se connecter. Merci !", 'index.php');
        }
    } else {
        //La clé est fausse
        $msg = new FlashMessages();
        $msg->error("Erreur lors de l'activation! ", 'index.php');
    }


} else {

    if (isset($_GET['sniper'], $_GET['email'], $_GET['rue'])) {

        $code = $_GET["sniper"];
        $email = $_GET['email'];
        $id = $_GET['rue'];

        if ($userManager->exists($code, 'codeactivation') == false) {
            $user = $userManager->getUser('codeactivation', $code);
            if ($user->getActive() == 0) {
                //On procéde à l'activation du compte
                $userManager->updateUserByColumn('active', 1, $user->getId());

                Utilities::sendEmail($user->getEmail(), "Calentiel", "
<hr /> <br />
Votre adresse email a été modifié avec succès! . <br/>
<p></p><br/>

<hr />",
                    "Confirmation de changement d'adresse email", "contact@calentiel.info");

                $msg = new FlashMessages();
                $msg->success("<b>" . $user->getPseudo() . "</b> Votre adresse email vient d'être modifiée, il vous reste qu'à se connecter. Merci !", 'index.php');


            } else {
                //Ce compte est déja activé
                $msg = new FlashMessages();
                $msg->warning("<b>" . $user->getPseudo() . "</b> Votre compte est déjà activé par le passé, il vous reste qu'à se connecter. Merci !", 'index.php');
            }
        } else {
            //La clé est fausse
            $msg = new FlashMessages();
            $msg->error("Erreur lors du changement d'adresse email! Veuillez contacter le service technique", 'index.php');
        }


    }else{
        Utilities::POST_redirect('index.php');
    }


}


?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Activation de compte</title>

    <?php include 'include/headerfile.php' ?>

    <link href="css/login.css" rel="stylesheet">

    <link rel="stylesheet" href="css/inscription.css"/>


</head>
<body>


<?php include 'include/navbar.php' ?>


<div class="box ">

    <?php


    ?>

    <fieldset>
        <legend id="text">Activation de compte</legend>


    </fieldset>


</div>


</body>
</html>
