<?php 
/*
 * Connection à la base de donnée
 */

/**
 * Classe de connexion à la base de données avec PDO mySQL
 * @author Philippe
 *
 */
class connectDB {
    
    /*
     * Variables
     */
    private $conn;
   
    /**
     * Constructeur
     */
    public function __construct() {
        
        $servername = "localhost";
        $username   = "telem";
        $password   = "telem";
        $dataBase   = "telem";
        
        try {
            $this -> conn = new PDO("mysql:host=$servername;dbname=$dataBase;charset=utf8", $username, $password);
            // set the PDO error mode to exception
            $this -> conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "<!-- Connexion OK --> \n";
        }
        catch(PDOException $e)
        {
            echo "Erreur connexion PDO : " . $e->getMessage();
        }
        
    }
    
    /**
     * Getter pour la connexion à la base
     * @return PDO
     */
    public function getConn() {
        return $this->conn;
    }
    
    
    function insertTicket($sujet, $iID, $socID, $status) {
        
        $pdo =  $this -> getConn();
        $today = date("Y-m-d"); 
        
        $preparedStatement =  $pdo -> prepare("INSERT INTO ticket( sujet, interlocuteurID, societeID, status, date) VALUES (?,?,?,?,?)");
        $preparedStatement->bindParam(1, $sujet);
        $preparedStatement->bindParam(2, $iID);
        $preparedStatement->bindParam(3, $socID);
        $preparedStatement->bindParam(4, $status);
        $preparedStatement->bindParam(5, $today);
        $preparedStatement->execute();
        $preparedStatement->closeCursor();
        
    }
    
    function insertDetail($type,$info,$ticketID) {
        
        $pdo =  $this -> getConn();
        $today = date("Y-m-d");
        
        $preparedStatement =  $pdo -> prepare("INSERT INTO ticketinfo( info, date, type, ticketID) VALUES (?,?,?,?)");
        $preparedStatement->bindParam(1, $info);
        $preparedStatement->bindParam(2, $today);
        $preparedStatement->bindParam(3, $type);
        $preparedStatement->bindParam(4, $ticketID);
        $preparedStatement->execute();
        $preparedStatement->closeCursor();
        
    }
    
    
    /**
     * Liste des enregistrements à supprimer
     * @param String $numeros
     */
    function deleteEmprunt($numeros) {
        
        $pdo =  $this -> getConn();
        
        $preparedStatement =  $pdo -> prepare("DELETE FROM emprunteur WHERE `numero` IN ($numeros)");
        $preparedStatement->execute();
        $preparedStatement->closeCursor();
        
    }
    
    /**
     * Execute une requete SELECT simple <br>
     * selectFromWhere($element,$table,$whereEl, $whereVal)
     * @param  $element (required)
     * @param  $table (required)
     * @param  $whereEl (optional)
     * @param  $whereVal (optional)
     * @return array
     */
    function selectFromWhere($element,$table,$whereEl, $whereVal) {
                
        if((isset($whereEl) && $whereEl != '') && (isset($whereVal) && $whereVal != '')) $where = " WHERE ".$whereEl."='".$whereVal."'";
        else $where = '';
        
        $pdo =  $this -> getConn();
        
        $query = "SELECT ".$element." FROM ".$table.$where;
        $reponse = $pdo->query($query);
        
        $reponses = NULL;
        while($message = $reponse->fetch()) {
            
            $reponses[] = $message;
            
        }
        
        return $reponses;
        
    }
    
    /**
     * selectFromWhereAnd($element,$table,$whereEl, $whereVal, $whereElAnd, $whereValAnd)
     * @param  $element
     * @param  $table
     * @param  $whereEl
     * @param  $whereVal
     * @param  $whereElAnd
     * @param  $whereValAnd
     * @return array
     */
    function selectFromWhereAnd($element,$table,$whereEl, $whereVal, $whereElAnd, $whereValAnd) {
        
        if(isset($whereElAnd) && isset($whereValAnd)) {
            $where = " WHERE ".$whereEl."='".$whereVal."' ";
            $where .= " AND $whereElAnd='".$whereValAnd."' ";
        } else $where = '';
        
        $pdo =  $this -> getConn();
        
        $query = "SELECT ".$element." FROM ".$table.$where;
        
        $reponse = $pdo->query($query);
        
        $reponses = NULL;
        while($message = $reponse->fetch()) {
            
            $reponses[] = $message;
            
        }
        
        return $reponses;
        
    }
    
    /**
     * 
     * @param  $element
     * @param  $table
     * @param  $whereEl
     * @param  $whereVal
     * @param  $whereElAnd
     * @param  $whereValAnd
     * @param  $sort
     * @param  $sortBy
     * @return NULL|mixed
     */
    function selectFromWhereAndSorted($element,$table,$whereEl, $whereVal, $whereElAnd, $whereValAnd, $sortCol,$sortBy) {
        
        if(isset($whereElAnd) && isset($whereValAnd)) {
            $where = " WHERE ".$whereEl."='".$whereVal."' ";
            $where .= " AND $whereElAnd='".$whereValAnd."' ";
        } else $where = '';
        
        $sorted = " ORDER BY ".$sortCol." ".$sortBy;
        
        $pdo =  $this -> getConn();
        
        $query = "SELECT ".$element." FROM ".$table.$where.$sorted;
        
        $reponse = $pdo->query($query);
        
        $reponses = NULL;
        while($message = $reponse->fetch()) {
            
            $reponses[] = $message;
            
        }
        
        return $reponses;
        
    }
    
    function selectLastId ($table, $champ, $id) {
        //SELECT id FROM ticket WHERE interlocuteurID=2 ORDER BY id DESC LIMIT 0,1
        $pdo =  $this -> getConn();
        
        $query = "SELECT id FROM $table WHERE $champ=$id ORDER BY id DESC LIMIT 0,1";
        
        $reponse = $pdo->query($query);
        
        $reponse =  $reponse ->fetch();
        
        return $reponse;
    }
    
    
    /**
     * updateRaw ($table, $valEl, $valVal, $whereEl, $whereVal)
     * -> UPDATE ticket SET status=0 WHERE id=68
     * @param  $table
     * @param  $valEl
     * @param  $valVal
     * @param  $whereEl
     * @param  $whereVal
     */
    function updateRaw ($table, $valEl, $valVal, $whereEl, $whereVal) {
        //
        $pdo =  $this -> getConn();
        
        $query = "UPDATE $table SET $valEl=$valVal WHERE $whereEl=$whereVal";
                
        // Prepare statement
        $stmt = $pdo->prepare($query);
        
        // execute the query
        $stmt->execute();
        
    }
    
    //SELECT * FROM ticket left join ticketinfo on ticket.id = ticketinfo.ticketID WHERE ticket.id=70
    function getDetailsTicketFromId($idTicket){
        
        $pdo =  $this -> getConn();
        
        $query = "SELECT * FROM ticket left join ticketinfo on ticket.id = ticketinfo.ticketID WHERE ticket.id=$idTicket ORDER BY ticketinfo.type, ticketinfo.id";
        
        // Prepare statement
       $reponse = $pdo->query($query);
        
        $reponses = NULL;
        while($message = $reponse->fetch()) {
            
            $reponses[] = $message;
            
        }
        
        return $reponses;
        
    }
    
}
?>