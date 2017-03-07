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
            $req = $pdo->prepare("INSERT INTO evenement(nom,lieu,date_pub,date_db,date_fn,
                                    contact,prix,description,user,type)
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

           // Utilities::POST_redirect('event/index.php?azan=' . $lastId);


        } catch (Exception $ex) {
            $pdo->rollback();
            echo 'Erreur : ' . $ex->getMessage() . '<br />';
            echo 'N° : ' . $ex->getCode();
            echo "Error: " . $req . "<br>" . $pdo->error;

            exit();
        }

    }

    public function updateEvenement(Evenement $evenement)
    {

        try {
            global $pdo;

            $pdo->beginTransaction();
            $req = $pdo->prepare("UPDATE evenement set nom= :nom, lieu= :lieu, prix= :prix,
                 date_pub= :datepub, date_db= :datedb, date_fn = :datefn, contact= :contact,
                 description= :description, type = :typeeve  WHERE id= :id AND user= :userId ");

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

    /*
     * Recupération des de tous les évènements
     * qui seront affichés sur le calendrier
     */
    public function getAllEvent()
    {
        global $pdo;
        $req = $pdo->prepare("SELECT e.nom, p.lien, e.lieu, e.date_db, e.date_fn, e.description, e.id, e.prix
        FROM evenement e, photo p, type_photo t
        WHERE e.date_pub <= now() AND e.date_fn >= now() AND e.id = p.id_eve AND p.type_photo = t.id AND t.id = 1 ");
        $req->execute();

        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        $tab = array();
        foreach ($data as $value) {
            $tab[] = new Evenement($value["nom"], $value["lien"], $value["lieu"],
                $value["date_db"], $value["date_fn"], $value["description"], $value["id"], $value["prix"]);
        }

        return $tab;
    }

    /*
     * Je sais pas ce qu'il fait pur le moment
     */
    public function getEvenementsByType($id){
        global $pdo;
        $req = $pdo->prepare("SELECT *  FROM  type_evenement WHERE type = :val ");
        $req->bindValue(':val', trim($id), PDO::PARAM_INT);
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        $tab_evenement = array();
        foreach ($data as $value) {
            $tab_evenement[] = array($value["id"] => $value["libelle"]) ;
        }
        return $tab_evenement;
    }


    /*
     * Récupérer un évènement grâce à son ID
     */
    public function getEvenementById($value, $typeData="")
    {

        global $pdo;
        $req = $pdo->prepare("SELECT *  FROM  evenement WHERE id = :val ");
        $req->bindValue(':val', trim($value), PDO::PARAM_STR);
        $req->execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);

        switch ($typeData) {

            case "Array":
                return $data;
                break;

            default;
                return new Evenement($data["id"], $data["nom"], $data["lieu"], $data["date_pub"], $data["date_db"],
                    $data["date_fn"], $data["contact"], $data["prix"], $data["description"], $data["user"], $data["type"]);
                break;
        }


    }

    /*
     * zbr zbr
     */
    public function getTypeById($id)
    {
        global $pdo;
        $req = $pdo->prepare("SELECT libelle from typeevenement WHERE id = :id");
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

        return $req->fetchColumn();
    }

    /*
     * Récupération d'évènement par utilisateur
     */
    public function getEvenementByUserId($value)
    {

        global $pdo;
        $req = $pdo->prepare("SELECT *  FROM  evenement WHERE id = :val ");
        $req->bindValue(':val', trim($value), PDO::PARAM_INT);
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        $tab = array();
        foreach ($data as $value) {
            $tab[] = new Evenement($value["id"], $value["nom"], $value["lieu"], $value["date_pub"], $value["date_db"],
                $value["date_fn"], $value["contact"], $value["prix"], $value["description"], $value["user"], $value["type"]);
        }

        return $tab;
    }

    /*
     * Vérification d'évènement par nom et par lieu
     */
    public function checkNomLieu($nom, $lieu)
    {
        global $pdo;
        $req = $pdo->prepare("SELECT COUNT(*) FROM  evenement WHERE lieu = :lieu and nom = :nom and date_fn >= now() ");
        $req->bindValue(':nom', trim($nom), PDO::PARAM_STR);
        $req->bindValue(':lieu', trim($lieu), PDO::PARAM_STR);
        $result = $req->execute();

        if ($result) {
            $count = $req->fetchColumn();
        } else {
            trigger_error('Error executing statement.', E_USER_ERROR);
        }
        return ($count == 0) ? true : false;
    }

    /*
     * Vérification d'évènement par nom et par lieu
     * avant mise à jour
     */
    public function checkNomLieuForUpdate($nom, $lieu, $oldLieu, $oldName)
    {

        if ($oldLieu === $lieu || $oldName === $nom) {
            $count = 0;
        } else {
            global $pdo;
            $req = $pdo->prepare("SELECT COUNT(*) FROM  evenement WHERE lieu = :lieu and nom = :nom");
            $req->bindValue(':nom', trim($nom), PDO::PARAM_STR);
            $req->bindValue(':lieu', trim($lieu), PDO::PARAM_STR);
            $result = $req->execute();

            if ($result) {
                $count = $req->fetchColumn();
            } else {
                trigger_error('Error executing statement.', E_USER_ERROR);
            }
        }


        return ($count == 0) ? true : false;
    }

    /*
     * Suppression d'évènement à réécrire
     * -on supprime les photos d'abord puis
     * -on supprime l'évènement même
     */
    public function deleteEvenement($nom, $lieu)
    {
        global $pdo;

        $req = $pdo->prepare("Select id from evenement WHERE nom = :nom AND lieu = :lieu");
        $req->bindValue(':nom', $nom, PDO::PARAM_STR);
        $req->bindValue(':lieu', $lieu, PDO::PARAM_STR);
        $req->execute();
        $result = $req->fetchColumn();


        $req = $pdo->prepare(" select id,ideve,lien,typephoto from photo where ideve= :id ");
        $req->bindValue('id', $result, PDO::PARAM_INT);
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_ASSOC);


        foreach ($data as $value) {
            // $tab[] = new Photos( $value["id"], $value["ideve"], $value["typephoto"], $value["lien"] );

            unlink("../images/" . $value["lien"]);

            $req = $pdo->prepare("delete from photos where id = :id ");
            $req->bindValue(':id', $value["id"], PDO::PARAM_INT);
            $req->execute();
        }

        $req = $pdo->prepare("delete from evenement where id = :id ");
        $req->bindValue(':id', $result, PDO::PARAM_INT);
        $req->execute();


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