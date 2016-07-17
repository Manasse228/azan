<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Inscription</title>

    <?php include 'include/headerfile.php' ?>

    <link rel="stylesheet" href="css/inscription.css"/>

    <link rel="stylesheet" href="css/formValidation.min.css">

    <script type="text/javascript" src="js/formValidation.min.js"></script>
    <script type="text/javascript" src="js/formvalidationbootstrap.min.js"></script>
    <script type="text/javascript" src="js/formValidation.js"></script>

</head>
<body>

<?php include 'include/navbar.php' ?>

<div class="box ">
    <fieldset>
        <legend id="text">Inscription</legend>

        <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES); ?>"
              autocomplete="off" method="post" id="inscription_form" class="form-horizontal">


            <div class="row">
                <div class="form-group">
                    <div class="col-xs-12 col-md-8 col-lg-8">
                        <input required autocomplete="off"
                               class="form-control" name="pseudo" placeholder="Pseudo" type="text"/>

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


            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">@</span>
                    <input type="email"
                           required autocomplete="off"
                           class="form-control" name="email" placeholder="Adresse Email"/>
                </div>

            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input class="form-control"
                           autocomplete="off" required name="password" placeholder="Mot de passe" type="password"/>
                </div>
            </div>


            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input class="form-control"
                           autocomplete="off" required name="password2" placeholder="Verification du mot de passe"
                           type="password"/>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-8 col-lg-8">
                    <button name="inscription" value="submit" class="btn btn-lg btn-primary btn-block" type="submit">
                        <span class="glyphicon glyphicon-floppy-save"></span> Inscription
                    </button>
                </div>
                <div class="col-xs-12 col-md-4 col-lg-4">
                    <button type="reset" class="btn btn-lg btn-primary btn-block btn-danger">Annuler</button>
                </div>
            </div>

        </form>


    </fieldset>


</div>


</body>
</html>

