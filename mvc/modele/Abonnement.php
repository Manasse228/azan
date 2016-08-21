<?php


class Abonnement
{

    protected $id;
    protected $user;
    protected $typeeve;


    public function __construct($id)
    {
        $num = func_num_args();

        switch ($num) {
            case 3:
                $this->id = func_get_arg(0);
                $this->user = func_get_arg(1);
                $this->typeeve = func_get_arg(2);
                break;

            case 1:
                $this->user = func_get_arg(0);
                break;


            default:
        }

    }


    public function getId()
    {
        return $this->id;
    }


    public function getUser()
    {
        return $this->user;
    }


    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getTypeeve()
    {
        return $this->typeeve;
    }


    public function setTypeeve($typeeve)
    {
        $this->typeeve = $typeeve;
    }


}