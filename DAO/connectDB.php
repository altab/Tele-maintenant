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
    
    
    function insertTicket($sujet, $iID, $socID, $status, $uID) {
        
        $pdo =  $this -> getConn();
        $today = date('Y-m-d H:i:s'); 
        
        $preparedStatement =  $pdo -> prepare("INSERT INTO ticket (sujet, interlocuteurID, societeID, status, date, utilisateurID) VALUES (?,?,?,?,?,?)");
        $preparedStatement->bindParam(1, $sujet);
        $preparedStatement->bindParam(2, $iID);
        $preparedStatement->bindParam(3, $socID);
        $preparedStatement->bindParam(4, $status);
        $preparedStatement->bindParam(5, $today);
        $preparedStatement->bindParam(6, $uID);
        $preparedStatement->execute();
        $preparedStatement->closeCursor();
        
    }
    
    function insertDetail($type,$info,$ticketID, $utilisateurID) {
        
        $pdo =  $this -> getConn();
        $today = date('Y-m-d H:i:s');
        
        $preparedStatement =  $pdo -> prepare("INSERT INTO ticketinfo( info, date, type, ticketID, utilisateurID) VALUES (?,?,?,?,?)");
        $preparedStatement->bindParam(1, $info);
        $preparedStatement->bindParam(2, $today);
        $preparedStatement->bindParam(3, $type);
        $preparedStatement->bindParam(4, $ticketID);
        $preparedStatement->bindParam(5, $utilisateurID);
        $preparedStatement->execute();
        $preparedStatement->closeCursor();
        
    }
    
    function insertSociete($nom, $adresse, $telephone, $email) {
        
        $pdo =  $this -> getConn();
        
        $preparedStatement =  $pdo -> prepare("INSERT INTO societe( nom, adresse, telephone, email) VALUES (?,?,?,?)");
        $preparedStatement->bindParam(1, $nom);
        $preparedStatement->bindParam(2, $adresse);
        $preparedStatement->bindParam(3, $telephone);
        $preparedStatement->bindParam(4, $email);
        $preparedStatement->execute();
        $preparedStatement->closeCursor();
        
    }
   
    
    /**
     * Procedure stockée
     * @param  $nom
     * @param  $prenom
     * @param  $telephone
     * @param  $email
     * @param  $societeID
     */
    function insertInterlocuteur($nom,$prenom, $telephone, $email, $societeID) {
        
        $pdo =  $this -> getConn();
        
         $preparedStatement =  $pdo -> prepare("INSERT INTO interlocuteur( nom, prenom, telephone, email, societeID) VALUES (?,?,?,?,?)");
        $preparedStatement->bindParam(1, $nom);
        $preparedStatement->bindParam(2, $prenom);
        $preparedStatement->bindParam(3, $telephone);
        $preparedStatement->bindParam(4, $email);
        $preparedStatement->bindParam(5, $societeID);
        $preparedStatement->execute();
        $preparedStatement->closeCursor();
        
    }
    
    function insertUtilisateur($nom,$prenom, $email, $password, $role) {
        
        $pdo =  $this -> getConn();
        
        $status = '0';
        
        $preparedStatement =  $pdo -> prepare("INSERT INTO utilisateur( nom, prenom, email, password, role, actif) VALUES (?,?,?,?,?,?)");
        $preparedStatement->bindParam(1, $nom);
        $preparedStatement->bindParam(2, $prenom);
        $preparedStatement->bindParam(3, $email);
        $preparedStatement->bindParam(4, $password);
        $preparedStatement->bindParam(5, $role);
        $preparedStatement->bindParam(6, $status);
        $preparedStatement->execute();
        $preparedStatement->closeCursor();
        
    }
    
    
    /**
     * Liste des enregistrements à supprimer
     * Peut egalement supprimer une donnée simple (non array)
     * @param String $numeros
     */
    function deleteArrayFrom($table, $whereEl, $whereVals) {
        
        $pdo =  $this -> getConn();
                
        // On verifie que c'est bien un array qui sera traité
        if (!is_array($whereVals)) $whereVals = array($whereVals); 
        
        // Protection contre les SQL injection
        $whereVals = array_map([$pdo, 'quote'], $whereVals); 
            
        $pdo->exec("DELETE FROM $table WHERE $whereEl IN (" . implode(', ', $whereVals) . ")");
 
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
//echo $query;
        $reponse = $pdo->query($query);
        
        $reponses = NULL;
        while($message = $reponse->fetch()) {
            
            $reponses[] = $message;
            
        }
        $reponse->closeCursor();
        
        return $reponses;
        
    }
    
    /**
     * Select avec une clause de recherche sur une colonne null. <br>
     * $whereEl et $whereVal peuvent etre vides
     * ex : SELECT * FROM `ticket` WHERE utilisateurID IS NULL<br>
     *      SELECT * FROM `ticket` WHERE `societeID`=1 AND utilisateurID IS NULL 
     * @param  $element
     * @param  $table
     * @param  $whereEl
     * @param  $whereVal
     * @param  $colIsNull
     * @return NULL|mixed
     */
    function selectFromWhereNull($element,$table,$whereEl, $whereVal, $colIsNull) {
        
        if((isset($whereEl) && $whereEl != '') && (isset($whereVal) && $whereVal != '')) $where = " WHERE ".$whereEl."='".$whereVal."' AND $colIsNull IS NULL";
        else $where = "WHERE $colIsNull IS NULL";
        
        $isNull = 
        
        $pdo =  $this -> getConn();
        
        $query = "SELECT ".$element." FROM ".$table.$where;
        $reponse = $pdo->query($query);
        
        $reponses = NULL;
        while($message = $reponse->fetch()) {
            
            $reponses[] = $message;
            
        }
        $reponse->closeCursor();
        
        return $reponses;
        
    }
    
    function selectFromWhereSorted($element,$table,$whereEl, $whereVal, $sortCol,$sortBy) {
        
        if((isset($whereEl) && $whereEl != '') && (isset($whereVal) && $whereVal != '')) $where = " WHERE ".$whereEl."='".$whereVal."'";
        else $where = '';
        
        $sorted = " ORDER BY ".$sortCol." ".$sortBy;
        
        $pdo =  $this -> getConn();
        
        $query = "SELECT ".$element." FROM ".$table.$where.$sorted;
        $reponse = $pdo->query($query);
        
        $reponses = NULL;
        while($message = $reponse->fetch()) {
            
            $reponses[] = $message;
            
        }
        $reponse->closeCursor();
        
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
        $reponse->closeCursor();
        
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
        $reponse->closeCursor();
        
        return $reponses;
        
    }
    
    /**
     * ex. : SELECT id FROM ticket WHERE interlocuteurID=2 ORDER BY id DESC LIMIT 0,1
     * @param  $table
     * @param  $champ
     * @param  $id
     */
    function selectLastId ($table, $champ, $id) {
        //SELECT id FROM ticket WHERE interlocuteurID=2 ORDER BY id DESC LIMIT 0,1
        $pdo =  $this -> getConn();
        
        $query = "SELECT id FROM $table WHERE $champ='$id' ORDER BY id DESC LIMIT 0,1";
        
        $reponse = $pdo->query($query);
        
        $reponse =  $reponse ->fetch();
                
        return $reponse;
    }
    
    
    function selectCountFromWhere($element,$table,$whereEl, $whereVal) {
        
        if((isset($whereEl) && $whereEl != '') && (isset($whereVal) && $whereVal != '')) $where = " WHERE ".$whereEl."='".$whereVal."'";
        else $where = '';
        
        $pdo =  $this -> getConn();
        
        $query = "SELECT COUNT($element) FROM ".$table.$where;
        $reponse = $pdo->query($query);
        
        $reponses = NULL;
        while($message = $reponse->fetch()) {
            
            $reponses[] = $message;
            
        }
        $reponse->closeCursor();
        
        return $reponses;
        
    }
    
    
    /**
     * updateRaw ($table, $valEl, $valVal, $whereEl, $whereVal)<br>
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
        
        $query = "UPDATE $table SET $valEl='$valVal' WHERE $whereEl=$whereVal";

        // Prepare statement
        $stmt = $pdo->prepare($query);
        
        // execute the query
        $stmt->execute();
        $stmt->closeCursor();
        
    }

    function updateRawDate ($table, $valEl, $valVal, $whereEl, $whereVal) {
        //
        $pdo =  $this -> getConn();
        
        
        $query = "UPDATE $table SET date='$valVal' WHERE id=$whereVal";
        
        // Prepare statement
        $stmt = $pdo->prepare($query);
        
        // execute the query
        $stmt->execute();
        $stmt->closeCursor();
        
        
    }
    
    
    function updateUtilisateur($id, $nom, $prenom, $email, $icone, $role, $actif) {
        
        $pdo =  $this -> getConn();
        $today = date('Y-m-d H:i:s');
        
        $preparedStatement =  $pdo -> prepare("UPDATE utilisateur SET nom=?, prenom=?,email=?, icone=?, role=?, actif=? WHERE id=$id");
        $preparedStatement->bindParam(1, $nom);
        $preparedStatement->bindParam(2, $prenom);
        $preparedStatement->bindParam(3, $email);
        $preparedStatement->bindParam(4, $icone);
        $preparedStatement->bindParam(5, $role);
        $preparedStatement->bindParam(6, $actif);
        $preparedStatement->execute();
        $preparedStatement->closeCursor();
        
    }
    
    function updatetoNewUtilisateur($utilisateurID, $ticketID) {
        //
        $pdo =  $this -> getConn();
        
        $query = "UPDATE ticket SET status=1,utilisateurID=$utilisateurID WHERE id=$ticketID";
        
        // Prepare statement
        $stmt = $pdo->prepare($query);
        
        // execute the query
        $stmt->execute();
        $stmt->closeCursor();
        
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
        $reponse->closeCursor();
        
        return $reponses;
        
    }
    
    function searchAllTickets(){
        /*
         * SELECT C.CLI_ID, C.CLI_NOM, T.TEL_NUMERO, E.EML_ADRESSE, A.ADR_VILLE
         * FROM T_CLIENT C, T_TELEPHONE T, T_ADRESSE A, T_EMAIL E
         * WHERE C.CLI_ID = T.CLI_ID
         * AND C.CLI_ID = A.CLI_ID
         * AND C.CLI_ID = E.CLI_ID
         * */
        
    }
    
    function countFromTableWhere($table, $whereEl, $whereVal){
        
        //SELECT COUNT(*) FROM table
        $pdo =  $this -> getConn();
        
        if(isset($whereEl) && $whereEl!= '') $where = " WHERE ".$whereEl."=".$whereVal;
        else $where ='';
        
        $query = "SELECT COUNT(*) FROM  $table $where";
        
        // Prepare statement
        $reponse = $pdo->query($query);
        
        $reponse =  $reponse ->fetch();
                
        return $reponse;
    }
    
    function InfoUtilisateur($id){
        
        $pdo =  $this -> getConn();
        
        $query = "CALL selectWhere($id)";
        
        // Prepare statement
        $reponse = $pdo->query($query);
        
        $reponse =  $reponse ->fetch();
        
        return $reponse;
    }
    
}
?>