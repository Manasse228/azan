<?php
include_once 'mvc/controleur/autoload.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pdo = Connection::getConnexion();

$evenementManager = new EvenementManager($pdo);
$photoManager = new PhotosManager($pdo);

$evenement = $evenementManager->getEvenementByUserId($_SESSION['User']->getId());


if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['type'], $_POST['nomEve'], $_POST['lieuEve'], $_POST['prixEve'],
        $_POST['dateMiseEnLigneEve'], $_POST['datedebutEve'], $_POST['datefinEve'], $_POST['contactEve'], $_POST['descriptionEve'], $_POST['updatePubEve']))
) {

    $eve = new Evenement($_POST['updatePubEve'], $_POST['nomEve'], $_POST['lieuEve'], $_POST['dateMiseEnLigneEve'], $_POST['datedebutEve'], $_POST['datefinEve'],
        $_POST['contactEve'], $_POST['prixEve'], $_POST['descriptionEve'], $_SESSION['User']->getId(), $_POST['type']);

    $evenementManager->updateEvenement($eve);
    $msg = new FlashMessages();
    $msg->success('Votre évènement est modifié avec succes! ', 'mesPublications.php');
}


?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Mes publications</title>

    <?php include 'include/headerfile.php' ?>

    <link href="css/login.css" rel="stylesheet">


    <script type="text/javascript" src="js/moment.min.js"></script>

    <link href="css/bootstrap-datetimepicker.css" rel="stylesheet"/>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>


    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.0/css/select.dataTables.min.css">

</head>
<body>


<?php include 'include/navbar.php' ?>

<?php

$msg = new FlashMessages();
$msg->display();


?>

