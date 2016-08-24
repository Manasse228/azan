<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "../../mvc/controleur/autoload.php";

$pdo = Connection::getConnexion();

$evenementManager = new EvenementManager($pdo);
$evenement = $evenementManager->getAllEvent();
$events = array();
$i=0;



foreach ($evenement as $db_event) {
    $i++;
	$event = new stdClass();
	$event->name = $db_event->getNom(); // Adapt with your suitable db field. If your db has not this field, please let it be : $event->name = "";
	$event->image = "images/".$db_event->getPhotoDeCouverture(); // Adapt with your suitable db field. If your db has not this field, please let it be : $event->image = "";
	$event->day = date('j', strtotime($db_event->getDateDb()));
	$event->month = date('n', strtotime($db_event->getDateDb()));
	$event->year = date('Y', strtotime($db_event->getDateDb()));
	$event->time = date('H:i', strtotime($db_event->getDateDb())); // You can change the format of time
	if (!$db_event->getDateFn()) {
		$event->duration = 1; // If end_time is blank -> event's duration = 1 (day).	
	} else {
		if (date('Ymd', strtotime($db_event->getDateDb())) == date('Ymd', strtotime($db_event->getDateFn()))) { // If start date and end date are same day -> event's duration = 1 (day).
			$event->duration = 1;
		} else {
			$start_day = date('Y-m-d', strtotime($db_event->getDateDb()));
			$end_day = date('Y-m-d', strtotime($db_event->getDateFn()));
			$event->duration = ceil(abs(strtotime($end_day) - strtotime($start_day)) / 86400) + 1; // Get event's duration = days between start date and end date.
		}
	}
	$event->color = $i;
	$event->location = $db_event->getLieu(); // Adapt with your suitable db field. If your db has not this field, please let it be : $event->location = "";
	$event->prix = ($db_event->getPrix() == 0) ? " Entrée gratuite" : " ".$db_event->getPrix();
	$event->description = $db_event->getDesription()."... <a target='_blank' href=http://localhost/azan//event/index.php?azan=".$db_event->getId()."> Plus de Détail </a>"; // Adapt with your suitable db field. If your db has not this field, please let it be : $event->description = "";
	array_push($events, $event);

}

echo json_encode($events);


?>