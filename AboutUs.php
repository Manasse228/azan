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

    <script type="text/css" >

        .fadeInUp {
            -webkit-animation-name: fadeInUp;
            animation-name: fadeInUp;
        }

    </script>

</head>
<body>

<?php include_once 'include/navbar.php';



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


?>


<div class="row" style="margin-top: 80px">


    <div class="row">
        <div class="col-md-12 ">
            <h1 class="page-header text-center"> Voici un peu ce que c'est Calentiel </h1>


                        <h3>Description</h3>
                        <p style="font-size: 20px">
                            Calentiel est une plateforme de promotion d'événements culturels. C'est un nouvel outil
                            qui offre une nouvelle approche plus esthétique, plus dynamique, plus pratique et plus
                            professionnelle de la présentation et gestion d'événements de tous genres; de la politique
                            aux soirées mondaines en passant par les promotions et les foires; tout type d'événement y est présenté.
                            Cet outil ergonomique met en relation l'organisateur et ses potentiels participants.
                            L'organisateur a en outre la possibilité de savoir approximativement le nombre de
                            participants ce qui l'aide dans une gestion efficiente de son activité.
                            Le participant à accès à tout types d'événements publics couvrant l'année, accès
                            aux contacts pour connaitre les modalités de participation et peux choisir d'y participer.
                            Le parfait outil pour la relation organisateurs participants
                        </p>




        </div>
    </div>
</div>


</div>



</body>
</html>
