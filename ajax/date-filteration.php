<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../mvc/controleur/autoload.php';

$pdo = Connection::getConnexion();


if ((!empty($_POST['startDate']) && (!empty($_POST['endDate'])))) {    // Check whether the date is empty
    $startDate = date('Y-m-d', strtotime($_POST['startDate']));
    $endDate = date('Y-m-d', strtotime($_POST['endDate']));

    //var_dump($_POST);

    if (!empty($_POST['type'])) {
        // echo $_POST['type'];
        $sql = "SELECT * FROM evenement WHERE idtype = '" . $_POST['type'] . "'  AND datepubeve <= now()
        and datefneve >= now() and datedbeve BETWEEN  '" . $startDate . "' AND '" . $endDate . "' ";

    } else {
        $sql = "SELECT * FROM evenement WHERE datepubeve <= now() and datefneve >= now() and datedbeve BETWEEN  '" . $startDate . "' AND '" . $endDate . "' ";
    }
    $req = $pdo->prepare($sql);
    //var_dump($req);
    $req->execute();
    $data = $req->fetchAll(PDO::FETCH_ASSOC);

//echo $startDate." ".$endDate;
    // var_dump($data);
    if (!$data) {
        echo "<p class='alert alert-warning'>Aucun résultat</p>";
    } else {
        $str = '<div class="media">';
        foreach ($data as $key => $value) {


            $req = $pdo->prepare("SELECT p.lien FROM photos p, evenement e, typephoto t
            WHERE p.ideve=e.id and p.typephoto = t.id and t.id = 5 and p.ideve = '" . $value["id"] . "'  ");
            $req->execute();
            $data = $req->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $photoData) {

                $str .= '<div class="well">
				<div class="row">
				<div class="col-sm-2">

                    <time class="time">
                        <span class="day">'. date_format(date_create($value['datedbeve']), "d").'</span>
                        <span class="month">'.date_format(date_create($value['datedbeve']), "M").'</span>
                    </time>

				</div>

				<div class="col-sm-4">
				<a class="pull-left" href="event/index.php?azan=' . $value["id"] . ' " target="_blank">
				<img class="media-object img-rounded"   alt="Calentiel" style="height: 120px;" src="images/' . strtolower($photoData['lien']) . '">
					</a><div class="media-body">
					<p id="cname"> <span class="label label-danger" style="font-size: 20px"> <strong >' . $value['nomeve'] . ' </span> </strong></p>
					<p><strong>Lieu: </strong> ' . $value['lieueve'] . '</p>
					<p><strong>Contact :</strong> ' . $value['contact'] . '</p>

					</div></div>

					 <div class="col-sm-2">

                    <strong>Description: </strong> <br /> <p>'.$value['description'].' </p>

                    </div>

					<div class="col-sm-4"><p class="pull-right" style="font-size: 20px" >
					 <span class="label label-success"> <strong>Date début: </strong>' . date_format(date_create($value['datedbeve']), "d-m-Y") .
                    ' <strong>à</strong> ' . date_format(date_create($value['datedbeve']), "H:i") . ' </span>
                     </p>   </div>
					</div></div>   ' . '<hr>';

            }
        }
        $str .= '</div>';
        echo $str;
    }


} else {
    echo "<p class='alert alert-warning'>Renseigner une date</p>";
}
?>
