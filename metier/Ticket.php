<?php


class Ticket {
    
    private $id, $sujet, $interlocuteurID, $societeID, $status, $date;
    
    function __construct($id, $sujet, $interlocuteurID, $societeID, $status, $date) {
        
        $this->setId($id);
        $this->setSujet($sujet);
        $this->setInterlocuteurID($interlocuteurID);
        $this->setSocieteID($societeID);
        $this->setStatus($status);
        $this->setDate($date);
        
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