<?php

class Detail {
    
    private $id,$info,$date,$ticketID,$utilisateurID;
    
    function __construct($id,$info,$date,$ticketID,$utilisateurID) {
        
        $this->setId($id);
        $this->setInfo($info);
        $this->setDate($date);
        $this->setTicketID($ticketID);
        $this->setUtilisateurID($utilisateurID);
        
    }
    
    function NomFromUtilisateurID () {
        require_once '../DAO/connectDB.php';
        $connexion = new connectDB();
        
        $nomUtilisateurs = $connexion->selectFromWhere('nom,prenom','utilisateur','id', $this->getUtilisateurID());
        
        return $nomUtilisateurs[0]['prenom']." ".$nomUtilisateurs[0]['nom'];
        
    }
    
    public function __toString() {
        
        $toString = "\n Objet Detail : "
            ."\n[ Id : ".$this->getId()
            ."\n Info : " .$this->getInfo()
            ."\n Date : " .$this->getDate()
            ."\n TicketId : " .$this->getTicketID()
            ."\n UtilisateurId : " .$this->getUtilisateurID()." ]";
            
            return $toString;
    }
    
    function dateFR(){
        
        $date = new DateTime($this->getDate(),new DateTimeZone('Europe/Paris'));
        $date = $date ->format('d.m.Y à H\hi');
        
        return $date;
        
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
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getTicketID()
    {
        return $this->ticketID;
    }

    /**
     * @return mixed
     */
    public function getUtilisateurID()
    {
        return $this->utilisateurID;
    }

    /**
     * @param mixed $utilisateurID
     */
    private function setUtilisateurID($utilisateurID)
    {
        $this->utilisateurID = $utilisateurID;
    }

    /**
     * @param mixed $id
     */
    private function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $info
     */
    private function setInfo($info)
    {
        $this->info = $info;
    }

    /**
     * @param mixed $date
     */
    private function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @param mixed $ticketID
     */
    private function setTicketID($ticketID)
    {
        $this->ticketID = $ticketID;
    }

}