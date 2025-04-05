<?php
    require_once __DIR__ . '/database.php';
    class AccountModel {
        private $db;
        public function __construct()
        {
            $this->db = new MyConnection();
        }

        public function getAccount($username) {
            $conn = $this->db->getConnection();
            $stmt = $conn->prepare("SELECT * FROM tai_khoan WHERE username = ? AND status = 1");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return json_encode($result->fetch_assoc());
            }
            $this->db->closeConnection();
            // return data as string json
            return null;
        }
    }
?>