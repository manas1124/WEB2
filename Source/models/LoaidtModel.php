<?php

require_once __DIR__ .'/database.php'; 

class LoaidtModel {

    private $db; // Database connection
    
    public function __construct() {
        $this->db = new MyConnection(); // Create a Database instance
    }

    public function getAllLoaidt() {
        $con = $this->db->getConnection();
        $sql = "SELECT * FROM loai_doi_tuong ";
        $result = $con->query($sql);
       
        if ($result) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data; // Return the result set for further processing
        } else {
            die("Query execution failed: " . $con->error);
        }
        $this->db->closeConnection();
    }

    }


?>