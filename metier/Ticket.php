<?php


class Ticket {
    
    private $id, $sujet, $interlocuteurID, $societeID, $status;
    
    function __construct($id, $sujet, $interlocuteurID, $societeID, $status) {
        
        $this->setId($id);
        $this->setSujet($sujet);
        $this->setInterlocuteurID($interlocuteurID);
        $this->setSocieteID($societeID);
        $this->setStatus($status);
        
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