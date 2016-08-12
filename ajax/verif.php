<?php
include_once '../mvc/controleur/autoload.php';
session_start();



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$pdo = Connection::getConnexion();

$userManager = new UserManager($pdo);
$evenementManager = new EvenementManager($pdo);

/*$event = $evenementManager->getEvenementById(41, "Array");
echo  '{"Evenement":['.json_encode($event, JSON_FORCE_OBJECT|JSON_UNESCAPED_UNICODE).']}' ;*/

if(isset($_POST['rowid'])){
    $id = $_POST['rowid'];
    $event = $evenementManager->getEvenementById($id, "Array");
    echo  '{"Evenement":['.json_encode($event, JSON_FORCE_OBJECT|JSON_UNESCAPED_UNICODE).']}' ;

}else{

    if(isset($_POST["nomEve"], $_POST["lieuEve"])){
        $result = $evenementManager->exists($_POST["nomEve"], $_POST["lieuEve"]);
    }else{
        switch ($_POST['type']) {

            case 'pseudo':
                $result = $userManager->exists($_POST["pseudo"], "pseudouser");
                break;

            case 'email':
                $result = $userManager->exists($_POST["email"], "email");
                break;

            case 'verifEmail':
                $result = $userManager->existEmail($_POST["emailVerif"]);
                break;

            /* case 'nomEvevenement':
                 $result = $evenementManager->exists($_POST["nomEve"], $_POST["lieuEve"]);
                 break; */

            default:
                break;
        }
    }





    echo json_encode(array(
        'valid' => $result,
    ));


}


?>