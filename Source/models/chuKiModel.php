<?php

require_once __DIR__ .'/database.php'; 

class ChuKiModel {

    private $db; // Database connection
    
    public function __construct() {
        $this->db = new MyConnection(); // Create a Database instance
    }

    public function getAllChuKi() {
        $con = $this->db->getConnection();
        $sql = "SELECT * FROM chu_ki ";
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
// $model = new KhaoSatModel();
// $re = $model->getAllChuKi();
// echo json_encode($re);

?>