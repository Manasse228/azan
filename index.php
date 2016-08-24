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

    <link href="css/searchEvenement.css" rel="stylesheet">
    <link href="css/daterangepicker.css" rel="stylesheet">

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

    <style type="text/css">
        .demo {
            position: relative;
        }

        .demo i {
            position: absolute;
            bottom: 10px;
            right: 24px;
            top: auto;
            cursor: pointer;
        }


    </style>


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

            <div class="col-lg-9 col-md-9 col-xs-12">
                <div class="col-md-4 col-md-offset-4 demo">
                    <input type="text" id="config-demo" class="form-control">
                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>

                </div>

            </div>

            <div class=" col-md-3 col-lg-3  col-xs-12 demo">

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




<script type="text/javascript" src="js/moment.min.js"></script>
<script type="text/javascript" src="js/daterangepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var startDate=moment().subtract(29, 'days').format('YYYY-MM-DD'), endDate=moment().format('YYYY-MM-DD');

        $('.demo i').click(function () {
            $(this).parent().find('input').click();
        });
        updateConfig();

        function updateConfig() {
            var options = {};
            options.startDate = moment().subtract(29, 'days');
            options.endDate = moment();
            options.opens = "center";
            options.ranges = {
                'Aujourd\' hui': [moment(), moment()],
                'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Les 7 derniers jours': [moment().subtract(6, 'days'), moment()],
                'Les 30 derniers jours': [moment().subtract(29, 'days'), moment()],
                'Ce mois ci': [moment().startOf('month'), moment().endOf('month')],
                'Le mois dernier': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            };

            $('#config-demo').daterangepicker(options, function (start, end, label) {
                startDate = start.format('YYYY-MM-DD');
                endDate = end.format('YYYY-MM-DD');
                passDate(startDate, endDate);
            });

        }



        function passDate(startDate, endDate) {
            $('.loader').show();
            $.ajax({
                    type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    url: 'ajax/date-filteration.php', // the url where we want to POST
                    data: 'startDate=' + startDate + '&endDate=' + endDate + '&type=' + $('select[name="type"]').val(), // our data object
                })
                // using the done promise callback
                .done(function (data) {
                    $('.loader').hide();
                    // log data to the console so we can see
                    $('.response').html(data);
                    // here we will handle errors and validation messages
                });
        }


    });

</script>

</body>
</html>
