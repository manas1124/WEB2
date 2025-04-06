<?php
// app/Models/KhaoSat.php

require_once __DIR__ .'/database.php'; 

Class NhomKsModel {
    private $db;
    public function __construct() {
        $this->db = new MyConnection(); // Create a Database instance
    }

    public function getAllNhomKs() {
        $con = $this->db->getConnection();
        $sql = "SELECT * FROM nhom_khao_sat ";
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
    }

    public function getAllKhaoSat() {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM khao_sat ");
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        // return data as string json
        return $data;
    }
}

// $test = new NhomKsModel();
// $re = $test->getAllNhomKs()[0];
// echo json_encode($re);

?>