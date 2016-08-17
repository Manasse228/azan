<?php
include_once 'mvc/controleur/autoload.php';
session_start();


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if( ($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['nomEve'])) && (isset($_POST['lieuEve']))
    && (isset($_POST['prixEve']))  && (isset($_POST['dateMiseEnLigneEve']))  && (isset($_POST['datedebutEve']))  && (isset($_POST['datefinEve']))
    && (isset($_POST['contactEve'])) && (isset($_POST['descriptionEve'])) && ($_POST['firtsPart'] == 'continuer' ) ){

    $evenement = new Evenement($_POST['nomEve'], $_POST['lieuEve'], $_POST['dateMiseEnLigneEve'], $_POST['datedebutEve'],
        $_POST['datefinEve'], $_POST['contactEve'], $_POST['prixEve'], $_POST['descriptionEve'], $_SESSION['User']->getId(), $_POST['type']);

     $_SESSION['Evenement'] = $evenement;

    $pdo = Connection::getConnexion();
    $evenementManager = new  EvenementManager($pdo);
    if($evenementManager->checkNomLieu($evenement->getNom(), $evenement->getLieu()) == false){
        $msg = new FlashMessages();
        $msg->error("<b>".$evenement->getNom()."</b> est déjà utilisé pour un autre évènement à <b>".$evenement->getLieu()."</b>");
    }else{
        Utilities::POST_redirect('nvoevesuite.php');
    }


}

?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Publier un évènement</title>

    <?php include 'include/headerfile.php' ?>

    <script type="text/javascript" src="js/moment.min.js" ></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />

    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

    <link href="css/bootstrap-datetimepicker.css" rel="stylesheet" />
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js" ></script>


<link rel="stylesheet" href="css/pulierArticle.css">




</head>
<body>

<?php include 'include/navbar.php';

?>

<form class="form-horizontal" id="formPub" method="post" role="form"
      action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES); ?>" >
    <?php
    $msg = new FlashMessages();
    $msg->display();
    ?>
    <fieldset>

        <!-- Form Name -->
        <legend>Publication d'évènement (1/2)</legend>

        <?php
        $pdo = Connection::getConnexion();
        $pdo->beginTransaction();
        $req = $pdo->prepare("select * from typeevenement ");
        $req->execute();
        $pdo->commit();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        ?>



        <!-- Type evenement -->
        <div class="form-group ">
            <label class="col-md-4 control-label" >Type événement</label>
            <div class="col-md-2">
                <select name="type" class="form-control">
                    <option value="">-- Selectionner --</option>
                    <?php
                    foreach($result as $value){
                        echo "<option value=".$value['id'].">".$value['libelle']."</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <!-- Nom -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Nom</label>
            <div class="col-md-6">
                <input  name="nomEve" value="<?php if(isset($_SESSION['Evenement'])){echo $_SESSION['Evenement']->getNom();} ?>"
                        type="text" placeholder="Nom de l'évènement"
                        class="form-control input-md" autocomplete="off">
                <span class="help-block">Ex: Avépozo Party</span>
            </div>
        </div>

        <!-- Lieu -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Lieu</label>
            <div class="col-md-6">
                <input  name="lieuEve" value="<?php if(isset($_SESSION['Evenement'])){echo $_SESSION['Evenement']->getLieu();} ?>"
                        type="text" placeholder="Lieu de l'évènement"
                        id="lieuEve"
                        class="form-control input-md" autocomplete="off" >
                <span class="help-block">Avépozo Beach</span>
            </div>
        </div>

        <!-- Entrée -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Entrée</label>
            <div class="col-md-4">
                <input  name="prixEve" value="<?php if(isset($_SESSION['Evenement'])){echo $_SESSION['Evenement']->getPrix();} ?>"
                        type="text" placeholder="Prix de la party"
                        class="form-control input-md" autocomplete="off">
                <span class="help-block">Mettez 0 Si gratuit</span>
            </div>
        </div>


        <!-- Date de mise en ligne -->
        <div class="form-group">
            <label class="col-md-4 control-label">Date de mise en ligne</label>
            <div class="col-md-4 date">
                <div class="input-group input-append date" id="dateML">
                    <input id="inputdateML" value="<?php if(isset($_SESSION['Evenement'])){echo $_SESSION['Evenement']->getDatePub();} ?>"
                           type="text" autocomplete="off"
                           class="form-control" name="dateMiseEnLigneEve" />
                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
        </div>


        <!-- Date debut -->
        <div class="form-group">
            <label class="col-md-4 control-label">Date début</label>
            <div class="col-md-4 date">
                <div class="input-group input-append date" id="dateDb">
                    <input type="text" value="<?php if(isset($_SESSION['Evenement'])){echo $_SESSION['Evenement']->getDateDb();} ?>"
                           class="form-control" name="datedebutEve" autocomplete="off"/>
                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
        </div>

        <!-- Date Fin -->
        <div class="form-group">
            <label class="col-md-4 control-label">Date fin</label>
            <div class="col-md-4 date">
                <div class="input-group input-append date" id="dateFin">
                    <input type="text" value="<?php if(isset($_SESSION['Evenement'])){echo $_SESSION['Evenement']->getDateFn();} ?>"
                           class="form-control" autocomplete="off" name="datefinEve" />
                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
        </div>

        <!-- Contact-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Contact</label>
            <div class="col-md-6">
                <input id="textinput" value="<?php if(isset($_SESSION['Evenement'])){echo $_SESSION['Evenement']->getContact();} ?>"
                       name="contactEve" type="text" autocomplete="off"
                       placeholder="Contact" class="form-control input-md">
                <span class="help-block">Tel: 00228 90 97 89 71</span>
            </div>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label class="col-md-4 control-label" >Description</label>
            <div class="col-md-4">
                <textarea class="form-control" id="textarea" name="descriptionEve">
                    <?php if(isset($_SESSION['Evenement'])){echo $_SESSION['Evenement']->getDesription();} ?>
                </textarea>
            </div>
        </div>

        <!-- Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" ></label>
            <div class="col-md-8">


                <button
                    type="submit" class="btn btn-success btn-lg btn3d" name="firtsPart" value="continuer">
                    <span class="glyphicon glyphicon-ok"></span> Valider & Continuer</button>

                <button type="reset" class="btn3d btn btn-danger btn-lg">
                    <span class="glyphicon glyphicon-remove"></span> Annuler</button>
            </div>
        </div>

    </fieldset>
</form>



<script>
    $(document).ready(function() {
var choix;
        $('#dateML')
            .datepicker({
                format: 'dd-mm-yyyy',
                todayHighlight: true,
                autoclose: true,
                startDate: new Date(),

            }).on('changeDate', function(e) {
                // Revalidate the date field
                //choix = document.getElementById('inputdateML').value;
                //console.log("date "+choix);
            $('#form').formValidation('revalidateField', 'dateMiseEnLigneEve');
            $('#dateDb').data("DateTimePicker").minDate(e.date);
            $('#dateFin').data("DateTimePicker").minDate(e.date);
            });



        $('#dateDb').datetimepicker({
            format: 'DD-MM-YYYY HH:mm',

        }).on('dp.change dp.show', function(e) {
            $('#dateFin').data("DateTimePicker").minDate(e.date);
            $('#form').formValidation('revalidateField', 'datedebutEve');
        });


        $('#dateFin')
            .datetimepicker({
            format: 'DD-MM-YYYY HH:mm'
        }).on('dp.change dp.show', function(e) {
            $('#form').formValidation('revalidateField', 'datefinEve');
        });


    });


</script>





</body>
</html>
