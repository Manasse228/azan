<?php
include_once 'mvc/controleur/autoload.php';
session_start();
$DOSSIER_UPLOAD = $_SESSION['Evenement_dir'];
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Publier un évènement (suite 12) </title>

    <?php include 'include/headerfile.php' ?>


    <link href="css/upload.css" rel="stylesheet"/>

    <link rel="stylesheet" href="css/pulierArticle.css">
    <link rel="stylesheet" href="dropzone/css/dropzone.css">


    <script type="text/javascript" src="js/upload.js"></script>

</head>
<body>


<?php include 'include/navbar.php' ;



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



?>

<div class="form-group image_upload_div">

    <div class="col-xs-12 col-md-3 col-lg-3 dropzone dz_popop"  id="photo_couverture">
        <p>Photo d'affiche</p>
        <img class="media-object img-rounded"   alt="Calentiel" style="height: 200px; width: 325px;" src="images/2a609685dc5cbf04df807f0e8ee0f681.png">
    </div>


    <div class="col-xs-12 col-md-9 col-lg-9 dropzone dz_popop" id="autres">
        <p>Autres photos</p>

        <div class="form-group">

            <div class="col-xs-12 col-md-4 col-lg-4">
                <img class="media-object img-rounded"   alt="Calentiel" style="height: 200px; width: 325px;" src="images/2a609685dc5cbf04df807f0e8ee0f681.png">
            </div>

            <div class="col-xs-12 col-md-4 col-lg-4">
                <img class="media-object img-rounded"   alt="Calentiel" style="height: 200px; width: 325px;" src="images/2a609685dc5cbf04df807f0e8ee0f681.png">
            </div>

            <div class="col-xs-12 col-md-4 col-lg-4">
                <img class="media-object img-rounded"   alt="Calentiel" style="height: 200px; width: 325px;" src="images/2a609685dc5cbf04df807f0e8ee0f681.png">
            </div>

        </div>




    </div>

</div>


<script type="text/javascript" src="dropzone/js/dropzone.js"></script>
<script type="text/javascript" >


    $(document).ready(function () {



        function initialisation_Delete_Btn() {
            $(".pjdelbtn").unbind("click" );
            $(".pjdelbtn").on( "click", function() {
                $(".pjdelbtn").unbind('click');
                /*
                 * Pour obtenir le nom du fichier on remplace les espaces par les underscore
                 * ce qui était fait tout en haut et puis nous essayons d'obtenir le nom du fichier en
                 * remplacant les underscore par les espace et enlever le mot deletep_..
                 */

                var get_file_name = $(this).attr('id').substring(8, $(this).attr('id').length );
                if( $(this).attr('id').substring(8, $(this).attr('id')) != "deletep_" ){
                    var all_id =  replaceAll($(this).attr('id'), '_', ' ');
                    get_file_name = all_id.substring(9, all_id.length);
                    // console.log("dans ce cas nouveau fichier");
                }

                /*Supprimer une image du serveur et
                 du front en cliquant sur le lien delete
                 */
                var dossier_jaune = getDj();

                var idForm = $(this).parent().parent().parent().attr('id');
                var foldername = idForm.substr(4, idForm.length);

                //console.log("Folder name "+foldername);

                $.ajax({
                    type: 'POST',
                    url: 'dj_detail_pj_upload.php',
                    data: {
                        file: get_file_name,
                        current_dir : foldername,
                        type: 'delete',
                        id_dj: getIdDj(),
                        dossier_id_dj : dossier_jaune,
                    },
                    success:function(data) {
                        //console.log("Delete "+data)
                        $(".div_dj_id").html(data);
                        initialisation_Delete_Btn();
                        fresh();
                        delte_space_css();
                    }
                });
                $(this).parent().remove();

            });
        }



        //prevent error: "Error: Dropzone already attached."
        Dropzone.autoDiscover = false;


        $(".dropzone").dropzone({

            url: "ajax/upload.php",

            addRemoveLinks: true,
            init: function () {



                /*
                 à chaque ajout de fichier il s'éxécute
                 */
                this.on("addedfile", function(file) {

                    idForm = $(this.element).attr('id');
                    console.log("je suis à "+idForm);


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
                            $("#"+idForm).html(data);
                            console.log("contenu "+data);
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








    });




</script>

</body>
</html>
