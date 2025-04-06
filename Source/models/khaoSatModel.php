<?php
// app/Models/KhaoSat.php

require_once __DIR__ . '/database.php';

class KhaoSatModel
{

    private $db; // Database connection

    public function __construct()
    {
        $this->db = new MyConnection(); // Create a Database instance
    }

    // Database operations
    public function create($ten_ks, $ngay_bat_dau, $ngay_ket_thuc, $su_dung, $nks_id, $ltl_id, $ctdt_id, $status)
    {
        $conn = $this->db->getConnection();
        // Change the data type to DATE for ngay_bat_dau and ngay_ket_thuc
        $stmt = $conn->prepare("INSERT INTO khao_sat (ten_ks, ngay_bat_dau, ngay_ket_thuc, su_dung, nks_id, ltl_id, ctdt_id,status ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        // Change the bind_param types to 'sssi' for the date fields
        $stmt->bind_param("ssssiiis", $ten_ks, $ngay_bat_dau, $ngay_ket_thuc, $su_dung, $nks_id, $ltl_id, $ctdt_id, $status);

        if ($stmt->execute()) {
            $id = $stmt->insert_id;
            $stmt->close();
            return $id;
        } else {
            $stmt->close();
            return false;
        }
    }


    public function getAllKhaoSat()
    {
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
        // return array
        return $data;
    }

    public function getKhaoSatById($ks_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM khao_sat WHERE ks_id = ?");
        $stmt->bind_param("i", $ks_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            return $row;
        } else {
            return false;
        }
    }

    public function update()
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE khao_sat SET ten_ks = ?, ngay_tao = ?, nhomks_id = ?, kh_id = ?, nks_id = ?, ltl_id = ?, ctdt_id = ?, field_9 = ? WHERE ks_id = ?");
        // $stmt->bind_param("siiiiiiii", $this->ten_ks, $this->ngay_tao, $this->nhomks_id, $this->kh_id, $this->nks_id, $this->ltl_id, $this->ctdt_id, $this->field_9, $this->ks_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($ks_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("DELETE FROM khao_sat WHERE ks_id = ?");
        $stmt->bind_param("i", $ks_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function searchCtdt($nganh_id, $chu_ki_id, $is_ctdt_daura)
    {
        $conn = $this->db->getConnection();
        $query = "SELECT * FROM ctdt_daura WHERE nganh_id = ? AND ck_id = ? AND la_ctdt = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iii", $nganh_id, $chu_ki_id, $is_ctdt_daura);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        $stmt->close();
        return $data;
    }
}

// $m = new KhaoSatModel();
// $r = $m->searchCtdt(1,1,0);
// $code = json_encode($r);
// $code = json_encode($r[0]["ctdt_id"]);
// $code = $r[0];
// echo json_encode($r[0]["ctdt_id"]);

?>