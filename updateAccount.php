<?php
include_once 'mvc/controleur/autoload.php';
session_start();


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if( ($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['update'] == 'submit')
    && (isset($_POST['pseudo'])) &&  (isset($_POST['sexe']))) {



    $pdo = Connection::getConnexion();
    $userManager = new UserManager($pdo);

    $userManager->updateUser(
        new User($_POST['pseudo'],$_POST['telephone'],$_POST['sexe'],$_POST['prenom'],$_POST['nom'],$_SESSION['User']->getId()));

    $msg = new FlashMessages();
    $msg->success('Modification effectuée avec succés! ');
    $msg->display();

}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Modification de compte</title>

    <?php include 'include/headerfile.php' ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.3.0/zxcvbn.js"></script>

    <style type="text/css">

        .fieldset{
            margin-top: 70px;
            margin-right: 40px;
            margin-left: 40px;
        }

    </style>
</head>
<body>

<?php include 'include/navbar.php' ?>



    <fieldset class="fieldset">
        <?php

        $msg = new FlashMessages();
        $msg->display();
        ?>
        <legend id="text">Mise à jour</legend>

        <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES); ?>"
              autocomplete="off" method="post" id="update_form" class="form-horizontal">


            <div class="row">
                <div class="form-group">
                    <div class="col-xs-12 col-md-6 col-lg-6">
                        <input  autocomplete="off" value="<?php  if(isset($_SESSION['User'])){echo $_SESSION['User']->getNom();} ?>"
                               class="form-control" name="nom" placeholder="Nom" type="text"/>
                        <span class="help-block">Votre Nom</span>
                    </div>

                    <div class="col-xs-12 col-md-6 col-lg-6">
                        <input  autocomplete="off" value="<?php  if(isset($_SESSION['User'])){echo $_SESSION['User']->getPrenom();} ?>"
                               class="form-control" name="prenom" placeholder="Prénom" type="text"/>
                        <span class="help-block">Votre Prénom</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-xs-12 col-md-8 col-lg-8">
                        <input required autocomplete="off"
                               value="<?php  if(isset($_SESSION['User'])){echo $_SESSION['User']->getPseudo();} ?>"
                               class="form-control" name="pseudo" placeholder="Pseudo" type="text"/>
                        <span class="help-block">Votre Pseudo</span>
                    </div>

                    <div class="col-xs-12 col-md-4 col-lg-4 form-inline ">
                        <label class="radio-inline">
                            <input type="radio" name="sexe" value="M" checked="checked">M
                        </label>
                        <label class="radio-inline" for="radios-1">
                            <input type="radio" name="sexe" value="F">F
                        </label>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="form-group">
                    <div class="col-xs-12 col-md-6 col-lg-6">
                        <input type="tel"  autocomplete="off"
                               value="<?php  if(isset($_SESSION['User'])){echo $_SESSION['User']->getTelephone();} ?>"
                               class="form-control" name="telephone" placeholder="Telephone"/>
                        <span class="help-block">Votre Numero de téléphone</span>
                    </div>

                    <div class="col-xs-12 col-md-6 col-lg-6">
                        <input type="email"  autocomplete="off"
                               value="<?php  if(isset($_SESSION['User'])){echo $_SESSION['User']->getEmail();} ?>"
                               disabled="disabled" class="form-control" name="telephone" placeholder="Telephone"/>
                        <span class="help-block">Votre adresse email</span>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-xs-12 col-md-8 col-lg-8">
                    <button name="update" value="submit" class="btn btn-lg btn-primary btn-block" type="submit">
                        <span class="glyphicon glyphicon-floppy-save"></span> Modfication
                    </button>
                </div>
                <div class="col-xs-12 col-md-4 col-lg-4">
                    <button type="reset" class="btn btn-lg btn-primary btn-block btn-danger">Annuler</button>
                </div>
            </div>


        </form>


    </fieldset>


</body>
</html>

