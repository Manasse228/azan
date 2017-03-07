<?php
include_once 'mvc/controleur/autoload.php';
include_once 'ajax/upload.php';
session_start();

if(!$_SESSION['Evenement_dir']){
    $_SESSION['Evenement_dir'] = time();
}
$DOSSIER_UPLOAD = $_SESSION['Evenement_dir'];
$folder_name = "Photo_Couverture";
$dir_tampom = "serveur_image";
$link = $dir_tampom.'/'.$DOSSIER_UPLOAD.'/'.$folder_name;
$tab="";
if($DOSSIER_UPLOAD){

    if(file_exists($link)){
        $tab = read($link);
    }

}


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if( ($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['nomEve'],$_POST['lieuEve'],$_POST['prixEve'],$_POST['dateMiseEnLigneEve'],
        $_POST['datedebutEve'],$_POST['datefinEve'],$_POST['contactEve'],$_POST['descriptionEve'])) && ($_POST['firtsPart'] == 'continuer' ) ){

    $pdo = Connection::getConnexion();

    $evenementManager = new  EvenementManager($pdo);
    $msg = new FlashMessages();
    $evenement = new Evenement($_POST['nomEve'], $_POST['lieuEve'], $_POST['dateMiseEnLigneEve'], $_POST['datedebutEve'],
        $_POST['datefinEve'], $_POST['contactEve'], $_POST['prixEve'], $_POST['descriptionEve'], $_SESSION['User']->getId(), $_POST['evenement']);

    $_SESSION['Evenement'] = $evenement;
    $error = array();

    if (!$evenement->getTypePublication()){
        $error[] = "Le type d'évènement est obligatoire";
    }

    if (!$evenementManager->checkNomLieu($evenement->getNom(), $evenement->getLieu())){
        $error[] = "<b>".$evenement->getNom()."</b> est déjà utilisé comme nom d' évènement à <b>".$evenement->getLieu()."</b>";
    }

    if(!file_exists($link) or getFileNumberInFolder($link) == 0){
        $error[] = "<b> L'évènement ne comporte pas d'image, choisissez en une </b>";
    }


    if(count($error)){
        foreach ($error as $erreur){
            $message .= "<b>".$erreur."</b> <br />";
        }
        $msg->error($message);
    }else{
        $tab_file[] = ["typePhoto" => 1, "fileName" => $DOSSIER_UPLOAD.$_SESSION['User']->getPseudo().'/'.$folder_name.'/'.$_SESSION['Evenement_pic']];
        $evenementManager->createEvenement($_SESSION['Evenement'], $tab_file);

        rename($dir_tampom.'/'.$DOSSIER_UPLOAD, $dir_tampom.'/'.$DOSSIER_UPLOAD.$_SESSION['User']->getPseudo() );

        unset($_SESSION['Evenement']);
        unset($_SESSION['Evenement_dir']);
        unset($_SESSION['Evenement_pic']);

        $msg->success('Votre évènement est créé avec succès.', 'index.php');
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
    <link rel="stylesheet" href="dropzone/css/dropzone.css">




</head>
<body>

<?php  include 'include/navbar.php';

?>

<form class="form-horizontal" id="formPub" method="post" role="form"
      action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES); ?>" >
    <?php
    $msg = new FlashMessages();
    $msg->display();
    ?>


        <?php
        $pdo = Connection::getConnexion();
        $req = $pdo->prepare("select * from sous_type_evenement ");
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        ?>



        <div class="form-group">

            <?php


            ?>

            <div class="col-xs-12 col-md-4 col-lg-4">

                <!-- Type evenement -->
                <div class="form-group ">
                    <label class="col-md-5 control-label" >Type évènement</label>
                    <div class="col-md-7">
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

            </div>


            <div class="col-xs-12 col-md-4 col-lg-4">

                <!-- Evenement -->
                <div class="form-group ">
                    <label class="col-md-4 control-label" >Evènement</label>
                    <div class="col-md-7">
                        <select name="evenement" class="form-control">
                            <option value=""> -- Selectionner --</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="col-xs-12 col-md-4 col-lg-4">
                <!-- Nom -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Nom</label>
                    <div class="col-md-7">
                        <input  name="nomEve" value="<?php if(isset($_SESSION['Evenement'])){echo $_SESSION['Evenement']->getNom();} ?>"
                                type="text" placeholder="Nom de l'évènement" required
                                class="form-control input-md" autocomplete="off">
                        <span class="help-block">Ex: Avépozo Party</span>
                    </div>
                </div>
            </div>

        </div>

    <div class="form-group">

        <div class="col-xs-12 col-md-4 col-lg-4">

            <!-- Lieu -->
            <div class="form-group">
                <label class="col-md-5 control-label" for="textinput">Lieu</label>
                <div class="col-md-7">
                    <input  name="lieuEve" value="<?php if(isset($_SESSION['Evenement'])){echo $_SESSION['Evenement']->getLieu();} ?>"
                            type="text" placeholder="Lieu de l'évènement" id="lieuEve" required
                            class="form-control input-md" autocomplete="off" >
                    <span class="help-block">Avépozo Beach</span>
                </div>
            </div>

        </div>

        <div class="col-xs-12 col-md-4 col-lg-4">

            <!-- Entrée -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Entrée</label>
                <div class="col-md-7">
                    <input  name="prixEve" value="<?php if(isset($_SESSION['Evenement'])){echo $_SESSION['Evenement']->getPrix();} ?>"
                            type="text" placeholder="Prix de la party" required
                            class="form-control input-md" autocomplete="off">
                    <span class="help-block">Mettez 0 Si gratuit</span>
                </div>
            </div>

        </div>

        <div class="col-xs-12 col-md-4 col-lg-4">

            <!-- Contact-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Contact</label>
                <div class="col-md-7">
                    <input id="textinput" value="<?php if(isset($_SESSION['Evenement'])){echo $_SESSION['Evenement']->getContact();} ?>"
                           name="contactEve" type="text" autocomplete="off" required
                           placeholder="Contact" class="form-control input-md">
                    <span class="help-block">Tel: 00228 90 97 89 71</span>
                </div>
            </div>

        </div>

    </div>

    <div class="form-group">

        <div class="col-xs-12 col-md-4 col-lg-4">

            <!-- Date de mise en ligne -->
            <div class="form-group">
                <label class="col-md-5 control-label">Date de mise en ligne</label>
                <div class="col-md-7 date">
                    <div class="input-group input-append date" id="dateML">
                        <input id="inputdateML" value="<?php if(isset($_SESSION['Evenement'])){echo $_SESSION['Evenement']->getDatePub();} ?>"
                               type="text" autocomplete="off" required
                               class="form-control" name="dateMiseEnLigneEve" />
                        <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-xs-12 col-md-4 col-lg-4">

            <!-- Date debut -->
            <div class="form-group">
                <label class="col-md-4 control-label">Date début</label>
                <div class="col-md-7 date">
                    <div class="input-group input-append date" id="dateDb">
                        <input type="text" value="<?php if(isset($_SESSION['Evenement'])){echo $_SESSION['Evenement']->getDateDb();} ?>"
                               class="form-control" name="datedebutEve" autocomplete="off" required/>
                        <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-xs-12 col-md-4 col-lg-4">

            <!-- Date Fin -->
            <div class="form-group">
                <label class="col-md-4 control-label">Date fin</label>
                <div class="col-md-7 date">
                    <div class="input-group input-append date" id="dateFin">
                        <input type="text" value="<?php if(isset($_SESSION['Evenement'])){echo $_SESSION['Evenement']->getDateFn();} ?>"
                               class="form-control" autocomplete="off" name="datefinEve" required/>
                        <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>

        </div>


    </div>


    <div class="form-group">

        <div class="col-xs-12 col-md-4 col-lg-4">

            <!-- Description -->
            <div class="form-group">
                <label class="col-md-5 control-label" >Description</label>
                <div class="col-md-7">
                <textarea class="form-control" id="textarea" name="descriptionEve" rows="6" style="resize: none;" required>
                    <?php if(isset($_SESSION['Evenement'])){echo trim($_SESSION['Evenement']->getDesription()); } ?>
                </textarea>
                </div>
            </div>

        </div>

        <div class="col-xs-12 col-md-7 col-lg-7 ">

            <!-- Photo -->
            <div class="form-group ">
                <label class="col-md-5 control-label" >Photo</label>
                <div class="col-md-7 image_upload_div dropzone dz_popop">

                    <?php
                    if($tab){
                        $template = "";
                        foreach ($tab as $fichier){
                            $template = "<img class='media-object img-rounded'   
                         alt='Calentiel' style='height: 325px; width: 325px;' src='$link/$fichier'>";
                        }

                        echo $template;
                    }

                    ?>

                    <?php ?>

                </div>
            </div>

        </div>


    </div>

        <!-- Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" ></label>
            <div class="col-md-8">

                <button
                    type="submit" class="btn btn-success btn-lg btn3d" name="firtsPart" value="continuer">
                    <span class="glyphicon glyphicon-ok"></span> Valider</button>

                <button type="reset" class="btn3d btn btn-danger btn-lg">
                    <span class="glyphicon glyphicon-remove"></span> Annuler</button>
            </div>
        </div>


</form>


<script type="text/javascript" src="dropzone/js/dropzone.js"></script>
<script>
    $(document).ready(function() {


        $(".del").on( "click", function() {

            $.ajax({
                type: 'POST',
                url: 'ajax/upload.php',
                data: {
                    type: 'delete',
                    dossier_temp:  <?php echo $DOSSIER_UPLOAD; ?>,
                    dossier: idForm,
                },
                success:function(data) {
                    $(".image_upload_div").html(data);
                }
            });

        });

        //prevent error: "Error: Dropzone already attached."
        Dropzone.autoDiscover = false;


        $(".image_upload_div").dropzone({

            url: "ajax/upload.php",

            addRemoveLinks: true,
            init: function () {



                /*
                 à chaque ajout de fichier il s'éxécute
                 */
                this.on("addedfile", function(file) {
                    idForm = "Photo_Couverture";
                });

                this.on("queuecomplete", function (file) {

                    $.ajax({
                        type: 'POST',
                        url: 'ajax/upload.php',
                        data: {
                            type: 'read',
                            dossier_temp:  <?php echo $DOSSIER_UPLOAD; ?>,
                            dir: idForm,
                        },
                        success:function(data) {
                            $(".image_upload_div").html(data);
                        }
                    });


                });

                this.on("uploadprogress", function(file, progress) {

                });


            },

            maxFilesize: 2000, // MégaBit
            /*
             Au cas ou l'upload a reussi on transfere le fichier dans son dossier
             */
            success: function (file, response) {

                console.log("Dossier name "+idForm+" file_name "+file.name+" dossier_temp "+<?php echo $DOSSIER_UPLOAD; ?>)

                $.ajax({
                    type: 'POST',
                    url: 'ajax/upload.php',
                    data: {
                        type: 'moveFile',
                        dossier: idForm,
                        dossier_temp:  <?php echo $DOSSIER_UPLOAD; ?>,
                        file_name: file.name,
                    },
                    success:function(data) {

                    }
                });

            },

            /*
             Au cas ou l'upload n'a pas reussi
             */
            error: function (file, response) {
                file.previewElement.classList.add("dz-error");
                $('#up-ack').css('color', 'red').html(response);
            }
        });



        $('select[name="type"]').on('change', function(){
            //console.log("Je change "+$(this).val());
            $.ajax({
                type: "POST",
                url: "ajax/chargement.php",
                data: {
                    id : $(this).val(),
                    type: "Chargement_Evenement",
                },
                success:function(data){
                    $('select[name="evenement"]').html(data);
                }
            });
        });

        $('input[name="nomEve"], input[name="lieuEve"]').on('input', function(){
            $('#formPub').formValidation('revalidateField', 'nomEve');
            $('#formPub').formValidation('revalidateField', 'lieuEve');
        });

        $('input[name="nomEve"], input[name="lieuEve"]').on('focus', function(){
            $('#formPub').formValidation('revalidateField', 'nomEve');
            $('#formPub').formValidation('revalidateField', 'lieuEve');
        });


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
            $('#formPub').formValidation('revalidateField', 'dateMiseEnLigneEve');
            $('#dateDb').data("DateTimePicker").minDate(e.date);
            $('#dateFin').data("DateTimePicker").minDate(e.date);
            });



        $('#dateDb').datetimepicker({
            format: 'DD-MM-YYYY HH:mm',

        }).on('dp.change dp.show', function(e) {
            $('#dateFin').data("DateTimePicker").minDate(e.date);
            $('#formPub').formValidation('revalidateField', 'datedebutEve');
        });


        $('#dateFin')
            .datetimepicker({
            format: 'DD-MM-YYYY HH:mm'
        }).on('dp.change dp.show', function(e) {
            $('#formPub').formValidation('revalidateField', 'datefinEve');
        });


    });


</script>





</body>
</html>
