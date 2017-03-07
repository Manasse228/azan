<?php

include_once 'autoload.php';

class PhotosManager
{


    private $pdo;


    public function __construct($pdo)
    {
        $this->setPdo($pdo);
    }


    public function createPhtotos(Photos $photos)
    {

        try {
            global $pdo;

            // $pdo->beginTransaction();
            $req = $pdo->prepare("INSERT INTO photo(id_eve, type_photo, lien) VALUES (:evenement, :typephoto, :lien)");

            $req->bindValue(':evenement', $photos->getEvenement(), PDO::PARAM_INT);
            $req->bindValue(':typephoto', $photos->getTypePhoto(), PDO::PARAM_INT);
            $req->bindValue(':lien', $photos->getLien(), PDO::PARAM_STR);

            $req->execute();
            //$pdo->commit();

        } catch (Exception $ex) {
            $pdo->rollback();
            echo 'Erreur : ' . $ex->getMessage() . '<br />';
            echo 'N° : ' . $ex->getCode();
            echo "Error: " . $req . "<br>" . $pdo->error;

            exit();
        }

    }

    public function updatePhotos(Photos $photos)
    {

        try {
            global $pdo;

            $pdo->beginTransaction();
            $req = $pdo->prepare("UPDATE photo set lien :lien, id_eve= :evenement, WHERE id= :id ");

            $req->bindValue(':lien', $photos->getLien(), PDO::PARAM_STR);
            $req->bindValue(':sponsor', $photos->getSponsor(), PDO::PARAM_STR);
            $req->bindValue(':evenement', $photos->getEvenement(), PDO::PARAM_INT);
            $req->bindValue(':id', $photos->getId(), PDO::PARAM_INT);

            $req->execute();
            $pdo->commit();

        } catch (Exception $ex) {
            $pdo->rollback();
            echo 'Erreur : ' . $ex->getMessage() . '<br />';
            echo 'N° : ' . $ex->getCode();
            echo "Error: " . $req . "<br>" . $pdo->error;

            exit();
        }

    }

    public function deletePhotos($id)
    {

        try {
            global $pdo;

            $pdo->beginTransaction();
            $req = $pdo->prepare("DELETE FROM photo WHERE id= :id");

            $req->bindValue(':id', $id, PDO::PARAM_INT);

            $req->execute();
            $pdo->commit();

        } catch (Exception $ex) {
            $pdo->rollback();
            echo 'Erreur : ' . $ex->getMessage() . '<br />';
            echo 'N° : ' . $ex->getCode();
            echo "Error: " . $req . "<br>" . $pdo->error;

            exit();
        }

    }

    public function getPhotosById($value){

        global $pdo;
        $req = $pdo->prepare("SELECT p.id, p.id_eve, p.type_photo, p.lien  FROM  photo p, evenement e WHERE p.id_eve = :val and p.id_eve=e.id");
        $req->bindValue(':val', trim($value), PDO::PARAM_STR);
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        $tab = array();
        foreach ($data as $value) {
            $tab[] = new Photos($value["id"], $value["id_eve"], $value["type_photo"], $value["lien"]);
        }
        return $tab;
    }

    public function getPhotoRepById($value){

        global $pdo;
        $req = $pdo->prepare("SELECT p.id, p.idèeve, p.type_photo, p.lien  FROM  photo p, evenement e, type_photo t
       WHERE t.id=1 AND e.id = :val AND p.id_eve=e.id AND t.id=p.type_photo");
        $req->bindValue(':val', trim($value), PDO::PARAM_INT);
        $req->execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);

        return new Photos($data["id"], $data["ideve"], $data["typephoto"], $data["lien"]);


    }


    public function getPdo()
    {
        return $this->pdo;
    }


    public function setPdo($pdo)
    {
        $this->pdo = $pdo;
    }


}