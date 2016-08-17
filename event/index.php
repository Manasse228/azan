<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ((isset($_GET['azan'])) AND ((int)$_GET['azan'] != 0)) {
    include_once '../mvc/controleur/autoload.php';
    $id = $_GET['azan'];
    $pdo = Connection::getConnexion();

    $msg = new FlashMessages();

    $evenementManager = new EvenementManager($pdo);
    $evenement = $evenementManager->getEvenementById($id, "");

    $dateDebut = $evenement->getDateDb();
    //var_dump($dateDebut);


    $userManager = new UserManager($pdo);
    $user = $userManager->getUserById($evenement->getUser());

    $photoManager = new PhotosManager($pdo);
    $photos = $photoManager->getPhotosById($evenement->getId());

    $spon = 0;
    for ($i = 0; $i < sizeof($photos); $i++) {

        if ($photos[$i]->getTypePhoto() == 3) {
            $spon++;
        }
    }

} else {
    header('Location: ../searcheve.php');
}

if (($_SERVER['REQUEST_METHOD'] == "POST") && (isset($_POST['name'], $_POST['email'], $_POST['message']))
    && $_POST['envoiEmail'] == "envoyer"
) {


    $to = trim($user->getEmail());
    $name = trim(stripslashes($_POST['name']));
    $email = trim(stripslashes($_POST['email']));
    $message = trim(stripslashes($_POST['message']));
    $subject = "Demande de renseignement [ " . $evenement->getNom() . " ]";


    $headers = 'From: ' . $name . '<contact@calentiel.info>' . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    // $headers = 'From: '.$name.'' . "\r\n" . 'Reply-To: '.$email.'' . "\r\n" . 'X-Mailer: PHP/' . phpversion();


    $message .= "<br /> Voici l'email de l'expéditeur ".$email."<br/> PS: Ne répondait pas à cet email";
    mail($to, $subject, $message, $headers);


   // $msg->success("Votre message a été envoyé avec succès! L'organisateur vous contactera dans les moindres délais");


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $evenement->getNom(); ?></title>

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <!--  <link rel="shortcut icon" href="images/ico/favicon.ico">
      <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
      <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png"> -->

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
            integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
            crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/TimeCircles.css"/>
</head><!--/head-->

<body>
<header id="header" role="banner">
    <div class="main-nav">
        <div class="container">

            <div class="row">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="scroll active"><a href="#home">Home</a></li>
                        <li class="scroll"><a href="#explore">Decompte</a></li>
                        <li class="scroll"><a href="#about">Description</a></li>

                        <?php if ($spon != 0) { ?>
                            <li class="scroll"><a href="#sponsor">Sponsor</a></li> <?php } ?>

                        <li class="scroll"><a href="#contact">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<!--/#header-->

<section id="home">
    <div id="main-slider" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#main-slider" data-slide-to="0" class="active"></li>
            <li data-target="#main-slider" data-slide-to="1"></li>
            <li data-target="#main-slider" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">

            <?php
            $j = 0;

            for ($i = 0;
            $i < sizeof($photos);
            $i++) {

            if ($photos[$i]->getTypePhoto() == 1) {
            $j++;
            $str = ($j == 1) ? '<div class="item active">' : '<div class="item">';
            echo $str;
            ?>

            <img class="img-responsive" alt="slider" style="height: 1000px; "
                 src="../images/<?php echo $photos[$i]->getLien(); ?>">
            <div class="carousel-caption">
                <h4><?php echo $evenement->getNom(); ?></h4>
            </div>
        </div>
        <?php
        }
        }
        ?>
    </div>
    </div>

</section>
<!--/#home-->

<?php
//$msg = new FlashMessages();
//$msg->display();
?>

<section id="explore">
    <div class="container">
        <div class="row">
            <div class="watch">
                <img class="img-responsive" src="images/watch.png" alt="">
            </div>
            <div class="col-md-4 col-md-offset-2 col-sm-5">
                <h2></h2>
            </div>
            <div class="col-sm-7 col-md-6">

                <div id="DateCountdown" data-date="<?php echo $evenement->getDateFn(); ?> "
                     style="width: 500px; height: 125px; padding: 0px; box-sizing: border-box; background-color: #C34C39"></div>


            </div>
        </div>
        <div class="cart">
            <a href="../index.php"><i class="fa fa-home"></i> <span>Acceuil</span></a>
        </div>
    </div>
</section><!--/#explore-->


<section id="about">
    <div class="guitar2">
        <img class="img-responsive" src="images/guitar2.jpg" alt="guitar">
    </div>
    <div class="about-content">
        <h2>Description</h2>
        <p><?php echo $evenement->getDesription(); ?></p>

    </div>
</section><!--/#about-->

<?php
if ($spon != 0) {
    ?>
    <section id="sponsor">
        <?php include 'include/sponsor.php' ?>
    </section><!--/#sponsor-->
    <?php
}
?>

<section id="contact">

    <div class="contact-section">
        <div class="ear-piece">
            <img class="img-responsive" src="images/ear-piece.png" alt="">
        </div>
        <?php include 'include/contact.php' ?>
    </div>
</section>
<!--/#contact-->

<footer id="footer">
    <div class="container">
        <div class="text-center">
            <p> Copyright &copy;<?php echo date("Y"); ?><a href="."> Calentiel </a> All Rights Reserved.
            </p>
        </div>
    </div>
</footer>
<!--/#footer-->


<script type="text/javascript" src="js/smoothscroll.js"></script>
<script type="text/javascript" src="js/jquery.parallax.js"></script>
<script type="text/javascript" src="js/jquery.scrollTo.js"></script>
<script type="text/javascript" src="js/jquery.nav.js"></script>

<script type="text/javascript" src="js/main.js"></script>

<script type="text/javascript" src="js/TimeCircles.js"></script>

<script>

    $("#DateCountdown").TimeCircles();

</script>

</body>
</html>