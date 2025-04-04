<?php

require_once __DIR__ .'/database.php'; 

class NganhModel {

    private $db; // Database connection
    
    public function __construct() {
        $this->db = new MyConnection(); // Create a Database instance
    }

    public function getAllNganh() {
        $con = $this->db->getConnection();
        $sql = "SELECT * FROM nganh ";
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
//     $model = new NganhModel();
//     $re = $model->getAllNganh();
// echo json_encode($re);

?>