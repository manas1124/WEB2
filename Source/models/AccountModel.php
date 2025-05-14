<?php
require_once __DIR__ . '/database.php';
class AccountModel
{
    private $db;
    public function __construct()
    {
        $this->db = new MyConnection();
    }

    public function usernameIsExist($username)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM tai_khoan WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true; 
        } else {
            return false; 
        }
    }
    public function isExistDoiTuongId($doiTuongId)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM doi_tuong WHERE dt_id = ?");
        $stmt->bind_param("s", $doiTuongId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true; 
        } else {
            return false; 
        }
    }
    public function usernameIsExistByAccountId($username,$accountId)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM tai_khoan WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1 && $result->fetch_assoc()['tk_id'] == $accountId) {
            return false;
        }
        if ($result->num_rows > 0 ) {
            return true; 
        } else {
            return false; 
        }
    }

    // Database operations
    public function create($username, $password, $dt_id, $quyen_id = 3, $status = 1)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO tai_khoan (username, password, dt_id, quyen_id, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiii", $username, $password, $dt_id, $quyen_id, $status);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function getAllTaiKhoan()
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("select *,quyen.ten_quyen 
                            from tai_khoan 
                            inner join quyen on tai_khoan.quyen_id = quyen.quyen_id 
                            where tai_khoan.status = 1");
                               
        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            return false;
        }

        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            return false;
        }

        $result = $stmt->get_result();
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();
        return $data;
    }
    public function update($tk_id, $username, $dt_id, $quyen_id, $status)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE tai_khoan 
                                SET username = ?, dt_id = ?, quyen_id = ?, status = ?
                                WHERE tk_id = ?
    ");
        $stmt->bind_param("siiii", $username, $dt_id, $quyen_id, $status, $tk_id);
        return $stmt->execute();
    }
    public function updatePassword($tk_id, $hashedPassword)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE tai_khoan 
                                SET password = ?
                                WHERE tk_id = ?
    ");
        $stmt->bind_param("si",  $hashedPassword, $tk_id);
        return $stmt->execute();
    }
    //hàm xoá , chuyển status về 0 thay vì xoá hết
    public function softDelete($tk_id)
    {
        $conn = $this->db->getConnection();
        $sql = "DELETE FROM tai_khoan WHERE tk_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $tk_id);
        $result = $stmt->execute();
        $stmt->close();
        $this->db->closeConnection();
        return $result;
    }
    public function searchAccount($keyword)
    {
        $conn = $this->db->getConnection();
        $query = "SELECT * FROM tai_khoan WHERE username LIKE ? AND status = 1";

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            return [];
        }

        $likeKeyword = '%' . $keyword . '%';
        $stmt->bind_param("s", $likeKeyword);

        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            $stmt->close();
            return [];
        }

        $result = $stmt->get_result();
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();
        $this->db->closeConnection();
        return $data;
    }
    public function getAccountById($tk_id)
    {
        $conn = $this->db->getConnection();
        $query = "
        SELECT 
            tai_khoan.tk_id,
            tai_khoan.username,
            tai_khoan.password,
            tai_khoan.dt_id,
            tai_khoan.quyen_id,
            tai_khoan.status,
            loai_doi_tuong.ten_dt,
            loai_doi_tuong.status AS dt_status,
            quyen.ten_quyen,
            quyen.status AS quyen_status
        FROM tai_khoan
        JOIN loai_doi_tuong ON tai_khoan.dt_id = loai_doi_tuong.dt_id
        JOIN quyen ON tai_khoan.quyen_id = quyen.quyen_id
        WHERE tai_khoan.tk_id = ?
    ";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $tk_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }
    // loi lấy quyền của tài khoản, tài khoản có quyền nhưng không có chức năng
    public function getAccount($username)
    {
    $conn = $this->db->getConnection();
    $stmt = $conn->prepare("SELECT tk_id, username, password, dt_id,quyen_id
                            FROM tai_khoan
                            WHERE username = ?");

    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return false;
    }

    $stmt->bind_param("s", $username);

    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        $stmt->close();
        return false;
    }

    $result = $stmt->get_result();
    $data = null;
    $keys = [];

    while ($row = $result->fetch_assoc()) {
        if (!$data) {
            // Lưu lại thông tin user lần đầu tiên
            $data = [
                'username' => $row['username'],
                'password' => $row['password'],
                'dt_id' => $row['dt_id'],
                'tk_id' => $row['tk_id'],
                'quyen_id' => $row['quyen_id'],
                'keys' => []
            ];
        }

        // Gom key vào danh sách
        // $keys[] = $row['key'];
    }

    if ($data) {
        require_once __DIR__ . '/../models/quyenModel.php';
        $quyenModel = new QuyenModel();
        $quyenList = $quyenModel->getChucNangByQuyenId($data['quyen_id']);
        //gom vào danh sách
        foreach ($quyenList as $item) {
            $keys[] = $item['key'];
        }
        $data['keys'] = $keys;
    }

    $stmt->close();
    $this->db->closeConnection();
    return $data;
    }

    public function getById($tk_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM tai_khoan WHERE tk_id = ?");
        $stmt->bind_param("i", $tk_id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // ✅ Trả về 1 bản ghi
        } else {
            return null; // ❌ Không tìm thấy
        }
    }
}
