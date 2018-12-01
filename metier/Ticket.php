<?php


class Ticket {
    
    private $id, $sujet, $interlocuteurID, $societeID, $status, $date, $utilisateurID;
    
    function __construct($id, $sujet, $interlocuteurID, $societeID, $status, $date, $utilisateurID) {
        
        $this->setId($id);
        $this->setSujet($sujet);
        $this->setInterlocuteurID($interlocuteurID);
        $this->setSocieteID($societeID);
        $this->setStatus($status);
        $this->setDate($date);
        $this->setUtilisateurID($utilisateurID);
        
    }
    
    function NomFromInterlocuteurID () {
        require_once '../DAO/connectDB.php';
        $connexion = new connectDB();
        
        $nomInterlocuteurs = $connexion->selectFromWhere('nom,prenom','interlocuteur','id', $this->getInterlocuteurID());
                
        return $nomInterlocuteurs[0]['prenom']." ".$nomInterlocuteurs[0]['nom'];
        
    }
    
    function NomFromSocieteID () {
        require_once '../DAO/connectDB.php';
        $connexion = new connectDB();
        
        $nomSocietes = $connexion->selectFromWhere('nom','societe','id', $this->getSocieteID());
        
        return $nomSocietes[0]['nom'];
        
    }
    
    function NomFromUtilisateurID () {
        
        if ($this->getUtilisateurID() == 99999) return 'N/A';
        else {
            
            require_once '../DAO/connectDB.php';
            $connexion = new connectDB();
            
            $nomUtilisateurs = $connexion->selectFromWhere('nom,prenom','utilisateur','id', $this->getUtilisateurID());
            
            return $nomUtilisateurs[0]['prenom']." ".$nomUtilisateurs[0]['nom'];
        
        }
        
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
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * @return mixed
     */
    public function getInterlocuteurID()
    {
        return $this->interlocuteurID;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getSocieteID()
    {
        return $this->societeID;
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
    public function getUtilisateurID()
    {
        return $this->utilisateurID;
    }

    /**
     * @param mixed $utilisateur
     */
    private function setUtilisateurID($utilisateurID)
    {
        $this->utilisateurID = $utilisateurID;
    }

    /**
     * @param mixed $date
     */
    private function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @param mixed $societeID
     */
    private function setSocieteID($societeID)
    {
        $this->societeID = $societeID;
    }

    /**
     * @param mixed $id
     */
    private function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $sujet
     */
    private function setSujet($sujet)
    {
        $this->sujet = $sujet;
    }

    /**
     * @param mixed $interlocuteurID
     */
    private function setInterlocuteurID($interlocuteurID)
    {
        $this->interlocuteurID = $interlocuteurID;
    }

    /**
     * @param mixed $status
     */
    private function setStatus($status)
    {
        $this->status = $status;
    }

    
}