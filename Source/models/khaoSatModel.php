<?php
// app/Models/KhaoSat.php

require_once __DIR__ .'/database.php'; 

class KhaoSatModel {

    private $db; // Database connection
    
    public function __construct() {
        $this->db = new MyConnection(); // Create a Database instance
    }

    // Database operations
    public function create() {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO khao_sat (ks_id, ten_ks, ngay_tao, nhomks_id, kh_id, nks_id, ltl_id, ctdt_id, field_9) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siiiiiiii", $this->ks_id, $this->ten_ks, $this->ngay_tao, $this->nhomks_id, $this->kh_id, $this->nks_id, $this->ltl_id, $this->ctdt_id, $this->field_9);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
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
        return json_encode($data);
    }

    public function getKhaoSatById($ks_id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM khao_sat WHERE ks_id = ?");
        $stmt->bind_param("i", $ks_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            return json_encode($row);
        } else {
            return false;
        }
    }

    public function update() {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE khao_sat SET ten_ks = ?, ngay_tao = ?, nhomks_id = ?, kh_id = ?, nks_id = ?, ltl_id = ?, ctdt_id = ?, field_9 = ? WHERE ks_id = ?");
        $stmt->bind_param("siiiiiiii", $this->ten_ks, $this->ngay_tao, $this->nhomks_id, $this->kh_id, $this->nks_id, $this->ltl_id, $this->ctdt_id, $this->field_9, $this->ks_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($ks_id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("DELETE FROM khao_sat WHERE ks_id = ?");
        $stmt->bind_param("i", $ks_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAll() {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM khao_sat";
        $result = $conn->query($sql);

        $surveys = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $survey = new KhaoSatDTO();
                $survey->ks_id = $row['ks_id'];
                $survey->ten_ks = $row['ten_ks'];
                $survey->ngay_tao = $row['ngay_tao'];
                $survey->nhomks_id = $row['nhomks_id'];
                $survey->kh_id = $row['kh_id'];
                $survey->nks_id = $row['nks_id'];
                $survey->ltl_id = $row['ltl_id'];
                $survey->ctdt_id = $row['ctdt_id'];
                $survey->field_9 = $row['field_9'];
                $surveys[] = $survey;
            }
        }
        return $surveys;
    }
}
?>