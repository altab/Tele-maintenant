<?php

class Detail {
    
    private $id,$info,$date,$ticketID;
    
    function __construct($id,$info,$date,$ticketID) {
        
        $this->setId($id);
        $this->setInfo($info);
        $this->setDate($date);
        $this->setTicketID($ticketID);
        
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