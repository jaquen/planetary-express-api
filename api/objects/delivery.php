<?php
class Delivery{
  
    // database connection and table name
    private $conn;
    private $table_name = "tbl_deliveries";
  
    // object properties
    public $captain;
    public $ship;
    public $destination;
    public $completed;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read deliveries
    function read(){
    
        // select all query
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // create delivery
    function create(){
    
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET captain=:captain, ship=:ship, destination=:destination, completed=:completed";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->captain=htmlspecialchars(strip_tags($this->captain));
        $this->ship=htmlspecialchars(strip_tags($this->ship));
        $this->destination=htmlspecialchars(strip_tags($this->destination));
        $this->completed=htmlspecialchars(strip_tags($this->completed));
    
        // bind values
        $stmt->bindParam(":captain", $this->captain);
        $stmt->bindParam(":ship", $this->ship);
        $stmt->bindParam(":destination", $this->destination);
        $stmt->bindParam(":completed", $this->completed);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // used when filling up the update delivery form
    function readOne(){
    
        // query to read single record
        $query = "SELECT * FROM " . $this->table_name . " WHERE tbl_deliveries.id = ?";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of delivery to be updated
        $stmt->bindParam(1, $this->id);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->captain = $row['captain'];
        $this->ship = $row['ship'];
        $this->destination = $row['destination'];
        $this->completed = $row['completed'];
    }

    function deliveryCount(){
    
        // select all query
        $query = "SELECT id FROM " . $this->table_name . " WHERE tbl_deliveries.captain = ?";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->captain);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }
}
?>
