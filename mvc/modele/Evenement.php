<?php



class Evenement
{

    private $id;
    protected $nom;
    protected $lieu;
    protected $datePub;
    protected $dateDb;
    protected $dateFn;
    protected $contact;
    protected $prix;
    protected $desription;
    protected $user;
    protected $typePublication;

    /* Ces deux valeurs permettent de changer la couleur à l'affichage
    sur le calendier et de contenir le lien vers la photo
    de couverture visible sur le calendrier*/
    protected $color;
    protected $photoDeCouverture;


    public function __construct()
    {

        $num = func_num_args();

        switch ($num) {
            case 11:
                $this->id = func_get_arg(0);
                $this->nom = func_get_arg(1);
                $this->lieu = func_get_arg(2);
                $this->datePub = func_get_arg(3);
                $this->dateDb = func_get_arg(4);
                $this->dateFn = func_get_arg(5);
                $this->contact = func_get_arg(6);
                $this->prix = func_get_arg(7);
                $this->desription = func_get_arg(8);

                $this->user = func_get_arg(9);
                $this->typePublication = func_get_arg(10);
                /*if(func_get_arg(9) instanceof User){
                    $this->user = func_get_arg(9);
                }
                if(func_get_arg(10) instanceof TypeEvenement){
                    $this->typePublication = func_get_arg(10);
                }*/


                break;

            case 10:
                $this->nom = func_get_arg(0);
                $this->lieu = func_get_arg(1);
                $this->datePub = func_get_arg(2);
                $this->dateDb = func_get_arg(3);
                $this->dateFn = func_get_arg(4);
                $this->contact = func_get_arg(5);
                $this->prix = func_get_arg(6);
                $this->desription = func_get_arg(7);

                $this->user = func_get_arg(8);
                $this->typePublication = func_get_arg(9);
                break;

            case 8:
                $this->nom = func_get_arg(0);
                $this->photoDeCouverture = func_get_arg(1);
                $this->lieu = func_get_arg(2);
                $this->dateDb = func_get_arg(3);
                $this->dateFn = func_get_arg(4);
                $this->desription = func_get_arg(5);
                $this->id = func_get_arg(6);
                $this->prix = func_get_arg(7);
                break;


            default:
        }

    }

//$photoManager->getPhotoRepById($evenement[$i]->getId())->getLien();
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


    public function getLieu()
    {
        return $this->lieu;
    }


    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
    }


    public function getDatePub()
    {
        return $this->datePub;
    }


    public function setDatePub($datePub)
    {
        $this->datePub = $datePub;
    }


    public function getDateDb()
    {
        return $this->dateDb;
    }


    public function setDateDb($dateDb)
    {
        $this->dateDb = $dateDb;
    }


    public function getDateFn()
    {
        return $this->dateFn;
    }


    public function setDateFn($dateFn)
    {
        $this->dateFn = $dateFn;
    }


    public function getContact()
    {
        return $this->contact;
    }


    public function setContact($contact)
    {
        $this->contact = $contact;
    }


    public function getPrix()
    {
        return $this->prix;
    }


    public function setPrix($prix)
    {
        $this->prix = $prix;
    }


    public function getDesription()
    {
        return $this->desription;
    }


    public function setDesription($desription)
    {
        $this->desription = $desription;
    }


    public function getUser()
    {
        return $this->user;
    }


    public function setUser($user)
    {

        // if ($user instanceof User) {
        $this->user = $user;
        // }

    }


    public function getTypePublication()
    {
        return $this->typePublication;
    }


    public function setTypePublication($typePublication)
    {

       // if ($typePublication instanceof TypeEvenement) {
            $this->typePublication = $typePublication;
       // }

    }


    public function getPhotoDeCouverture()
    {
        return $this->photoDeCouverture;
    }


    public function setPhotoDeCouverture($photoDeCouverture)
    {
        $this->photoDeCouverture = $photoDeCouverture;
    }


    public function getColor()
    {
        return $this->color;
    }


    public function setColor($color)
    {
        $this->color = $color;
    }




}