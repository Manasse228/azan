<?php

include_once 'autoload.php';

class UserManager
{

    private $pdo;

    public function __construct($pdo)
    {
        $this->setPdo($pdo);
    }


    public function createUser(User $user)
    {

        try {
            global $pdo;

            $pdo->beginTransaction();
            $req = $pdo->prepare("INSERT INTO user(pseudo,date_creation,sexe,email,password,code_activation)
            VALUES (:pseudo, :dat, :sexe, :email, :password, :codeactivation)");

            $req->bindValue(':pseudo', $user->getPseudo(), PDO::PARAM_STR);
            $req->bindValue(':dat', $user->getDateCreation());
            $req->bindValue(':sexe', $user->getSexe(), PDO::PARAM_STR);
            $req->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);

            $options = [
                'cost' => 11,                                         // Cout algorithmique
                'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),    // Salt automatique
            ];
            $req->bindValue(':password', password_hash($user->getPassword(), PASSWORD_BCRYPT), PDO::PARAM_STR);

            $user->setCodeActivation(Utilities::codeActivation());
            $req->bindValue(':codeactivation', $user->getCodeActivation(), PDO::PARAM_STR);

            $req->execute();
            $pdo->commit();

            Utilities::sendEmail($user->getEmail(), "Calentiel",
                "
<h3>".$user->getPseudo()."</h3> Nous avons le plaisir de vous confirmer que votre inscription sur calentiel.info a bien été pris en compte. <br />
<hr />
Nos Félicitations ! <br />
Toute l’équipe calentiel est très heureuse de vous accueillir. Vous pouvez désormais publier une évènement et le gérer depuis votre espace personnel, poster un avis... Bienvenue !
Désormais pour vous connecter à votre compte vous pouvez soit utiliser votre adresse email ou pseudo et votre mot de passe. <br />
<p></p> <br />
Activez dès a présent votre compte pour pour profiter gratuitement de nos services en cliquant sur le lien ci-dessus: <br />
<a href='http://calentiel.info/active.php?pcaisas=".$user->getCodeActivation()."'> Activer mon compte </a> <br/>
<hr />
NB: Si le lien ne fonctionne pas, copiez le dans la barre d'adresse de votre navigateur. <br/>

                 ",
                "Confirmation d'inscription", "contact@calentiel.info");

        } catch (Exception $ex) {
            $pdo->rollback();
            echo 'Erreur : ' . $ex->getMessage() . '<br />';
            echo 'N° : ' . $ex->getCode();
            echo "Error: " . $req . "<br>" . $pdo->error;

            exit();
        }

    }

    public function createUserWithFollow(User $user, $typeve)
    {

        try {
            global $pdo;

            $pdo->beginTransaction();
            $req = $pdo->prepare("INSERT INTO user(pseudo,email) VALUES (:pseudo, :email)");

            //Ici le id est le pseudo car dans le contructeur on ...
            $req->bindValue(':pseudo', $user->getId(), PDO::PARAM_STR);
            $req->bindValue(':email', $user->getPassword(), PDO::PARAM_STR);

            $req->execute();

            $lastId = $pdo->lastInsertId();
            $abonnementManager = new AbonnementManager($pdo);

            foreach ($typeve as $type) {
                $abonnementManager->newAbonnement($lastId, $type);
            }

            $pdo->commit();

             Utilities::sendEmail($user->getEmail(), "Calentiel",
                 "Votre abonnement est bien pris en compte!", "Abonnement", "contact@calentiel.info");


        } catch (Exception $ex) {
            $pdo->rollback();
            echo 'Erreur : ' . $ex->getMessage() . '<br />';
            echo 'N° : ' . $ex->getCode();
            echo "Error: " . $req . "<br>" . $pdo->error;

            exit();
        }

    }

