<?php
session_start();


include_once '../mvc/controleur/autoload.php';

$pdo = Connection::getConnexion();


if ((!empty($_POST['startDate']) && (!empty($_POST['endDate'])))) {    // Check whether the date is empty
    $startDate = date('Y-m-d', strtotime($_POST['startDate']));
    $endDate = date('Y-m-d', strtotime($_POST['endDate']));
    $condition = $a ="";

    if (!empty($_POST['type']) && empty($_POST['evenement'])) {
        $q = "SELECT id from type_evenement where type = ".$_POST['type'];
        $req = $pdo->prepare($q);
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $key => $value) {
            $a .= $value["id"]." ";
        }

        if(count($data) != 1){
            $a = str_replace(" ", ",", $a);
            $a = substr($a, 0, -1);
        }

        $condition = "type in ( " . $a . " )  AND  ";

    }

    if (!empty($_POST['evenement'])){
        $condition .= "type = '" . $_POST['evenement'] . "'  AND  ";
    }

    $sql = "SELECT * FROM evenement WHERE ".$condition." date_pub <= now() and date_fn >= now() and date_db BETWEEN  '" . $startDate . "' AND '" . $endDate . "' ";
    $req = $pdo->prepare($sql);
    $req->execute();
    $data = $req->fetchAll(PDO::FETCH_ASSOC);

    if (!$data) {
        echo "<p class='alert alert-warning'>Aucun résultat</p>";
    } else {
        $str = '<div class="media">';
        foreach ($data as $key => $value) {

            $req = $pdo->prepare("SELECT p.lien, p.id_eve FROM photo p, evenement e, type_photo t
            WHERE p.id_eve=e.id and p.type_photo = t.id and t.id = 1 and p.id_eve = '" . $value["id"] . "'  ");
            $req->execute();
            $data = $req->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $photoData) {

                $str .= '<div class="well">
				<div class="row">
				<div class="col-sm-2">

                    <time class="time">
                        <span class="day">'. date_format(date_create($value['date_db']), "d").'</span>
                        <span class="month">'.date_format(date_create($value['date_db']), "M").'</span>
                    </time>

				</div>

				<div class="col-sm-4">
				<!-- popup afficher -->
				<a href="http://www.calentiel.info/event/index.php?azan='.$photoData['id_eve'].'" target="_blank">
				<img class="media-object img-rounded"   alt="Calentiel" style="height: 120px;" src="serveur_image/' . strtolower($photoData['lien']) . '"></a>
					</a><div class="media-body">
					<p id="cname"> <span class="label label-danger" style="font-size: 20px"> <strong >' . $value['nom'] . ' </span> </strong></p>
					<p><strong>Lieu: </strong> ' . $value['lieu'] . '</p>
					<p><strong>Contact :</strong> ' . $value['contact'] . '</p>

					</div></div>

					 <div class="col-sm-2">

                    <strong>Description: </strong> <br /> <p>'.$value['description'].' </p>

                    </div>

					<div class="col-sm-4"><p class="pull-right" style="font-size: 20px" >
					 <span class="label label-success"> <strong>Date début: </strong>' . date_format(date_create($value['date_db']), "d-m-Y") .
                    ' <strong>à</strong> ' . date_format(date_create($value['date_db']), "H:i") . ' </span>
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
