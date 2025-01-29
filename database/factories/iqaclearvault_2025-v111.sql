-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 29, 2025 at 01:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iqaclearvault_2025-v111`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_faculty`
--

CREATE TABLE `admin_faculty` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `faculty_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_ids`
--

CREATE TABLE `admin_ids` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_assigned` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_ids`
--

INSERT INTO `admin_ids` (`id`, `admin_id`, `user_id`, `is_assigned`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN20250001', NULL, 0, NULL, NULL),
(2, 'ADMIN20250002', NULL, 0, NULL, NULL),
(3, 'ADMIN20250003', NULL, 0, NULL, NULL),
(4, 'ADMIN20250004', NULL, 0, NULL, NULL),
(5, 'ADMIN20250005', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campuses`
--

CREATE TABLE `campuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `campuses`
--

INSERT INTO `campuses` (`id`, `name`, `description`, `location`, `profile_picture`, `created_at`, `updated_at`) VALUES
(1, 'San Jose Campus', NULL, NULL, NULL, '2025-01-29 11:56:36', '2025-01-29 11:56:36');

-- --------------------------------------------------------

--
-- Table structure for table `clearances`
--

CREATE TABLE `clearances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `units` int(11) DEFAULT NULL,
  `type` enum('Part-Time','Part-Time-FullTime','Permanent-Temporary','Permanent-FullTime','Dean','Program-Head','Admin-Staff') DEFAULT NULL,
  `number_of_requirements` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clearance_feedback`
--

CREATE TABLE `clearance_feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `requirement_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `message` text DEFAULT NULL,
  `signature_status` varchar(255) NOT NULL DEFAULT 'Checking',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clearance_requirements`
--

CREATE TABLE `clearance_requirements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `clearance_id` bigint(20) UNSIGNED NOT NULL,
  `requirement` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `campus_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `profile_picture`, `created_at`, `updated_at`, `campus_id`) VALUES
(1, 'CAST', 'Computer Arts, Science and Technology', NULL, '2025-01-29 11:56:36', '2025-01-29 11:56:36', 1);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_09_16_140134_add_columns_to_users_table', 1),
(5, '2024_09_19_072204_create_clearances_table', 1),
(6, '2024_09_19_072923_create_clearance_requirements_table', 1),
(7, '2024_09_26_081243_create_shared_clearances_table', 1),
(8, '2024_09_26_082804_create_uploaded_clearances_table', 1),
(9, '2024_09_27_153704_create_user_clearances_table', 1),
(10, '2024_10_12_115901_create_clearance_feedback_table', 1),
(11, '2024_10_18_085332_add_profile_picture_to_users_table', 1),
(12, '2024_10_18_150951_create_submitted_reports_table', 1),
(13, '2024_10_19_235113_create_departments_table', 1),
(14, '2024_10_19_235214_create_programs_table', 1),
(15, '2024_10_19_235310_add_department_id_to_users_table', 1),
(16, '2024_10_21_114457_create_admin_faculty_table', 1),
(17, '2024_10_28_124330_add_is_archived_to_uploaded_clearances_and_feedback', 1),
(18, '2024_10_30_223527_add_admin_id_to_users_and_create_admin_ids_table', 1),
(19, '2024_11_06_224344_add_user_id_to_admin_ids_table', 1),
(20, '2024_11_09_083543_create_campuses_table', 1),
(21, '2024_11_09_083831_add_campus_id_to_users_programs_departments', 1),
(22, '2024_11_09_223658_add_program_head_and_dean_ids_to_users_and_create_program_head_dean_ids_table', 1),
(23, '2024_11_16_081011_update_user_enum_position_and_clearance_type', 1),
(24, '2024_11_18_185943_add_academic_year_and_semester_to_uploaded_clearances_table', 1),
(25, '2024_11_23_143115_create_sub_programs_table', 1),
(26, '2024_11_25_082238_create_user_notifications_table', 1),
(27, '2025_01_03_145630_create_uploaded_file_metadata_table', 1),
(28, '2025_01_09_142044_update_user_type_enum_in_users_table', 1),
(29, '2025_01_12_150746_update_type_enum_in_clearances_table', 1),
(30, '2025_01_16_221449_create_offices_table', 1),
(31, '2025_01_20_224734_add_new_column_office_id_in_users_table', 1),
(32, '2025_01_26_095230_create_users_feedback_systems_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`id`, `name`, `description`, `profile_picture`, `campus_id`, `created_at`, `updated_at`) VALUES
(1, 'MIS', 'Management Information System', NULL, 1, '2025-01-29 11:56:36', '2025-01-29 11:56:36');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `campus_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `name`, `department_id`, `profile_picture`, `created_at`, `updated_at`, `campus_id`) VALUES
(1, 'Bachelor of Science in Information Technology', 1, NULL, '2025-01-29 11:56:36', '2025-01-29 11:56:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `program_head_dean_ids`
--

CREATE TABLE `program_head_dean_ids` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `type` enum('Program-Head','Dean') DEFAULT NULL,
  `is_assigned` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shared_clearances`
--

CREATE TABLE `shared_clearances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `clearance_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `submitted_reports`
--

CREATE TABLE `submitted_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_programs`
--

CREATE TABLE `sub_programs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `program_id` bigint(20) UNSIGNED NOT NULL,
  `sub_program_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_clearances`
--

CREATE TABLE `uploaded_clearances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shared_clearance_id` bigint(20) UNSIGNED NOT NULL,
  `requirement_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'oncheck',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0,
  `academic_year` varchar(255) DEFAULT NULL,
  `semester` enum('1','2','3') DEFAULT NULL,
  `archive_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_file_metadata`
--

CREATE TABLE `uploaded_file_metadata` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `shared_clearance_id` bigint(20) UNSIGNED NOT NULL,
  `requirement_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_content` longblob DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `user_type` enum('Admin','Faculty','Dean','Program-Head','Admin-Staff') NOT NULL,
  `program` varchar(255) DEFAULT NULL,
  `position` enum('Part-Time','Part-Time-FullTime','Permanent-Temporary','Permanent-FullTime','Dean','Program-Head') DEFAULT NULL,
  `units` int(11) DEFAULT NULL,
  `clearances_status` enum('pending','return','complete') NOT NULL DEFAULT 'pending',
  `last_clearance_update` timestamp NULL DEFAULT NULL,
  `checked_by` varchar(255) DEFAULT NULL,
  `admin_id_registered` varchar(255) DEFAULT NULL,
  `program_head_id` varchar(255) DEFAULT NULL,
  `dean_id` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `office_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `program_id` bigint(20) UNSIGNED DEFAULT NULL,
  `campus_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `profile_picture`, `user_type`, `program`, `position`, `units`, `clearances_status`, `last_clearance_update`, `checked_by`, `admin_id_registered`, `program_head_id`, `dean_id`, `email_verified_at`, `password`, `google_id`, `remember_token`, `created_at`, `updated_at`, `office_id`, `department_id`, `program_id`, `campus_id`) VALUES
(1, 'IQA S.A.', 'omsc.iqaclearvault@gmail.com', NULL, 'Admin', NULL, NULL, NULL, 'pending', NULL, NULL, NULL, NULL, NULL, '2025-01-29 11:56:35', '$2y$12$0.QD8oD53O153oHUI5yGeuh7l3KHChDteibqB9PntaohPfoPO7GSS', NULL, NULL, '2025-01-29 11:56:36', '2025-01-29 11:56:36', NULL, NULL, NULL, NULL),
(2, 'IQA SJ Admin', 'adminsj@iqaclearvault.com', NULL, 'Admin', NULL, NULL, NULL, 'pending', NULL, NULL, 'ADMIN20250006', NULL, NULL, '2025-01-29 11:56:36', '$2y$12$9K/fHljDgxOZJoqpxX7FZ.bznYe0P0Z1HZFB7.yeVg2qPjkfa4gZW', NULL, NULL, '2025-01-29 11:56:36', '2025-01-29 11:56:36', NULL, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_feedback_systems`
--

CREATE TABLE `users_feedback_systems` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `c1_1` int(11) DEFAULT NULL,
  `c1_2` int(11) DEFAULT NULL,
  `c1_3` int(11) DEFAULT NULL,
  `c1_4` int(11) DEFAULT NULL,
  `c1_5` int(11) DEFAULT NULL,
  `c2_1` int(11) DEFAULT NULL,
  `c2_2` int(11) DEFAULT NULL,
  `c2_3` int(11) DEFAULT NULL,
  `c2_4` int(11) DEFAULT NULL,
  `c2_5` int(11) DEFAULT NULL,
  `c3_1` int(11) DEFAULT NULL,
  `c3_2` int(11) DEFAULT NULL,
  `c3_3` int(11) DEFAULT NULL,
  `c3_4` int(11) DEFAULT NULL,
  `c3_5` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_clearances`
--

CREATE TABLE `user_clearances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shared_clearance_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `date_completed` timestamp NULL DEFAULT NULL,
  `last_uploaded` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notification_type` varchar(255) NOT NULL,
  `notification_message` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_faculty`
--
ALTER TABLE `admin_faculty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_faculty_admin_id_foreign` (`admin_id`),
  ADD KEY `admin_faculty_faculty_id_foreign` (`faculty_id`);

--
-- Indexes for table `admin_ids`
--
ALTER TABLE `admin_ids`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_ids_admin_id_unique` (`admin_id`),
  ADD KEY `admin_ids_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `campuses`
--
ALTER TABLE `campuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clearances`
--
ALTER TABLE `clearances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clearance_feedback`
--
ALTER TABLE `clearance_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clearance_feedback_requirement_id_foreign` (`requirement_id`),
  ADD KEY `clearance_feedback_user_id_foreign` (`user_id`);

--
-- Indexes for table `clearance_requirements`
--
ALTER TABLE `clearance_requirements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clearance_requirements_clearance_id_foreign` (`clearance_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_campus_id_foreign` (`campus_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offices_campus_id_foreign` (`campus_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `programs_department_id_foreign` (`department_id`),
  ADD KEY `programs_campus_id_foreign` (`campus_id`);

--
-- Indexes for table `program_head_dean_ids`
--
ALTER TABLE `program_head_dean_ids`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `program_head_dean_ids_identifier_unique` (`identifier`),
  ADD KEY `program_head_dean_ids_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shared_clearances`
--
ALTER TABLE `shared_clearances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shared_clearances_clearance_id_unique` (`clearance_id`);

--
-- Indexes for table `submitted_reports`
--
ALTER TABLE `submitted_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submitted_reports_user_id_foreign` (`user_id`),
  ADD KEY `submitted_reports_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `sub_programs`
--
ALTER TABLE `sub_programs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_programs_user_id_foreign` (`user_id`),
  ADD KEY `sub_programs_program_id_foreign` (`program_id`);

--
-- Indexes for table `uploaded_clearances`
--
ALTER TABLE `uploaded_clearances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded_clearances_shared_clearance_id_foreign` (`shared_clearance_id`),
  ADD KEY `uploaded_clearances_requirement_id_foreign` (`requirement_id`),
  ADD KEY `uploaded_clearances_user_id_foreign` (`user_id`);

--
-- Indexes for table `uploaded_file_metadata`
--
ALTER TABLE `uploaded_file_metadata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded_file_metadata_user_id_foreign` (`user_id`),
  ADD KEY `uploaded_file_metadata_shared_clearance_id_foreign` (`shared_clearance_id`),
  ADD KEY `uploaded_file_metadata_requirement_id_foreign` (`requirement_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_department_id_foreign` (`department_id`),
  ADD KEY `users_program_id_foreign` (`program_id`),
  ADD KEY `users_campus_id_foreign` (`campus_id`),
  ADD KEY `users_office_id_foreign` (`office_id`);

--
-- Indexes for table `users_feedback_systems`
--
ALTER TABLE `users_feedback_systems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_feedback_systems_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_clearances`
--
ALTER TABLE `user_clearances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_clearances_shared_clearance_id_user_id_unique` (`shared_clearance_id`,`user_id`),
  ADD KEY `user_clearances_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_notifications_user_id_foreign` (`user_id`),
  ADD KEY `user_notifications_admin_user_id_foreign` (`admin_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_faculty`
--
ALTER TABLE `admin_faculty`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_ids`
--
ALTER TABLE `admin_ids`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `campuses`
--
ALTER TABLE `campuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clearances`
--
ALTER TABLE `clearances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clearance_feedback`
--
ALTER TABLE `clearance_feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clearance_requirements`
--
ALTER TABLE `clearance_requirements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `program_head_dean_ids`
--
ALTER TABLE `program_head_dean_ids`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shared_clearances`
--
ALTER TABLE `shared_clearances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `submitted_reports`
--
ALTER TABLE `submitted_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_programs`
--
ALTER TABLE `sub_programs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uploaded_clearances`
--
ALTER TABLE `uploaded_clearances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uploaded_file_metadata`
--
ALTER TABLE `uploaded_file_metadata`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_feedback_systems`
--
ALTER TABLE `users_feedback_systems`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_clearances`
--
ALTER TABLE `user_clearances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_faculty`
--
ALTER TABLE `admin_faculty`
  ADD CONSTRAINT `admin_faculty_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_faculty_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `admin_ids`
--
ALTER TABLE `admin_ids`
  ADD CONSTRAINT `admin_ids_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `clearance_feedback`
--
ALTER TABLE `clearance_feedback`
  ADD CONSTRAINT `clearance_feedback_requirement_id_foreign` FOREIGN KEY (`requirement_id`) REFERENCES `clearance_requirements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `clearance_feedback_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `clearance_requirements`
--
ALTER TABLE `clearance_requirements`
  ADD CONSTRAINT `clearance_requirements_clearance_id_foreign` FOREIGN KEY (`clearance_id`) REFERENCES `clearances` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `offices`
--
ALTER TABLE `offices`
  ADD CONSTRAINT `offices_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `programs_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `programs_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `program_head_dean_ids`
--
ALTER TABLE `program_head_dean_ids`
  ADD CONSTRAINT `program_head_dean_ids_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `shared_clearances`
--
ALTER TABLE `shared_clearances`
  ADD CONSTRAINT `shared_clearances_clearance_id_foreign` FOREIGN KEY (`clearance_id`) REFERENCES `clearances` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `submitted_reports`
--
ALTER TABLE `submitted_reports`
  ADD CONSTRAINT `submitted_reports_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `submitted_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_programs`
--
ALTER TABLE `sub_programs`
  ADD CONSTRAINT `sub_programs_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sub_programs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `uploaded_clearances`
--
ALTER TABLE `uploaded_clearances`
  ADD CONSTRAINT `uploaded_clearances_requirement_id_foreign` FOREIGN KEY (`requirement_id`) REFERENCES `clearance_requirements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `uploaded_clearances_shared_clearance_id_foreign` FOREIGN KEY (`shared_clearance_id`) REFERENCES `shared_clearances` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `uploaded_clearances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `uploaded_file_metadata`
--
ALTER TABLE `uploaded_file_metadata`
  ADD CONSTRAINT `uploaded_file_metadata_requirement_id_foreign` FOREIGN KEY (`requirement_id`) REFERENCES `clearance_requirements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `uploaded_file_metadata_shared_clearance_id_foreign` FOREIGN KEY (`shared_clearance_id`) REFERENCES `shared_clearances` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `uploaded_file_metadata_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_office_id_foreign` FOREIGN KEY (`office_id`) REFERENCES `offices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users_feedback_systems`
--
ALTER TABLE `users_feedback_systems`
  ADD CONSTRAINT `users_feedback_systems_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_clearances`
--
ALTER TABLE `user_clearances`
  ADD CONSTRAINT `user_clearances_shared_clearance_id_foreign` FOREIGN KEY (`shared_clearance_id`) REFERENCES `shared_clearances` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_clearances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD CONSTRAINT `user_notifications_admin_user_id_foreign` FOREIGN KEY (`admin_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
