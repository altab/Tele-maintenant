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
            echo "<!-- Connexion OK --> \n";
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
    
    
//     function insertEmprunt($emprunt) {
        
//         $pdo =  $this -> getConn();
        
//         $nom     = $emprunt->getNom();
//         $adresse = $emprunt->getAdresse();
//         $date    = $emprunt->getDate();
//         $type    = $emprunt->getType();
//         $numero  = $emprunt->getNumero();
//         $etat    = $emprunt->getEtat();
        
//         $preparedStatement =  $pdo -> prepare("INSERT INTO emprunteur(nom, adresse, date, type, numero, etat) VALUES (?,?,?,?,?,?)");
//         $preparedStatement->bindParam(1, $nom);
//         $preparedStatement->bindParam(2, $adresse);
//         $preparedStatement->bindParam(3, $date);
//         $preparedStatement->bindParam(4, $type);
//         $preparedStatement->bindParam(5, $numero);
//         $preparedStatement->bindParam(6, $etat);
//         $preparedStatement->execute();
//         $preparedStatement->closeCursor();
        
//     }
    
    
//     /**
//      * Liste des enregistrements à supprimer
//      * @param String $numeros
//      */
//     function deleteEmprunt($numeros) {
        
//         $pdo =  $this -> getConn();
        
//         $preparedStatement =  $pdo -> prepare("DELETE FROM emprunteur WHERE `numero` IN ($numeros)");
//         $preparedStatement->execute();
//         $preparedStatement->closeCursor();
        
//     }
    
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
        
        if((isset($whereElAnd) && $whereElAnd != '') && (isset($whereValAnd) && $whereValAnd != '')) {
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
    
}
?>