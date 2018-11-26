<?php


class Societe {
    
    private $id,$nom,$adresse,$telephone,$email;
    
    function __construct($id,$nom,$adresse,$telephone,$email) {
        
        $this->setId($id);
        $this->setNom($nom);
        $this->setAdresse($adresse);
        $this->setTelephone($telephone);
        $this->setEmail($email);
        
    }
    
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $nom
     */
    private function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @param mixed $adresse
     */
    private function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @param mixed $telephone
     */
    private function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @param mixed $email
     */
    private function setEmail($email)
    {
        $this->email = $email;
    }

}