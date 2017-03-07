<?php
session_start();

$dossier_tampom = "../serveur_image";

switch ($_POST['type']) {

    /*
 * Déplacer un fichier vers son dossier
 */
    case "read":

        if ( isset($_POST['dossier_temp'], $_POST['dir']) ) {

            $link = $dossier_tampom.'/'.$_POST['dossier_temp'].'/'.$_POST['dir'];

            $tab = read($link);
            $template = "";
            foreach ($tab as $fichier){
                $_SESSION['Evenement_pic'] = $fichier;
                $template = "<img class='media-object img-rounded'   
                alt='Calentiel' style='height: 200px; width: 325px;' src='$link/$fichier'>";
            }

            echo $template;
        }

        break;

    /*
* Déplacer un fichier vers son dossier
*/

    case "moveFile":

        if (isset($_POST['dossier'], $_POST['dossier_temp'], $_POST['file_name'])) {
            check_And_Transfert($_POST['dossier'], $_POST['dossier_temp'], $_POST['file_name']);
        }

        break;

    case "delete":

        if (isset($_POST['dossier_temp'], $_POST['dossier'])) {

            $link = $dossier_tampom.'/'.$_POST['dossier_temp'].'/'.$_POST['dossier'];

            if (file_exists($link)) {
                rmdir_recursive($link);
            }


        }


        break;

    default:

        $ds = DIRECTORY_SEPARATOR;
        $storeFolder =  $dossier_tampom;

        if (!empty($_FILES)) {
            $tempFile = $_FILES['file']['tmp_name'];
            $targetPath = dirname(__FILE__) . $ds . $storeFolder . $ds;
            $targetFile = $targetPath . $_FILES['file']['name'];
            /*
             * Dans un premier temps le ficher est
             * transféré dans un dossier global avant d'être
             * redirigé dans son dossier final
             */
            move_uploaded_file($tempFile, $targetFile);
        }

        break;

}


function read($dir_name){
    return parcourir_repertoire($dir_name);
}


function parcourir_repertoire($repertoire) {

    $tab = [];
    $le_repertoire = opendir($repertoire);
    while ($fichier = @readdir($le_repertoire)) {
        if ($fichier == "." or $fichier == ".." or $fichier == "Thumbs.db") continue;
        $tab[] = $fichier;
    }
    closedir($le_repertoire);
    return ($tab);
}

function check_And_Transfert($dossier, $dossier_temp, $file_Name) {
    global $dossier_tampom;
    //echo "fichier ".$dj_name."/".$dir_Name."/".$file_Name;

    $new_file_Name = $file_Name;

    if (!file_exists($dossier_tampom.'/'.$dossier_temp)) {
        mkdir($dossier_tampom.'/'.$dossier_temp , 0777, true);
    }

    if (!file_exists($dossier_tampom.'/'.$dossier_temp.'/'.$dossier)) {
        mkdir($dossier_tampom.'/'.$dossier_temp.'/'.$dossier , 0777, true);
    }

    rmdir_recursive($dossier_tampom.'/'. $dossier_temp . '/' . utf8_decode($dossier));
    rename($dossier_tampom.'/'. utf8_decode($file_Name),  $dossier_tampom.'/'. $dossier_temp . '/' . utf8_decode($dossier) . '/' . utf8_decode($file_Name));

}




/**
 * Cette methode te dit exactement que le dossier est vide même les fichiers Thumbs
 *
 */
function getFileNumberInFolder($path)
{
    $count = 0;
    foreach (new DirectoryIterator($path) as $fileInfo) {
        if ($fileInfo == "." or $fileInfo == ".." or $fileInfo == "Thumbs.db") continue;
        $count++;
    }
    return $count;
}

/*
 * Suppression recursive
 */
function rmdir_recursive($dir)
{
    $dir_content = scandir($dir);
    if ($dir_content !== FALSE) {
        foreach ($dir_content as $entry) {
            if (!in_array($entry, array('.', '..'))) {
                $entry = $dir . '/' . $entry;
                if (!is_dir($entry)) {
                    unlink($entry);
                } else {
                    rmdir_recursive($entry);
                }
            }
        }
    }
    //rmdir($dir);
}