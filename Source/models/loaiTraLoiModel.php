<?php

require_once __DIR__ .'/database.php'; 

class TraLoiModel {

    private $db; // Database connection
    
    public function __construct() {
        $this->db = new MyConnection(); // Create a Database instance
    }

    public function getAllTraLoi() {
        $con = $this->db->getConnection();
        $sql = "SELECT * FROM loai_tra_loi ";
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

    public function getTraLoiByIdKhaoSat($idKhaoSat) {
        $con = $this->db->getConnection();
        $sql = "SELECT thang_diem
                FROM khao_sat ks JOIN loai_tra_loi ltl ON ks.ltl_id = ltl.ltl_id
                WHERE ks.ks_id = ? AND ltl.status = 1 AND ks.status = 1";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $idKhaoSat);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result) {
            return $result->fetch_assoc(); 
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