<?php


class Interlocuteur {
    
    private $id,$nom,$prenom,$telephone,$email,$societeID;
    
    public function __construct($id,$nom,$prenom,$telephone,$email,$societeID) {
        
        $this->setId($id);
        $this->setNom($nom);
        $this->setPrenom($prenom);
        $this->setTelephone($telephone);
        $this->setEmail($email);
        $this->setSocieteID($societeID);
        
    }
    
    function NomFromSocieteID () {
        require_once '../DAO/connectDB.php';
        $connexion = new connectDB();
        
        $nomSocietes = $connexion->selectFromWhere('nom','societe','id', $this->getSocieteID());
        
        return $nomSocietes[0]['nom'];
        
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
    public function getPrenom()
    {
        return $this->prenom;
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
     * @return mixed
     */
    public function getSocieteID()
    {
        return $this->societeID;
    }
    
    /**
     * @param mixed $id
     */
    private function setId($id)
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
     * @param mixed $prenom
     */
    private function setPrenom($prenom)
    {
        $this->prenom = $prenom;
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
    
    /**
     * @param mixed $societeID
     */
    private function setSocieteID($societeID)
    {
        $this->societeID = $societeID;
    }
    
    
}