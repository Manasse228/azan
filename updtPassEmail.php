<?php
include_once 'mvc/controleur/autoload.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (($_SERVER['REQUEST_METHOD'] == 'POST')
    && (isset($_POST['oldEmail'], $_POST['mewemail'], $_POST['mewemail2']))&& ($_POST['updtemail'] == 'changeremail')
) {

    $pdo = Connection::getConnexion();
    $userManager = new UserManager($pdo);

    $userManager->prepareToChangeEmail($_POST['oldEmail'], $_POST['mewemail'], $_SESSION['User']->getId());

    $msg = new FlashMessages();
    $msg->success("Le lien de changement d' email vous a été à votre nouvelle adresse email. Merci!", "index.php");

}


if (($_SERVER['REQUEST_METHOD'] == 'POST')
    && (isset($_POST['oldPassword'], $_POST['newPassword'], $_POST['newPassword2']))&& ($_POST['pwdupdt'] == 'updatemail')
) {
    $pdo = Connection::getConnexion();
    $userManager = new UserManager($pdo);

}

?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Modification Email / Mot de passe</title>

    <?php include 'include/headerfile.php' ?>

    <link href="css/login.css" rel="stylesheet">

    <script type="text/javascript" src='js/reCaptcha2.min.js'></script>

</head>
<body>

<?php include_once 'include/navbar.php';

?>

<br/>
<div class="container">

    <?php
    $msg = new FlashMessages();
    $msg->display();
    ?>

    <div class="row">
        <div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#email" role="tab" data-toggle="tab">Modifier Email</a>
                </li>
                <li role="presentation"><a href="#password" role="tab" data-toggle="tab">Modifier mot de passe</a></li>

            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="email">

                    <form id="modification_email" method="post" class="form-horizontal">

                        <br/>
                        <!-- email actuel -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="textinput">Email actuel</label>
                            <div class="col-md-4">
                                <input name="oldEmail" type="email" placeholder="Mot de passe actuel"
                                       class="form-control " autocomplete="off">
                                <span class="help-block">Mot de passe actuel</span>
                            </div>
                        </div>

                        <!-- Nouveau mot de passe -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="textinput">Nouvelle adresse email</label>
                            <div class="col-md-4">
                                <input name="mewemail" type="email" placeholder="xxx@xxx.xxx"
                                       class="form-control input-md" autocomplete="off">
                                <span class="help-block">Nouveau mot de passe</span>
                            </div>
                        </div>

                        <!-- Nouveau mot de passe 2 -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="textinput">Nouvelle adresse email</label>
                            <div class="col-md-4">
                                <input name="mewemail2" type="email" placeholder="xxx@xxx.xxx"
                                       class="form-control input-md" autocomplete="off">
                                <span class="help-block">Nouveau adresse email (Verification)</span>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label"></label>
                            <div class="col-md-8">

                                <button
                                    type="submit" class="btn btn-success btn-lg btn3d" name="updtemail"
                                    value="changeremail">
                                    <span class="glyphicon glyphicon-pencil"></span> Modifier
                                </button>

                                <button type="reset" class="btn3d btn btn-danger btn-lg">
                                    <span class="glyphicon glyphicon-remove"></span> Annuler
                                </button>
                            </div>
                        </div>


                    </form>

                </div>


                <div role="tabpanel" class="tab-pane" id="password">

                    <form id="modification_password" method="post" class="form-horizontal">

                        <br/>
                        <!-- Mot de passe actuel -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="textinput">Mot de passe actuel</label>
                            <div class="col-md-4">
                                <input name="oldPassword" type="password" placeholder="Mot de passe actuel"
                                       class="form-control " autocomplete="off">
                                <span class="help-block">Mot de passe actuel</span>
                            </div>
                        </div>

                        <!-- Nouveau mot de passe -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="textinput">Nouveau mot de passe</label>
                            <div class="col-md-4">
                                <input name="newPassword"
                                       type="password" placeholder="Prix de la party"
                                       class="form-control input-md" autocomplete="off">
                                <span class="help-block">Nouveau mot de passe</span>
                            </div>
                        </div>

                        <!-- Nouveau mot de passe 2 -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="textinput">Nouveau mot de passe</label>
                            <div class="col-md-4">
                                <input name="newPassword2"
                                       type="password" placeholder="Prix de la party"
                                       class="form-control input-md" autocomplete="off">
                                <span class="help-block">Nouveau mot de passe (Verification)</span>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label"></label>
                            <div class="col-md-8">


                                <button
                                    type="submit" class="btn btn-success btn-lg btn3d" name="pwdupdt"
                                    value="updatemail">
                                    <span class="glyphicon glyphicon-pencil"></span> Modifier
                                </button>

                                <button type="reset" class="btn3d btn btn-danger btn-lg">
                                    <span class="glyphicon glyphicon-remove"></span> Annuler
                                </button>
                            </div>
                        </div>


                    </form>

                </div>

            </div>

        </div>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function () {

        useremail = '<?php echo $_SESSION['User']->getEmail() ?>';

    });


</script>

</body>
</html>
