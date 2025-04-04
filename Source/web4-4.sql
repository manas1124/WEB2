-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: student_survey_management
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cau_hoi`
--

DROP TABLE IF EXISTS `cau_hoi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cau_hoi` (
  `ch_id` int NOT NULL,
  `noi_dung` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mks_id` int DEFAULT NULL COMMENT 'ma muc khao sat',
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`ch_id`),
  KEY `cau_hoi_mks_id_fk` (`mks_id`),
  CONSTRAINT `cau_hoi_mks_id_fk` FOREIGN KEY (`mks_id`) REFERENCES `muc_khao_sat` (`mks_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cau_hoi`
--

LOCK TABLES `cau_hoi` WRITE;
/*!40000 ALTER TABLE `cau_hoi` DISABLE KEYS */;
INSERT INTO `cau_hoi` VALUES (1,'Bạn đánh giá thế nào về chương trình đào tạo?',1,0),(2,'Bạn có hài lòng với chất lượng giảng dạy?',2,0),(3,'Mức độ hài lòng của bạn về môi trường thực tập?',3,0);
/*!40000 ALTER TABLE `cau_hoi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chu_ki`
--

DROP TABLE IF EXISTS `chu_ki`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chu_ki` (
  `ck_id` int NOT NULL,
  `ten_ck` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`ck_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chu_ki`
--

LOCK TABLES `chu_ki` WRITE;
/*!40000 ALTER TABLE `chu_ki` DISABLE KEYS */;
INSERT INTO `chu_ki` VALUES (1,'2023-2024',0),(2,'2024-2025',0);
/*!40000 ALTER TABLE `chu_ki` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chuc_nang`
--

DROP TABLE IF EXISTS `chuc_nang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chuc_nang` (
  `cn_id` int NOT NULL COMMENT 'ma id chuc nang',
  `ten_cn` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quyen_id` int DEFAULT NULL COMMENT 'id quyen có chuc nang do',
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`cn_id`),
  KEY `chuc_nang_quyen_id_fk` (`quyen_id`),
  CONSTRAINT `chuc_nang_quyen_id_fk` FOREIGN KEY (`quyen_id`) REFERENCES `quyen` (`quyen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chuc_nang`
--

LOCK TABLES `chuc_nang` WRITE;
/*!40000 ALTER TABLE `chuc_nang` DISABLE KEYS */;
INSERT INTO `chuc_nang` VALUES (1,'Quản lý người dùng',1,0),(2,'Xem kết quả khảo sát',2,0),(3,'Làm khảo sát',3,0);
/*!40000 ALTER TABLE `chuc_nang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ctdt_daura`
--

DROP TABLE IF EXISTS `ctdt_daura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ctdt_daura` (
  `ctdt_id` int NOT NULL,
  `file` int DEFAULT NULL,
  `nganh_id` int DEFAULT NULL,
  `ck_id` int DEFAULT NULL COMMENT 'id chu ky',
  `la_ctdt` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`ctdt_id`),
  KEY `khoa_hoc_chu_ki_id_fk` (`ck_id`),
  KEY `khoa_hoc_nganh_id_fk` (`nganh_id`),
  CONSTRAINT `khoa_hoc_chu_ki_id_fk` FOREIGN KEY (`ck_id`) REFERENCES `chu_ki` (`ck_id`),
  CONSTRAINT `khoa_hoc_nganh_id_fk` FOREIGN KEY (`nganh_id`) REFERENCES `nganh` (`nganh_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ctdt_daura`
--

LOCK TABLES `ctdt_daura` WRITE;
/*!40000 ALTER TABLE `ctdt_daura` DISABLE KEYS */;
INSERT INTO `ctdt_daura` VALUES (1,1234,1,1,0,0),(2,5678,2,1,1,0),(3,9012,1,2,1,0);
/*!40000 ALTER TABLE `ctdt_daura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doi_tuong`
--

DROP TABLE IF EXISTS `doi_tuong`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doi_tuong` (
  `dt_id` int NOT NULL,
  `ho_ten` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diachi` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dien_thoai` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nhom_ks` int DEFAULT NULL,
  `loai_dt_id` int DEFAULT NULL COMMENT 'id loai doi tuong trong table loai doi tuong',
  `ctdt_id` int DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`dt_id`),
  KEY `doi_tuong_ctdt_id_fk` (`ctdt_id`),
  KEY `doi_tuong_loai_dt_fk` (`loai_dt_id`),
  KEY `user_loai_tk_fk` (`nhom_ks`),
  CONSTRAINT `doi_tuong_ctdt_id_fk` FOREIGN KEY (`ctdt_id`) REFERENCES `ctdt_daura` (`ctdt_id`),
  CONSTRAINT `doi_tuong_loai_dt_fk` FOREIGN KEY (`loai_dt_id`) REFERENCES `loai_doi_tuong` (`dt_id`),
  CONSTRAINT `user_loai_tk_fk` FOREIGN KEY (`nhom_ks`) REFERENCES `nhom_khao_sat` (`nks_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doi_tuong`
--

LOCK TABLES `doi_tuong` WRITE;
/*!40000 ALTER TABLE `doi_tuong` DISABLE KEYS */;
INSERT INTO `doi_tuong` VALUES (1,'Nguyễn Văn A','vana@example.com','Hà Nội','0987654321',1,1,1,0),(2,'Trần Thị B','thib@example.com','Hồ Chí Minh','0912345678',2,2,2,0),(3,'Lê Công C','congl@example.com','Đà Nẵng','0909090909',3,3,1,0);
/*!40000 ALTER TABLE `doi_tuong` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `khao_sat`
--

DROP TABLE IF EXISTS `khao_sat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `khao_sat` (
  `ks_id` int NOT NULL,
  `ten_ks` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_bat_dau` date DEFAULT NULL,
  `ngay_ket_thuc` date DEFAULT NULL,
  `su_dung` tinyint(1) DEFAULT NULL COMMENT 'hien tai khao sat co dang duoc thuc hien hay khong',
  `nks_id` int DEFAULT NULL COMMENT 'id nhóm khảo sát',
  `ltl_id` int DEFAULT NULL COMMENT 'loai cau tra loi',
  `ctdt_id` int DEFAULT NULL COMMENT 'ma chuong trinh dao tao',
  `status` tinyint(1) DEFAULT NULL COMMENT 'tinh trang su dung 0,1',
  PRIMARY KEY (`ks_id`),
  KEY `khao_sat_ctdt_id_fk` (`ctdt_id`),
  KEY `khao_sat_ltl_id_fk` (`ltl_id`),
  KEY `khao_sat_nks_id_fk` (`nks_id`),
  CONSTRAINT `khao_sat_ctdt_id_fk` FOREIGN KEY (`ctdt_id`) REFERENCES `ctdt_daura` (`ctdt_id`),
  CONSTRAINT `khao_sat_ltl_id_fk` FOREIGN KEY (`ltl_id`) REFERENCES `loai_tra_loi` (`ltl_id`),
  CONSTRAINT `khao_sat_nks_id_fk` FOREIGN KEY (`nks_id`) REFERENCES `nhom_khao_sat` (`nks_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `khao_sat`
--

LOCK TABLES `khao_sat` WRITE;
/*!40000 ALTER TABLE `khao_sat` DISABLE KEYS */;
INSERT INTO `khao_sat` VALUES (1,'Khảo sát đầu ra CNTT','2023-10-26','2023-10-28',1,1,1,1,0),(2,'Khảo sát chất lượng giảng dạy QTB','2023-10-26','2023-10-31',0,2,2,2,0),(3,'Khảo sát thực tập KTD','2023-10-26','2023-10-30',1,3,1,3,0);
/*!40000 ALTER TABLE `khao_sat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kq_khao_sat`
--

DROP TABLE IF EXISTS `kq_khao_sat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kq_khao_sat` (
  `kqks_id` int NOT NULL,
  `nguoi_lamks_id` int DEFAULT NULL,
  `ks_id` int DEFAULT NULL COMMENT 'id cua bai khao sat',
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`kqks_id`),
  KEY `kq_khao_sat_ks_id_fk` (`ks_id`),
  KEY `kq_khao_sat_nguoi_lamks_id_fk` (`nguoi_lamks_id`),
  CONSTRAINT `kq_khao_sat_ks_id_fk` FOREIGN KEY (`ks_id`) REFERENCES `khao_sat` (`ks_id`),
  CONSTRAINT `kq_khao_sat_nguoi_lamks_id_fk` FOREIGN KEY (`nguoi_lamks_id`) REFERENCES `doi_tuong` (`dt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kq_khao_sat`
--

LOCK TABLES `kq_khao_sat` WRITE;
/*!40000 ALTER TABLE `kq_khao_sat` DISABLE KEYS */;
INSERT INTO `kq_khao_sat` VALUES (1,1,1,0),(2,2,2,0),(3,3,3,0);
/*!40000 ALTER TABLE `kq_khao_sat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loai_doi_tuong`
--

DROP TABLE IF EXISTS `loai_doi_tuong`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `loai_doi_tuong` (
  `dt_id` int NOT NULL,
  `ten_dt` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`dt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loai_doi_tuong`
--

LOCK TABLES `loai_doi_tuong` WRITE;
/*!40000 ALTER TABLE `loai_doi_tuong` DISABLE KEYS */;
INSERT INTO `loai_doi_tuong` VALUES (1,'Sinh viên',0),(2,'Giảng viên',0),(3,'Doanh nghiệp',0);
/*!40000 ALTER TABLE `loai_doi_tuong` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loai_tra_loi`
--

DROP TABLE IF EXISTS `loai_tra_loi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `loai_tra_loi` (
  `ltl_id` int NOT NULL,
  `thang_diem` int DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`ltl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loai_tra_loi`
--

LOCK TABLES `loai_tra_loi` WRITE;
/*!40000 ALTER TABLE `loai_tra_loi` DISABLE KEYS */;
INSERT INTO `loai_tra_loi` VALUES (1,5,0),(2,10,0);
/*!40000 ALTER TABLE `loai_tra_loi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `muc_khao_sat`
--

DROP TABLE IF EXISTS `muc_khao_sat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `muc_khao_sat` (
  `mks_id` int NOT NULL,
  `ten_muc` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ks_id` int DEFAULT NULL COMMENT 'id cua bai khao sat',
  PRIMARY KEY (`mks_id`),
  KEY `muc_khao_sat_ks_id_fk` (`ks_id`),
  CONSTRAINT `muc_khao_sat_ks_id_fk` FOREIGN KEY (`ks_id`) REFERENCES `khao_sat` (`ks_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `muc_khao_sat`
--

LOCK TABLES `muc_khao_sat` WRITE;
/*!40000 ALTER TABLE `muc_khao_sat` DISABLE KEYS */;
INSERT INTO `muc_khao_sat` VALUES (1,'Mục khảo sát 1',1),(2,'Mục khảo sát 2',2),(3,'Mục khảo sát 3',3);
/*!40000 ALTER TABLE `muc_khao_sat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nganh`
--

DROP TABLE IF EXISTS `nganh`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nganh` (
  `nganh_id` int NOT NULL,
  `ten_nganh` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`nganh_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nganh`
--

LOCK TABLES `nganh` WRITE;
/*!40000 ALTER TABLE `nganh` DISABLE KEYS */;
INSERT INTO `nganh` VALUES (1,'Công nghệ thông tin',0),(2,'Quản trị kinh doanh',0),(3,'Kỹ thuật điện tử',0);
/*!40000 ALTER TABLE `nganh` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nhom_khao_sat`
--

DROP TABLE IF EXISTS `nhom_khao_sat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nhom_khao_sat` (
  `nks_id` int NOT NULL,
  `ten_nks` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`nks_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nhom_khao_sat`
--

LOCK TABLES `nhom_khao_sat` WRITE;
/*!40000 ALTER TABLE `nhom_khao_sat` DISABLE KEYS */;
INSERT INTO `nhom_khao_sat` VALUES (1,'Khảo sát đầu ra',0),(2,'Khảo sát chất lượng giảng dạy',0),(3,'Khảo sát thực tập',0);
/*!40000 ALTER TABLE `nhom_khao_sat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quyen`
--

DROP TABLE IF EXISTS `quyen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quyen` (
  `quyen_id` int NOT NULL,
  `ten_quyen` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`quyen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quyen`
--

LOCK TABLES `quyen` WRITE;
/*!40000 ALTER TABLE `quyen` DISABLE KEYS */;
INSERT INTO `quyen` VALUES (1,'Admin',0),(2,'Giảng viên',0),(3,'Sinh viên',0);
/*!40000 ALTER TABLE `quyen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tai_khoan`
--

DROP TABLE IF EXISTS `tai_khoan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tai_khoan` (
  `tk_id` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dt_id` int DEFAULT NULL COMMENT 'doi tuong id lien ket ban doi tuong',
  `quyen_id` int DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  KEY `tai_khoan_dt_id_fk` (`dt_id`),
  KEY `tai_khoan_quyen_id_fk` (`quyen_id`),
  CONSTRAINT `tai_khoan_dt_id_fk` FOREIGN KEY (`dt_id`) REFERENCES `doi_tuong` (`dt_id`),
  CONSTRAINT `tai_khoan_quyen_id_fk` FOREIGN KEY (`quyen_id`) REFERENCES `quyen` (`quyen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tai_khoan`
--

LOCK TABLES `tai_khoan` WRITE;
/*!40000 ALTER TABLE `tai_khoan` DISABLE KEYS */;
INSERT INTO `tai_khoan` VALUES ('tk001','vana','password123',1,3,0),('tk002','thib','secure456',2,2,0),('tk003','congl','strong789',3,3,0);
/*!40000 ALTER TABLE `tai_khoan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tra_loi`
--

DROP TABLE IF EXISTS `tra_loi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tra_loi` (
  `tl_id` int NOT NULL,
  `ket_qua` int DEFAULT NULL,
  `ch_id` int DEFAULT NULL COMMENT 'cau hoi id',
  `kq_ks_id` int DEFAULT NULL COMMENT 'ket qua khao sat id',
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`tl_id`),
  KEY `tra_loi_ch_id_fk` (`ch_id`),
  KEY `tra_loi_kq_ks_id_fk` (`kq_ks_id`),
  CONSTRAINT `tra_loi_ch_id_fk` FOREIGN KEY (`ch_id`) REFERENCES `cau_hoi` (`ch_id`),
  CONSTRAINT `tra_loi_kq_ks_id_fk` FOREIGN KEY (`kq_ks_id`) REFERENCES `kq_khao_sat` (`kqks_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tra_loi`
--

LOCK TABLES `tra_loi` WRITE;
/*!40000 ALTER TABLE `tra_loi` DISABLE KEYS */;
INSERT INTO `tra_loi` VALUES (1,4,1,1,0),(2,5,2,2,0),(3,3,3,3,0);
/*!40000 ALTER TABLE `tra_loi` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-04 11:13:19
