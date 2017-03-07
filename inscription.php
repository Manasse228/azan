<?php
include_once 'mvc/controleur/autoload.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if( ($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['inscription'] == 'submit') &&  (isset($_POST['pseudo'],$_POST['email'],$_POST['password'])) ) {
    $pdo = Connection::getConnexion();
    $userManager = new UserManager($pdo);
    $msg = new FlashMessages();
    $user = new User($_POST['pseudo'], '', $_POST['email'], date('Y-m-d'), $_POST['password']);
    $_SESSION['User_Creation'] = $user;
    $error = array();

    if (!$userManager->check_email_format($user->getEmail())){
        $error[] = "Format de l'adresse Email est incorrect";
    }

    if (!$userManager->exists($user->getPseudo(), "pseudo")){
        $error[] = "Pseudo déjà utilisé";
    }

    if (!$userManager->exists($user->getEmail(), "email")){
        $error[] = "Email déjà utilisée";
    }

    if (!Utilities::same_field($user->getPassword(), $_POST['password2'])){
        $error[] = "Les deux mots de passe sont pas identiques";
    }

    if(count($error)){
        foreach ($error as $erreur){
            $message .= "<b>".$erreur."</b> <br />";
        }
        $msg->error($message);
    }else{
        $userManager->createUser($user);
        unset($_SESSION['User_Creation']);
        $msg->success("Inscription effectuée avec succès; un message de confirmation vous a été envoyé à cette adresse email : ".$_POST['email'], 'index.php');
    }

}

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Inscription</title>

    <?php include 'include/headerfile.php' ?>

    <link rel="stylesheet" href="css/inscription.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.3.0/zxcvbn.js"></script>

</head>
<body>

<?php include 'include/navbar.php' ?>



<div class="box ">

    <fieldset>
        <legend id="text">Inscription</legend>
        <?php
        $sms = new FlashMessages();
        $sms->display();
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES); ?>" role="form"
              autocomplete="off" method="post" id="inscription_form" class="form-horizontal">


                <div class="form-group">
                    <div class="input-group" >
                        <input value="<?php if(isset($_SESSION['User_Creation'])) echo $_SESSION['User_Creation']->getPseudo() ?>"
                            required autocomplete="off" class="form-control" name="pseudo" placeholder="Pseudo" type="text"/>
                    </div>
                </div>


            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">@</span>
                    <input value="<?php if(isset($_SESSION['User_Creation'])) echo $_SESSION['User_Creation']->getEmail(); ?>"
                        type="email" required autocomplete="off"class="form-control" name="email" placeholder="Adresse Email"/>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input class="form-control" required name="password"
                           autocomplete="off" placeholder="Mot de passe" type="password"/>
                </div>

                <div class="progress password-progress">
                    <div id="strengthBar" class="progress-bar" role="progressbar" style="width: 0;"></div>
                </div>
            </div>


            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input class="form-control" type="password"
                           autocomplete="off" required name="password2" placeholder="Verification du mot de passe"/>
                </div>

                <div class="progress password-progress">
                    <div id="strengthBar2" class="progress-bar" role="progressbar" style="width: 0;"></div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-md-8 col-lg-8">
                    <button name="inscription" value="submit" class="btn btn-lg btn-primary " type="submit">
                        <span class="glyphicon glyphicon-floppy-save"></span> Valider
                    </button>

                    <button type="reset" class="btn btn-lg btn-primary btn-danger">
                        <span class="glyphicon glyphicon-remove"> Annuler
                    </button>
                </div>
            </div>


        </form>


    </fieldset>


</div>


</body>
</html>

