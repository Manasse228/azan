<?php
include_once 'mvc/controleur/autoload.php';
session_start();


    $pdo = Connection::getConnexion();
    $req = $pdo->prepare("select * from sous_type_evenement ");
    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Recherche d évènement</title>

    <?php include 'include/headerfile.php' ?>

    <link href="css/searchEvenement.css" rel="stylesheet">
    <link href="css/daterangepicker.css" rel="stylesheet">

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

         .day {
            display: block;
            font-size: 56pt;
            font-weight: 100;
            line-height: 1;
        }

        .month {
            display: block;
            font-size: 24pt;
            font-weight: 900;
            line-height: 1;
        }

        .time{
            display: inline-block;
            width: 100%;
            color: rgb(255, 255, 255);
            background-color: rgb(197, 44, 102);
            padding: 5px;
            text-align: center;
            text-transform: uppercase;
        }

    </style>

</head>
<body>


<?php include 'include/navbar.php' ?>





<!-- Wrap all page content here -->
<div id="wrap">

    <div class="container">

        <?php

        $msg = new FlashMessages();

        echo "";
        $msg->display();
        ?>

        <div class="form-group">
            <h3 class="text-center">Recherche d'évènement</h3>

            <div class="col-lg-4 col-md-4 col-xs-12 ">
                <select name="type" class="form-control" >
                    <option value="">---- Type événement ----</option>
                    <?php
                    foreach ($result as $value) {
                        echo "<option value=" . $value['id'] . ">" . $value['libelle'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="col-lg-4 col-md-4 col-xs-12 ">
                <select name="evenement" class="form-control">
                    <option value=""> -- Evènement --</option>
                </select>
            </div>


            <div class="col-lg-4 col-md-4 col-xs-12 demo">
                <input type="text" id="config-demo" class="form-control">
                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
            </div>

        </div>
        <div class="col-lg-1 col-md-1 col-sm-1"></div>
    </div>

    <hr>
    <div class="row">
        <div class="col-lg-1 col-md-1 col-sm-1"></div>
        <div class="col-lg-10 col-md-10 col-sm-10">
            <div class="loader text-center" style="display:none"><img src="images/res/loading.gif"></div>

            <div class="response"></div>

        </div>
        <div class="col-lg-1 col-md-1 col-sm-1"></div>
    </div>
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
                data: 'startDate=' + startDate + '&endDate=' + endDate + '&type=' + $('select[name="type"]').val() + '&eve=' + $('select[name="evenement"]').val() , // our data object
            })
            // using the done promise callback
            .done(function (data) {
                $('.loader').hide();
                // log data to the console so we can see
                $('.response').html(data);
                // here we will handle errors and validation messages
            });
    }

        $(' select[name="type"] , select[name="evenement"] ').on('change', function() {

            //console.log("je danse "+startDate);

            $('.loader').show();
            $.ajax({
                    type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    url: 'ajax/date-filteration.php', // the url where we want to POST
                    data: 'startDate=' + startDate + '&endDate=' + endDate + '&type=' + $('select[name="type"]').val() + '&eve=' + $('select[name="evenement"]').val() , // our data object
                })
                // using the done promise callback
                .done(function (data) {
                    $('.loader').hide();
                    // log data to the console so we can see
                    $('.response').html(data);
                    // here we will handle errors and validation messages
                });

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



    });

</script>


</body>
</html>