    public function updateUser(User $user)
    {

        try {
            global $pdo;

            $pdo->beginTransaction();
            $req = $pdo->prepare("UPDATE user set pseudo= :pseudo, telephone = :telephone, sexe= :sexe,
                prenom= :prenom,  nom= :nom  WHERE id= :id");

            $req->bindValue(':telephone', $user->getTelephone(), PDO::PARAM_STR);
            $req->bindValue(':sexe', $user->getSexe(), PDO::PARAM_STR);
            $req->bindValue(':prenom', $user->getPrenom(), PDO::PARAM_STR);
            $req->bindValue(':nom', $user->getNom(), PDO::PARAM_STR);
            $req->bindValue(':id', $user->getId(), PDO::PARAM_INT);
            $req->bindValue(':pseudo', $user->getPseudo(), PDO::PARAM_STR);

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

    public function updateUserPassword(User $user)
    {

        try {
            global $pdo;

            $pdo->beginTransaction();
            $req = $pdo->prepare("UPDATE user set password :password  WHERE id= :id");

            $req->bindValue(':password', password_hash($user->getPassword(), PASSWORD_DEFAULT), PDO::PARAM_STR);
            $req->bindValue(':id', $user->getId(), PDO::PARAM_INT);

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

    function updateUserByColumn($column, $valeur, $id)
    {

        try {
            global $pdo;

            $pdo->beginTransaction();
            $req = $pdo->prepare("UPDATE user set " . $column . "  = :valeur  WHERE id = :id");

            $req->bindValue(':valeur', $valeur, PDO::PARAM_INT);
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

    public function deleteUser($id)
    {

        try {
            global $pdo;

            $pdo->beginTransaction();
            $req = $pdo->prepare("DELETE FROM user WHERE id= :id");

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

    public function prepareToChangeEmail($oldemail, $newemail, $id){

        try {
            global $pdo;

            $pdo->beginTransaction();
            $req = $pdo->prepare("UPDATE user set email= :email, code_activation= :newcode, active=0  WHERE id= :id AND email= :oldemail");

            $req->bindValue(':email', trim($newemail), PDO::PARAM_STR);
            $req->bindValue(':oldemail', trim($oldemail), PDO::PARAM_STR);
            $req->bindValue(':id', $id, PDO::PARAM_INT);
            $code = Utilities::codeActivation();
            $req->bindValue(':newcode', $code, PDO::PARAM_STR);

            Utilities::sendEmail($newemail, "Calentiel", "
<hr /> <br />
Recemment vous avez demandé à changer d'adresse email depuis votre espace personnel . <br/>
<p></p><br/>
Changez votre adresse email en cliquant sur le lien ci-dessus: <br />
<a href='http://calentiel.info/active.php?sniper=".$code."&email=".$newemail."&rue=".$id." '> Changer mon adresse email </a> <br/>

NB: Si le lien ne fonctionne pas, copiez le dans la barre d'adresse de votre navigateur. <br/>
<hr />",
                "Changement d'adresse email", "contact@calentiel.info");

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

    public function checkLogin($login, $password)
    {

        global $pdo;
        $column = (Utilities::VerifierAdresseMail(trim($login)) == 1) ? "email" : "pseudo";

        $req = $pdo->prepare("select * from user where " . $column . " = :val ");
        $req->bindValue(':val', trim($login), PDO::PARAM_STR);
        $req->execute();

        $data = $req->fetch(PDO::FETCH_ASSOC);

        return (password_verify($password, $data["password"])) ? $this->getUser($column, $login) : null;

    }

    public function checkEmailOrPseudo($login)
    {

        global $pdo;

        $column = (Utilities::VerifierAdresseMail(trim($login)) == 1) ? "email" : "pseudo";

        $req = $pdo->prepare("SELECT COUNT(" . $column . ") FROM  user WHERE " . $column . " = :value ");
        $req->bindValue(':value', trim($login), PDO::PARAM_STR);
        $result = $req->execute();

        if ($result) {
            $count = $req->fetchColumn();
        } else {
            trigger_error('Error executing statement.', E_USER_ERROR);
        }
        return ($count == 1) ? true : false;

    }

    public function getUser($column, $value)
    {

        global $pdo;
        $req = $pdo->prepare("SELECT id,code_activation,active,
                          nom,prenom,pseudo,date_creation,sexe,telephone,email  FROM  user WHERE  $column = :val ");
        $req->bindValue(':val', $value, PDO::PARAM_STR);
        $req->execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);


        return new User($data["id"], $data["code_activation"], $data["active"], $data["nom"], $data["prenom"], $data["pseudo"],
            $data["date_creation"], $data["sexe"], $data["telephone"], $data["email"]);
    }

    public function getUserById($value)
    {

        global $pdo;
        $req = $pdo->prepare("SELECT *  FROM  user WHERE id = :val ");
        $req->bindValue(':val', trim($value), PDO::PARAM_INT);
        $result = $req->execute();
        $data = $req->fetch(PDO::FETCH_ASSOC);

        return new User($data["id"], $data["nom"], $data["prenom"], $data["sexe"], $data["pseudo"],
            $data["date_creation"], $data["telephone"], $data["email"]);
    }

    public function exists($donne, $column)
    {
        global $pdo;
        $req = $pdo->prepare("SELECT COUNT(" . $column . ") FROM  user WHERE " . $column . " = :value ");
        $req->bindValue(':value', trim($donne), PDO::PARAM_STR);
        $result = $req->execute();

        if ($result) {
            $count = $req->fetchColumn();
        } else {
            trigger_error('Error executing statement.', E_USER_ERROR);
        }
        return ($count == 0) ? true : false;
    }

    public function checkColomunBeforeUpdate($newValue, $column, $oldValue)
    {
        if (($this->exists($newValue, $column) == false) && ($oldValue == $newValue)) {
            $count = true;
        } else {
            $count = ($this->exists($newValue, $column) == true) ? true: false;
        }
        return $count;
    }

    public function checkEmailBeforeUpdate($newValue, $column, $oldValue)
    {
        return (($this->exists($newValue, $column) == false) && ($oldValue == $newValue)) ? true : false;
    }

    public function existEmail($donne)
    {
        global $pdo;
        $req = $pdo->prepare("SELECT COUNT(email) FROM  user WHERE email = :value ");
        $req->bindValue(':value', trim($donne), PDO::PARAM_STR);
        $result = $req->execute();

        if ($result) {
            $count = $req->fetchColumn();
        } else {
            trigger_error('Error executing statement.', E_USER_ERROR);
        }
        return ($count == 1) ? true : false;
    }

    public function check_email_format($email){
        return (Utilities::VerifierAdresseMail($email) == 1) ? true : false ;
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