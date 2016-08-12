<?php
include_once 'mvc/controleur/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


/*var_dump($_COOKIE);

if (isset($_COOKIE['Nefertiti'])) {
    parse_str($_COOKIE['Nefertiti']);
//echo "on la vue";
    echo $pseudo;
} */


if ( ($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['login'], $_POST['password'])) ) {

    $pdo = Connection::getConnexion();
    $userManager = new UserManager($pdo);
    if ($client = $userManager->checkLogin($_POST['login'], $_POST['password'])) {
        $_SESSION['User'] = $client;

        /*  if (isset($_POST['autoconnect']) && ($_POST['autoconnect'] == 'yes') ) {

   setcookie("Nefertiti", 'rci='.$_POST['login'].'&egypte='.md5($_POST['password']).'&togo=0&email='.$client->getEmail(),
       time()+3600*24*10, "/", '/azan/', false, false);

              ini_set('display_errors', 1);
              ini_set('display_startup_errors', 1);
              error_reporting(E_ALL);

              echo "Sa passe";
          } */

    } else {
        $msg = new FlashMessages();
        $msg->error('Login ou mot de passe erroné ! ');
        $msg->display();
    }

}


?>

<nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href=".">Calentiel</a>
        </div>


        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav">

                <li class="active"><a href=".">Acceuil</a></li>
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown">Compte <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="updateAccount.php">Modifier profil</a></li>
                        <li><a href="" data-toggle="modal"
                               data-target="#modificationPassword">Modifier mot de passe</a></li>
                    </ul>
                </li>


                <li class="dropdown">
                    <a href="#" " data-toggle="dropdown">Evenement <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="nvoeve.php">Publier</a></li>
                        <li><a href="searcheve.php">Recherche</a></li>
                        <li class="divider"></li>
                        <li><a href="mesPublications.php">Mes publications</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" " data-toggle="dropdown">Guide<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Utilisateur</a></li>
                        <li><a href="#">Aide</a></li>
                    </ul>
                </li>

                <li><a href="contact.php">Contact</a></li>

            </ul>


            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Login</b> <span class="caret"></span></a>
                    <ul id="login-dp" class="dropdown-menu">
                        <li>
                            <div class="row">
                                <div class="col-md-12">
                                    <!--   Connexion via
                                      <div class="social-buttons">
                                     !-- <a href="#" class="btn btn-fb"><i class="fa fa-facebook"></i> Facebook</a>
                                          <a href="#" class="btn btn-tw"><i class="fa fa-twitter"></i> Twitter</a>
                                    </div>
                                    ou -->

                                    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES); ?>"
                                          class="form" role="form" method="post" accept-charset="UTF-8" id="login_form">

                                        <div class="form-group">
                                            <label class="sr-only" for="login">Email addresse</label>
                                            <input type="text" class="form-control" autocomplete="off" id="login"
                                                   placeholder="Adresse Email / Pseudo" required name="login">
                                        </div>

                                        <div class="form-group">
                                            <label class="sr-only" for="password">Mot de passe</label>
                                            <input type="password" class="form-control" name="password"
                                                   placeholder="Mot de passe" required autocomplete="off">
                                            <div class="help-block text-right"><a href="" data-toggle="modal"
                                                                                  data-target="#myModal">Mot de passe
                                                    oublié?</a>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button name="signin" value="login"
                                                    type="submit" class="btn btn-primary btn-block">Login
                                            </button>
                                        </div>

                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="autoconnect" value="yes"> Se souvenir de
                                                moi
                                            </label>
                                        </div>

                                    </form>
                                </div>
                                <div class="bottom text-center">
                                    <a href="inscription.php"><b>Inscription</b></a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>

                <li><a href="mvc/controleur/deconnexion.php"><span class="glyphicon glyphicon-log-out"></span>Deconnexion</a>
                </li>

            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>


<!-- Modal mot de passe oublié-->
<form id="recuperation_password" method="post" class="form-horizontal">
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Récupération de mot de passe</h4>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-12 col-md-12 col-lg-12">
                                <input autocomplete="off" class="form-control"
                                       name="emailVerif" placeholder="Votre Adresse email"
                                       type="email"/>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Récupérer</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modification mot de passe oublié-->
<form id="modification_password" method="post" class="form-horizontal">
    <div class="modal fade" id="modificationPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Modification de mot de passe</h4>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-12 col-md-12 col-lg-12">
                                <input autocomplete="off" class="form-control"
                                       name="oldPassword" placeholder="Mot de passe actuel"
                                       type="password"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-12 col-md-12 col-lg-12">
                                <input autocomplete="off" class="form-control"
                                       name="newPassword" placeholder="Nouveau mot de passe"
                                       type="password"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-12 col-md-12 col-lg-12">
                                <input autocomplete="off" class="form-control"
                                       name="newPassword2" placeholder="Nouveau mot de passe (Verification)"
                                       type="password"/>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Récupérer</button>
                </div>
            </div>
        </div>
    </div>
</form>


