<?php
    class ObjectModel {
        private $db;
        public function __construct()
        {
            $this->db = new MyConnection();
        }

        public function getObjectId($id) {
            $conn = $this->db->getConnection();
            $stmt = $conn->prepare("SELECT * FROM doi_tuong WHERE dt_id = ?");
            $stmt->bind_param("i", $id);
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