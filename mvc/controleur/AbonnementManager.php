<?php


include_once 'autoload.php';

class AbonnementManager
{

    private $pdo;


    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function newAbonnement($user, $typeve){

        try {
            global $pdo;

            $req = $pdo->prepare("INSERT INTO abonnement(user,typeve) VALUES (:user, :typeve)");

            $req->bindValue(':user', $user, PDO::PARAM_STR);
            $req->bindValue(':typeve', $typeve, PDO::PARAM_STR);

            $req->execute();

        } catch (Exception $ex) {
            $pdo->rollback();
            echo 'Erreur : ' . $ex->getMessage() . '<br />';
            echo 'N° : ' . $ex->getCode();
            echo "Error: " . $req . "<br>" . $pdo->error;

            exit();
        }

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