<?php


class User
{

    private $id;
    protected $nom;
    protected $prenom;
    protected $sexe;
    protected $pseudo;
    protected $dateCreation;
    protected $telephone;
    protected $email;
    protected $password;
    protected $codeActivation;
    protected $active;


    public function __construct()
    {

        $num = func_num_args();

        switch ($num) {
            case 8:
                $this->id = func_get_arg(0);
                $this->nom = func_get_arg(1);
                $this->prenom = func_get_arg(2);
                $this->sexe = func_get_arg(3);
                $this->pseudo = func_get_arg(4);
                $this->dateCreation = func_get_arg(5);
                $this->telephone = func_get_arg(6);
                $this->email = func_get_arg(7);
                break;

            case 5:
                $this->pseudo = func_get_arg(0);
                $this->sexe = func_get_arg(1);
                $this->email = func_get_arg(2);
                $this->dateCreation = func_get_arg(3);
                $this->password = func_get_arg(4);
                break;

            case 2:
                $this->id = func_get_arg(0);
                $this->password = func_get_arg(1);
                break;

            case 6:
                $this->pseudo = func_get_arg(0);
                $this->telephone = func_get_arg(1);
                $this->sexe = func_get_arg(2);
                $this->prenom = func_get_arg(3);
                $this->nom = func_get_arg(4);
                $this->id = func_get_arg(5);
                break;

            case 10:
                $this->id = func_get_arg(0);
                $this->codeActivation = func_get_arg(1);
                $this->active = func_get_arg(2);
                $this->nom = func_get_arg(3);
                $this->prenom = func_get_arg(4);
                $this->pseudo = func_get_arg(5);
                $this->dateCreation = func_get_arg(6);
                $this->sexe = func_get_arg(7);
                $this->telephone = func_get_arg(8);
                $this->email = func_get_arg(9);
                break;


            default:
        }

    }


    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }


    public function setNom($nom)
    {
        $this->nom = $nom;
    }


    public function getPrenom()
    {
        return $this->prenom;
    }


    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }


    public function getSexe()
    {
        return $this->sexe;
    }

    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    }


    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }


    public function getDateCreation()
    {
        return $this->dateCreation;
    }


    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }


    public function getEmail()
    {
        return $this->email;
    }


    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }


    public function getCodeActivation()
    {
        return $this->codeActivation;
    }


    public function setCodeActivation($codeActivation)
    {
        $this->codeActivation = $codeActivation;
    }


    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }


}