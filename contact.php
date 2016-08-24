<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>

    <?php include 'include/headerfile.php' ?>

    <link href="css/login.css" rel="stylesheet">

    <script type="text/javascript" src='js/reCaptcha2.min.js'></script>

</head>
<body>

<?php include_once 'include/navbar.php';



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['name'])) && (isset($_POST['email']))
    && (isset($_POST['message'])) && ($_POST['submitContact'] == 'Envoyer')
) {

    include_once 'mvc/controleur/autoload.php';
    $mail = $_POST['email']; // Déclaration de l'adresse de destination.

    Utilities::sendEmail($_POST['email'], "Calentiel Equipe technique",
        "Votre demande (<br/> <b>". $_POST['message'] ."</b> <br />) est bien prise en compte Merci!",
        "Demande d'information", "contact@calentiel.info");

    Utilities::sendEmail("contact@calentiel.info", "Demande Urgente",
         $_POST['message']. "<br /> venant de : ".$_POST['email'],
        "Demande Urgente", "contact@calentiel.info");

    $msg = new FlashMessages();
    $msg->success('Votre message a été envoyé avec succès; notre épuique technique vous répondra dans de plus bref délai. Merci!');
    $msg->display();
}


?>


<div class="row" style="margin-top: 80px">


    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1 class="page-header text-center">Vous avez quelque chose à nous dire ? </h1>

            <form class="form-horizontal" id="contactForm" method="post" role="form" autocomplete="off"
                  action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES); ?>" >

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name"
                               placeholder="Votre nom">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="example@domain.com">
                    </div>
                </div>

                <div class="form-group">
                    <label for="message" class="col-sm-2 control-label">Message</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="4"
                                  name="message"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="human" class="col-sm-2 control-label">Captcha</label>
                    <div class="col-sm-10">
                        <div id="captchaContainer"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        <button name="submitContact" value="Envoyer" class="btn btn-lg btn-primary " type="submit">
                            <span class="glyphicon glyphicon-bell"></span> Envoyer
                        </button>
                        <button type="reset" class="btn btn-lg btn-primary btn-danger" id="resetButton">
                            <span class="glyphicon glyphicon-remove"></span> Annuler
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


</div>



</body>
</html>
