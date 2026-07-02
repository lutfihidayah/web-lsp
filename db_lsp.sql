-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: db_lsp
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `absensi`
--

DROP TABLE IF EXISTS `absensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `absensi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `asesmen_id` bigint unsigned NOT NULL,
  `pertemuan_ke` int NOT NULL,
  `tanggal` date DEFAULT NULL,
  `status` enum('hadir','tidak_hadir','belum') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum',
  `dikonfirmasi_oleh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `absensi_asesmen_id_foreign` (`asesmen_id`),
  CONSTRAINT `absensi_asesmen_id_foreign` FOREIGN KEY (`asesmen_id`) REFERENCES `asesmen` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `absensi`
--

LOCK TABLES `absensi` WRITE;
/*!40000 ALTER TABLE `absensi` DISABLE KEYS */;
/*!40000 ALTER TABLE `absensi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asesmen`
--

DROP TABLE IF EXISTS `asesmen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asesmen` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pendaftaran_id` bigint unsigned NOT NULL,
  `status` enum('berlangsung','selesai','lulus','tidak_lulus') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'berlangsung',
  `nilai_quiz` int DEFAULT NULL,
  `no_sertifikat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sertifikat_dibuat_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `asesmen_pendaftaran_id_foreign` (`pendaftaran_id`),
  KEY `asesmen_status_index` (`status`),
  CONSTRAINT `asesmen_pendaftaran_id_foreign` FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asesmen`
--

