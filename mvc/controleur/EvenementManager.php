<?php

include_once 'autoload.php';

class EvenementManager
{

    private $pdo;


    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createEvenement(Evenement $evenement, $tab)
    {

        try {
            global $pdo;

            $pdo->beginTransaction();
            $req = $pdo->prepare("INSERT INTO evenement(nomeve,lieueve,datepubeve,datedbeve,datefneve,
                                    contact,prix,description,iduser,idtype)
            VALUES (:nomeve, :lieueve, :datepubeve, :datedbeve, :datefneve, :contact, :prix, :description, :iduser, :idtype)");

            $req->bindValue(':nomeve', $evenement->getNom(), PDO::PARAM_STR);
            $req->bindValue(':lieueve', $evenement->getLieu(), PDO::PARAM_STR);
            $req->bindValue(':datepubeve', date("Y-m-d", strtotime($evenement->getDatePub())), PDO::PARAM_STR);
            $req->bindValue(':datedbeve', date("Y-m-d H:i:s", strtotime($evenement->getDateDb())), PDO::PARAM_STR);
            $req->bindValue(':datefneve', date("Y-m-d H:i:s", strtotime($evenement->getDateFn())), PDO::PARAM_STR);
            $req->bindValue(':contact', $evenement->getContact(), PDO::PARAM_STR);
            $req->bindValue(':prix', $evenement->getPrix(), PDO::PARAM_STR);
            $req->bindValue(':description', trim($evenement->getDesription()), PDO::PARAM_STR);
            $req->bindValue(':iduser', $evenement->getUser(), PDO::PARAM_INT);
            $req->bindValue(':idtype', $evenement->getTypePublication(), PDO::PARAM_INT);


            $req->execute();
            $lastId = $pdo->lastInsertId();


            $photoManager = new PhotosManager($pdo);
            foreach ($tab as $value) {
                $photos = new Photos($lastId, $value['typePhoto'], $value['fileName']);
                $photoManager->createPhtotos($photos);
            }


            $pdo->commit();

            Utilities::POST_redirect('event/index.php?azan=' . $lastId);


        } catch (Exception $ex) {
            $pdo->rollback();
            echo 'Erreur : ' . $ex->getMessage() . '<br />';
            echo 'N° : ' . $ex->getCode();
            echo "Error: " . $req . "<br>" . $pdo->error;

            exit();
        }

    }

    public function updateEvenement(Evenement $evenement){

        try {
            global $pdo;

            $pdo->beginTransaction();
            $req = $pdo->prepare("UPDATE evenement set nomeve= :nom, lieueve= :lieu, prix= :prix,
                 datepubeve= :datepub, datedbeve= :datedb, datefneve= :datefn, contact= :contact,
                 description= :description, idtype= :typeeve  WHERE id= :id AND iduser= :userId ");

            $req->bindValue(':nom', $evenement->getNom(), PDO::PARAM_STR);
            $req->bindValue(':lieu', $evenement->getLieu(), PDO::PARAM_STR);
            $req->bindValue(':prix', $evenement->getPrix(), PDO::PARAM_INT);

            $req->bindValue(':datepub', date("Y-m-d", strtotime($evenement->getDatePub())), PDO::PARAM_STR);
            $req->bindValue(':datedb', date("Y-m-d H:i:s", strtotime($evenement->getDateDb())), PDO::PARAM_STR);
            $req->bindValue(':datefn', date("Y-m-d H:i:s", strtotime($evenement->getDateFn())), PDO::PARAM_STR);

            $req->bindValue(':contact', $evenement->getContact(), PDO::PARAM_STR);
            $req->bindValue(':description', $evenement->getDesription(), PDO::PARAM_STR);
            $req->bindValue(':id', $evenement->getId(), PDO::PARAM_INT);

            $req->bindValue(':typeeve', $evenement->getTypePublication(), PDO::PARAM_INT);
            $req->bindValue(':userId', $evenement->getUser(), PDO::PARAM_INT);

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

    //Recupération des évènements
    public function getAllEvent()
    {
        global $pdo;
        $req = $pdo->prepare("SELECT e.nomeve, p.lien, e.lieueve, e.datedbeve, e.datefneve, e.description, e.id
        FROM evenement e, photos p, typephoto t
        WHERE e.datepubeve <= now() AND e.datefneve >= now() AND e.id = p.ideve AND p.typephoto = t.id AND t.code = 'couv'");
        $req->execute();

        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        $tab = array();
        foreach ($data as $value) {
            $tab[] = new Evenement($value["nomeve"], $value["lien"], $value["lieueve"],
                $value["datedbeve"], $value["datefneve"], $value["description"], $value["id"]);
        }

        return $tab;
    }


    public function getEvenementById($value, $typeData)
    {

        global $pdo;
       // $req = $pdo->prepare("SELECT *  FROM  evenement WHERE id = :val AND datepubeve <= now() AND evenement.datefneve >= now()");
        $req = $pdo->prepare("SELECT *  FROM  evenement WHERE id = :val ");
        $req->bindValue(':val', trim($value), PDO::PARAM_STR);
        $req->execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);

        switch($typeData){

            case "Array":
                return $data;
                break;

            default ;
                return new Evenement($data["id"], $data["nomeve"], $data["lieueve"], $data["datepubeve"], $data["datedbeve"],
                    $data["datefneve"], $data["contact"], $data["prix"], $data["description"], $data["iduser"], $data["idtype"]);
                break;
        }


    }

    public function getTypeById($id){
        global $pdo;
        $req=$pdo->prepare("SELECT libelle from typeevenement WHERE id = :id");
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

        return  $req->fetchColumn();
    }

    public function getEvenementByUserId($value)
    {

        global $pdo;
        $req = $pdo->prepare("SELECT *  FROM  evenement WHERE iduser = :val ");
        $req->bindValue(':val', trim($value), PDO::PARAM_INT);
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        $tab = array();
        foreach ($data as $value) {
            $tab[] = new Evenement($value["id"], $value["nomeve"], $value["lieueve"], $value["datepubeve"], $value["datedbeve"],
                $value["datefneve"], $value["contact"], $value["prix"], $value["description"], $value["iduser"], $value["idtype"]);
        }

        return $tab;
    }

    public function exists($donne, $donne2){
        global $pdo;
      //  $req = $pdo->prepare("SELECT COUNT(" . $column . ") FROM  evenement WHERE " . $column . " = :value ");
        $req = $pdo->prepare("SELECT COUNT(*) FROM  evenement WHERE lieueve = :lieu and nomeve = :nom");
        $req->bindValue(':nom', trim($donne), PDO::PARAM_STR);
        $req->bindValue(':lieu', trim($donne2), PDO::PARAM_STR);
        $result = $req->execute();

        if ($result) {
            $count = $req->fetchColumn();
        } else {
            trigger_error('Error executing statement.', E_USER_ERROR);
        }
        return ($count == 0) ? true : false;
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