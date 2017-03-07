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


    $pdo = Connection::getConnexion();
    $pdo->beginTransaction();
    $req = $pdo->prepare("select * from sous_type_evenement ");
    $req->execute();
    $pdo->commit();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['name'],$_POST['email'],$_POST['message'])) && ($_POST['submitContact'] == 'Envoyer')
) {

    include_once 'mvc/controleur/autoload.php';


    $to = trim($user->getEmail());
    $name = trim(stripslashes($_POST['name']));
    $email = trim(stripslashes($_POST['email']));
    $message = $name." votre souscription est bien priss encompte, vous serez mis au courant dès qu'un nouveau évènement sera mis en ligne";
    $subject = "Souscription";


    $headers = 'From: ' . $name . '<contact@calentiel.info>' . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


    $message .= "<br /> Voici l'email de l'expéditeur ".$email."<br/> PS: Ne répondait pas à cet email";
    mail($to, $subject, $message, $headers);
}


?>


<div class="row" style="margin-top: 80px">
    <?php

    $msg = new FlashMessages();
    $msg->display();
    ?>

    <div class="row">

        <div class="col-md-6 col-md-offset-3">
            <h1 class="page-header text-center">
                Souscrivez aux types d'évènements que vous désirez et nous s'occuperons du reste en vous mettant au courant</h1>

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
                    <label for="email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="example@domain.com">
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
                        <button name="submitContact" value="Envoyer" class="btn btn-lg btn-primary" type="submit">
                            <span class="glyphicon glyphicon-pencil"></span> Valider
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
