<?php
include_once 'mvc/controleur/autoload.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['btnNveEve'] == 'btnValNveEve') {

    if (isset($_SESSION['User'])) {
        Utilities::POST_redirect('nvoeve.php');
    } else {
        Utilities::POST_redirect('inscription.php');
    }

}


?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Acceuil</title>

    <?php include 'include/headerfile.php' ?>

    <link href="css/login.css" rel="stylesheet">


    <!-- Include events calendar css file -->
    <link rel="stylesheet" href="tiva/assets/css/calendar.css">
    <link rel="stylesheet" href="tiva/assets/css/calendar_full.css">
    <link rel="stylesheet" href="tiva/assets/css/calendar_compact.css">

    <!-- Include config file -->
    <script src="tiva/config/config.js"></script>

    <!-- Include events calendar language file -->
    <script src="tiva/assets/languages/en.js"></script>

    <!-- Include events calendar js file -->
    <script src="tiva/assets/js/calendar.js"></script>


</head>
<body>


<?php include 'include/navbar.php' ?>

<?php

$msg = new FlashMessages();
$msg->display();
?>


<div class="row" style="margin-top: 80px">

    <div class="container">
        <div class="row">

            <div class="col-md-offset-9 col-md-3 col-lg-offset-9 col-lg-3  col-xs-12 ">

                <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES); ?>" method="post">
                    <button
                        class="btn btn-danger btn-lg " name="btnNveEve" value="btnValNveEve">
                        <span class="glyphicon glyphicon-plus"></span> Créer un nouveau évènement
                    </button>
                </form>

            </div>


        </div>
    </div>

    <div class="tiva-events-calendar full" data-source="php"></div>

</div>


</body>
</html>