<div class="row" style="margin-top: 80px">


    <div class="form-group">
        <label class="col-md-3 control-label"></label>
        <div class="col-md-9 ">

            <button type="reset" class="btn3d btn btn-danger btn-lg" id="btnDelete" disabled="true"
                    data-toggle="confirmation">
                <span class="glyphicon glyphicon-trash"></span>Supprimer
            </button>
        </div>
    </div>


    <table id="example" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Photo</th>
            <th>Lieu</th>
            <th>Entrée</th>
            <th>Type</th>
            <th>Date de mise en ligne</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th>Modifier</th>
        </tr>
        </thead>
        <tbody>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES); ?>">
            <?php
            for ($i = 0; $i < sizeof($evenement); $i++) {
                ?>
                <tr>
                    <td><?php echo $evenement[$i]->getNom(); ?></td>
                    <td>
                        <img height="100" width="100"
                             src="images/<?php echo $photoManager->getPhotoRepById($evenement[$i]->getId())->getLien(); ?>">

                    </td>
                    <td><?php echo $evenement[$i]->getLieu(); ?></td>
                    <td><?php if ($evenement[$i]->getPrix() == 0) {
                            echo "Gratuite";
                        }else{ echo $evenement[$i]->getPrix(); } ?></td>
                    <td><?php echo $evenementManager->getTypeById($evenement[$i]->getTypePublication()); ?></td>
                    <td><?php echo date("d-m-Y", strtotime($evenement[$i]->getDatePub())); ?></td>
                    <td><?php echo date("d-m-Y H:i", strtotime($evenement[$i]->getDateDb())); ?></td>
                    <td><?php echo date("d-m-Y H:i", strtotime($evenement[$i]->getDateFn())); ?></td>

                    <td>

                        <?php if ($evenement[$i]->getDatePub() > date("Y-m-d")) { ?>
                            <!-- && $evenement[$i]->getDateFn() < date("Y-m-d") -->
                            <button name="updatePub" value="<?php echo $evenement[$i]->getId(); ?>"
                                    id="updatePub" href="#updateEve" data-toggle="modal"
                                    data-id="<?php echo $evenement[$i]->getId(); ?>>"
                                    class="btn btn-sm btn-primary glyphicon glyphicon-pencil">
                            </button>

                        <?php } ?>

                    </td>
                </tr>
            <?php } ?>

        </form>


        </tbody>
        <tfoot>
        <tr>
            <th>Nom</th>
            <th>Photo</th>
            <th>Lieu</th>
            <th>Entrée</th>
            <th>Type</th>
            <th>Date de mise en ligne</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th>Modifier</th>
        </tr>
        </tfoot>
    </table>


    <div class="modal fade " id="updateEve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" style="z-index: 3000;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Modification d'évènement</h4>
                </div>

                <div class="modal-body">

                    <form class="form-horizontal" id="formPub" method="post" role="form" autocomplete="off"
                          action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES); ?>">
                        <fieldset>

                            <?php

                            $pdo->beginTransaction();
                            $req = $pdo->prepare("select * from typeevenement ");
                            $req->execute();
                            $pdo->commit();
                            $result = $req->fetchAll(PDO::FETCH_ASSOC);
                            ?>


                            <!-- Type evenement -->
                            <div class="form-group">
                                <label class="col-md-4 control-label">Type événement</label>
                                <div class="col-md-4">
                                    <select name="type" class="form-control">
                                        <option value="">-- Selectionner --</option>
                                        <?php
                                        foreach ($result as $value) {
                                            echo "<option value=" . $value['id'] . ">" . $value['libelle'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Nom -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="textinput">Nom</label>
                                <div class="col-md-6">
                                    <input name="nomEve" value=""
                                           type="text" placeholder="Nom de l'évènement"
                                           class="form-control input-md" autocomplete="off">
                                    <span class="help-block">Ex: Avépozo Party</span>
                                </div>
                            </div>


                            <!-- Lieu -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="textinput">Lieu</label>
                                <div class="col-md-6">
                                    <input name="lieuEve"
                                           type="text" placeholder="Lieu de l'évènement"
                                           class="form-control input-md" autocomplete="off">
                                    <span class="help-block">Avépozo Beach</span>
                                </div>
                            </div>

                            <!-- Entrée -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="textinput">Entrée</label>
                                <div class="col-md-8">
                                    <input name="prixEve"
                                           type="text" placeholder="Prix de la party"
                                           class="form-control input-md" autocomplete="off">
                                    <span class="help-block">Mettez 0 Si gratuit</span>
                                </div>
                            </div>


                            <!-- Date de mise en ligne -->
                            <div class="form-group">
                                <label class="col-md-4 control-label">Date de mise en ligne</label>
                                <div class="col-md-8 date">
                                    <div class="input-group input-append date" id="dateML">
                                        <input type="text" autocomplete="off"
                                               class="form-control" name="dateMiseEnLigneEve"/>
                                        <span class="input-group-addon add-on"><span
                                                class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                            </div>


                            <!-- Date debut -->
                            <div class="form-group">
                                <label class="col-md-4 control-label">Date début</label>
                                <div class="col-md-8 date">
                                    <div class="input-group input-append date" id="dateDb">
                                        <input type="text"
                                               class="form-control" name="datedebutEve" autocomplete="off"/>
                                        <span class="input-group-addon add-on"><span
                                                class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Date Fin -->
                            <div class="form-group">
                                <label class="col-md-4 control-label">Date fin</label>
                                <div class="col-md-8 date">
                                    <div class="input-group input-append date" id="dateFin">
                                        <input type="text"
                                               class="form-control" autocomplete="off" name="datefinEve"/>
                                        <span class="input-group-addon add-on"><span
                                                class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact-->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="textinput">Contact</label>
                                <div class="col-md-6">
                                    <input id="textinput"
                                           name="contactEve" type="text" autocomplete="off"
                                           placeholder="Contact" class="form-control input-md">
                                    <span class="help-block">Tel: 00228 90 97 89 71 / Monsieur Cedric</span>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label class="col-md-4 control-label">Description</label>
                                <div class="col-md-4">
                                    <textarea class="form-control" name="descriptionEve"
                                              id="idDescriptionEve"></textarea>
                                </div>
                            </div>

                            <!-- Button -->
                            <div class="form-group">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-8">


                                    <button
                                        type="submit" class="btn btn-primary btn-lg btn3d" name="updatePubEve"
                                        value="modifierEvenement">
                                        <span class="glyphicon glyphicon-pencil"></span> Modifier
                                    </button>

                                    <button type="reset" class="btn3d btn btn-danger btn-lg">
                                        <span class="glyphicon glyphicon-remove"></span> Annuler
                                    </button>
                                </div>
                            </div>

                        </fieldset>
                    </form>


                </div>

                <!-- <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                     <button type="button" class="btn btn-primary">Modifier</button>
                 </div> -->

            </div>
        </div>
    </div>

    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>

    <script type="text/javascript"
            src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>

    <script type="text/javascript"
            src="https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js"></script>

    <script type="text/javascript"
            src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>

    <script type="text/javascript" src="js/bootstrap-tooltip.js"></script>
    <script type="text/javascript" src="js/bootstrap-transition.js"></script>
    <script type="text/javascript" src="js/bootstrap-confirmation.min.js"></script>

    <script type="text/javascript">


        $(document).ready(function () {


            $('#dateML').datetimepicker({
                format: 'DD-MM-YYYY',
                minDate: new Date()
            }).on('dp.change dp.show', function (e) {
                $('#dateDb').data("DateTimePicker").minDate(e.date);
                $('#dateFin').data("DateTimePicker").minDate(e.date);
                $('#form').formValidation('revalidateField', 'dateMiseEnLigneEve');
            });


            $('#dateDb').datetimepicker({
                format: 'DD-MM-YYYY HH:mm',
            }).on('dp.change dp.show', function (e) {
                $('#dateFin').data("DateTimePicker").minDate(e.date);
                $('#form').formValidation('revalidateField', 'datedebutEve');
            });


            $('#dateFin')
                .datetimepicker({
                    format: 'DD-MM-YYYY HH:mm'
                }).on('dp.change dp.show', function (e) {
                $('#form').formValidation('revalidateField', 'datefinEve');
            });


            $('#updateEve').on('show.bs.modal', function (e) {
                var rowid = $(e.relatedTarget).data('id');
                console.log("Resultat " + rowid);
                $.ajax({
                    type: 'post',
                    datatype: 'JSON',
                    url: 'ajax/verif.php', //Here you will fetch records
                    data: 'rowid=' + rowid, //Pass $id
                    success: function (data) {
                        var obj = JSON.parse(data);
                        // console.log(obj.Evenement[0].lieueve + " " + obj.Evenement[0].datedbeve);
                        //console.log(obj.Evenement[0].description);
                        var parts = obj.Evenement[0].datepubeve.split('-');


                        $('button[name="updatePubEve"]').val(obj.Evenement[0].id);

                        $('input[name="nomEve"]').val(obj.Evenement[0].nomeve);
                        $('input[name="lieuEve"]').val(obj.Evenement[0].lieueve);
                        $('input[name="prixEve"]').val(obj.Evenement[0].prix);
                        $('input[name="dateMiseEnLigneEve"]').val(parts[2] + '-' + parts[1] + '-' + parts[0]);
                        $('input[name="datedebutEve"]').val(dateFormat(obj.Evenement[0].datedbeve));
                        $('input[name="datefinEve"]').val(dateFormat(obj.Evenement[0].datefneve));
                        $('input[name="contactEve"]').val(obj.Evenement[0].contact);
                        $('#idDescriptionEve').val(obj.Evenement[0].description);
                    }
                });


            });

            var table = $('#example').DataTable({
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function (row) {
                                var data = row.data();
                                return 'Détail de: ' + data[0];
                                //return 'Détail de: '+data[0]+' '+data[1];
                            }
                        }),
                        renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                            tableClass: 'table'
                        })
                    }
                },
                select: {
                    style: 'single'
                }
            });


            var rowData;
            table
                .on('select', function (e, dt, type, indexes) {
                    // console.log(table.rows(indexes).data().toArray()[0]);
                    rowData = table.rows(indexes).data().toArray();
                    // console.log(JSON.stringify( rowData ));
                    $("#btnDelete").removeAttr("disabled");

                })
                .on('deselect', function (e, dt, type, indexes) {
                    var rowData = table.rows(indexes).data().toArray();
                    $("#btnDelete").attr("disabled", "disabled");
                });

            $('[data-toggle="confirmation"]').confirmation({

                singleton: true,
                onConfirm: function (e) {

                    var nom=rowData[0][0], lieu=rowData[0][2];
                    $.ajax({
                        type: 'post',
                        datatype: 'JSON',
                        url: 'ajax/verif.php',
                        data: {rowNom:  nom  , rowLieu: lieu },
                        success: function (data) {
                            console.log(data);
                        },
                    });
                }
            });

        });

        function dateFormat(date) {
            var parts = date.split(' '), part1 = parts[0], part2 = parts[1];
            part1 = part1.split('-');
            part2 = part2.split(':');
            return part1[2] + '-' + part1[1] + '-' + part1[0] + ' ' + part2[0] + ':' + part2[1];
        }

    </script>


</body>
</html>
