<?php
include_once 'mvc/controleur/autoload.php';
session_start();

$pdo = Connection::getConnexion();
$req = $pdo->prepare("select * from type_evenement ");
$req->execute();
$result = $req->fetchAll(PDO::FETCH_ASSOC);


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['pseudo'], $_POST['email'], $_POST['type'])) && ($_POST['inscription'] == 'submit')) {

    $userManager = new UserManager($pdo);
    $userManager->createUserWithFollow(new User($_POST['pseudo'], $_POST['email']), $_POST['type']);

    $msg = new FlashMessages();
    $msg->success("Abonnement effectué avec succès; un message de confirmation vous a été envoyé à cette adresse email : " . $_POST['email'], 'index.php');
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

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.0/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.0/js/bootstrap-select.min.js"></script>

</head>
<body>

<?php include 'include/navbar.php' ?>


<div class="box ">

    <fieldset>
        <legend id="text">NewsLetters</legend>


        <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES); ?>" role="form"
              autocomplete="off" method="post" id="newsletters_form" class="form-horizontal">


            <div class="form-group ">
                <label class="col-md-2 col-lg-2 col-xs-12 control-label">Type évènement</label>
                <div class="col-md-10 col-lg-10 col-xs-12">
                    <select id="typeeve" name="type[]" class="form-control selectpicker"
                            multiple data-live-search="true" data-live-search-placeholder="Recherche"
                            data-actions-box="true">
                        <?php
                        foreach ($result as $value) {
                            echo "<option value=" . $value['id'] . ">" . $value['libelle'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>


            <div class="form-group">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <input required autocomplete="off"
                           class="form-control" name="pseudo" placeholder="Pseudo" type="text"/>
                </div>

            </div>


            <div class="form-group">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="input-group ">
                        <span class="input-group-addon">@</span>
                        <input type="email" required autocomplete="off"
                               class="form-control" name="email" placeholder="Adresse Email"/>
                    </div>
                </div>
            </div>


            <div class="form-group">

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <button name="inscription" value="submit" class="btn btn-lg btn-primary " type="submit">
                        <span class="glyphicon glyphicon-bullhorn"></span> Abonner
                    </button>

                    <button type="reset" class="btn btn-lg btn-primary btn-danger">
                        <span class="glyphicon glyphicon-remove"></span>Annuler
                    </button>
                </div>

            </div>


        </form>


    </fieldset>


</div>


</body>
</html>

