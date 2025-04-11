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
        $stmt = $conn->prepare("SELECT * FROM khao_sat where status = 1 ");
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
        $query = "
            SELECT 
            khao_sat.ks_id, khao_sat.ten_ks, khao_sat.ngay_bat_dau,khao_sat.ngay_ket_thuc,khao_sat.su_dung,khao_sat.status,
            loai_tra_loi.ltl_id,loai_tra_loi.thang_diem,
            nhom_khao_sat.nks_id,nhom_khao_sat.ten_nks,
            chu_ki.ck_id,chu_ki.ten_ck,
            nganh.nganh_id, nganh.ten_nganh,
            ctdt_daura.la_ctdt
            FROM khao_sat
            JOIN loai_tra_loi ON khao_sat.ltl_id = loai_tra_loi.ltl_id
            JOIN nhom_khao_sat ON khao_sat.nks_id = nhom_khao_sat.nks_id
            JOIN ctdt_daura ON khao_sat.ctdt_id = khao_sat.ctdt_id
            JOIN chu_ki ON ctdt_daura.ck_id = chu_ki.ck_id 
            JOIN nganh ON  ctdt_daura.nganh_id=  nganh.nganh_id
            Where khao_sat.ks_id = ? and khao_sat.ctdt_id = ctdt_daura.ctdt_id
        ";
        $stmt = $conn->prepare($query);
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

    public function update($ks_id, $ten_ks, $ngay_bat_dau, $ngay_ket_thuc, $su_dung, $nks_id, $ltl_id, $ctdt_id, $status)
    {
        $conn = $this->db->getConnection();
        // (ten_ks, ngay_bat_dau, ngay_ket_thuc, su_dung, nks_id, ltl_id, ctdt_id,status )
        $stmt = $conn->prepare(
            "UPDATE khao_sat SET 
        ten_ks = ?,
        ngay_bat_dau = ?,
        ngay_ket_thuc = ?,
        su_dung = ?,
        nks_id = ?,
        ltl_id = ?,
        ctdt_id = ?,
        status = ?
        WHERE ks_id = ?"
        );
        $stmt->bind_param("sssiiiiii", $ten_ks, $ngay_bat_dau, $ngay_ket_thuc, $su_dung, $nks_id, $ltl_id, $ctdt_id, $status, $ks_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($ks_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE khao_sat SET status = 0 WHERE ks_id = ?");
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
// $r = $m->getKhaoSatById(2);
// echo json_encode($r);

?>