LOCK TABLES `asesmen` WRITE;
/*!40000 ALTER TABLE `asesmen` DISABLE KEYS */;
/*!40000 ALTER TABLE `asesmen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hasil`
--

DROP TABLE IF EXISTS `hasil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hasil` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `peserta_id` bigint unsigned NOT NULL,
  `jadwal_id` bigint unsigned NOT NULL,
  `asesor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` int DEFAULT NULL,
  `hasil` enum('Kompeten','Belum Kompeten','Dalam Proses') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Dalam Proses',
  `no_sertifikat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hasil_peserta_id_foreign` (`peserta_id`),
  KEY `hasil_jadwal_id_foreign` (`jadwal_id`),
  CONSTRAINT `hasil_jadwal_id_foreign` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`id`) ON DELETE CASCADE,
  CONSTRAINT `hasil_peserta_id_foreign` FOREIGN KEY (`peserta_id`) REFERENCES `peserta` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hasil`
--

LOCK TABLES `hasil` WRITE;
/*!40000 ALTER TABLE `hasil` DISABLE KEYS */;
/*!40000 ALTER TABLE `hasil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `informasi`
--

DROP TABLE IF EXISTS `informasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `informasi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `penulis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Admin LSP',
  `dilihat` int NOT NULL DEFAULT '0',
  `status` enum('Dipublikasikan','Draft') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Draft',
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `informasi`
--

LOCK TABLES `informasi` WRITE;
/*!40000 ALTER TABLE `informasi` DISABLE KEYS */;
INSERT INTO `informasi` VALUES (1,'Pembukaan Pendaftaran Sertifikasi Batch Januari 2026','Pengumuman','LSP Profesional membuka pendaftaran untuk sertifikasi batch Januari 2026.','Admin LSP',1200,'Dipublikasikan',NULL,'2026-06-14 18:05:08','2026-06-14 18:05:08'),(2,'Kerjasama dengan Industri untuk Peningkatan Kompetensi','Kerjasama','LSP menjalin kerjasama strategis dengan berbagai perusahaan teknologi.','Admin LSP',876,'Dipublikasikan',NULL,'2026-06-14 18:05:08','2026-06-14 18:05:08'),(3,'Tips Sukses Menghadapi Uji Kompetensi','Tips','Panduan lengkap persiapan menghadapi uji kompetensi dari para asesor.','Admin LSP',2100,'Dipublikasikan',NULL,'2026-06-14 18:05:08','2026-06-14 18:05:08'),(4,'Peluncuran Skema Sertifikasi Baru 2025','Berita','LSP Profesional meluncurkan skema sertifikasi baru untuk tahun 2025.','Admin LSP',654,'Dipublikasikan',NULL,'2026-06-14 18:05:09','2026-06-14 18:05:09'),(5,'Rencana Pembukaan Batch Baru Februari 2026','Pengumuman','Informasi terkait rencana pembukaan batch baru Februari 2026.','Admin LSP',0,'Draft',NULL,'2026-06-14 18:05:09','2026-06-14 18:05:09');
/*!40000 ALTER TABLE `informasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jadwal`
--

DROP TABLE IF EXISTS `jadwal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jadwal` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `skema_id` bigint unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asesor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kuota` int NOT NULL DEFAULT '30',
  `status` enum('Terjadwal','Berlangsung','Selesai','Dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Terjadwal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jadwal_skema_id_foreign` (`skema_id`),
  KEY `jadwal_tanggal_index` (`tanggal`),
  CONSTRAINT `jadwal_skema_id_foreign` FOREIGN KEY (`skema_id`) REFERENCES `skema` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jadwal`
--

LOCK TABLES `jadwal` WRITE;
/*!40000 ALTER TABLE `jadwal` DISABLE KEYS */;
INSERT INTO `jadwal` VALUES (1,1,'2026-07-10','08.00 - 16.00','Ruang A101','Budi Santoso',25,'Terjadwal','2026-06-14 18:05:07','2026-06-14 18:05:07'),(2,2,'2026-07-12','09.00 - 15.00','Ruang B202','Rina Oktavia',20,'Terjadwal','2026-06-14 18:05:07','2026-06-14 18:05:07'),(3,4,'2026-06-15','08.00 - 17.00','Lab Jaringan','Hendra Wijaya',18,'Berlangsung','2026-06-14 18:05:07','2026-06-14 18:05:07'),(4,3,'2026-06-18','08.00 - 14.00','Ruang C303','Anisa Rahmawati',30,'Terjadwal','2026-06-14 18:05:08','2026-06-14 18:05:08'),(5,5,'2026-06-20','09.00 - 16.00','Lab Desain','Sofa Azzahra',22,'Terjadwal','2026-06-14 18:05:08','2026-06-14 18:05:08'),(6,6,'2026-06-22','08.00 - 15.00','Ruang A102','Dimas Mardiana',15,'Terjadwal','2026-06-14 18:05:08','2026-06-14 18:05:08'),(7,7,'2026-06-25','09.00 - 16.00','Lab Desain','Lutfi Hidayah',19,'Terjadwal','2026-06-14 18:05:08','2026-06-14 18:05:08'),(8,9,'2026-06-27','08.00 - 17.00','Lab Komputer','Budi Santoso',28,'Terjadwal','2026-06-14 18:05:08','2026-06-14 18:05:08'),(9,8,'2026-06-28','08.00 - 16.00','Lab Jaringan','Hendra Wijaya',12,'Dibatalkan','2026-06-14 18:05:08','2026-06-14 18:05:08'),(10,6,'2026-06-30','09.00 - 15.00','Ruang B201','Rina Oktavia',17,'Terjadwal','2026-06-14 18:05:08','2026-06-14 18:05:08');
/*!40000 ALTER TABLE `jadwal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_04_13_025456_create_skema_table',1),(5,'2026_04_13_025510_create_peserta_table',1),(6,'2026_04_13_025520_create_jadwal_table',1),(7,'2026_04_13_025528_create_hasil_table',1),(8,'2026_04_13_025535_create_informasi_table',1),(9,'2026_04_17_040015_add_fields_to_users_table',1),(10,'2026_05_08_100001_add_harga_to_skema_table',1),(11,'2026_05_08_100002_create_pendaftaran_table',1),(12,'2026_05_09_100001_create_soal_table',1),(13,'2026_05_09_100002_create_asesmen_table',1),(14,'2026_05_09_100003_create_absensi_table',1),(15,'2026_05_09_100004_create_quiz_jawaban_table',1),(16,'2026_05_22_000001_update_roles_in_users_table',1),(17,'2026_05_22_000004_normalize_peserta_table',1),(18,'2026_05_22_000005_add_passing_grade_to_skema_table',1),(19,'2026_05_22_000006_add_indexes_to_tables',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pendaftaran`
--

DROP TABLE IF EXISTS `pendaftaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pendaftaran` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `skema_id` bigint unsigned NOT NULL,
  `jadwal_id` bigint unsigned DEFAULT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `snap_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` bigint NOT NULL,
  `status` enum('pending','paid','failed','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `midtrans_response` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pendaftaran_order_id_unique` (`order_id`),
  KEY `pendaftaran_user_id_foreign` (`user_id`),
  KEY `pendaftaran_skema_id_foreign` (`skema_id`),
  KEY `pendaftaran_jadwal_id_foreign` (`jadwal_id`),
  KEY `pendaftaran_status_index` (`status`),
  CONSTRAINT `pendaftaran_jadwal_id_foreign` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pendaftaran_skema_id_foreign` FOREIGN KEY (`skema_id`) REFERENCES `skema` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pendaftaran_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pendaftaran`
--

LOCK TABLES `pendaftaran` WRITE;
/*!40000 ALTER TABLE `pendaftaran` DISABLE KEYS */;
/*!40000 ALTER TABLE `pendaftaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peserta`
--

DROP TABLE IF EXISTS `peserta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `peserta` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `skema_id` bigint unsigned NOT NULL,
  `status` enum('Verifikasi','Asesmen','Kompeten','Belum Kompeten','Dalam Proses') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Verifikasi',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `peserta_skema_id_foreign` (`skema_id`),
  KEY `peserta_user_id_foreign` (`user_id`),
  CONSTRAINT `peserta_skema_id_foreign` FOREIGN KEY (`skema_id`) REFERENCES `skema` (`id`) ON DELETE CASCADE,
  CONSTRAINT `peserta_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peserta`
--

LOCK TABLES `peserta` WRITE;
/*!40000 ALTER TABLE `peserta` DISABLE KEYS */;
INSERT INTO `peserta` VALUES (1,4,'Kuningan, Jawa Barat',1,'Verifikasi','2026-06-14 18:05:04','2026-06-14 18:05:04'),(2,5,'Bandung, Jawa Barat',4,'Asesmen','2026-06-14 18:05:04','2026-06-14 18:05:04'),(3,6,'Jakarta Selatan',7,'Belum Kompeten','2026-06-14 18:05:05','2026-06-14 18:05:05'),(4,7,'Cirebon, Jawa Barat',3,'Kompeten','2026-06-14 18:05:05','2026-06-14 18:05:05'),(5,8,'Surabaya, Jawa Timur',2,'Dalam Proses','2026-06-14 18:05:06','2026-06-14 18:05:06'),(6,9,'Yogyakarta',6,'Kompeten','2026-06-14 18:05:06','2026-06-14 18:05:06'),(7,10,'Semarang, Jawa Tengah',1,'Verifikasi','2026-06-14 18:05:07','2026-06-14 18:05:07'),(8,11,'Medan, Sumatera Utara',5,'Asesmen','2026-06-14 18:05:07','2026-06-14 18:05:07');
/*!40000 ALTER TABLE `peserta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz_jawaban`
--

DROP TABLE IF EXISTS `quiz_jawaban`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quiz_jawaban` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `asesmen_id` bigint unsigned NOT NULL,
  `soal_id` bigint unsigned NOT NULL,
  `jawaban_user` enum('a','b','c','d') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_benar` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_jawaban_asesmen_id_foreign` (`asesmen_id`),
  KEY `quiz_jawaban_soal_id_foreign` (`soal_id`),
  CONSTRAINT `quiz_jawaban_asesmen_id_foreign` FOREIGN KEY (`asesmen_id`) REFERENCES `asesmen` (`id`) ON DELETE CASCADE,
  CONSTRAINT `quiz_jawaban_soal_id_foreign` FOREIGN KEY (`soal_id`) REFERENCES `soal` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz_jawaban`
--

LOCK TABLES `quiz_jawaban` WRITE;
/*!40000 ALTER TABLE `quiz_jawaban` DISABLE KEYS */;
/*!40000 ALTER TABLE `quiz_jawaban` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skema`
--

DROP TABLE IF EXISTS `skema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `skema` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `durasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_kompetensi` int NOT NULL,
  `status` enum('Aktif','Tidak Aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `harga` bigint NOT NULL DEFAULT '1500000',
  `passing_grade` int NOT NULL DEFAULT '60',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skema`
--

LOCK TABLES `skema` WRITE;
/*!40000 ALTER TABLE `skema` DISABLE KEYS */;
INSERT INTO `skema` VALUES (1,'Junior Web Developer','Teknologi Informasi','2-3 Hari',8,'Aktif','Kompetensi dalam membangun website dengan HTML, CSS, dan JavaScript.',1500000,60,'2026-06-14 18:05:01','2026-06-14 18:05:01'),(2,'Digital Marketing Specialist','Pemasaran Digital','2 Hari',6,'Aktif','Strategi pemasaran digital, SEO, dan manajemen media sosial.',1500000,60,'2026-06-14 18:05:01','2026-06-14 18:05:01'),(3,'Administrasi Perkantoran','Administrasi','5 Hari',10,'Aktif','Kompetensi administrasi perkantoran secara profesional.',1500000,60,'2026-06-14 18:05:01','2026-06-14 18:05:01'),(4,'Network Administrator','Teknologi Informasi','3 Hari',12,'Aktif','Pengelolaan dan pemeliharaan infrastruktur jaringan komputer.',1500000,60,'2026-06-14 18:05:01','2026-06-14 18:05:01'),(5,'Graphic Designer','Desain','2 Hari',7,'Aktif','Desain grafis, branding, dan pembuatan konten visual.',1500000,60,'2026-06-14 18:05:01','2026-06-14 18:05:01'),(6,'Data Analyst','Teknologi Informasi','3 Hari',10,'Aktif','Analisis data, visualisasi, dan pengambilan keputusan berbasis data.',1500000,60,'2026-06-14 18:05:01','2026-06-14 18:05:01'),(7,'UI/UX Designer','Desain','3 Hari',9,'Aktif','Desain antarmuka dan pengalaman pengguna yang optimal.',1500000,60,'2026-06-14 18:05:01','2026-06-14 18:05:01'),(8,'Cyber Security','Teknologi Informasi','4 Hari',14,'Tidak Aktif','Keamanan sistem dan jaringan komputer.',1500000,60,'2026-06-14 18:05:01','2026-06-14 18:05:01'),(9,'Software Engineer','Teknologi Informasi','4 Hari',12,'Aktif','Pengembangan perangkat lunak secara profesional.',1500000,60,'2026-06-14 18:05:01','2026-06-14 18:05:01'),(10,'Administrasi Keuangan','Administrasi','3 Hari',8,'Aktif','Pengelolaan keuangan dan akuntansi perkantoran.',1500000,60,'2026-06-14 18:05:01','2026-06-14 18:05:01');
/*!40000 ALTER TABLE `skema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `soal`
--

DROP TABLE IF EXISTS `soal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `soal` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `skema_id` bigint unsigned NOT NULL,
  `pertanyaan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pilihan_a` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pilihan_b` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pilihan_c` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pilihan_d` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jawaban_benar` enum('a','b','c','d') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `soal_skema_id_foreign` (`skema_id`),
  CONSTRAINT `soal_skema_id_foreign` FOREIGN KEY (`skema_id`) REFERENCES `skema` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `soal`
--

LOCK TABLES `soal` WRITE;
/*!40000 ALTER TABLE `soal` DISABLE KEYS */;
INSERT INTO `soal` VALUES (1,1,'Apa kepanjangan dari HTML?','Hyper Text Markup Language','High Text Machine Language','Hyper Transfer Markup Language','Home Tool Markup Language','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(2,1,'Tag HTML yang digunakan untuk membuat link adalah?','<link>','<a>','<href>','<url>','b','2026-06-14 18:05:02','2026-06-14 18:05:02'),(3,1,'CSS digunakan untuk?','Membuat struktur halaman','Membuat logika program','Mengatur tampilan halaman','Mengelola database','c','2026-06-14 18:05:02','2026-06-14 18:05:02'),(4,1,'Properti CSS untuk mengubah warna teks adalah?','text-color','font-color','color','text-style','c','2026-06-14 18:05:02','2026-06-14 18:05:02'),(5,1,'JavaScript adalah bahasa pemrograman yang berjalan di?','Server saja','Browser saja','Database','Browser dan Server','d','2026-06-14 18:05:02','2026-06-14 18:05:02'),(6,1,'Fungsi document.getElementById() digunakan untuk?','Membuat elemen baru','Menghapus elemen','Memilih elemen berdasarkan ID','Mengubah warna halaman','c','2026-06-14 18:05:02','2026-06-14 18:05:02'),(7,1,'Apa itu responsive design?','Desain yang cepat','Desain yang menyesuaikan ukuran layar','Desain yang berwarna','Desain yang animatif','b','2026-06-14 18:05:02','2026-06-14 18:05:02'),(8,1,'Tag HTML untuk menampilkan gambar adalah?','<image>','<pic>','<img>','<photo>','c','2026-06-14 18:05:02','2026-06-14 18:05:02'),(9,1,'Apa fungsi dari tag <form> dalam HTML?','Menampilkan tabel','Membuat formulir input','Membuat navigasi','Menampilkan video','b','2026-06-14 18:05:02','2026-06-14 18:05:02'),(10,1,'Framework CSS yang populer adalah?','React','Laravel','Bootstrap','Node.js','c','2026-06-14 18:05:02','2026-06-14 18:05:02'),(11,2,'Apa kepanjangan dari SEO?','Search Engine Optimization','Social Engine Operation','Search Email Optimization','Site Engine Optimizer','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(12,2,'Platform media sosial mana yang paling efektif untuk B2B marketing?','TikTok','LinkedIn','Snapchat','Pinterest','b','2026-06-14 18:05:02','2026-06-14 18:05:02'),(13,2,'CTR adalah singkatan dari?','Click Through Rate','Cost Through Revenue','Customer Target Rate','Content To Revenue','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(14,2,'Apa itu bounce rate?','Jumlah pengunjung baru','Persentase pengunjung yang langsung meninggalkan situs','Kecepatan loading halaman','Jumlah klik iklan','b','2026-06-14 18:05:02','2026-06-14 18:05:02'),(15,2,'Google Ads menggunakan model pembayaran?','Pay Per View','Pay Per Click','Pay Per Month','Pay Per User','b','2026-06-14 18:05:02','2026-06-14 18:05:02'),(16,2,'Apa fungsi Google Analytics?','Membuat website','Mengirim email','Menganalisis trafik website','Membuat iklan','c','2026-06-14 18:05:02','2026-06-14 18:05:02'),(17,2,'Content marketing bertujuan untuk?','Menjual langsung','Memberikan nilai melalui konten berkualitas','Mengirim spam','Membuat virus','b','2026-06-14 18:05:02','2026-06-14 18:05:02'),(18,2,'KPI dalam marketing adalah?','Key Performance Indicator','Knowledge Process Integration','Key Product Information','Known Performance Index','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(19,2,'Email marketing yang efektif harus memiliki?','Subject line menarik','Banyak gambar besar','Teks sangat panjang','Warna mencolok','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(20,2,'Apa itu A/B Testing?','Tes kecepatan internet','Membandingkan dua versi untuk melihat mana yang lebih efektif','Tes keamanan website','Tes kompatibilitas browser','b','2026-06-14 18:05:02','2026-06-14 18:05:02'),(21,3,'Soal 1 untuk skema Administrasi Perkantoran: Apa yang dimaksud dengan kompetensi utama dalam bidang Administrasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(22,3,'Soal 2 untuk skema Administrasi Perkantoran: Apa yang dimaksud dengan kompetensi utama dalam bidang Administrasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(23,3,'Soal 3 untuk skema Administrasi Perkantoran: Apa yang dimaksud dengan kompetensi utama dalam bidang Administrasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(24,3,'Soal 4 untuk skema Administrasi Perkantoran: Apa yang dimaksud dengan kompetensi utama dalam bidang Administrasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(25,3,'Soal 5 untuk skema Administrasi Perkantoran: Apa yang dimaksud dengan kompetensi utama dalam bidang Administrasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(26,3,'Soal 6 untuk skema Administrasi Perkantoran: Apa yang dimaksud dengan kompetensi utama dalam bidang Administrasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(27,3,'Soal 7 untuk skema Administrasi Perkantoran: Apa yang dimaksud dengan kompetensi utama dalam bidang Administrasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(28,3,'Soal 8 untuk skema Administrasi Perkantoran: Apa yang dimaksud dengan kompetensi utama dalam bidang Administrasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(29,3,'Soal 9 untuk skema Administrasi Perkantoran: Apa yang dimaksud dengan kompetensi utama dalam bidang Administrasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(30,3,'Soal 10 untuk skema Administrasi Perkantoran: Apa yang dimaksud dengan kompetensi utama dalam bidang Administrasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(31,4,'Soal 1 untuk skema Network Administrator: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(32,4,'Soal 2 untuk skema Network Administrator: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(33,4,'Soal 3 untuk skema Network Administrator: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(34,4,'Soal 4 untuk skema Network Administrator: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(35,4,'Soal 5 untuk skema Network Administrator: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(36,4,'Soal 6 untuk skema Network Administrator: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(37,4,'Soal 7 untuk skema Network Administrator: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(38,4,'Soal 8 untuk skema Network Administrator: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(39,4,'Soal 9 untuk skema Network Administrator: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(40,4,'Soal 10 untuk skema Network Administrator: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(41,5,'Soal 1 untuk skema Graphic Designer: Apa yang dimaksud dengan kompetensi utama dalam bidang Desain?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(42,5,'Soal 2 untuk skema Graphic Designer: Apa yang dimaksud dengan kompetensi utama dalam bidang Desain?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(43,5,'Soal 3 untuk skema Graphic Designer: Apa yang dimaksud dengan kompetensi utama dalam bidang Desain?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(44,5,'Soal 4 untuk skema Graphic Designer: Apa yang dimaksud dengan kompetensi utama dalam bidang Desain?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(45,5,'Soal 5 untuk skema Graphic Designer: Apa yang dimaksud dengan kompetensi utama dalam bidang Desain?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(46,5,'Soal 6 untuk skema Graphic Designer: Apa yang dimaksud dengan kompetensi utama dalam bidang Desain?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(47,5,'Soal 7 untuk skema Graphic Designer: Apa yang dimaksud dengan kompetensi utama dalam bidang Desain?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(48,5,'Soal 8 untuk skema Graphic Designer: Apa yang dimaksud dengan kompetensi utama dalam bidang Desain?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(49,5,'Soal 9 untuk skema Graphic Designer: Apa yang dimaksud dengan kompetensi utama dalam bidang Desain?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(50,5,'Soal 10 untuk skema Graphic Designer: Apa yang dimaksud dengan kompetensi utama dalam bidang Desain?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(51,6,'Soal 1 untuk skema Data Analyst: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(52,6,'Soal 2 untuk skema Data Analyst: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(53,6,'Soal 3 untuk skema Data Analyst: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(54,6,'Soal 4 untuk skema Data Analyst: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(55,6,'Soal 5 untuk skema Data Analyst: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(56,6,'Soal 6 untuk skema Data Analyst: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(57,6,'Soal 7 untuk skema Data Analyst: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(58,6,'Soal 8 untuk skema Data Analyst: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(59,6,'Soal 9 untuk skema Data Analyst: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(60,6,'Soal 10 untuk skema Data Analyst: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(61,7,'Soal 1 untuk skema UI/UX Designer: Apa yang dimaksud dengan kompetensi utama dalam bidang Desain?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(62,7,'Soal 2 untuk skema UI/UX Designer: Apa yang dimaksud dengan kompetensi utama dalam bidang Desain?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(63,7,'Soal 3 untuk skema UI/UX Designer: Apa yang dimaksud dengan kompetensi utama dalam bidang Desain?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(64,7,'Soal 4 untuk skema UI/UX Designer: Apa yang dimaksud dengan kompetensi utama dalam bidang Desain?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:02','2026-06-14 18:05:02'),(65,7,'Soal 5 untuk skema UI/UX Designer: Apa yang dimaksud dengan kompetensi utama dalam bidang Desain?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(66,7,'Soal 6 untuk skema UI/UX Designer: Apa yang dimaksud dengan kompetensi utama dalam bidang Desain?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(67,7,'Soal 7 untuk skema UI/UX Designer: Apa yang dimaksud dengan kompetensi utama dalam bidang Desain?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(68,7,'Soal 8 untuk skema UI/UX Designer: Apa yang dimaksud dengan kompetensi utama dalam bidang Desain?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(69,7,'Soal 9 untuk skema UI/UX Designer: Apa yang dimaksud dengan kompetensi utama dalam bidang Desain?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(70,7,'Soal 10 untuk skema UI/UX Designer: Apa yang dimaksud dengan kompetensi utama dalam bidang Desain?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(71,8,'Soal 1 untuk skema Cyber Security: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(72,8,'Soal 2 untuk skema Cyber Security: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(73,8,'Soal 3 untuk skema Cyber Security: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(74,8,'Soal 4 untuk skema Cyber Security: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(75,8,'Soal 5 untuk skema Cyber Security: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(76,8,'Soal 6 untuk skema Cyber Security: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(77,8,'Soal 7 untuk skema Cyber Security: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(78,8,'Soal 8 untuk skema Cyber Security: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(79,8,'Soal 9 untuk skema Cyber Security: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(80,8,'Soal 10 untuk skema Cyber Security: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(81,9,'Soal 1 untuk skema Software Engineer: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(82,9,'Soal 2 untuk skema Software Engineer: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(83,9,'Soal 3 untuk skema Software Engineer: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(84,9,'Soal 4 untuk skema Software Engineer: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(85,9,'Soal 5 untuk skema Software Engineer: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(86,9,'Soal 6 untuk skema Software Engineer: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(87,9,'Soal 7 untuk skema Software Engineer: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(88,9,'Soal 8 untuk skema Software Engineer: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(89,9,'Soal 9 untuk skema Software Engineer: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(90,9,'Soal 10 untuk skema Software Engineer: Apa yang dimaksud dengan kompetensi utama dalam bidang Teknologi Informasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(91,10,'Soal 1 untuk skema Administrasi Keuangan: Apa yang dimaksud dengan kompetensi utama dalam bidang Administrasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(92,10,'Soal 2 untuk skema Administrasi Keuangan: Apa yang dimaksud dengan kompetensi utama dalam bidang Administrasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(93,10,'Soal 3 untuk skema Administrasi Keuangan: Apa yang dimaksud dengan kompetensi utama dalam bidang Administrasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(94,10,'Soal 4 untuk skema Administrasi Keuangan: Apa yang dimaksud dengan kompetensi utama dalam bidang Administrasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(95,10,'Soal 5 untuk skema Administrasi Keuangan: Apa yang dimaksud dengan kompetensi utama dalam bidang Administrasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(96,10,'Soal 6 untuk skema Administrasi Keuangan: Apa yang dimaksud dengan kompetensi utama dalam bidang Administrasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(97,10,'Soal 7 untuk skema Administrasi Keuangan: Apa yang dimaksud dengan kompetensi utama dalam bidang Administrasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(98,10,'Soal 8 untuk skema Administrasi Keuangan: Apa yang dimaksud dengan kompetensi utama dalam bidang Administrasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(99,10,'Soal 9 untuk skema Administrasi Keuangan: Apa yang dimaksud dengan kompetensi utama dalam bidang Administrasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03'),(100,10,'Soal 10 untuk skema Administrasi Keuangan: Apa yang dimaksud dengan kompetensi utama dalam bidang Administrasi?','Kemampuan dasar yang harus dikuasai','Kemampuan tambahan yang opsional','Kemampuan yang tidak relevan','Kemampuan yang sudah usang','a','2026-06-14 18:05:03','2026-06-14 18:05:03');
/*!40000 ALTER TABLE `soal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('superadmin','admin','asesor','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `no_telepon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super Admin LSP','superadmin','aktif',NULL,'superadmin@lsp.com',NULL,'$2y$12$1nl1o6gbompCBe73iL3kju2xN3dYkYtXdKud3ZPbMvEJhE8zahQA.',NULL,'2026-06-14 18:04:59','2026-06-14 18:04:59'),(2,'Admin LSP','admin','aktif',NULL,'admin@lsp.com',NULL,'$2y$12$nBi27GX2n/Hwhhzb22obseyRBVHH3C74OhyGfXQgP2newFSj01ag2',NULL,'2026-06-14 18:05:00','2026-06-14 18:05:00'),(3,'Asesor LSP','asesor','aktif',NULL,'asesor@lsp.com',NULL,'$2y$12$i0mRw/1irfC/R/aly50VAuEnsRd3VecwlYaVeWldkbLSM7ThUZEnq',NULL,'2026-06-14 18:05:00','2026-06-14 18:05:00'),(4,'Lutfi Hidayah','user','aktif','081234567890','lutfi@gmail.com',NULL,'$2y$12$op.EYa1NJlNl/Ibv5o/fcO.0RfJU7.zCpopJ9d/a7nZ/auhhD90q2',NULL,'2026-06-14 18:05:04','2026-06-14 18:05:04'),(5,'Sofa Azzahra','user','aktif','081234567891','sofa@gmail.com',NULL,'$2y$12$NPUFJAdaI6CQSBrU0.QjZejdpXwqC0Z8XASfAh4hulNzzRoSWQnnq',NULL,'2026-06-14 18:05:04','2026-06-14 18:05:04'),(6,'Dimas Mardiana','user','aktif','081234567892','dimas@gmail.com',NULL,'$2y$12$fMTVrI5FVdXc8ltVUa2ovOiDU4lvsZup/09I3jojd5KL/BvtP1wvu',NULL,'2026-06-14 18:05:05','2026-06-14 18:05:05'),(7,'Mas\'ud','user','aktif','081234567893','masud@gmail.com',NULL,'$2y$12$RUwsmUvg9AowqggGK2S4jOdnNgyYdv.QXzYqOLO1hyA2Io/FpbaYG',NULL,'2026-06-14 18:05:05','2026-06-14 18:05:05'),(8,'Rina Oktavia','user','aktif','081234567894','rina@gmail.com',NULL,'$2y$12$pAN.0KYzvL.hE/k9KqvOmevXrggax9TLBlJxMV0vbSWYneT4Prwii',NULL,'2026-06-14 18:05:06','2026-06-14 18:05:06'),(9,'Budi Santoso','user','aktif','081234567895','budi@gmail.com',NULL,'$2y$12$0KrYIFiwSrWRgVItHsfDP.Q9uvItLZwlpX1mi5mVZvsf5SfsQDeSS',NULL,'2026-06-14 18:05:06','2026-06-14 18:05:06'),(10,'Anisa Rahmawati','user','aktif','081234567896','anisa@gmail.com',NULL,'$2y$12$dFp5BBdmk.NPcqZSsTu13uzIyzSaMFQkK0NAVVPSJFmQkkI1HDnoa',NULL,'2026-06-14 18:05:07','2026-06-14 18:05:07'),(11,'Hendra Wijaya','user','aktif','081234567897','hendra@gmail.com',NULL,'$2y$12$7kJfLJkCx7u.9WYPyg8FLu/VDSbNZTckNId4fxXFP1CluS6MhH2z.',NULL,'2026-06-14 18:05:07','2026-06-14 18:05:07');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-15  8:15:13
