-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 18, 2021 at 11:47 AM
-- Server version: 5.7.24
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `safe_food`
--

-- --------------------------------------------------------

--
-- Table structure for table `adjustments`
--

CREATE TABLE `adjustments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `adjustment_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `item` double(8,2) NOT NULL,
  `total_qty` double(8,2) NOT NULL,
  `total_cost` double NOT NULL,
  `date` date DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `adjustments`
--

INSERT INTO `adjustments` (`id`, `adjustment_no`, `warehouse_id`, `item`, `total_qty`, `total_cost`, `date`, `note`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'ADJ-1021639', 1, 2.00, 300.00, 13500, '2021-10-21', NULL, 'Super Admin', NULL, '2021-10-21 10:39:38', '2021-10-21 10:39:38'),
(2, 'ADJ-1121952', 1, 3.00, 400.00, 2220, '2021-11-08', 'Lorem Ipsum DOllar', 'Super Admin', 'Super Admin', '2021-11-07 18:26:52', '2021-11-09 06:33:11'),
(3, 'ADJ-1121204', 1, 8.00, 950.00, 13770, '2021-11-13', NULL, 'Super Admin', NULL, '2021-11-13 17:00:48', '2021-11-13 17:00:48'),
(4, 'ADJ-1121143', 1, 1.00, 100.00, 520, '2021-11-16', NULL, 'Super Admin', NULL, '2021-11-16 12:29:27', '2021-11-16 12:29:27');

-- --------------------------------------------------------

--
-- Table structure for table `adjustment_products`
--

CREATE TABLE `adjustment_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `adjustment_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `base_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `base_unit_qty` double NOT NULL,
  `base_unit_cost` double NOT NULL,
  `total_cost` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `adjustment_products`
--

INSERT INTO `adjustment_products` (`id`, `adjustment_id`, `product_id`, `base_unit_id`, `base_unit_qty`, `base_unit_cost`, `total_cost`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 200, 10, 2000, '2021-10-21 00:00:00', NULL),
(2, 1, 1, 1, 100, 115, 11500, '2021-10-21 00:00:00', NULL),
(3, 2, 1, 1, 100, 5.2, 520, '2021-11-07 18:00:00', '2021-11-09 06:33:11'),
(5, 2, 3, 1, 200, 5, 1000, '2021-11-07 18:00:00', '2021-11-09 06:33:11'),
(6, 2, 11, 1, 100, 7, 700, '2021-11-09 06:33:11', '2021-11-09 06:33:11'),
(7, 3, 1, 1, 100, 5.2, 520, '2021-11-12 18:00:00', NULL),
(8, 3, 2, 1, 100, 5, 500, '2021-11-12 18:00:00', NULL),
(9, 3, 3, 1, 100, 5, 500, '2021-11-12 18:00:00', NULL),
(10, 3, 4, 1, 250, 15, 3750, '2021-11-12 18:00:00', NULL),
(11, 3, 5, 1, 100, 10, 1000, '2021-11-12 18:00:00', NULL),
(12, 3, 6, 1, 100, 20, 2000, '2021-11-12 18:00:00', NULL),
(13, 3, 7, 1, 100, 25, 2500, '2021-11-12 18:00:00', NULL),
(14, 3, 8, 1, 100, 30, 3000, '2021-11-12 18:00:00', NULL),
(15, 4, 1, 1, 100, 5.2, 520, '2021-11-15 18:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `allowance_deductions`
--

CREATE TABLE `allowance_deductions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Alowance, 2=Deduction, 3=Others',
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `allowance_deduction_manages`
--

CREATE TABLE `allowance_deduction_manages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `allowance_deduction_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `type` int(11) DEFAULT NULL COMMENT '1=Alowance, 2=Deduction, 3=Others',
  `basic_salary` double NOT NULL,
  `percentage` int(11) NOT NULL,
  `amount` double NOT NULL,
  `status` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive, 3=Cancel',
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `employee_route_id` int(11) DEFAULT NULL,
  `wallet_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `am_pm` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_str` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_str_am_pm` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive, 3=Cancel',
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('safe_food_cache_suppliers', 'O:29:\"Illuminate\\Support\\Collection\":1:{s:8:\"\0*\0items\";a:1:{i:0;O:8:\"stdClass\":13:{s:2:\"id\";i:1;s:4:\"name\";s:5:\"Mr. A\";s:12:\"company_name\";s:3:\"AAA\";s:6:\"mobile\";s:11:\"01521225963\";s:5:\"email\";N;s:4:\"city\";N;s:7:\"zipcode\";N;s:7:\"address\";N;s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-11-15 14:20:32\";s:10:\"updated_at\";s:19:\"2021-11-15 14:20:32\";}}}', 1952360514),
('sef_fud_end_bevarej_saluk_cache_active_taxes', 'O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1952399264),
('sef_fud_end_bevarej_saluk_cache_active_warehouses', 'O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:8:\"stdClass\":12:{s:2:\"id\";i:1;s:4:\"name\";s:14:\"Main Warehouse\";s:5:\"phone\";N;s:5:\"email\";N;s:7:\"address\";N;s:11:\"district_id\";i:1;s:6:\"status\";s:1:\"1\";s:9:\"deletable\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";s:11:\"Super Admin\";s:10:\"created_at\";s:19:\"2021-10-11 12:41:53\";s:10:\"updated_at\";s:19:\"2021-10-20 15:34:26\";}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1952399271),
('sef_fud_end_bevarej_saluk_cache_material_categories', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:7:{i:0;O:19:\"App\\Models\\Category\":38:{s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"type\";i:2;s:6:\"status\";i:3;s:10:\"created_by\";i:4;s:11:\"modified_by\";}s:7:\"\0*\0type\";N;s:7:\"\0*\0name\";N;s:9:\"\0*\0status\";N;s:8:\"\0*\0order\";a:1:{s:2:\"id\";s:4:\"desc\";}s:15:\"\0*\0column_order\";N;s:13:\"\0*\0orderValue\";N;s:11:\"\0*\0dirValue\";N;s:13:\"\0*\0startVlaue\";N;s:14:\"\0*\0lengthVlaue\";N;s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:4;s:4:\"name\";s:3:\"Can\";s:4:\"type\";s:1:\"1\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-09-14 11:57:51\";s:10:\"updated_at\";s:19:\"2021-09-14 11:57:51\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:4;s:4:\"name\";s:3:\"Can\";s:4:\"type\";s:1:\"1\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-09-14 11:57:51\";s:10:\"updated_at\";s:19:\"2021-09-14 11:57:51\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:19:\"App\\Models\\Category\":38:{s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"type\";i:2;s:6:\"status\";i:3;s:10:\"created_by\";i:4;s:11:\"modified_by\";}s:7:\"\0*\0type\";N;s:7:\"\0*\0name\";N;s:9:\"\0*\0status\";N;s:8:\"\0*\0order\";a:1:{s:2:\"id\";s:4:\"desc\";}s:15:\"\0*\0column_order\";N;s:13:\"\0*\0orderValue\";N;s:11:\"\0*\0dirValue\";N;s:13:\"\0*\0startVlaue\";N;s:14:\"\0*\0lengthVlaue\";N;s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Element\";s:4:\"type\";s:1:\"1\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-09-14 11:57:30\";s:10:\"updated_at\";s:19:\"2021-09-14 11:57:30\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:2;s:4:\"name\";s:7:\"Element\";s:4:\"type\";s:1:\"1\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-09-14 11:57:30\";s:10:\"updated_at\";s:19:\"2021-09-14 11:57:30\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:19:\"App\\Models\\Category\":38:{s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"type\";i:2;s:6:\"status\";i:3;s:10:\"created_by\";i:4;s:11:\"modified_by\";}s:7:\"\0*\0type\";N;s:7:\"\0*\0name\";N;s:9:\"\0*\0status\";N;s:8:\"\0*\0order\";a:1:{s:2:\"id\";s:4:\"desc\";}s:15:\"\0*\0column_order\";N;s:13:\"\0*\0orderValue\";N;s:11:\"\0*\0dirValue\";N;s:13:\"\0*\0startVlaue\";N;s:14:\"\0*\0lengthVlaue\";N;s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:6;s:4:\"name\";s:4:\"Foil\";s:4:\"type\";s:1:\"1\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-09-14 11:58:04\";s:10:\"updated_at\";s:19:\"2021-09-14 11:58:04\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:6;s:4:\"name\";s:4:\"Foil\";s:4:\"type\";s:1:\"1\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-09-14 11:58:04\";s:10:\"updated_at\";s:19:\"2021-09-14 11:58:04\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:19:\"App\\Models\\Category\":38:{s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"type\";i:2;s:6:\"status\";i:3;s:10:\"created_by\";i:4;s:11:\"modified_by\";}s:7:\"\0*\0type\";N;s:7:\"\0*\0name\";N;s:9:\"\0*\0status\";N;s:8:\"\0*\0order\";a:1:{s:2:\"id\";s:4:\"desc\";}s:15:\"\0*\0column_order\";N;s:13:\"\0*\0orderValue\";N;s:11:\"\0*\0dirValue\";N;s:13:\"\0*\0startVlaue\";N;s:14:\"\0*\0lengthVlaue\";N;s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:1;s:4:\"name\";s:6:\"Liquid\";s:4:\"type\";s:1:\"1\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-09-14 11:57:21\";s:10:\"updated_at\";s:19:\"2021-09-14 11:57:21\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:1;s:4:\"name\";s:6:\"Liquid\";s:4:\"type\";s:1:\"1\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-09-14 11:57:21\";s:10:\"updated_at\";s:19:\"2021-09-14 11:57:21\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:19:\"App\\Models\\Category\":38:{s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"type\";i:2;s:6:\"status\";i:3;s:10:\"created_by\";i:4;s:11:\"modified_by\";}s:7:\"\0*\0type\";N;s:7:\"\0*\0name\";N;s:9:\"\0*\0status\";N;s:8:\"\0*\0order\";a:1:{s:2:\"id\";s:4:\"desc\";}s:15:\"\0*\0column_order\";N;s:13:\"\0*\0orderValue\";N;s:11:\"\0*\0dirValue\";N;s:13:\"\0*\0startVlaue\";N;s:14:\"\0*\0lengthVlaue\";N;s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:10;s:4:\"name\";s:3:\"Oil\";s:4:\"type\";s:1:\"1\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:5:\"Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-10-21 16:18:07\";s:10:\"updated_at\";s:19:\"2021-10-21 16:18:07\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:10;s:4:\"name\";s:3:\"Oil\";s:4:\"type\";s:1:\"1\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:5:\"Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-10-21 16:18:07\";s:10:\"updated_at\";s:19:\"2021-10-21 16:18:07\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:19:\"App\\Models\\Category\":38:{s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"type\";i:2;s:6:\"status\";i:3;s:10:\"created_by\";i:4;s:11:\"modified_by\";}s:7:\"\0*\0type\";N;s:7:\"\0*\0name\";N;s:9:\"\0*\0status\";N;s:8:\"\0*\0order\";a:1:{s:2:\"id\";s:4:\"desc\";}s:15:\"\0*\0column_order\";N;s:13:\"\0*\0orderValue\";N;s:11:\"\0*\0dirValue\";N;s:13:\"\0*\0startVlaue\";N;s:14:\"\0*\0lengthVlaue\";N;s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:5;s:4:\"name\";s:5:\"Paper\";s:4:\"type\";s:1:\"1\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-09-14 11:57:56\";s:10:\"updated_at\";s:19:\"2021-09-14 11:57:56\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:5;s:4:\"name\";s:5:\"Paper\";s:4:\"type\";s:1:\"1\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-09-14 11:57:56\";s:10:\"updated_at\";s:19:\"2021-09-14 11:57:56\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:6;O:19:\"App\\Models\\Category\":38:{s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"type\";i:2;s:6:\"status\";i:3;s:10:\"created_by\";i:4;s:11:\"modified_by\";}s:7:\"\0*\0type\";N;s:7:\"\0*\0name\";N;s:9:\"\0*\0status\";N;s:8:\"\0*\0order\";a:1:{s:2:\"id\";s:4:\"desc\";}s:15:\"\0*\0column_order\";N;s:13:\"\0*\0orderValue\";N;s:11:\"\0*\0dirValue\";N;s:13:\"\0*\0startVlaue\";N;s:14:\"\0*\0lengthVlaue\";N;s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:3;s:4:\"name\";s:6:\"Powder\";s:4:\"type\";s:1:\"1\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-09-14 11:57:37\";s:10:\"updated_at\";s:19:\"2021-09-14 11:57:37\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:3;s:4:\"name\";s:6:\"Powder\";s:4:\"type\";s:1:\"1\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-09-14 11:57:37\";s:10:\"updated_at\";s:19:\"2021-09-14 11:57:37\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1952399271),
('sef_fud_end_bevarej_saluk_cache_product_categories', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:6:{i:0;O:19:\"App\\Models\\Category\":38:{s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"type\";i:2;s:6:\"status\";i:3;s:10:\"created_by\";i:4;s:11:\"modified_by\";}s:7:\"\0*\0type\";N;s:7:\"\0*\0name\";N;s:9:\"\0*\0status\";N;s:8:\"\0*\0order\";a:1:{s:2:\"id\";s:4:\"desc\";}s:15:\"\0*\0column_order\";N;s:13:\"\0*\0orderValue\";N;s:11:\"\0*\0dirValue\";N;s:13:\"\0*\0startVlaue\";N;s:14:\"\0*\0lengthVlaue\";N;s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:12;s:4:\"name\";s:8:\"Biscuits\";s:4:\"type\";s:1:\"2\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:5:\"Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-10-25 15:45:24\";s:10:\"updated_at\";s:19:\"2021-10-25 15:45:24\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:12;s:4:\"name\";s:8:\"Biscuits\";s:4:\"type\";s:1:\"2\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:5:\"Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-10-25 15:45:24\";s:10:\"updated_at\";s:19:\"2021-10-25 15:45:24\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:19:\"App\\Models\\Category\":38:{s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"type\";i:2;s:6:\"status\";i:3;s:10:\"created_by\";i:4;s:11:\"modified_by\";}s:7:\"\0*\0type\";N;s:7:\"\0*\0name\";N;s:9:\"\0*\0status\";N;s:8:\"\0*\0order\";a:1:{s:2:\"id\";s:4:\"desc\";}s:15:\"\0*\0column_order\";N;s:13:\"\0*\0orderValue\";N;s:11:\"\0*\0dirValue\";N;s:13:\"\0*\0startVlaue\";N;s:14:\"\0*\0lengthVlaue\";N;s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:13;s:4:\"name\";s:5:\"Bread\";s:4:\"type\";s:1:\"2\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-10-27 13:59:40\";s:10:\"updated_at\";s:19:\"2021-10-27 13:59:40\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:13;s:4:\"name\";s:5:\"Bread\";s:4:\"type\";s:1:\"2\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-10-27 13:59:40\";s:10:\"updated_at\";s:19:\"2021-10-27 13:59:40\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:19:\"App\\Models\\Category\":38:{s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"type\";i:2;s:6:\"status\";i:3;s:10:\"created_by\";i:4;s:11:\"modified_by\";}s:7:\"\0*\0type\";N;s:7:\"\0*\0name\";N;s:9:\"\0*\0status\";N;s:8:\"\0*\0order\";a:1:{s:2:\"id\";s:4:\"desc\";}s:15:\"\0*\0column_order\";N;s:13:\"\0*\0orderValue\";N;s:11:\"\0*\0dirValue\";N;s:13:\"\0*\0startVlaue\";N;s:14:\"\0*\0lengthVlaue\";N;s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:11;s:4:\"name\";s:4:\"Cake\";s:4:\"type\";s:1:\"2\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:5:\"Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-10-25 15:45:09\";s:10:\"updated_at\";s:19:\"2021-10-25 15:45:09\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:11;s:4:\"name\";s:4:\"Cake\";s:4:\"type\";s:1:\"2\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:5:\"Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-10-25 15:45:09\";s:10:\"updated_at\";s:19:\"2021-10-25 15:45:09\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:19:\"App\\Models\\Category\":38:{s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"type\";i:2;s:6:\"status\";i:3;s:10:\"created_by\";i:4;s:11:\"modified_by\";}s:7:\"\0*\0type\";N;s:7:\"\0*\0name\";N;s:9:\"\0*\0status\";N;s:8:\"\0*\0order\";a:1:{s:2:\"id\";s:4:\"desc\";}s:15:\"\0*\0column_order\";N;s:13:\"\0*\0orderValue\";N;s:11:\"\0*\0dirValue\";N;s:13:\"\0*\0startVlaue\";N;s:14:\"\0*\0lengthVlaue\";N;s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:9;s:4:\"name\";s:7:\"Element\";s:4:\"type\";s:1:\"2\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-10-21 10:32:49\";s:10:\"updated_at\";s:19:\"2021-10-21 10:32:49\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:9;s:4:\"name\";s:7:\"Element\";s:4:\"type\";s:1:\"2\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-10-21 10:32:49\";s:10:\"updated_at\";s:19:\"2021-10-21 10:32:49\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:19:\"App\\Models\\Category\":38:{s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"type\";i:2;s:6:\"status\";i:3;s:10:\"created_by\";i:4;s:11:\"modified_by\";}s:7:\"\0*\0type\";N;s:7:\"\0*\0name\";N;s:9:\"\0*\0status\";N;s:8:\"\0*\0order\";a:1:{s:2:\"id\";s:4:\"desc\";}s:15:\"\0*\0column_order\";N;s:13:\"\0*\0orderValue\";N;s:11:\"\0*\0dirValue\";N;s:13:\"\0*\0startVlaue\";N;s:14:\"\0*\0lengthVlaue\";N;s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:8;s:4:\"name\";s:6:\"Liquid\";s:4:\"type\";s:1:\"2\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-09-14 15:19:36\";s:10:\"updated_at\";s:19:\"2021-09-14 15:19:36\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:8;s:4:\"name\";s:6:\"Liquid\";s:4:\"type\";s:1:\"2\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-09-14 15:19:36\";s:10:\"updated_at\";s:19:\"2021-09-14 15:19:36\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:19:\"App\\Models\\Category\":38:{s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"type\";i:2;s:6:\"status\";i:3;s:10:\"created_by\";i:4;s:11:\"modified_by\";}s:7:\"\0*\0type\";N;s:7:\"\0*\0name\";N;s:9:\"\0*\0status\";N;s:8:\"\0*\0order\";a:1:{s:2:\"id\";s:4:\"desc\";}s:15:\"\0*\0column_order\";N;s:13:\"\0*\0orderValue\";N;s:11:\"\0*\0dirValue\";N;s:13:\"\0*\0startVlaue\";N;s:14:\"\0*\0lengthVlaue\";N;s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:7;s:4:\"name\";s:6:\"Powder\";s:4:\"type\";s:1:\"2\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-09-14 15:19:30\";s:10:\"updated_at\";s:19:\"2021-09-14 15:19:30\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:7;s:4:\"name\";s:6:\"Powder\";s:4:\"type\";s:1:\"2\";s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-09-14 15:19:30\";s:10:\"updated_at\";s:19:\"2021-09-14 15:19:30\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1952399005),
('sef_fud_end_bevarej_saluk_cache_suppliers', 'O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:8:\"stdClass\":13:{s:2:\"id\";i:1;s:4:\"name\";s:5:\"Mr. A\";s:12:\"company_name\";s:3:\"AAA\";s:6:\"mobile\";s:11:\"01521225963\";s:5:\"email\";N;s:4:\"city\";N;s:7:\"zipcode\";N;s:7:\"address\";N;s:6:\"status\";s:1:\"1\";s:10:\"created_by\";s:11:\"Super Admin\";s:11:\"modified_by\";N;s:10:\"created_at\";s:19:\"2021-11-15 14:20:32\";s:10:\"updated_at\";s:19:\"2021-11-15 14:20:32\";}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1952395390);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Material Category, 2=Product Category',
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `type`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'Liquid', '1', '1', 'Super Admin', NULL, '2021-09-14 05:57:21', '2021-09-14 05:57:21'),
(2, 'Element', '1', '1', 'Super Admin', NULL, '2021-09-14 05:57:30', '2021-09-14 05:57:30'),
(3, 'Powder', '1', '1', 'Super Admin', NULL, '2021-09-14 05:57:37', '2021-09-14 05:57:37'),
(4, 'Can', '1', '1', 'Super Admin', NULL, '2021-09-14 05:57:51', '2021-09-14 05:57:51'),
(5, 'Paper', '1', '1', 'Super Admin', NULL, '2021-09-14 05:57:56', '2021-09-14 05:57:56'),
(6, 'Foil', '1', '1', 'Super Admin', NULL, '2021-09-14 05:58:04', '2021-09-14 05:58:04'),
(7, 'Powder', '2', '1', 'Super Admin', NULL, '2021-09-14 09:19:30', '2021-09-14 09:19:30'),
(8, 'Liquid', '2', '1', 'Super Admin', NULL, '2021-09-14 09:19:36', '2021-09-14 09:19:36'),
(9, 'Element', '2', '1', 'Super Admin', NULL, '2021-10-21 04:32:49', '2021-10-21 04:32:49'),
(10, 'Oil', '1', '1', 'Admin', NULL, '2021-10-21 10:18:07', '2021-10-21 10:18:07'),
(11, 'Cake', '2', '1', 'Admin', NULL, '2021-10-25 09:45:09', '2021-10-25 09:45:09'),
(12, 'Biscuits', '2', '1', 'Admin', NULL, '2021-10-25 09:45:24', '2021-10-25 09:45:24'),
(13, 'Bread', '2', '1', 'Super Admin', NULL, '2021-10-27 07:59:40', '2021-10-27 07:59:40');

-- --------------------------------------------------------

--
-- Table structure for table `chart_of_accounts`
--

CREATE TABLE `chart_of_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  `type` enum('A','L','I','E') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'A=Asset, L=Liabilty, I=income, E=Expense',
  `transaction` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Yes, 2=No',
  `general_ledger` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Yes, 2=No',
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `depo_id` int(11) DEFAULT NULL,
  `dealer_id` int(11) DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `mobile_bank_id` int(11) DEFAULT NULL,
  `budget` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Yes, 2=No',
  `depreciation` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Yes, 2=No',
  `depreciation_rate` double NOT NULL DEFAULT '0',
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chart_of_accounts`
--

INSERT INTO `chart_of_accounts` (`id`, `code`, `name`, `parent_name`, `level`, `type`, `transaction`, `general_ledger`, `customer_id`, `supplier_id`, `depo_id`, `dealer_id`, `bank_id`, `mobile_bank_id`, `budget`, `depreciation`, `depreciation_rate`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, '1', 'Assets', 'COA', 0, 'A', '2', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(2, '2', 'Equity', 'COA', 0, 'L', '2', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(3, '3', 'Income', 'COA', 0, 'I', '2', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(4, '4', 'Expense', 'COA', 0, 'E', '2', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(5, '5', 'Liabilities', 'COA', 0, 'L', '2', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(6, '101', 'Non Current Asset', 'Assets', 1, 'A', '2', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(7, '102', 'Current Asset', 'Assets', 1, 'A', '2', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(8, '301', 'Product Sale', 'Income', 1, 'I', '1', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(9, '302', 'Service Income', 'Income', 1, 'I', '1', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(10, '401', 'Default Expense', 'Expense', 1, 'E', '1', '2', NULL, NULL, NULL, NULL, NULL, NULL, '1', '1', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(11, '402', 'Material Purchase', 'Expense', 1, 'E', '2', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(12, '403', 'Employee Salary', 'Expense', 1, 'E', '1', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(13, '404', 'Machine Purchase', 'Expense', 1, 'E', '2', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(14, '405', 'Maintenance Service', 'Expense', 1, 'E', '2', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(15, '501', 'Non Current Liabilities', 'Liabilities', 1, 'L', '2', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(16, '502', 'Current Liabilities', 'Liabilities', 1, 'L', '2', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(17, '10101', 'Inventory', 'Non Current Asset', 2, 'A', '2', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(18, '10201', 'Cash & Cash Equivalent', 'Current Asset', 2, 'A', '2', '1', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(19, '10202', 'Account Receivable', 'Current Asset', 2, 'A', '2', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(20, '50201', 'Account Payable', 'Current Liabilities', 2, 'L', '2', '1', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(21, '50202', 'Employee Ledger', 'Current Liabilities', 2, 'L', '2', '1', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(22, '50203', 'Tax', 'Current Liabilities', 2, 'L', '2', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(23, '1020101', 'Cash In Hand', 'Cash & Cash Equivalent', 3, 'A', '1', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(24, '1020102', 'Cash At Bank', 'Cash & Cash Equivalent', 3, 'A', '2', '1', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(25, '1020103', 'Cash At Mobile Bank', 'Cash & Cash Equivalent', 3, 'A', '2', '1', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(26, '1020201', 'Customer Receivable', 'Account Receivable', 3, 'A', '2', '1', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(27, '1020202', 'Loan Receivable', 'Account Receivable', 3, 'A', '2', '1', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'SuperAdmin', NULL, '2021-04-02 23:14:59', '2021-04-02 23:14:59'),
(40, '50101', 'Loans', 'Non Current Liabilities', 2, 'L', '2', '1', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'Super Admin', NULL, '2021-09-13 05:17:53', '2021-09-13 05:17:53'),
(41, '50204', 'Loans & Overdrafts', 'Current Liabilities', 2, 'L', '2', '1', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'Super Admin', NULL, '2021-09-13 05:18:27', '2021-09-13 05:18:27'),
(42, '5010101', 'Loan Payable Long Term', 'Loans', 3, 'L', '2', '1', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'Super Admin', NULL, '2021-09-13 05:19:20', '2021-09-13 05:19:20'),
(43, '5020401', 'Loan Payable Short Term', 'Loans & Overdrafts', 3, 'L', '2', '1', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'Super Admin', NULL, '2021-09-13 05:19:55', '2021-09-13 05:19:55'),
(44, '1020203', 'Depo Receivable', 'Account Receivable', 3, 'A', '2', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'Super Admin', NULL, '2021-10-28 06:05:03', '2021-10-28 06:05:03'),
(45, '1020204', 'Dealer Receivable', 'Account Receivable', 3, 'A', '2', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'Super Admin', NULL, '2021-10-28 06:05:25', '2021-10-28 06:05:25'),
(49, '102020300001', '4-বিল্লাল', 'Depo Receivable', 4, 'A', '1', '2', NULL, NULL, 4, NULL, NULL, NULL, '2', '2', 0, '1', 'Super Admin', NULL, '2021-10-28 08:12:50', '2021-10-28 08:12:50'),
(50, '102020300002', '5-হুসাইন', 'Depo Receivable', 4, 'A', '1', '2', NULL, NULL, 5, NULL, NULL, NULL, '2', '2', 0, '1', 'Super Admin', NULL, '2021-10-28 08:19:53', '2021-10-28 08:19:53'),
(52, '102020300004', '7-মিল্লাদ', 'Depo Receivable', 4, 'A', '1', '2', NULL, NULL, 7, NULL, NULL, NULL, '2', '2', 0, '1', 'Super Admin', NULL, '2021-10-28 08:23:30', '2021-10-28 08:23:30'),
(55, '1020204000001', '1-সানজা এন্টারপ্রাইজ', 'Dealer Receivable', 4, 'A', '1', '2', NULL, NULL, NULL, 1, NULL, NULL, '2', '2', 0, '1', 'Super Admin', NULL, '2021-10-28 08:37:43', '2021-10-28 08:37:43'),
(56, '1020204000002', '2-মিলন এন্টারপ্রাইজ', 'Dealer Receivable', 4, 'A', '1', '2', NULL, NULL, NULL, 2, NULL, NULL, '2', '2', 0, '1', 'Super Admin', NULL, '2021-10-28 08:39:45', '2021-10-28 08:39:45'),
(57, '5020101', '1-Mr. A', 'Account Payable', 3, 'L', '1', '2', NULL, 1, NULL, NULL, NULL, NULL, '2', '2', 0, '1', 'Super Admin', NULL, '2021-11-15 08:20:32', '2021-11-15 08:20:32');

-- --------------------------------------------------------

--
-- Table structure for table `daily_closings`
--

CREATE TABLE `daily_closings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `last_day_closing` double DEFAULT NULL,
  `cash_in` double DEFAULT NULL,
  `cash_out` double DEFAULT NULL,
  `balance` double DEFAULT NULL,
  `transfer` double DEFAULT NULL,
  `closing_amount` double DEFAULT NULL,
  `adjustment` double DEFAULT NULL,
  `date` date NOT NULL,
  `thousands` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `five_hundred` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `hundred` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `fifty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `twenty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `ten` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `five` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `two` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `one` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daily_closings`
--

INSERT INTO `daily_closings` (`id`, `warehouse_id`, `last_day_closing`, `cash_in`, `cash_out`, `balance`, `transfer`, `closing_amount`, `adjustment`, `date`, `thousands`, `five_hundred`, `hundred`, `fifty`, `twenty`, `ten`, `five`, `two`, `one`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 4000, 1000, 3000, 0, 3000, NULL, '2021-11-15', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'Super Admin', '0', '2021-11-15 09:30:24', '2021-11-15 09:30:24');

-- --------------------------------------------------------

--
-- Table structure for table `damages`
--

CREATE TABLE `damages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `damage_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item` float NOT NULL,
  `total_qty` float NOT NULL,
  `grand_total` double NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `damage_date` date NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `damages`
--

INSERT INTO `damages` (`id`, `damage_no`, `sale_id`, `item`, `total_qty`, `grand_total`, `reason`, `damage_date`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(2, 'DINV-211117850', 7, 2, 8, 95, NULL, '2021-11-17', 'Super Admin', NULL, '2021-11-17 06:56:04', '2021-11-17 06:56:04');

-- --------------------------------------------------------

--
-- Table structure for table `damage_products`
--

CREATE TABLE `damage_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `damage_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `damage_qty` double NOT NULL,
  `base_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `net_unit_price` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `damage_products`
--

INSERT INTO `damage_products` (`id`, `damage_id`, `product_id`, `damage_qty`, `base_unit_id`, `net_unit_price`, `total`, `created_at`, `updated_at`) VALUES
(3, 2, 4, 5, 1, 10, 50, '2021-11-17 06:56:04', NULL),
(4, 2, 6, 3, 1, 15, 45, '2021-11-17 06:56:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dealers`
--

CREATE TABLE `dealers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_no` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `depo_id` int(11) DEFAULT NULL,
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `upazila_id` bigint(20) UNSIGNED NOT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `commission_rate` double(8,2) DEFAULT NULL,
  `type` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Depo Dealer,2=Direct Dealer',
  `dealer_group_id` int(11) NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dealers`
--

INSERT INTO `dealers` (`id`, `name`, `mobile_no`, `email`, `depo_id`, `district_id`, `upazila_id`, `area_id`, `address`, `commission_rate`, `type`, `dealer_group_id`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'সানজা এন্টারপ্রাইজ', '01521225986', NULL, NULL, 6, 104, 559, 'Lorem Ipsum Dollar', 8.00, '2', 1, '1', 'Super Admin', NULL, '2021-10-28 08:37:43', '2021-10-28 08:37:43'),
(2, 'মিলন এন্টারপ্রাইজ', '01680256365', NULL, NULL, 17, 179, 558, 'Lorem Ipsum Dollar', 7.00, '2', 1, '1', 'Super Admin', 'Super Admin', '2021-10-28 08:39:45', '2021-11-07 10:54:54'),
(4, 'সুলতান এন্টারপ্রাইজ', '01521225632', NULL, 4, 17, 179, 557, 'Lorem Ipsum DOllar', NULL, '1', 2, '1', 'Super Admin', NULL, '2021-11-07 10:13:36', '2021-11-07 10:13:36'),
(5, 'পাপিয়া এন্টারপ্রাইজ', '0152125463', NULL, 5, 6, 104, 559, 'Lorem Ipsum Dollar', NULL, '1', 3, '1', 'Super Admin', 'Super Admin', '2021-11-07 10:42:29', '2021-11-07 10:54:38'),
(6, 'আয়েশা এন্টারপ্রাইজ', '01523457896', NULL, 4, 17, 179, 557, 'Lorem Ipsum Dollar', NULL, '1', 1, '1', 'Super Admin', NULL, '2021-11-13 14:00:31', '2021-11-13 14:00:31');

-- --------------------------------------------------------

--
-- Table structure for table `dealer_groups`
--

CREATE TABLE `dealer_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=active,2=inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dealer_groups`
--

INSERT INTO `dealer_groups` (`id`, `group_name`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'Regular', '1', 'Super Admin', NULL, '2021-11-07 07:59:47', '2021-11-07 07:59:47'),
(2, 'Tangail', '1', 'Super Admin', NULL, '2021-11-07 07:59:57', '2021-11-07 07:59:57'),
(3, 'Kishorganj', '1', 'Super Admin', NULL, '2021-11-07 08:00:10', '2021-11-07 08:00:10');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `depos`
--

CREATE TABLE `depos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_no` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `upazila_id` bigint(20) UNSIGNED NOT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `commission_rate` double(8,2) DEFAULT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `depos`
--

INSERT INTO `depos` (`id`, `name`, `mobile_no`, `email`, `district_id`, `upazila_id`, `area_id`, `address`, `commission_rate`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(4, 'বিল্লাল', '01521225985', NULL, 17, 179, 557, 'Lorem Ipsum Dollar', 10.00, '1', 'Super Admin', 'Super Admin', '2021-10-28 08:12:50', '2021-10-28 08:14:11'),
(5, 'হুসাইন', '01521225986', NULL, 6, 104, 559, 'Lorem Ipsum Dollar', 9.50, '1', 'Super Admin', NULL, '2021-10-28 08:19:53', '2021-10-28 08:19:53'),
(7, 'মিল্লাদ', '01825633265', NULL, 17, 179, 558, 'Lortem Ipsum Dollar', 10.00, '1', 'Super Admin', NULL, '2021-10-28 08:23:30', '2021-10-28 08:23:30');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photograph` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternative_phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `holiday` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attendance_type` int(11) DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `finger_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wallet_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shift_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `job_status` enum('1','2','3','4') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Permanent,2=Probation,3=Resigned,4=Suspended',
  `duty_type` enum('1','2','3','4') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Full Time,2=Part Time,3=Contractual,4=Other',
  `joining_designation_id` bigint(20) UNSIGNED NOT NULL,
  `current_designation_id` bigint(20) UNSIGNED NOT NULL,
  `joining_date` date DEFAULT NULL,
  `probation_start` date DEFAULT NULL,
  `probation_end` date DEFAULT NULL,
  `contract_start` date DEFAULT NULL,
  `contract_end` date DEFAULT NULL,
  `confirmation_date` date DEFAULT NULL,
  `termination_date` date DEFAULT NULL,
  `termination_reason` text COLLATE utf8mb4_unicode_ci,
  `rate_type` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Hourly,2=Salary',
  `rate` double NOT NULL,
  `joining_rate` double DEFAULT NULL,
  `overtime` enum('1','2') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1=Allowed,2=Not Allowed',
  `pay_freequency` enum('1','2','3','4') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Weekly,2=Biweekly,3=Monthly,4=Annual',
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supervisor_id` int(10) UNSIGNED DEFAULT NULL,
  `is_supervisor` enum('1','2') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1=Yes,2=No',
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Male,2=Female,3=Other',
  `marital_status` enum('1','2','3','4','5') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Single,2=Married,3=Divorced,4=Widowed,5=Other',
  `blood_group` enum('1','2','3','4','5','6','7','8') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=A+,2=B+,3=A-,4=B-,5=AB+,6=AB-,7=O+,8=O-',
  `religion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `residential_status` enum('1','2') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1=Resident,2=Non-Resident',
  `emergency_contact_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact_relation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternative_emergency_contact_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternative_emergency_contact_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternative_emergency_contact_relation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternative_emergency_contact_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_education`
--

CREATE TABLE `employee_education` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `degree` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `major` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `institute` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passing_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_professional_information`
--

CREATE TABLE `employee_professional_information` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `responsibility` text COLLATE utf8mb4_unicode_ci,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_routes`
--

CREATE TABLE `employee_routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `expense_item_id` bigint(20) UNSIGNED NOT NULL,
  `voucher_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `date` date NOT NULL,
  `payment_type` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Cash,2=Bank,3=Mobile',
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_items`
--

CREATE TABLE `expense_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `holiday_type` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Weekly, 2=Public',
  `holiday_status` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Holiday, 2=General, 3=Others',
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` int(11) DEFAULT NULL,
  `leave_type` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Unpaid, 2=Paid',
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_application_manages`
--

CREATE TABLE `leave_application_manages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leave_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `alternative_employee` int(11) DEFAULT NULL,
  `number_leave` int(11) DEFAULT NULL,
  `leave_type` int(11) DEFAULT NULL,
  `employee_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purpose` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submission` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Pre, 2=Post',
  `leave_status` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Pending, 2=Accepted, 3=Cancel',
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `person_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `adjust_amount` double DEFAULT NULL,
  `purpose` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_adjusted_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `month_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_changed_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adjusted_date` date DEFAULT NULL,
  `loan_type` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Personal,2=Official',
  `payment_method` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Cash,2=Cheque,3=Mobile',
  `account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `loan_status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=Complete,2=Pending',
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Active,2=InActive',
  `approve` enum('1','2') COLLATE utf8mb4_unicode_ci DEFAULT '2' COMMENT '1=approve\r\n2=not approve',
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_installments`
--

CREATE TABLE `loan_installments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `person_id` bigint(20) UNSIGNED DEFAULT NULL,
  `installment_amount` double DEFAULT NULL,
  `purpose` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_changed_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `installment_date` date DEFAULT NULL,
  `month_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loan_type` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Personal,2=Official',
  `payment_method` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Cash,2=Cheque,3=Mobile',
  `account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Active,2=InActive',
  `approve` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Yes, 2=No',
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_people`
--

CREATE TABLE `loan_people` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `loan_term_type` set('1','2') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1=Short Term, 2= Long Term',
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Active,2=InActive',
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `grand_parent_id` int(10) UNSIGNED DEFAULT NULL,
  `type` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=District, 2=Upazila, 3=Area',
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `parent_id`, `grand_parent_id`, `type`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'Dhaka', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(2, 'Faridpur', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(3, 'Gazipur', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(4, 'Gopalganj', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(5, 'Jamalpur', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(6, 'Kishoreganj', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(7, 'Madaripur', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(8, 'Manikganj', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(9, 'Munshiganj', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(10, 'Mymensingh', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(11, 'Narayanganj', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(12, 'Narsingdi', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(13, 'Netrokona', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(14, 'Rajbari', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(15, 'Shariatpur', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(16, 'Sherpur', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(17, 'Tangail', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(18, 'Bogra', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(19, 'Joypurhat', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(20, 'Naogaon', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(21, 'Natore', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(22, 'Nawabganj', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(23, 'Pabna', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(24, 'Rajshahi', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(25, 'Sirajgonj', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(26, 'Dinajpur', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(27, 'Gaibandha', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(28, 'Kurigram', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(29, 'Lalmonirhat', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(30, 'Nilphamari', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(31, 'Panchagarh', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(32, 'Rangpur', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(33, 'Thakurgaon', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(34, 'Barguna', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(35, 'Barisal', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(36, 'Bhola', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(37, 'Jhalokati', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(38, 'Patuakhali', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(39, 'Pirojpur', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(40, 'Bandarban', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(41, 'Brahmanbaria', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(42, 'Chandpur', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(43, 'Chittagong', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(44, 'Comilla', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(45, 'Cox\'s Bazar', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(46, 'Feni', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(47, 'Khagrachari', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(48, 'Lakshmipur', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(49, 'Noakhali', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(50, 'Rangamati', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(51, 'Habiganj', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(52, 'Maulvibazar', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(53, 'Sunamganj', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(54, 'Sylhet', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(55, 'Bagerhat', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(56, 'Chuadanga', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(57, 'Jessore', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(58, 'Jhenaidah', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(59, 'Khulna', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(60, 'Kushtia', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(61, 'Magura', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(62, 'Meherpur', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(63, 'Narail', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(64, 'Satkhira', 0, NULL, '1', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(65, 'Gulsan 1', 1, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(66, 'Dhamrai Upazila', 1, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(67, 'Dohar Upazila', 1, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(68, 'Keraniganj Upazila', 1, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(69, 'Nawabganj Upazila', 1, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(70, 'Savar Upazila', 1, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(71, 'Charbhadrasan Upazila', 2, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(72, 'Sadarpur Upazila', 2, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(73, 'Shaltha Upazila', 2, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(74, 'Nagarkanda Upazila', 2, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(75, 'Bhanga Upazila', 2, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(76, 'Madhukhali Upazila', 2, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(77, 'Alfadanga Upazila', 2, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(78, 'Boalmari Upazila', 2, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(79, 'Faridpur Sadar Upazila', 2, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(80, 'Tongi', 3, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(81, 'Kaliganj', 3, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(82, 'Sripur', 3, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(83, 'Kapasia', 3, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(84, 'Kaliakior', 3, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(85, 'Gazipur Sadar-Joydebpur', 3, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(86, 'Kotalipara Upazila', 4, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(87, 'Tungipara Upazila', 4, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(88, 'Muksudpur Upazila', 4, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(89, 'Kashiani Upazila', 4, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(90, 'Gopalganj Sadar Upazila', 4, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(91, 'Sarishabari Upazila', 5, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(92, 'Melandaha Upazila', 5, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(93, 'Narundi Police I.C', 5, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(94, 'Madarganj Upazila', 5, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(95, 'Jamalpur Sadar Upazila', 5, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(96, 'Islampur Upazila', 5, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(97, 'Baksiganj Upazila', 5, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(98, 'Dewanganj Upazila', 5, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(99, 'Tarail Upazila', 6, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(100, 'Pakundia Upazila', 6, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(101, 'Nikli Upazila', 6, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(102, 'Mithamain Upazila', 6, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(103, 'Kuliarchar Upazila', 6, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(104, 'Kishoreganj Sadar Upazila', 6, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(105, 'Karimganj Upazila', 6, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(106, 'Itna Upazila', 6, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(107, 'Astagram Upazila', 6, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(108, 'Bajitpur Upazila', 6, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(109, 'Hossainpur Upazila', 6, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(110, 'Bhairab Upazila', 6, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(111, 'Katiadi Upazila', 6, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(112, 'Kalkini', 7, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(113, 'Rajoir', 7, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(114, 'Madaripur Sadar', 7, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(115, 'Shibchar', 7, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(116, 'Harirampur Upazila', 8, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(117, 'Manikganj Sadar Upazila', 8, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(118, 'Daulatpur Upazila', 8, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(119, 'Ghior Upazila', 8, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(120, 'Singair Upazila', 8, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(121, 'Shibalaya Upazila', 8, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(122, 'Saturia Upazila', 8, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(123, 'Tongibari Upazila', 9, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(124, 'Sirajdikhan Upazila', 9, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(125, 'Munshiganj Sadar Upazila', 9, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(126, 'Sreenagar Upazila', 9, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(127, 'Gazaria Upazila', 9, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(128, 'Lohajang Upazila', 9, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(129, 'Nandail', 10, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(130, 'Phulpur', 10, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(131, 'Mymensingh Sadar', 10, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(132, 'Ishwarganj', 10, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(133, 'Gauripur', 10, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(134, 'Gaffargaon', 10, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(135, 'Fulbaria', 10, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(136, 'Dhobaura', 10, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(137, 'Trishal', 10, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(138, 'Haluaghat', 10, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(139, 'Bhaluka', 10, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(140, 'Muktagachha', 10, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(141, 'Rupganj Upazila', 11, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(142, 'Naryanganj Sadar Upazila', 11, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(143, 'Bandar', 11, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(144, 'Sonargaon Upazila', 11, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(145, 'Araihazar Upazila', 11, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(146, 'Siddirgonj Upazila', 11, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(147, 'Shibpur Upazila', 12, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(148, 'Raipura Upazila, Narsingdi', 12, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(149, 'Palash Upazila', 12, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(150, 'Narsingdi Sadar Upazila', 12, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(151, 'Monohardi Upazila', 12, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(152, 'Belabo Upazila', 12, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(153, 'Khaliajuri Upazilla', 13, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(154, 'Purbadhala Upazilla', 13, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(155, 'Netrakona-S Upazilla', 13, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(156, 'Mohanganj Upazilla', 13, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(157, 'Madan Upazilla', 13, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(158, 'Kalmakanda Upazilla', 13, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(159, 'Durgapur Upazilla', 13, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(160, 'Barhatta Upazilla', 13, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(161, 'Atpara Upazilla', 13, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(162, 'Kendua Upazilla', 13, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(163, 'Rajbari Sadar Upazila', 14, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(164, 'Kalukhali Upazila', 14, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(165, 'Pangsha Upazila', 14, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(166, 'Goalandaghat Upazila', 14, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(167, 'Baliakandi Upazila', 14, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(168, 'Gosairhat Upazila', 15, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(169, 'Bhedarganj Upazila', 15, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(170, 'Jajira Upazila', 15, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(171, 'Damudya Upazila', 15, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(172, 'Shariatpur Sadar -Palong', 15, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(173, 'Naria Upazila', 15, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(174, 'Sreebardi Upazila', 16, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(175, 'Sherpur Sadar Upazila', 16, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(176, 'Nalitabari Upazila', 16, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(177, 'Nakla Upazila', 16, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(178, 'Jhenaigati Upazila', 16, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(179, 'Tangail Sadar Upazila', 17, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(180, 'Sakhipur Upazila', 17, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(181, 'Basail Upazila', 17, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(182, 'Madhupur Upazila', 17, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(183, 'Ghatail Upazila', 17, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(184, 'Kalihati Upazila', 17, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(185, 'Dhanbari Upazila', 17, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(186, 'Bhuapur Upazila', 17, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(187, 'Delduar Upazila', 17, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(188, 'Gopalpur Upazila', 17, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(189, 'Mirzapur Upazila', 17, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(190, 'Nagarpur Upazila', 17, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(191, 'Sonatala', 18, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(192, 'Shibganj', 18, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(193, 'Sariakandi', 18, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(194, 'Sahajanpur', 18, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(195, 'Nandigram', 18, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(196, 'Kahaloo', 18, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(197, 'Adamdighi', 18, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(198, 'Gabtali', 18, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(199, 'Dhupchanchia', 18, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(200, 'Dhunat', 18, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(201, 'Bogra Sadar', 18, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(202, 'Panchbibi', 19, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(203, 'Khetlal', 19, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(204, 'Kalai', 19, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(205, 'Joypurhat S', 19, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(206, 'Akkelpur', 19, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(207, 'Patnitala Upazila', 20, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(208, 'Dhamoirhat Upazila', 20, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(209, 'Sapahar Upazila', 20, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(210, 'Porsha Upazila', 20, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(211, 'Badalgachhi Upazila', 20, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(212, 'Atrai Upazila', 20, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(213, 'Niamatpur Upazila', 20, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(214, 'Raninagar Upazila', 20, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(215, 'Manda Upazila', 20, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(216, 'Mohadevpur Upazila', 20, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(217, 'Naogaon Sadar Upazila', 20, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(218, 'Baraigram Upazila', 21, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(219, 'Natore Sadar Upazila', 21, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(220, 'Lalpur Upazila', 21, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(221, 'Bagatipara Upazila', 21, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(222, 'Shibganj Upazila', 22, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(223, 'Nawabganj Sadar Upazila', 22, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(224, 'Nachole Upazila', 22, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(225, 'Gomastapur Upazila', 22, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(226, 'Bholahat Upazila', 22, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(227, 'Sujanagar Upazila', 23, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(228, 'Santhia Upazila', 23, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(229, 'Pabna Sadar Upazila', 23, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(230, 'Ishwardi Upazila', 23, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(231, 'Faridpur Upazila', 23, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(232, 'Chatmohar Upazila', 23, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(233, 'Bhangura Upazila', 23, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(234, 'Bera Upazila', 23, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(235, 'Atgharia Upazila', 23, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(236, 'Godagari', 24, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(237, 'Tanore', 24, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(238, 'Puthia', 24, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(239, 'Paba', 24, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(240, 'Mohanpur', 24, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(241, 'Durgapur', 24, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(242, 'Charghat', 24, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(243, 'Bagmara', 24, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(244, 'Bagha', 24, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(245, 'Chauhali Upazila', 25, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(246, 'Ullahpara Upazila', 25, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(247, 'Tarash Upazila', 25, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(248, 'Shahjadpur Upazila', 25, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(249, 'Raiganj Upazila', 25, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(250, 'Kazipur Upazila', 25, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(251, 'Kamarkhanda Upazila', 25, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(252, 'Belkuchi Upazila', 25, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(253, 'Sirajganj Sadar Upazila', 25, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(254, 'Hakimpur Upazila', 26, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(255, 'Kaharole Upazila', 26, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(256, 'Khansama Upazila', 26, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(257, 'Dinajpur Sadar Upazila', 26, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(258, 'Nawabganj', 26, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(259, 'Parbatipur Upazila', 26, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(260, 'Ghoraghat Upazila', 26, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(261, 'Phulbari Upazila', 26, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(262, 'Chirirbandar Upazila', 26, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(263, 'Bochaganj Upazila', 26, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(264, 'Biral Upazila', 26, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(265, 'Birganj', 26, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(266, 'Birampur Upazila', 26, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(267, 'Sadullapur', 27, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(268, 'Saghata', 27, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(269, 'Sundarganj', 27, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(270, 'Palashbari', 27, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(271, 'Gaibandha sadar', 27, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(272, 'Fulchhari', 27, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(273, 'Gobindaganj', 27, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(274, 'Char Rajibpur', 28, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(275, 'Rowmari', 28, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(276, 'Chilmari', 28, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(277, 'Ulipur', 28, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(278, 'Rajarhat', 28, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(279, 'Phulbari', 28, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(280, 'Bhurungamari', 28, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(281, 'Nageshwari', 28, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(282, 'Kurigram Sadar', 28, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(283, 'Patgram', 29, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(284, 'Hatibandha', 29, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(285, 'Kaliganj', 29, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(286, 'Aditmari', 29, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(287, 'Lalmanirhat Sadar', 29, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(288, 'Dimla', 30, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(289, 'Domar', 30, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(290, 'Kishoreganj', 30, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(291, 'Jaldhaka', 30, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(292, 'Saidpur', 30, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(293, 'Nilphamari Sadar', 30, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(294, 'Panchagarh Sadar', 31, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(295, 'Debiganj', 31, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(296, 'Boda', 31, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(297, 'Atwari', 31, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(298, 'Tetulia', 31, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(299, 'Kaunia', 32, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(300, 'Badarganj', 32, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(301, 'Mithapukur', 32, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(302, 'Gangachara', 32, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(303, 'Rangpur Sadar', 32, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(304, 'Pirgachha', 32, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(305, 'Pirganj', 32, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(306, 'Taraganj', 32, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(307, 'Baliadangi Upazila', 33, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(308, 'Thakurgaon Sadar Upazila', 33, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(309, 'Pirganj Upazila', 33, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(310, 'Haripur Upazila', 33, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(311, 'Ranisankail Upazila', 33, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(312, 'Patharghata Upazila', 34, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(313, 'Betagi Upazila', 34, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(314, 'Barguna Sadar Upazila', 34, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(315, 'Bamna Upazila', 34, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(316, 'Taltali Upazila', 34, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(317, 'Amtali Upazila', 34, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(318, 'Gaurnadi Upazila', 35, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(319, 'Banaripara Upazila', 35, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(320, 'Hizla Upazila', 35, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(321, 'Mehendiganj Upazila', 35, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(322, 'Wazirpur Upazila', 35, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(323, 'Bakerganj Upazila', 35, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(324, 'Barisal Sadar Upazila', 35, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(325, 'Babuganj Upazila', 35, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(326, 'Muladi Upazila', 35, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(327, 'Agailjhara Upazila', 35, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(328, 'Daulatkhan Upazila', 36, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(329, 'Tazumuddin Upazila', 36, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(330, 'Manpura Upazila', 36, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(331, 'Lalmohan Upazila', 36, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(332, 'Char Fasson Upazila', 36, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(333, 'Burhanuddin Upazila', 36, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(334, 'Bhola Sadar Upazila', 36, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(335, 'Nalchity Upazila', 37, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(336, 'Rajapur Upazila', 37, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(337, 'Jhalokati Sadar Upazila', 37, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(338, 'Kathalia Upazila', 37, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(339, 'Mirzaganj Upazila', 38, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(340, 'Patuakhali Sadar Upazila', 38, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(341, 'Rangabali Upazila', 38, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(342, 'Dumki Upazila', 38, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(343, 'Kalapara Upazila', 38, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(344, 'Galachipa Upazila', 38, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(345, 'Dashmina Upazila', 38, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(346, 'Bauphal Upazila', 38, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(347, 'Zianagar', 39, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(348, 'Pirojpur Sadar', 39, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(349, 'Nazirpur', 39, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(350, 'Mathbaria', 39, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(351, 'Kaukhali', 39, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(352, 'Bhandaria', 39, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(353, 'Nesarabad', 39, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(354, 'Rowangchhari', 40, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(355, 'Ruma', 40, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(356, 'Ali kadam', 40, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(357, 'Naikhongchhari', 40, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(358, 'Lama', 40, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(359, 'Thanchi', 40, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(360, 'Bandarban Sadar', 40, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(361, 'Bancharampur Upazila', 41, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(362, 'Bijoynagar Upazila', 41, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(363, 'Ashuganj Upazila', 41, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(364, 'Akhaura Upazila', 41, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(365, 'Kasba Upazila', 41, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(366, 'Shahbazpur Town', 41, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(367, 'Sarail Upazila', 41, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(368, 'Nabinagar Upazila', 41, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(369, 'Nasirnagar Upazila', 41, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(370, 'Brahmanbaria Sadar Upazila', 41, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(371, 'Shahrasti', 42, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(372, 'Matlab Dakkhin', 42, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(373, 'Matlab Uttar', 42, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(374, 'Kachua', 42, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(375, 'Haziganj', 42, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(376, 'Faridganj', 42, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(377, 'Chandpur Sadar', 42, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(378, 'Haimchar', 42, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(379, 'Patiya Upazila', 43, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(380, 'Rangunia Upazila', 43, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(381, 'Raozan Upazila', 43, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(382, 'Sandwip Upazila', 43, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(383, 'Satkania Upazila', 43, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(384, 'Sitakunda Upazila', 43, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(385, 'Mirsharai Upazila', 43, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(386, 'Lohagara Upazila', 43, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(387, 'Hathazari Upazila', 43, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(388, 'Fatikchhari Upazila', 43, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(389, 'Chandanaish Upazila', 43, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(390, 'Khulshi', 43, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(391, 'Banshkhali Upazila', 43, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(392, 'Anwara Upazila', 43, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(393, 'Panchlaish', 43, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(394, 'Boalkhali Upazila', 43, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(395, 'Chittagong Port', 43, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(396, 'Chauddagram Upazila', 44, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(397, 'Monohorgonj Upazila', 44, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(398, 'Laksam Upazila', 44, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(399, 'Comilla Sadar Upazila', 44, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(400, 'Homna Upazila', 44, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(401, 'Debidwar Upazila', 44, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(402, 'Daudkandi Upazila', 44, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(403, 'Chandina Upazila', 44, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(404, 'Burichong Upazila', 44, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(405, 'Brahmanpara Upazila', 44, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(406, 'Barura Upazila', 44, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(407, 'Meghna Upazila', 44, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(408, 'Nangalkot Upazila', 44, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(409, 'Comilla Sadar South Upazila', 44, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(410, 'Titas Upazila', 44, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(411, 'Muradnagar Upazila', 44, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(412, 'Kutubdia Upazila', 45, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(413, 'Pekua Upazila', 45, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(414, 'Ukhia Upazila', 45, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(415, 'Teknaf Upazila', 45, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(416, 'Ramu Upazila', 45, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(417, 'Maheshkhali Upazila', 45, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(418, 'Cox\'s Bazar Sadar Upazila', 45, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(419, 'Chakaria Upazila', 45, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(420, 'Sonagazi', 46, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(421, 'Fhulgazi', 46, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(422, 'Parshuram', 46, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(423, 'Chagalnaiya', 46, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(424, 'Feni Sadar', 46, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(425, 'Daganbhuiyan', 46, NULL, '2', '1', 'Super Admin', 'Mohammad Arman', '2021-01-27 21:58:52', '2021-08-16 03:18:26'),
(426, 'Dighinala Upazila', 47, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(427, 'Ramgarh Upazila', 47, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(428, 'Panchhari Upazila', 47, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(429, 'Matiranga Upazila', 47, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(430, 'Mahalchhari Upazila', 47, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(431, 'Lakshmichhari Upazila', 47, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(432, 'Khagrachhari Upazila', 47, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(433, 'Manikchhari Upazila', 47, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(434, 'Lakshmipur Sadar Upazila', 48, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(435, 'Komol Nagar Upazila', 48, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(436, 'Ramgati Upazila', 48, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(437, 'Raipur Upazila', 48, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(438, 'Ramganj Upazila', 48, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(439, 'Chatkhil Upazila', 49, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(440, 'Begumganj Upazila', 49, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(441, 'Noakhali Sadar Upazila', 49, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(442, 'Shenbag Upazila', 49, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(443, 'Hatia Upazila', 49, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(444, 'Kobirhat Upazila', 49, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(445, 'Sonaimuri Upazila', 49, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(446, 'Suborno Char Upazila', 49, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(447, 'Companyganj Upazila', 49, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(448, 'Bagaichhari Upazila', 50, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(449, 'Kaptai Upazila', 50, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(450, 'Langadu Upazila', 50, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(451, 'Nannerchar Upazila', 50, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(452, 'Kaukhali Upazila', 50, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(453, 'Rajasthali Upazila', 50, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(454, 'Juraichhari Upazila', 50, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(455, 'Barkal Upazila', 50, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(456, 'Rangamati Sadar Upazila', 50, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(457, 'Belaichhari Upazila', 50, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(458, 'Nabiganj', 51, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(459, 'Madhabpur', 51, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(460, 'Lakhai', 51, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(461, 'Habiganj Sadar', 51, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(462, 'Chunarughat', 51, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(463, 'Shaistagonj Upazila', 51, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(464, 'Bahubal', 51, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(465, 'Ajmiriganj', 51, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(466, 'Baniachang', 51, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(467, 'Sreemangal', 52, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(468, 'Rajnagar', 52, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(469, 'Kulaura', 52, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(470, 'Kamalganj', 52, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(471, 'Barlekha', 52, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(472, 'Moulvibazar Sadar', 52, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(473, 'Juri', 52, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(474, 'Sulla', 53, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(475, 'Jamalganj', 53, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(476, 'Tahirpur', 53, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(477, 'Jagannathpur', 53, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(478, 'Dowarabazar', 53, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(479, 'Dharampasha', 53, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(480, 'Derai', 53, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(481, 'Chhatak', 53, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(482, 'Bishwamvarpur', 53, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(483, 'Shanthiganj', 53, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(484, 'Sunamganj Sadar', 53, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(485, 'Sylhet Sadar', 54, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(486, 'Beanibazar', 54, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(487, 'Bishwanath', 54, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(488, 'Balaganj', 54, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(489, 'Companiganj', 54, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(490, 'Golapganj', 54, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(491, 'Gowainghat', 54, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(492, 'Jaintiapur', 54, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(493, 'Kanaighat', 54, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(494, 'Fenchuganj', 54, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(495, 'Zakiganj', 54, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(496, 'Nobigonj', 54, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(497, 'Dakshin Surma Upazila', 54, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(498, 'Chitalmari Upazila', 55, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(499, 'Bagerhat Sadar Upazila', 55, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(500, 'Fakirhat Upazila', 55, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(501, 'Kachua Upazila', 55, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(502, 'Mollahat Upazila', 55, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(503, 'Mongla Upazila', 55, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(504, 'Morrelganj Upazila', 55, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(505, 'Rampal Upazila', 55, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(506, 'Sarankhola Upazila', 55, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(507, 'Chuadanga-S Upazila', 56, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(508, 'Jibannagar Upazila', 56, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(509, 'Alamdanga Upazila', 56, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(510, 'Damurhuda Upazila', 56, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(511, 'Manirampur Upazila', 57, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(512, 'Sharsha Upazila', 57, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(513, 'Jhikargachha Upazila', 57, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(514, 'Chaugachha Upazila', 57, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(515, 'Abhaynagar Upazila', 57, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(516, 'Jessore Sadar Upazila', 57, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(517, 'Bagherpara Upazila', 57, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(518, 'Keshabpur Upazila', 57, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(519, 'Harinakunda Upazila', 58, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(520, 'Shailkupa Upazila', 58, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(521, 'Kotchandpur Upazila', 58, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(522, 'Kaliganj Upazila', 58, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(523, 'Maheshpur Upazila', 58, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(524, 'Jhenaidah Sadar Upazila', 58, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(525, 'Batiaghata Upazila', 59, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(526, 'Dacope Upazila', 59, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(527, 'Dumuria Upazila', 59, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(528, 'Dighalia Upazila', 59, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(529, 'Koyra Upazila', 59, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(530, 'Paikgachha Upazila', 59, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(531, 'Rupsa Upazila', 59, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(532, 'Phultala Upazila', 59, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(533, 'Terokhada Upazila', 59, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(534, 'Mirpur', 60, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(535, 'Daulatpur', 60, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(536, 'Bheramara', 60, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(537, 'Khoksa', 60, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(538, 'Kumarkhali', 60, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(539, 'Kushtia Sadar', 60, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(540, 'Sreepur Upazila', 61, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL);
INSERT INTO `locations` (`id`, `name`, `parent_id`, `grand_parent_id`, `type`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(541, 'Magura Sadar Upazila', 61, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(542, 'Mohammadpur Upazila', 61, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(543, 'Shalikha Upazila', 61, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(544, 'Meherpur-S Upazila', 62, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(545, 'angni Upazila', 62, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(546, 'Mujib Nagar Upazila', 62, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(547, 'Kalia Upazilla', 63, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(548, 'Narail-S Upazilla', 63, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(549, 'Lohagara Upazilla', 63, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(550, 'Shyamnagar Upazila', 64, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(551, 'Kaliganj Upazila', 64, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(552, 'Kalaroa Upazila', 64, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(553, 'Tala Upazila', 64, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(554, 'Debhata Upazila', 64, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(555, 'Satkhira Sadar Upazila', 64, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(556, 'Assasuni Upazila', 64, NULL, '2', '1', 'Super Admin', NULL, '2021-01-27 21:58:52', NULL),
(557, 'Area One', 179, 17, '3', '1', 'Super Admin', NULL, '2021-10-26 06:19:15', '2021-10-26 06:19:15'),
(558, 'Area Two', 179, 17, '3', '1', 'Super Admin', NULL, '2021-10-26 06:19:33', '2021-10-26 06:19:33'),
(559, 'K Area One', 104, 6, '3', '1', 'Super Admin', 'Super Admin', '2021-10-26 06:20:01', '2021-10-26 06:20:37'),
(560, 'K Area Two', 104, 6, '3', '1', 'Super Admin', NULL, '2021-10-26 06:20:28', '2021-10-26 06:20:28');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `material_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `material_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_unit_id` bigint(20) UNSIGNED NOT NULL,
  `cost` double DEFAULT NULL,
  `old_cost` double(10,2) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `alert_qty` double DEFAULT NULL,
  `tax_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tax_method` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Exclusive,2=Inclusive',
  `type` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Raw,2=Packaging',
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `has_opening_stock` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=Yes, 2=No',
  `opening_stock_qty` double DEFAULT NULL,
  `opening_cost` double DEFAULT NULL,
  `opening_warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `material_name`, `material_code`, `category_id`, `unit_id`, `purchase_unit_id`, `cost`, `old_cost`, `qty`, `alert_qty`, `tax_id`, `tax_method`, `type`, `status`, `has_opening_stock`, `opening_stock_qty`, `opening_cost`, `opening_warehouse_id`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'Flour', '84233669', 3, 2, 2, 42.564102564103, 40.00, 195, 0, NULL, '2', '1', '1', '2', NULL, 0, 1, 'Super Admin', NULL, '2021-10-21 04:23:55', '2021-11-18 08:14:21'),
(2, 'Sugar', '84193536', 2, 2, 2, 82.631578947368, 80.00, 95, 0, NULL, '2', '1', '1', '2', NULL, 0, NULL, 'Super Admin', 'Super Admin', '2021-10-21 04:25:01', '2021-11-18 08:14:21'),
(3, 'Soyabeen Oil', '12603732', 1, 10, 10, 152.5, 150.00, 100, 25, NULL, '2', '1', '1', '2', NULL, 0, NULL, 'Super Admin', 'Super Admin', '2021-10-21 04:54:22', '2021-11-18 08:14:21'),
(4, 'Cocolate Cream', '52670186', 2, 2, 2, 0, 0.00, 0, 10, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Super Admin', 'Admin', '2021-10-21 06:46:57', '2021-10-27 05:49:00'),
(5, 'Vegetable fat(dalda)', '63912223', 10, 2, 2, 0, 0.00, 0, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-21 10:18:43', '2021-10-27 05:49:00'),
(6, 'Palm oil', '08782361', 10, 2, 2, 0, 0.00, 0, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-21 10:20:25', '2021-10-27 06:19:45'),
(7, 'Sodium cloride(salt)', '06287438', 2, 2, 2, 0, 0.00, 0, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-21 10:25:04', '2021-10-27 09:37:19'),
(8, 'Yeast', '20847093', 2, 2, 2, 0, 0.00, 0, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-21 10:53:39', '2021-10-27 05:49:00'),
(9, 'Bread improver', '21915039', 2, 2, 2, 0, 0.00, 0, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-21 10:54:21', '2021-10-27 09:37:19'),
(10, 'Baking powder', '32312608', 3, 2, 2, 40, 0.00, 40, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-21 10:55:33', '2021-11-18 08:14:21'),
(11, 'Margerin(butter)', '10395064', 2, 2, 2, 0, 0.00, 0, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-24 16:57:51', '2021-10-27 06:20:53'),
(12, 'Calcium propionate,cp', '94021317', 2, 2, 2, 0, 0.00, 0, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-24 17:00:50', '2021-10-27 06:20:53'),
(13, 'whey power milk', '13433056', 2, 2, 2, 0, NULL, NULL, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-24 17:02:58', '2021-10-24 17:02:58'),
(14, 'Nigella(black cumin)', '93459862', 2, 2, 2, 0, NULL, NULL, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-24 17:04:16', '2021-10-24 17:04:16'),
(15, 'Glucouse', '18109954', 2, 2, 2, 0, NULL, NULL, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-24 17:05:22', '2021-10-24 17:05:22'),
(16, 'Potassium sorbet', '00611823', 2, 2, 2, 0, 0.00, 0, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-24 17:07:13', '2021-10-26 10:39:46'),
(17, 'Sorbitol', '82009937', 2, 2, 2, 0, 0.00, 0, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-24 17:08:59', '2021-10-26 06:29:44'),
(18, 'Glycerin', '90212495', 2, 2, 2, 0, NULL, NULL, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-24 17:10:29', '2021-10-24 17:10:29'),
(19, 'Milk flavour 1', '72408341', 2, 2, 2, 0, 0.00, 0, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-24 17:11:38', '2021-10-26 06:06:32'),
(20, 'Butter flavour', '00573439', 2, 2, 2, 0, NULL, NULL, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-24 17:12:40', '2021-10-24 17:12:40'),
(21, 'Vanilla flavour', '31807327', 2, 2, 2, 0, NULL, NULL, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-24 17:13:34', '2021-10-24 17:13:34'),
(22, 'Milk flavour Cookies', '12841070', 2, 2, 2, 0, NULL, NULL, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-24 17:14:48', '2021-10-24 17:14:48'),
(23, 'Sodium bcarbonate', '15159323', 2, 2, 2, 0, NULL, NULL, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-24 17:15:47', '2021-10-24 17:15:47'),
(24, 'Citric acid(mono)', '00654693', 2, 2, 2, 0, NULL, NULL, 0, NULL, '2', '1', '1', '2', NULL, 0, NULL, 'Admin', 'Super Admin', '2021-10-24 17:17:42', '2021-11-16 05:57:44'),
(25, 'Milk flavour Cake', '06061313', 2, 2, 2, 0, NULL, NULL, 0, NULL, '2', '1', '1', '2', NULL, 0, NULL, 'Admin', 'Super Admin', '2021-10-24 17:24:50', '2021-11-16 05:57:38'),
(26, 'Cherry fruit', '05239630', 2, 2, 2, 0, NULL, NULL, 0, NULL, '2', '1', '1', '2', NULL, 0, NULL, 'Admin', 'Super Admin', '2021-10-24 17:25:58', '2021-11-16 05:57:30'),
(27, 'Egg', '06293713', 2, 2, 2, 0, NULL, NULL, 0, NULL, '2', '1', '1', '2', NULL, 0, NULL, 'Admin', 'Super Admin', '2021-10-24 17:26:39', '2021-11-16 05:57:50'),
(28, 'Invert syrap', '29323051', 2, 2, 2, 0, NULL, NULL, 0, NULL, '2', '1', '1', '2', NULL, 0, NULL, 'Admin', 'Super Admin', '2021-10-24 17:27:55', '2021-11-16 05:57:55'),
(29, 'Corn strach', '65280702', 2, 2, 2, 0, NULL, NULL, 0, NULL, '2', '1', '1', '2', NULL, 0, NULL, 'Admin', 'Super Admin', '2021-10-24 17:28:59', '2021-11-16 05:58:01'),
(30, 'Tuli puti', '24235899', 2, 2, 2, 0, NULL, NULL, 0, NULL, '2', '1', '1', '2', NULL, 0, NULL, 'Admin', 'Super Admin', '2021-10-24 17:29:41', '2021-11-16 05:58:07'),
(31, 'Cake gel', '64210503', 2, 2, 2, 0, NULL, NULL, 0, NULL, '2', '1', '1', '2', NULL, 0, NULL, 'Admin', 'Super Admin', '2021-10-24 17:31:15', '2021-11-16 05:58:19'),
(32, 'Chocolate pest', '27098366', 2, 2, 2, 0, NULL, NULL, 0, NULL, '2', '1', '1', '2', NULL, 0, NULL, 'Admin', 'Super Admin', '2021-10-24 17:33:55', '2021-11-16 05:58:29'),
(33, 'Kis mis', '21075331', 2, 2, 2, 0, NULL, NULL, 0, NULL, '2', '1', '1', '2', NULL, 0, NULL, 'Admin', 'Super Admin', '2021-10-24 17:35:14', '2021-11-16 05:58:57'),
(34, 'Shuzi', '99361536', 2, 2, 2, 0, NULL, NULL, 0, NULL, '2', '1', '1', '2', NULL, 0, NULL, 'Admin', 'Super Admin', '2021-10-24 17:37:42', '2021-11-16 05:59:06'),
(35, 'Morobba', '71865907', 2, 2, 2, 0, NULL, NULL, 0, NULL, '2', '1', '1', '2', NULL, 0, NULL, 'Admin', 'Super Admin', '2021-10-24 17:38:47', '2021-11-16 05:59:20'),
(36, 'Penuat bar', '95309161', 2, 2, 2, 0, NULL, NULL, 0, NULL, '2', '1', '1', '2', NULL, 0, NULL, 'Admin', 'Super Admin', '2021-10-24 17:39:49', '2021-11-16 06:05:37'),
(37, 'Cocoa powder', '05615912', 2, 2, 2, 0, NULL, NULL, 0, NULL, '2', '1', '1', '2', NULL, 0, NULL, 'Admin', 'Super Admin', '2021-10-24 17:41:30', '2021-11-16 06:05:46'),
(38, 'Skim milk powder', '59984240', 2, 2, 2, 0, NULL, NULL, 0, NULL, '2', '1', '1', '2', NULL, 0, NULL, 'Admin', 'Super Admin', '2021-10-24 17:42:12', '2021-11-16 06:05:52'),
(39, 'K2', '52031290', 2, 2, 2, 0, NULL, NULL, 0, NULL, '2', '1', '1', '2', NULL, 0, NULL, 'Admin', 'Super Admin', '2021-10-24 17:42:52', '2021-11-16 06:05:59'),
(40, 'Atta', '39734612', 2, 2, 2, 0, NULL, NULL, 0, NULL, '2', '1', '1', '2', NULL, 0, NULL, 'Admin', 'Super Admin', '2021-10-24 17:54:45', '2021-11-16 06:06:29'),
(41, 'Cake super', '99356144', 2, 2, 2, 0, NULL, NULL, 0, NULL, '2', '1', '1', '2', NULL, 0, NULL, 'Admin', 'Super Admin', '2021-10-24 17:55:22', '2021-11-16 06:06:37'),
(42, 'Lemon yellow', '22953865', 2, 2, 2, 0, NULL, NULL, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-24 17:56:34', '2021-10-24 17:56:34'),
(43, 'Sapp', '33047029', 2, 2, 2, 0, NULL, NULL, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-24 17:57:16', '2021-10-24 17:57:16'),
(44, 'Ghee flavour', '06320421', 2, 2, 2, 0, NULL, NULL, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-24 17:57:55', '2021-10-24 17:57:55'),
(45, 'Condensed milk', '91243950', 2, 2, 2, 0, NULL, NULL, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-24 17:58:58', '2021-10-24 17:58:58'),
(46, 'Coconat', '20712849', 2, 2, 2, 0, NULL, NULL, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-24 18:01:36', '2021-10-24 18:01:36'),
(47, 'Nut', '30261206', 2, 2, 2, 0, NULL, NULL, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-24 18:02:40', '2021-10-24 18:02:40'),
(48, 'Sesame', '80582133', 2, 2, 2, 0, NULL, NULL, 0, NULL, '1', '1', '1', '2', NULL, 0, NULL, 'Admin', NULL, '2021-10-24 18:03:25', '2021-10-24 18:03:25');

-- --------------------------------------------------------

--
-- Table structure for table `material_purchase`
--

CREATE TABLE `material_purchase` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `qty` double NOT NULL,
  `purchase_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `net_unit_cost` double NOT NULL,
  `new_unit_cost` double(10,2) DEFAULT NULL,
  `old_cost` double DEFAULT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_purchase`
--

INSERT INTO `material_purchase` (`id`, `purchase_id`, `material_id`, `qty`, `purchase_unit_id`, `net_unit_cost`, `new_unit_cost`, `old_cost`, `total`, `created_at`, `updated_at`) VALUES
(4, 10, 1, 100, 2, 40, 40.00, 0, 4000, '2021-11-16 06:46:58', NULL),
(5, 10, 2, 50, 2, 80, 80.00, 0, 4000, '2021-11-16 06:46:58', NULL),
(6, 10, 3, 50, 10, 150, 150.00, 0, 7500, '2021-11-16 06:46:58', NULL),
(7, 11, 1, 100, 2, 45, 42.56, 0, 4500, '2021-11-18 08:14:21', '2021-11-18 08:14:21'),
(8, 11, 2, 50, 2, 85, 82.63, 0, 4250, '2021-11-18 08:14:21', '2021-11-18 08:14:21'),
(9, 11, 3, 50, 10, 155, 152.50, 0, 7750, '2021-11-18 08:14:21', '2021-11-18 08:14:21'),
(15, 11, 10, 40, 2, 40, 40.00, 0, 1600, '2021-11-18 08:14:21', '2021-11-18 08:14:21');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `menu_name`, `deletable`, `created_at`, `updated_at`) VALUES
(1, 'Admin Sidebar Menu', '1', '2021-03-26 17:49:24', '2021-07-16 19:07:49');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(6, '2021_10_21_222929_create_opening_stocks_table', 4),
(7, '2021_10_21_222940_create_opening_stock_products_table', 4),
(10, '2021_10_25_105036_create_depos_table', 5),
(11, '2021_10_25_105056_create_dealers_table', 6),
(12, '2021_10_25_105729_create_sales_table', 7),
(13, '2021_10_25_105741_create_sale_products_table', 7),
(23, '2020_11_17_101065_create_dealer_groups_table', 9),
(24, '2021_11_07_165713_create_product_prices_table', 10),
(31, '2021_10_31_105417_create_order_sheets_table', 11),
(32, '2021_10_31_105430_create_order_sheet_products_table', 11),
(33, '2021_10_31_105509_create_order_sheet_memos_table', 11),
(34, '2021_10_05_141516_create_damages_table', 12),
(35, '2021_10_05_141527_create_damage_products_table', 12),
(40, '2021_06_19_141703_create_purchase_returns_table', 13),
(41, '2021_06_19_141731_create_purchase_return_materials_table', 13),
(42, '2021_06_19_141741_create_sale_returns_table', 13),
(43, '2021_06_19_141758_create_sale_return_products_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `mobile_banks`
--

CREATE TABLE `mobile_banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=divider,2=module',
  `module_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `divider_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `target` enum('_self','_blank') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `menu_id`, `type`, `module_name`, `divider_title`, `icon_class`, `url`, `order`, `parent_id`, `target`, `created_at`, `updated_at`) VALUES
(1, 1, '2', 'Dashboard', NULL, 'fas fa-tachometer-alt', '/', 1, NULL, NULL, NULL, '2021-11-18 11:20:22'),
(2, 1, '1', NULL, 'Menus', NULL, NULL, 2, NULL, NULL, NULL, '2021-11-18 11:20:22'),
(3, 1, '1', NULL, 'Access Control', NULL, NULL, 23, NULL, NULL, NULL, '2021-11-18 11:19:55'),
(4, 1, '2', 'User', NULL, 'fas fa-users', 'user', 24, NULL, NULL, NULL, '2021-11-18 11:19:55'),
(5, 1, '2', 'Role', NULL, 'fas fa-user-tag', 'role', 25, NULL, NULL, NULL, '2021-11-18 11:19:55'),
(6, 1, '1', NULL, 'System', NULL, NULL, 26, NULL, NULL, NULL, '2021-11-18 11:19:55'),
(7, 1, '2', 'Setting', NULL, 'fas fa-cogs', NULL, 27, NULL, NULL, NULL, '2021-11-18 11:19:55'),
(8, 1, '2', 'Menu', NULL, 'fas fa-th-list', 'menu', 28, NULL, NULL, NULL, '2021-11-18 11:19:55'),
(9, 1, '2', 'Permission', NULL, 'fas fa-tasks', 'menu/module/permission', 29, NULL, NULL, NULL, '2021-11-18 11:19:55'),
(10, 1, '2', 'General Setting', NULL, NULL, 'setting', 1, 7, NULL, '2021-03-26 18:01:48', '2021-03-26 18:06:29'),
(11, 1, '2', 'Warehouse', NULL, NULL, 'warehouse', 2, 7, NULL, '2021-03-26 18:07:10', '2021-10-11 05:42:35'),
(12, 1, '2', 'Dealer Group', NULL, NULL, 'dealer-group', 3, 7, NULL, '2021-03-26 18:07:41', '2021-11-07 07:56:19'),
(13, 1, '2', 'Unit', NULL, NULL, 'unit', 4, 7, NULL, '2021-03-26 18:07:54', '2021-06-05 21:48:54'),
(14, 1, '2', 'Tax', NULL, NULL, 'tax', 5, 7, NULL, '2021-03-26 18:08:03', '2021-07-12 19:59:29'),
(15, 1, '2', 'Material', NULL, 'fas fa-toolbox', NULL, 3, NULL, NULL, '2021-07-13 04:20:56', '2021-11-18 11:20:22'),
(16, 1, '2', 'Category', NULL, NULL, 'material/category', 1, 15, '_self', '2021-07-13 04:21:32', '2021-07-13 04:42:48'),
(17, 1, '2', 'Manage Material', NULL, NULL, 'material', 2, 15, NULL, '2021-07-13 04:22:22', '2021-07-13 04:42:54'),
(18, 1, '2', 'Material Stock Report', NULL, NULL, 'material-stock-report', 3, 15, NULL, '2021-07-13 04:41:53', '2021-07-13 04:42:58'),
(20, 1, '2', 'Purchase', NULL, 'fas fa-cart-arrow-down', NULL, 5, NULL, NULL, '2021-07-13 04:45:27', '2021-11-18 11:20:22'),
(21, 1, '2', 'Add Purchase', NULL, NULL, 'purchase/add', 1, 20, NULL, '2021-07-13 04:46:05', '2021-07-13 04:46:35'),
(22, 1, '2', 'Manage Purchase', NULL, NULL, 'purchase', 2, 20, NULL, '2021-07-13 04:46:31', '2021-07-13 04:46:44'),
(23, 1, '2', 'Product', NULL, 'fas fa-box', NULL, 4, NULL, NULL, '2021-07-13 04:49:30', '2021-11-18 11:20:22'),
(24, 1, '2', 'Category', NULL, NULL, 'product/category', 1, 23, NULL, '2021-07-13 04:50:00', '2021-07-13 04:52:42'),
(25, 1, '2', 'Add Product', NULL, NULL, 'product/add', 2, 23, NULL, '2021-07-13 04:50:23', '2021-08-14 04:30:42'),
(26, 1, '2', 'Manage Product', NULL, NULL, 'product', 3, 23, NULL, '2021-07-13 04:51:10', '2021-10-04 04:00:53'),
(28, 1, '2', 'Print Barcode', NULL, NULL, 'print-barcode', 4, 23, NULL, '2021-07-13 04:53:40', '2021-11-18 11:17:08'),
(29, 1, '2', 'Add Finish Goods Stock', NULL, NULL, 'finish-goods-stock/add', 1, 33, '_self', '2021-07-13 04:54:21', '2021-10-27 08:59:34'),
(30, 1, '2', 'Manage Finish Goods Stock', NULL, NULL, 'finish-goods-stock', 2, 33, '_self', '2021-07-13 04:55:23', '2021-10-27 08:59:40'),
(31, 1, '2', 'Product Stock Report', NULL, NULL, 'product-stock-report', 5, 23, NULL, '2021-07-13 04:57:37', '2021-11-18 11:17:08'),
(33, 1, '2', 'Production', NULL, 'fas fa-industry', NULL, 7, NULL, NULL, '2021-07-13 05:47:47', '2021-11-18 11:20:22'),
(47, 1, '2', 'Supplier', NULL, 'fas fa-user-tie', NULL, 11, NULL, NULL, '2021-07-13 06:02:42', '2021-11-18 11:20:22'),
(48, 1, '2', 'Manage Supplier', NULL, NULL, 'supplier', 1, 47, NULL, '2021-07-13 06:03:11', '2021-07-13 06:04:20'),
(49, 1, '2', 'Supplier Ledger', NULL, NULL, 'supplier-ledger', 2, 47, NULL, '2021-07-13 06:03:44', '2021-07-13 06:04:37'),
(50, 1, '2', 'Supplier Advance', NULL, NULL, 'supplier-advance', 3, 47, NULL, '2021-07-13 06:04:13', '2021-07-13 06:04:37'),
(51, 1, '2', 'Stock Return', NULL, 'fas fa-undo-alt', NULL, 14, NULL, NULL, '2021-07-13 06:14:46', '2021-11-18 11:19:55'),
(52, 1, '2', 'Return', NULL, NULL, 'return', 1, 51, '_self', '2021-07-13 06:15:33', '2021-09-23 04:37:04'),
(53, 1, '2', 'Purchase Return', NULL, NULL, 'purchase-return', 2, 51, NULL, '2021-07-13 06:16:14', '2021-09-23 04:37:15'),
(55, 1, '2', 'Depo', NULL, 'fas fa-store', NULL, 9, NULL, NULL, '2021-07-13 06:22:38', '2021-11-18 11:20:22'),
(56, 1, '2', 'Manage Dealer', NULL, NULL, 'dealer', 1, 243, '_self', '2021-07-13 06:25:04', '2021-10-25 11:11:35'),
(57, 1, '2', 'Location', NULL, 'fas fa-map-marker-alt', NULL, 22, NULL, NULL, '2021-07-13 06:56:46', '2021-11-18 11:19:55'),
(58, 1, '2', 'Manage District', NULL, NULL, 'district', 1, 57, '_self', '2021-07-13 06:57:29', '2021-07-13 06:58:53'),
(59, 1, '2', 'Manage Upazila', NULL, NULL, 'upazila', 2, 57, NULL, '2021-07-13 06:57:58', '2021-07-13 06:58:57'),
(61, 1, '2', 'Manage Area', NULL, NULL, 'area', 3, 57, NULL, '2021-07-13 06:58:48', '2021-10-25 11:14:19'),
(62, 1, '2', 'Bank', NULL, 'fas fa-university', NULL, 19, NULL, NULL, '2021-07-13 08:16:58', '2021-11-18 11:19:55'),
(63, 1, '2', 'Manage Bank', NULL, NULL, 'bank', 1, 62, NULL, '2021-07-13 08:17:23', '2021-07-13 08:18:19'),
(64, 1, '2', 'Bank Transaction', NULL, NULL, 'bank-transaction', 2, 62, NULL, '2021-07-13 08:17:50', '2021-07-13 08:18:23'),
(65, 1, '2', 'Bank Ledger', NULL, NULL, 'bank-ledger', 3, 62, NULL, '2021-07-13 08:18:15', '2021-07-13 08:18:27'),
(66, 1, '2', 'Mobile Bank', NULL, 'fas fa-mobile-alt', NULL, 20, NULL, NULL, '2021-07-13 08:19:07', '2021-11-18 11:19:55'),
(67, 1, '2', 'Manage Mobile Bank', NULL, NULL, 'mobile-bank', 1, 66, NULL, '2021-07-13 08:19:31', '2021-07-13 08:20:41'),
(68, 1, '2', 'Mobile Bank Transaction', NULL, NULL, 'mobile-bank-transaction', 2, 66, NULL, '2021-07-13 08:20:10', '2021-09-06 04:19:26'),
(69, 1, '2', 'Mobile Bank Ledger', NULL, NULL, 'mobile-bank-ledger', 3, 66, NULL, '2021-07-13 08:20:37', '2021-09-06 04:19:54'),
(70, 1, '2', 'Expense', NULL, 'fas fa-money-check-alt', NULL, 18, NULL, NULL, '2021-07-13 09:00:55', '2021-11-18 11:19:55'),
(71, 1, '2', 'Manage Expense Item', NULL, NULL, 'expense-item', 1, 70, NULL, '2021-07-13 09:01:28', '2021-07-13 09:02:23'),
(72, 1, '2', 'Manage Expense', NULL, NULL, 'expense', 2, 70, NULL, '2021-07-13 09:01:50', '2021-07-13 09:02:31'),
(73, 1, '2', 'Expense Statement', NULL, NULL, 'expense-statement', 3, 70, NULL, '2021-07-13 09:02:19', '2021-07-13 09:02:36'),
(74, 1, '2', 'Accounts', NULL, 'far fa-money-bill-alt', NULL, 15, NULL, NULL, '2021-03-26 18:52:27', '2021-11-18 11:19:55'),
(75, 1, '2', 'Chart of Account', NULL, NULL, 'coa', 1, 74, NULL, '2021-03-26 18:52:53', '2021-05-11 06:10:34'),
(76, 1, '2', 'Opening Balance', NULL, NULL, 'opening-balance', 2, 74, NULL, '2021-03-26 18:53:20', '2021-05-11 06:10:34'),
(77, 1, '2', 'Supplier Payment', NULL, NULL, 'supplier-payment', 3, 74, NULL, '2021-03-26 18:53:43', '2021-05-11 06:10:34'),
(79, 1, '2', 'Cash Adjustment', NULL, NULL, 'cash-adjustment/create', 6, 74, NULL, '2021-03-26 18:54:30', '2021-10-31 04:34:39'),
(80, 1, '2', 'Debit Voucher', NULL, NULL, 'debit-voucher/create', 8, 74, '_self', '2021-03-26 18:54:52', '2021-10-31 04:34:39'),
(81, 1, '2', 'Credit Voucher', NULL, NULL, 'credit-voucher/create', 10, 74, '_self', '2021-03-26 18:55:10', '2021-10-31 04:34:39'),
(82, 1, '2', 'Contra Voucher', NULL, NULL, 'contra-voucher/create', 12, 74, '_self', '2021-03-26 18:55:31', '2021-10-31 04:34:39'),
(83, 1, '2', 'Contra Voucher List', NULL, NULL, 'contra-voucher', 13, 74, NULL, '2021-07-03 05:53:42', '2021-10-31 04:34:39'),
(84, 1, '2', 'Journal Voucher', NULL, NULL, 'journal-voucher/create', 14, 74, '_self', '2021-03-26 18:55:50', '2021-10-31 04:34:39'),
(85, 1, '2', 'Journal Voucher List', NULL, NULL, 'journal-voucher', 15, 74, NULL, '2021-07-03 05:54:24', '2021-10-31 04:34:39'),
(86, 1, '2', 'Voucher Approval', NULL, NULL, 'voucher-approval', 16, 74, NULL, '2021-03-26 18:56:21', '2021-10-31 04:34:39'),
(87, 1, '2', 'Report', NULL, 'fas fa-file-signature', NULL, 17, 74, NULL, '2021-03-26 18:58:02', '2021-10-31 04:34:39'),
(88, 1, '2', 'Cash Book', NULL, NULL, 'cash-book', 1, 87, NULL, '2021-03-26 18:58:53', '2021-03-26 19:01:24'),
(89, 1, '2', 'Inventory Ledger', NULL, NULL, 'inventory-ledger', 2, 87, NULL, '2021-03-26 18:59:21', '2021-03-26 19:01:25'),
(90, 1, '2', 'Bank Book', NULL, NULL, 'bank-book', 3, 87, NULL, '2021-03-26 18:59:42', '2021-03-26 19:01:30'),
(91, 1, '2', 'Mobile Bank Book', NULL, NULL, 'mobile-bank-book', 4, 87, NULL, '2021-03-26 19:00:00', '2021-03-26 19:01:41'),
(92, 1, '2', 'General Ledger', NULL, NULL, 'general-ledger', 5, 87, NULL, '2021-03-26 19:00:23', '2021-03-26 19:01:42'),
(93, 1, '2', 'Trial Balance', NULL, NULL, 'trial-balance', 6, 87, NULL, '2021-03-26 19:00:42', '2021-03-26 19:01:46'),
(94, 1, '2', 'Profit Loss', NULL, NULL, 'profit-loss', 7, 87, NULL, '2021-03-26 19:01:03', '2021-03-26 19:01:47'),
(95, 1, '2', 'Cash Flow', NULL, NULL, 'cash-flow', 8, 87, NULL, '2021-03-26 19:01:21', '2021-03-26 19:01:51'),
(96, 1, '2', 'Human Resource', NULL, 'fas fa-users', NULL, 17, NULL, NULL, '2021-04-03 10:54:02', '2021-11-18 11:19:55'),
(97, 1, '2', 'HRM', NULL, NULL, NULL, 1, 96, NULL, '2021-04-03 10:54:49', '2021-04-25 23:02:56'),
(98, 1, '2', 'Manage Department', NULL, NULL, 'department', 1, 97, NULL, '2021-04-03 10:55:36', '2021-04-25 22:59:58'),
(99, 1, '2', 'Manage Division', NULL, NULL, 'division', 2, 97, NULL, '2021-04-03 10:55:58', '2021-04-25 23:00:21'),
(100, 1, '2', 'Manage Designation', NULL, NULL, 'designation', 3, 97, NULL, '2021-04-03 10:56:21', '2021-04-25 23:01:09'),
(101, 1, '2', 'Shift', NULL, NULL, 'shift', 4, 97, NULL, '2021-04-26 01:09:53', '2021-04-26 01:20:08'),
(102, 1, '2', 'Add Employee', NULL, NULL, 'employee/add', 5, 97, NULL, '2021-04-03 10:57:01', '2021-04-25 23:02:24'),
(103, 1, '2', 'Manage Employee', NULL, NULL, 'employee', 6, 97, NULL, '2021-04-03 10:59:55', '2021-04-26 17:16:32'),
(104, 1, '2', 'Attendance', NULL, NULL, NULL, 2, 96, NULL, '2021-04-03 11:00:34', '2021-04-25 23:06:51'),
(105, 1, '2', 'Manage Attendance', NULL, NULL, 'attendance', 1, 104, NULL, '2021-04-03 11:01:28', '2021-04-25 23:04:12'),
(106, 1, '2', 'Attendance Report', NULL, NULL, 'attendance-report', 2, 104, NULL, '2021-04-03 11:01:53', '2021-04-25 23:04:16'),
(107, 1, '2', 'Payroll', NULL, NULL, NULL, 4, 96, NULL, '2021-04-03 11:08:19', '2021-04-25 23:09:25'),
(108, 1, '2', 'Manage Benifits', NULL, NULL, 'benifits', 1, 107, NULL, '2021-04-03 11:09:11', '2021-04-25 23:08:33'),
(109, 1, '2', 'Add Salary Setup', NULL, NULL, 'salary.setup/add', 2, 107, NULL, '2021-04-03 11:09:53', '2021-05-08 22:34:40'),
(110, 1, '2', 'Manage Salary Setup', NULL, NULL, 'salary-setup', 3, 107, NULL, '2021-04-03 11:10:19', '2021-04-25 23:08:57'),
(111, 1, '2', 'Manage Salary Generate', NULL, NULL, 'salary-generate', 4, 107, NULL, '2021-04-03 11:14:01', '2021-04-25 23:08:57'),
(112, 1, '2', 'Leave', NULL, NULL, NULL, 3, 96, NULL, '2021-04-03 12:02:43', '2021-04-25 23:06:51'),
(113, 1, '2', 'Weekly Holiday', NULL, NULL, 'weekly-holiday', 1, 112, NULL, '2021-04-03 12:03:11', '2021-04-25 23:05:09'),
(114, 1, '2', 'Holiday', NULL, NULL, 'holiday', 2, 112, NULL, '2021-04-03 12:03:29', '2021-04-26 01:11:00'),
(115, 1, '2', 'Manage Leave Type', NULL, NULL, 'leave-type', 3, 112, NULL, '2021-04-03 12:03:56', '2021-04-26 01:11:00'),
(116, 1, '2', 'Manage Leave Application', NULL, NULL, 'leave-application', 4, 112, NULL, '2021-04-03 12:04:31', '2021-04-26 01:11:00'),
(179, 1, '2', 'Report', NULL, 'fas fa-file-signature', NULL, 21, NULL, NULL, '2021-09-06 04:06:13', '2021-11-18 11:19:55'),
(180, 1, '2', 'Closing', NULL, NULL, 'closing', 1, 179, '_self', '2021-09-06 04:06:36', '2021-09-06 04:15:28'),
(181, 1, '2', 'Closing Report', NULL, NULL, 'closing-report', 2, 179, '_self', '2021-09-06 04:06:57', '2021-09-06 04:15:33'),
(182, 1, '2', 'Today\'s Sales Report', NULL, NULL, 'todays-sales-report', 5, 179, '_self', '2021-09-06 04:07:35', '2021-11-15 10:16:38'),
(183, 1, '2', 'Sales Report', NULL, NULL, 'sales-report', 6, 179, '_self', '2021-09-06 04:07:55', '2021-11-15 10:16:26'),
(190, 1, '2', 'Product Wise Sales Report', NULL, NULL, 'product-wise-sales-report', 8, 179, '_self', '2021-09-06 04:11:35', '2021-11-15 10:39:36'),
(194, 1, '2', 'Warehouse Summary', NULL, NULL, 'warehouse-summary', 13, 179, '_self', '2021-09-06 04:13:36', '2021-11-15 10:44:13'),
(196, 1, '2', 'Material Stock Alert Report', NULL, NULL, 'material-stock-alert-report', 14, 179, '_self', '2021-09-06 04:14:40', '2021-11-15 10:44:13'),
(203, 1, '2', 'Debit Voucher List', NULL, NULL, 'debit-voucher', 9, 74, '_self', '2021-09-07 09:55:31', '2021-10-31 04:34:39'),
(204, 1, '2', 'Credit Voucher List', NULL, NULL, 'credit-voucher', 11, 74, '_self', '2021-09-07 09:56:13', '2021-10-31 04:34:39'),
(222, 1, '2', 'Cash Adjustment List', NULL, NULL, 'cash-adjustment', 7, 74, '_self', '2021-09-12 10:39:28', '2021-10-31 04:34:39'),
(223, 1, '2', 'Loan', NULL, 'far fa-money-bill-alt', NULL, 16, NULL, NULL, '2021-09-13 04:31:56', '2021-11-18 11:19:55'),
(224, 1, '2', 'Personal Loan', NULL, NULL, NULL, 1, 223, NULL, '2021-09-13 04:32:14', '2021-09-13 04:33:23'),
(225, 1, '2', 'Mangage Person', NULL, NULL, 'personal-loan-person', 1, 224, NULL, '2021-09-13 04:32:32', '2021-09-13 04:33:31'),
(226, 1, '2', 'Loan Manage', NULL, NULL, 'personal-loan', 2, 224, NULL, '2021-09-13 04:32:53', '2021-09-13 04:33:36'),
(227, 1, '2', 'Loan Installment Manage', NULL, NULL, 'personal-loan-installment', 3, 224, NULL, '2021-09-13 04:33:13', '2021-09-13 04:33:40'),
(228, 1, '2', 'Official Loan', NULL, NULL, NULL, 2, 223, NULL, '2021-09-13 04:34:00', '2021-09-13 04:34:58'),
(229, 1, '2', 'Loan manage', NULL, NULL, 'official-loan', 1, 228, NULL, '2021-09-13 04:34:18', '2021-09-13 04:34:48'),
(230, 1, '2', 'Loan Installment Manage', NULL, NULL, 'official-loan-installment', 2, 228, NULL, '2021-09-13 04:34:37', '2021-09-13 04:34:58'),
(231, 1, '2', 'Loan Report', NULL, NULL, NULL, 3, 223, NULL, '2021-09-13 04:35:25', '2021-09-13 04:35:44'),
(232, 1, '2', 'Report', NULL, NULL, 'loan-report', 1, 231, NULL, '2021-09-13 04:35:37', '2021-09-13 04:35:40'),
(233, 1, '2', 'Balance Sheet', NULL, NULL, 'balance-sheet', 9, 87, '_self', '2021-09-13 05:21:49', '2021-09-13 05:22:04'),
(234, 1, '2', 'Sale', NULL, 'fab fa-opencart', NULL, 8, NULL, '_self', '2021-09-22 08:55:19', '2021-11-18 11:20:22'),
(235, 1, '2', 'Add Sale', NULL, NULL, 'sale/add', 1, 234, '_self', '2021-09-22 08:55:45', '2021-09-22 08:56:03'),
(236, 1, '2', 'Manage Sale', NULL, NULL, 'sale', 2, 234, '_self', '2021-09-22 09:18:29', '2021-09-22 09:18:34'),
(237, 1, '2', 'Sale Return', NULL, NULL, 'sale-return', 3, 51, '_self', '2021-09-23 04:37:37', '2021-09-23 04:37:49'),
(238, 1, '2', 'Product Stock Alert Report', NULL, NULL, 'product-stock-alert-report', 15, 179, '_self', '2021-09-23 06:59:01', '2021-11-15 10:44:13'),
(240, 1, '2', 'Invoice Report', NULL, NULL, 'invoice-report', 3, 234, NULL, '2021-10-03 04:47:28', '2021-10-03 05:44:17'),
(241, 1, '2', 'Dealer Receive', NULL, NULL, 'dealer-receive', 5, 74, '_self', '2021-10-03 09:56:32', '2021-10-31 04:34:39'),
(242, 1, '2', 'Dealer Ledger', NULL, NULL, 'dealer/ledger', 2, 243, '_self', '2021-10-03 11:40:20', '2021-10-26 07:47:49'),
(243, 1, '2', 'Dealer', NULL, 'fas fa-user-secret', NULL, 10, NULL, NULL, '2021-10-04 03:59:49', '2021-11-18 11:20:22'),
(244, 1, '2', 'Damage Product', NULL, 'fas fa-recycle', NULL, 13, NULL, NULL, '2021-10-05 07:58:44', '2021-11-18 11:19:55'),
(245, 1, '2', 'Damage', NULL, NULL, 'damage', 1, 244, NULL, '2021-10-05 07:59:04', '2021-10-05 09:24:26'),
(246, 1, '2', 'Damage Product', NULL, NULL, 'damage-product', 2, 244, NULL, '2021-10-06 08:16:38', '2021-10-06 08:16:48'),
(250, 1, '2', 'Material Stock Out', NULL, 'fas fa-box-open', NULL, 6, NULL, '_self', '2021-10-19 08:12:58', '2021-11-18 11:20:22'),
(251, 1, '2', 'Create Material Stock Out', NULL, NULL, 'material-stock-out/create', 1, 250, '_self', '2021-10-19 08:13:48', '2021-10-19 08:14:00'),
(252, 1, '2', 'Manage Material Stock Out', NULL, NULL, 'material-stock-out', 2, 250, '_self', '2021-10-19 08:14:31', '2021-10-19 08:14:36'),
(253, 1, '2', 'Material Stock Out Report', NULL, NULL, 'material-stock-out/report', 3, 250, '_self', '2021-10-19 08:15:35', '2021-10-19 08:15:38'),
(258, 1, '2', 'Manage Depo', NULL, NULL, 'depo', 1, 55, '_self', '2021-10-25 11:13:05', '2021-10-25 11:14:23'),
(259, 1, '2', 'Depo Ledger', NULL, NULL, 'depo/ledger', 2, 55, '_self', '2021-10-25 11:13:38', '2021-10-25 11:14:26'),
(260, 1, '2', 'Depo Receive', NULL, NULL, 'depo-receive', 4, 74, '_self', '2021-10-25 11:28:16', '2021-10-31 04:34:39'),
(263, 1, '2', 'Today\'s Production Order Sheet', NULL, NULL, 'todays-production-order-sheet', 3, 33, '_self', '2021-10-31 04:33:38', '2021-10-31 04:34:39'),
(264, 1, '2', 'Manage Production Order Sheet', NULL, NULL, 'production-order-sheet', 4, 33, '_self', '2021-10-31 04:34:24', '2021-10-31 04:38:17'),
(265, 1, '2', 'Depo Advance', NULL, NULL, 'depo-advance', 3, 55, '_self', '2021-11-14 19:18:09', '2021-11-14 19:18:47'),
(266, 1, '2', 'Dealer Advance', NULL, NULL, 'dealer-advance', 3, 243, '_self', '2021-11-14 19:19:37', '2021-11-14 19:20:12'),
(267, 1, '2', 'Today\'s Purchase Report', NULL, NULL, 'todays-purchase-report', 3, 179, '_self', '2021-11-15 10:15:56', '2021-11-15 10:16:01'),
(268, 1, '2', 'Purchase Report', NULL, NULL, 'purchase-report', 4, 179, '_self', '2021-11-15 10:16:22', '2021-11-15 10:16:26'),
(270, 1, '2', 'Depo Wise Sales Report', NULL, NULL, 'depo-wise-sales-report', 9, 179, '_self', '2021-11-15 10:40:45', '2021-11-15 10:41:54'),
(271, 1, '2', 'Dealer Wise Sales Report', NULL, NULL, 'dealer-wise-sales-report', 10, 179, '_self', '2021-11-15 10:41:24', '2021-11-15 10:41:57'),
(272, 1, '2', 'Depo Wise Product Sales Report', NULL, NULL, 'depo-wise-product-sales-report', 11, 179, '_self', '2021-11-15 10:43:17', '2021-11-15 10:44:10'),
(273, 1, '2', 'Dealer Wise Product Sales Report', NULL, NULL, 'dealer-wise-product-sales-report', 12, 179, '_self', '2021-11-15 10:44:02', '2021-11-15 10:44:13'),
(274, 1, '2', 'Product Sales Report', NULL, NULL, 'product-sales-report', 7, 179, '_self', '2021-11-16 10:18:04', '2021-11-16 10:18:29'),
(275, 1, '2', 'Guest Gift', NULL, 'fas fa-gift', NULL, 12, NULL, NULL, '2021-11-18 11:16:00', '2021-11-18 11:20:22'),
(276, 1, '2', 'Add Guest Gift', NULL, NULL, 'guest-gift/add', 1, 275, '_self', '2021-11-18 11:16:40', '2021-11-18 11:20:01'),
(277, 1, '2', 'Manage Guest Gift', NULL, NULL, 'guest-gift', 2, 275, '_self', '2021-11-18 11:17:04', '2021-11-18 11:19:57');

-- --------------------------------------------------------

--
-- Table structure for table `module_role`
--

CREATE TABLE `module_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `module_role`
--

INSERT INTO `module_role` (`id`, `module_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(2, 2, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(13, 29, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(14, 30, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(20, 47, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(21, 48, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(22, 49, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(23, 50, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(29, 3, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(30, 4, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(31, 5, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(32, 55, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(33, 56, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(34, 6, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(35, 7, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(36, 10, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(37, 11, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(38, 12, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(39, 13, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(40, 14, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(41, 20, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(42, 21, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(43, 22, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(51, 51, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(52, 52, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(53, 53, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(55, 74, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(56, 75, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(57, 76, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(58, 77, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(60, 79, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(61, 222, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(63, 203, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(65, 204, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(66, 82, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(67, 83, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(68, 84, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(69, 85, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(70, 86, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(71, 87, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(72, 88, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(73, 89, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(74, 90, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(75, 91, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(76, 92, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(77, 93, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(78, 94, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(79, 95, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(80, 233, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(81, 223, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(82, 224, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(83, 225, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(84, 226, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(85, 227, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(86, 228, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(87, 229, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(88, 230, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(89, 231, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(90, 232, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(91, 96, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(92, 97, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(93, 98, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(94, 99, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(95, 100, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(96, 101, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(97, 102, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(98, 103, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(99, 104, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(100, 105, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(101, 106, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(102, 112, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(103, 113, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(104, 114, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(105, 115, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(106, 116, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(107, 107, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(108, 108, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(109, 109, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(110, 110, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(111, 111, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(112, 70, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(113, 71, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(114, 72, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(115, 73, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(116, 62, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(117, 63, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(118, 64, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(119, 65, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(120, 66, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(121, 67, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(122, 68, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(123, 69, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(147, 80, 2, '2021-09-20 09:42:13', '2021-09-20 09:42:13'),
(148, 81, 2, '2021-09-20 09:42:13', '2021-09-20 09:42:13'),
(149, 234, 2, '2021-09-23 06:57:20', '2021-09-23 06:57:20'),
(150, 235, 2, '2021-09-23 06:57:20', '2021-09-23 06:57:20'),
(151, 236, 2, '2021-09-23 06:57:20', '2021-09-23 06:57:20'),
(152, 237, 2, '2021-09-23 06:57:41', '2021-09-23 06:57:41'),
(156, 244, 2, '2021-10-13 10:19:18', '2021-10-13 10:19:18'),
(157, 245, 2, '2021-10-13 10:19:18', '2021-10-13 10:19:18'),
(158, 246, 2, '2021-10-13 10:19:18', '2021-10-13 10:19:18'),
(159, 241, 2, '2021-10-13 10:19:18', '2021-10-13 10:19:18'),
(162, 243, 2, '2021-10-13 10:19:18', '2021-10-13 10:19:18'),
(163, 242, 2, '2021-10-13 10:19:18', '2021-10-13 10:19:18'),
(164, 250, 2, '2021-10-21 10:02:30', '2021-10-21 10:02:30'),
(165, 251, 2, '2021-10-21 10:02:30', '2021-10-21 10:02:30'),
(166, 252, 2, '2021-10-21 10:02:30', '2021-10-21 10:02:30'),
(167, 253, 2, '2021-10-21 10:02:30', '2021-10-21 10:02:30'),
(172, 1, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(173, 2, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(174, 15, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(175, 16, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(176, 17, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(177, 18, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(178, 247, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(179, 250, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(180, 251, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(181, 252, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(182, 253, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(183, 20, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(184, 21, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(185, 22, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(186, 23, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(187, 24, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(188, 25, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(189, 26, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(190, 28, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(191, 29, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(192, 30, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(193, 31, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(194, 249, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(195, 234, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(196, 235, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(197, 236, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(198, 240, 3, '2021-10-21 10:13:38', '2021-10-21 10:13:38'),
(205, 47, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(206, 48, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(207, 49, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(208, 50, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(209, 55, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(210, 243, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(211, 56, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(212, 242, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(214, 33, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(215, 263, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(216, 264, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(217, 260, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(218, 57, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(219, 58, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(220, 59, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(221, 61, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(222, 258, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(223, 259, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23');

-- --------------------------------------------------------

--
-- Table structure for table `opening_stocks`
--

CREATE TABLE `opening_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `opening_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `item` double(8,2) NOT NULL,
  `total_qty` double(8,2) NOT NULL,
  `date` date NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `opening_stocks`
--

INSERT INTO `opening_stocks` (`id`, `opening_no`, `warehouse_id`, `item`, `total_qty`, `date`, `note`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'OP-2110955', 1, 3.00, 300.00, '2021-10-27', NULL, 'Super Admin', NULL, '2021-10-27 09:06:24', '2021-10-27 09:06:24');

-- --------------------------------------------------------

--
-- Table structure for table `opening_stock_products`
--

CREATE TABLE `opening_stock_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `opening_stock_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `base_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `base_unit_qty` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `opening_stock_products`
--

INSERT INTO `opening_stock_products` (`id`, `opening_stock_id`, `product_id`, `base_unit_id`, `base_unit_qty`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 100, '2021-10-26 18:00:00', NULL),
(2, 1, 2, 1, 100, '2021-10-26 18:00:00', NULL),
(3, 1, 3, 1, 100, '2021-10-26 18:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_sheets`
--

CREATE TABLE `order_sheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sheet_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_date` date NOT NULL,
  `delivery_date` date NOT NULL,
  `delivery_status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=Delivered,2=Pending',
  `item` double(8,2) NOT NULL,
  `total_qty` double(8,2) NOT NULL,
  `total_order_value` double(8,2) NOT NULL,
  `total_commission` double(8,2) DEFAULT NULL,
  `created_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_sheets`
--

INSERT INTO `order_sheets` (`id`, `sheet_no`, `order_date`, `delivery_date`, `delivery_status`, `item`, `total_qty`, `total_order_value`, `total_commission`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(3, '211113', '2021-11-13', '2021-11-13', '1', 8.00, 1180.00, 11674.00, 1029.17, 'Super Admin', NULL, '2021-11-13 14:10:43', '2021-11-14 19:05:20'),
(4, '211116', '2021-11-16', '2021-11-16', '1', 3.00, 115.00, 1440.00, 0.00, 'Super Admin', NULL, '2021-11-16 12:28:55', '2021-11-16 12:29:41');

-- --------------------------------------------------------

--
-- Table structure for table `order_sheet_memos`
--

CREATE TABLE `order_sheet_memos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_sheet_id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_sheet_memos`
--

INSERT INTO `order_sheet_memos` (`id`, `order_sheet_id`, `sale_id`, `created_at`, `updated_at`) VALUES
(5, 3, 3, '2021-11-13 14:10:43', '2021-11-13 14:10:43'),
(6, 3, 4, '2021-11-13 14:10:43', '2021-11-13 14:10:43'),
(7, 3, 5, '2021-11-13 14:10:43', '2021-11-13 14:10:43'),
(8, 3, 6, '2021-11-13 14:10:43', '2021-11-13 14:10:43'),
(9, 3, 7, '2021-11-13 14:10:43', '2021-11-13 14:10:43'),
(10, 4, 8, '2021-11-16 12:28:55', '2021-11-16 12:28:55');

-- --------------------------------------------------------

--
-- Table structure for table `order_sheet_products`
--

CREATE TABLE `order_sheet_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_sheet_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `stock_qty` double(8,2) NOT NULL,
  `ordered_qty` double(8,2) NOT NULL,
  `required_qty` double(8,2) NOT NULL,
  `total` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_sheet_products`
--

INSERT INTO `order_sheet_products` (`id`, `order_sheet_id`, `product_id`, `stock_qty`, `ordered_qty`, `required_qty`, `total`, `created_at`, `updated_at`) VALUES
(13, 3, 1, 200.00, 295.00, 95.00, 2133.00, '2021-11-13 14:10:43', '2021-11-13 14:10:43'),
(14, 3, 2, 100.00, 175.00, 75.00, 1277.50, '2021-11-13 14:10:43', '2021-11-13 14:10:43'),
(15, 3, 3, 300.00, 255.00, 0.00, 1287.50, '2021-11-13 14:10:43', '2021-11-13 14:10:43'),
(16, 3, 4, 0.00, 215.00, 215.00, 2160.00, '2021-11-13 14:10:43', '2021-11-13 14:10:43'),
(17, 3, 5, 0.00, 96.00, 96.00, 1216.00, '2021-11-13 14:10:43', '2021-11-13 14:10:43'),
(18, 3, 6, 0.00, 72.00, 72.00, 1080.00, '2021-11-13 14:10:43', '2021-11-13 14:10:43'),
(19, 3, 7, 0.00, 48.00, 48.00, 1440.00, '2021-11-13 14:10:43', '2021-11-13 14:10:43'),
(20, 3, 8, 0.00, 24.00, 24.00, 1080.00, '2021-11-13 14:10:43', '2021-11-13 14:10:43'),
(21, 4, 1, 5.00, 41.00, 36.00, 288.00, '2021-11-16 12:28:55', '2021-11-16 12:28:55'),
(22, 4, 8, 76.00, 24.00, 0.00, 1152.00, '2021-11-16 12:28:55', '2021-11-16 12:28:55'),
(23, 4, 11, 100.00, 50.00, 0.00, 0.00, '2021-11-16 12:28:55', '2021-11-16 12:28:55');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `module_id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dashboard Access', 'dashboard-access', '2021-03-26 17:49:24', NULL),
(2, 4, 'User Access', 'user-access', '2021-03-26 17:49:24', NULL),
(3, 4, 'User Add', 'user-add', '2021-03-26 17:49:24', NULL),
(4, 4, 'User Edit', 'user-edit', '2021-03-26 17:49:24', NULL),
(5, 4, 'User View', 'user-view', '2021-03-26 17:49:24', NULL),
(6, 4, 'User Delete', 'user-delete', '2021-03-26 17:49:24', NULL),
(7, 4, 'User Bulk Delete', 'user-bulk-delete', '2021-03-26 17:49:24', NULL),
(8, 4, 'User Report', 'user-report', '2021-03-26 17:49:24', NULL),
(9, 5, 'Role Access', 'role-access', '2021-03-26 17:49:24', NULL),
(10, 5, 'Role Add', 'role-add', '2021-03-26 17:49:24', NULL),
(11, 5, 'Role Edit', 'role-edit', '2021-03-26 17:49:24', NULL),
(12, 5, 'Role View', 'role-view', '2021-03-26 17:49:24', NULL),
(13, 5, 'Role Delete', 'role-delete', '2021-03-26 17:49:24', NULL),
(14, 5, 'Role Bulk Delete', 'role-bulk-delete', '2021-03-26 17:49:24', NULL),
(15, 5, 'Role Report', 'role-report', '2021-03-26 17:49:24', NULL),
(17, 8, 'Menu Access', 'menu-access', '2021-03-26 17:49:24', NULL),
(18, 8, 'Menu Add', 'menu-add', '2021-03-26 17:49:24', NULL),
(19, 8, 'Menu Edit', 'menu-edit', '2021-03-26 17:49:24', NULL),
(20, 8, 'Menu Delete', 'menu-delete', '2021-03-26 17:49:24', NULL),
(21, 8, 'Menu Bulk Delete', 'menu-bulk-delete', '2021-03-26 17:49:24', NULL),
(22, 8, 'Menu Report', 'menu-report', '2021-03-26 17:49:24', NULL),
(23, 8, 'Menu Builder Access', 'menu-builder-access', '2021-03-26 17:49:24', NULL),
(24, 8, 'Menu Module Add', 'menu-module-add', '2021-03-26 17:49:24', NULL),
(25, 8, 'Menu Module Edit', 'menu-module-edit', '2021-03-26 17:49:24', NULL),
(26, 8, 'Menu Module Delete', 'menu-module-delete', '2021-03-26 17:49:24', NULL),
(27, 9, 'Permission Access', 'permission-access', '2021-03-26 17:49:24', NULL),
(28, 9, 'Permission Add', 'permission-add', '2021-03-26 17:49:24', NULL),
(29, 9, 'Permission Edit', 'permission-edit', '2021-03-26 17:49:24', NULL),
(30, 9, 'Permission Delete', 'permission-delete', '2021-03-26 17:49:24', NULL),
(31, 9, 'Permission Bulk Delete', 'permission-bulk-delete', '2021-03-26 17:49:24', NULL),
(32, 9, 'Permission Report', 'permission-report', '2021-03-26 17:49:24', NULL),
(33, 11, 'Warehouse Access', 'warehouse-access', '2021-03-26 20:06:16', '2021-10-11 05:43:11'),
(34, 11, 'Warehouse Add', 'warehouse-add', '2021-03-26 20:06:16', '2021-10-11 05:43:21'),
(35, 11, 'Warehouse Edit', 'warehouse-edit', '2021-03-26 20:06:16', '2021-10-11 05:43:32'),
(36, 11, 'Warehouse Delete', 'warehouse-delete', '2021-03-26 20:06:16', '2021-10-11 05:43:42'),
(37, 11, 'Warehouse Bulk Delete', 'warehouse-bulk-delete', '2021-03-26 20:06:16', '2021-10-11 05:43:53'),
(38, 11, 'Warehouse Report', 'warehouse-report', '2021-03-26 20:06:16', '2021-10-11 05:44:05'),
(39, 10, 'General Setting Access', 'general-setting-access', '2021-03-26 20:07:15', NULL),
(40, 12, 'Dealer Group Access', 'dealer-group-access', '2021-03-26 20:08:50', '2021-11-07 07:57:00'),
(41, 12, 'Dealer Group Add', 'dealer-group-add', '2021-03-26 20:08:50', '2021-11-07 07:57:11'),
(42, 12, 'Dealer Group Edit', 'dealer-group-edit', '2021-03-26 20:08:50', '2021-11-07 07:57:25'),
(43, 12, 'Dealer Group Delete', 'dealer-group-delete', '2021-03-26 20:08:50', '2021-11-07 07:57:39'),
(44, 12, 'Dealer Group Bulk Delete', 'dealer-group-bulk-delete', '2021-03-26 20:08:50', '2021-11-07 07:57:51'),
(46, 13, 'Unit Access', 'unit-access', '2021-03-26 20:10:02', NULL),
(47, 13, 'Unit Add', 'unit-add', '2021-03-26 20:10:02', NULL),
(48, 13, 'Unit Edit', 'unit-edit', '2021-03-26 20:10:02', NULL),
(49, 13, 'Unit Delete', 'unit-delete', '2021-03-26 20:10:02', NULL),
(50, 13, 'Unit Bulk Delete', 'unit-bulk-delete', '2021-03-26 20:10:02', NULL),
(51, 13, 'Unit Report', 'unit-report', '2021-03-26 20:10:02', NULL),
(52, 14, 'Tax Access', 'tax-access', '2021-03-26 20:10:46', NULL),
(53, 14, 'Tax Add', 'tax-add', '2021-03-26 20:10:46', NULL),
(54, 14, 'Tax Edit', 'tax-edit', '2021-03-26 20:10:46', NULL),
(55, 14, 'Tax Delete', 'tax-delete', '2021-03-26 20:10:46', NULL),
(56, 14, 'Tax Bulk Delete', 'tax-bulk-delete', '2021-03-26 20:10:46', NULL),
(57, 14, 'Tax Report', 'tax-report', '2021-03-26 20:10:46', NULL),
(58, 16, 'Material Category Access', 'material-category-access', '2021-07-13 10:31:39', NULL),
(59, 16, 'Material Category Add', 'material-category-add', '2021-07-13 10:31:39', NULL),
(60, 16, 'Material Category Edit', 'material-category-edit', '2021-07-13 10:31:39', NULL),
(61, 16, 'Material Category Delete', 'material-category-delete', '2021-07-13 10:31:39', NULL),
(62, 16, 'Material Category Bulk Delete', 'material-category-bulk-delete', '2021-07-13 10:31:39', NULL),
(63, 16, 'Material Category Report', 'material-category-report', '2021-07-13 10:31:39', NULL),
(64, 17, 'Material Access', 'material-access', '2021-07-13 10:34:53', NULL),
(65, 17, 'Material Add', 'material-add', '2021-07-13 10:34:53', NULL),
(66, 17, 'Material Edit', 'material-edit', '2021-07-13 10:34:53', NULL),
(67, 17, 'Material View', 'material-view', '2021-07-13 10:34:53', NULL),
(68, 17, 'Material Delete', 'material-delete', '2021-07-13 10:34:53', NULL),
(69, 17, 'Material Bulk Delete', 'material-bulk-delete', '2021-07-13 10:34:53', NULL),
(70, 17, 'Material Report', 'material-report', '2021-07-13 10:34:53', NULL),
(71, 18, 'Material Stock Report Access', 'material-stock-report-access', '2021-07-13 10:35:17', NULL),
(73, 22, 'Purchase Access', 'purchase-access', '2021-07-13 10:37:12', NULL),
(74, 22, 'Purchase Add', 'purchase-add', '2021-07-13 10:37:12', NULL),
(75, 22, 'Purchase Edit', 'purchase-edit', '2021-07-13 10:37:12', NULL),
(76, 22, 'Purchase View', 'purchase-view', '2021-07-13 10:37:12', NULL),
(77, 22, 'Purchase Delete', 'purchase-delete', '2021-07-13 10:37:12', NULL),
(78, 22, 'Purchase Bulk Delete', 'purchase-bulk-delete', '2021-07-13 10:37:12', NULL),
(79, 22, 'Purchase Report', 'purchase-report', '2021-07-13 10:37:12', NULL),
(80, 24, 'Product Category Access', 'product-category-access', '2021-07-13 10:38:23', NULL),
(81, 24, 'Product Category Add', 'product-category-add', '2021-07-13 10:38:23', NULL),
(82, 24, 'Product Category Edit', 'product-category-edit', '2021-07-13 10:38:23', NULL),
(83, 24, 'Product Category Delete', 'product-category-delete', '2021-07-13 10:38:23', NULL),
(84, 24, 'Product Category Bulk Delete', 'product-category-bulk-delete', '2021-07-13 10:38:23', NULL),
(85, 24, 'Product Category Report', 'product-category-report', '2021-07-13 10:38:23', NULL),
(92, 26, 'Product Access', 'product-access', '2021-07-13 10:42:37', NULL),
(93, 26, 'Product Add', 'product-add', '2021-07-13 10:42:37', NULL),
(94, 26, 'Product Edit', 'product-edit', '2021-07-13 10:42:37', NULL),
(95, 26, 'Product View', 'product-view', '2021-07-13 10:42:37', NULL),
(96, 26, 'Product Delete', 'product-delete', '2021-07-13 10:42:37', NULL),
(97, 26, 'Product Bulk Delete', 'product-bulk-delete', '2021-07-13 10:42:37', NULL),
(98, 26, 'Product Report', 'product-report', '2021-07-13 10:42:37', NULL),
(99, 28, 'Print Barcode Access', 'print-barcode-access', '2021-07-13 10:43:04', NULL),
(100, 30, 'Finish Goods Stock Access', 'finish-goods-stock-access', '2021-07-13 10:46:34', '2021-10-13 07:57:17'),
(101, 30, 'Finish Goods Stock Add', 'finish-goods-stock-add', '2021-07-13 10:46:34', '2021-10-13 07:57:25'),
(102, 30, 'Finish Goods Stock Edit', 'finish-goods-stock-edit', '2021-07-13 10:46:34', '2021-10-13 07:57:33'),
(103, 30, 'Finish Goods Stock View', 'finish-goods-stock-view', '2021-07-13 10:46:34', '2021-10-13 07:57:43'),
(104, 30, 'Finish Goods Stock Delete', 'finish-goods-stock-delete', '2021-07-13 10:46:34', '2021-10-13 07:57:51'),
(105, 30, 'Finish Goods Stock Bulk Delete', 'finish-goods-stock-bulk-delete', '2021-07-13 10:46:34', '2021-10-13 07:58:00'),
(106, 30, 'Finish Goods Stock Report', 'finish-goods-stock-report', '2021-07-13 10:46:34', '2021-10-13 07:58:08'),
(107, 31, 'Product Stock Report Access', 'product-stock-report-access', '2021-07-13 10:47:01', NULL),
(140, 48, 'Supplier Access', 'supplier-access', '2021-07-13 11:09:21', NULL),
(141, 48, 'Supplier Add', 'supplier-add', '2021-07-13 11:09:21', NULL),
(142, 48, 'Supplier Edit', 'supplier-edit', '2021-07-13 11:09:21', NULL),
(143, 48, 'Supplier View', 'supplier-view', '2021-07-13 11:09:21', NULL),
(144, 48, 'Supplier Delete', 'supplier-delete', '2021-07-13 11:09:21', NULL),
(145, 48, 'Supplier Bulk Delete', 'supplier-bulk-delete', '2021-07-13 11:09:21', NULL),
(146, 48, 'Supplier Report', 'supplier-report', '2021-07-13 11:09:21', NULL),
(147, 49, 'Supplier Ledger Access', 'supplier-ledger-access', '2021-07-13 11:09:45', NULL),
(148, 50, 'Supplier Advance Access', 'supplier-advance-access', '2021-07-13 11:10:00', NULL),
(152, 52, 'Return Access', 'return-access', '2021-07-13 11:18:24', '2021-09-23 04:38:18'),
(153, 53, 'Purchase Return Access', 'purchase-return-access', '2021-07-13 11:19:27', NULL),
(154, 53, 'Purchase Return Add', 'purchase-return-add', '2021-07-13 11:19:27', NULL),
(155, 53, 'Purchase Return View', 'purchase-return-view', '2021-07-13 11:19:27', NULL),
(156, 53, 'Purchase Return Delete', 'purchase-return-delete', '2021-07-13 11:19:27', NULL),
(160, 75, 'COA Access', 'coa-access', '2021-07-13 16:12:36', '2021-09-13 05:09:58'),
(161, 75, 'COA Add', 'coa-add', '2021-07-13 16:12:36', '2021-09-13 05:09:51'),
(162, 75, 'COA Edit', 'coa-edit', '2021-07-13 16:12:36', '2021-09-13 05:09:43'),
(163, 75, 'COA Delete', 'coa-delete', '2021-07-13 16:12:36', '2021-09-13 05:09:35'),
(164, 76, 'Opening Balance Access', 'opening-balance-access', '2021-07-13 16:13:13', NULL),
(165, 77, 'Supplier Payment Access', 'supplier-payment-access', '2021-07-13 16:13:38', NULL),
(170, 83, 'Contra Voucher Access', 'contra-voucher-access', '2021-07-13 16:20:59', NULL),
(171, 83, 'Contra Voucher Add', 'contra-voucher-add', '2021-07-13 16:20:59', NULL),
(172, 83, 'Contra Voucher View', 'contra-voucher-view', '2021-07-13 16:20:59', NULL),
(173, 83, 'Contra Voucher Delete', 'contra-voucher-delete', '2021-07-13 16:20:59', NULL),
(174, 85, 'Journal Voucher Access', 'journal-voucher-access', '2021-07-13 16:21:48', '2021-09-20 09:40:17'),
(175, 85, 'Journal Voucher Add', 'journal-voucher-add', '2021-07-13 16:21:48', '2021-09-20 09:40:24'),
(176, 85, 'Journal Voucher View', 'journal-voucher-view', '2021-07-13 16:21:48', '2021-09-20 09:40:30'),
(177, 85, 'Journal Voucher Delete', 'journal-voucher-delete', '2021-07-13 16:21:48', '2021-09-20 09:40:36'),
(178, 86, 'Voucher Access', 'voucher-access', '2021-07-13 16:24:05', NULL),
(179, 86, 'Voucher Approve', 'voucher-approve', '2021-07-13 16:24:05', NULL),
(180, 86, 'Voucher Edit', 'voucher-edit', '2021-07-13 16:24:05', NULL),
(181, 86, 'Voucher Delete', 'voucher-delete', '2021-07-13 16:24:05', NULL),
(182, 88, 'Cash Book Access', 'cash-book-access', '2021-07-13 16:31:28', NULL),
(183, 89, 'Inventory Ledger Access', 'inventory-ledger-access', '2021-07-13 16:31:52', NULL),
(184, 90, 'Bank Book Access', 'bank-book-access', '2021-07-13 16:32:26', NULL),
(185, 91, 'Mobile Bank Book Access', 'mobile-bank-book-access', '2021-07-13 16:32:46', NULL),
(186, 92, 'General Ledger Access', 'general-ledger-access', '2021-07-13 17:00:34', NULL),
(187, 93, 'Trial Balance Access', 'trial-balance-access', '2021-07-13 17:00:59', NULL),
(188, 94, 'Profit Loss Access', 'profit-loss-access', '2021-07-13 17:01:20', NULL),
(189, 95, 'Cash Flow Access', 'cash-flow-access', '2021-07-13 17:01:40', NULL),
(190, 71, 'Expense Item Access', 'expense-item-access', '2021-07-13 17:03:02', NULL),
(191, 71, 'Expense Item Add', 'expense-item-add', '2021-07-13 17:03:02', NULL),
(192, 71, 'Expense Item Edit', 'expense-item-edit', '2021-07-13 17:03:02', NULL),
(193, 71, 'Expense Item Delete', 'expense-item-delete', '2021-07-13 17:03:02', NULL),
(194, 71, 'Expense Item Bulk Delete', 'expense-item-bulk-delete', '2021-07-13 17:03:02', NULL),
(195, 71, 'Expense Item Report', 'expense-item-report', '2021-07-13 17:03:02', NULL),
(196, 72, 'Expense Access', 'expense-access', '2021-07-13 17:04:23', NULL),
(197, 72, 'Expense Add', 'expense-add', '2021-07-13 17:04:23', NULL),
(198, 72, 'Expense Edit', 'expense-edit', '2021-07-13 17:04:23', NULL),
(199, 72, 'Expense Delete', 'expense-delete', '2021-07-13 17:04:23', NULL),
(200, 72, 'Expense Bulk Delete', 'expense-bulk-delete', '2021-07-13 17:04:23', NULL),
(201, 72, 'Expense Report', 'expense-report', '2021-07-13 17:04:23', NULL),
(202, 72, 'Expense Approve', 'expense-approve', '2021-07-13 17:04:23', NULL),
(203, 73, 'Expense Statement Access', 'expense-statement-access', '2021-07-13 17:04:44', NULL),
(204, 63, 'Bank Access', 'bank-access', '2021-07-13 17:06:06', NULL),
(205, 63, 'Bank Add', 'bank-add', '2021-07-13 17:06:06', NULL),
(206, 63, 'Bank Edit', 'bank-edit', '2021-07-13 17:06:06', NULL),
(207, 63, 'Bank Delete', 'bank-delete', '2021-07-13 17:06:06', NULL),
(208, 63, 'Bank Report', 'bank-report', '2021-07-13 17:06:06', NULL),
(209, 64, 'Bank Transaction Access', 'bank-transaction-access', '2021-07-13 17:09:48', NULL),
(210, 65, 'Bank Ledger Access', 'bank-ledger-access', '2021-07-13 17:10:05', NULL),
(211, 67, 'Mobile Bank Access', 'mobile-bank-access', '2021-07-13 17:17:15', NULL),
(212, 67, 'Mobile Bank Add', 'mobile-bank-add', '2021-07-13 17:17:15', NULL),
(213, 67, 'Mobile Bank Edit', 'mobile-bank-edit', '2021-07-13 17:17:15', NULL),
(214, 67, 'Mobile Bank Delete', 'mobile-bank-delete', '2021-07-13 17:17:15', NULL),
(215, 67, 'Mobile Bank Bulk Delete', 'mobile-bank-bulk-delete', '2021-07-13 17:17:15', NULL),
(216, 67, 'Mobile Bank Report', 'mobile-bank-report', '2021-07-13 17:17:15', NULL),
(217, 68, 'Mobile Bank Transaction Access', 'mobile-bank-transaction-access', '2021-07-13 17:17:36', NULL),
(218, 69, 'Mobile Bank Ledger Access', 'mobile-bank-ledger-access', '2021-07-13 17:17:56', NULL),
(219, 58, 'District Access', 'district-access', '2021-07-13 17:26:47', NULL),
(220, 58, 'District Add', 'district-add', '2021-07-13 17:26:47', NULL),
(221, 58, 'District Edit', 'district-edit', '2021-07-13 17:26:47', NULL),
(222, 58, 'District Delete', 'district-delete', '2021-07-13 17:26:47', NULL),
(223, 58, 'District Bulk Delete', 'district-bulk-delete', '2021-07-13 17:26:47', NULL),
(224, 58, 'District Report', 'district-report', '2021-07-13 17:26:47', NULL),
(225, 59, 'Upazila Access', 'upazila-access', '2021-07-13 17:30:37', NULL),
(226, 59, 'Upazila Add', 'upazila-add', '2021-07-13 17:30:37', NULL),
(227, 59, 'Upazila Edit', 'upazila-edit', '2021-07-13 17:30:37', NULL),
(228, 59, 'Upazila Delete', 'upazila-delete', '2021-07-13 17:30:37', NULL),
(229, 59, 'Upazila Bulk Delete', 'upazila-bulk-delete', '2021-07-13 17:30:37', NULL),
(230, 59, 'Upazila Report', 'upazila-report', '2021-07-13 17:30:37', NULL),
(237, 61, 'Area Access', 'area-access', '2021-07-13 17:32:53', NULL),
(238, 61, 'Area Add', 'area-add', '2021-07-13 17:32:53', NULL),
(239, 61, 'Area Edit', 'area-edit', '2021-07-13 17:32:53', NULL),
(240, 61, 'Area Delete', 'area-delete', '2021-07-13 17:32:53', NULL),
(241, 61, 'Area Bulk Delete', 'area-bulk-delete', '2021-07-13 17:32:53', NULL),
(242, 61, 'Area Report', 'area-report', '2021-07-13 17:32:53', NULL),
(251, 56, 'Dealer Access', 'dealer-access', '2021-07-13 17:48:06', '2021-10-25 11:15:43'),
(252, 56, 'Dealer Add', 'dealer-add', '2021-07-13 17:48:06', '2021-10-25 11:15:54'),
(253, 56, 'Dealer Edit', 'dealer-edit', '2021-07-13 17:48:06', '2021-10-25 11:16:01'),
(254, 56, 'Dealer View', 'dealer-view', '2021-07-13 17:48:06', '2021-10-25 11:16:07'),
(255, 56, 'Dealer Delete', 'dealer-delete', '2021-07-13 17:48:06', '2021-10-25 11:16:15'),
(256, 56, 'Dealer Bulk Delete', 'dealer-bulk-delete', '2021-07-13 17:48:06', '2021-10-25 11:16:22'),
(258, 98, 'Department Access', 'department-access', '2021-04-03 18:20:33', NULL),
(259, 98, 'Department Add', 'department-add', '2021-04-03 18:20:33', NULL),
(260, 98, 'Department Edit', 'department-edit', '2021-04-03 18:20:33', NULL),
(261, 98, 'Department Delete', 'department-delete', '2021-04-03 18:20:33', NULL),
(262, 98, 'Department Bulk Delete', 'department-bulk-delete', '2021-04-03 18:20:33', NULL),
(263, 98, 'Department Report', 'department-report', '2021-04-03 18:20:33', NULL),
(264, 99, 'Division Access', 'division-access', '2021-04-03 18:21:27', NULL),
(265, 99, 'Division Add', 'division-add', '2021-04-03 18:21:27', NULL),
(266, 99, 'Division Edit', 'division-edit', '2021-04-03 18:21:27', NULL),
(267, 99, 'Division Delete', 'division-delete', '2021-04-03 18:21:27', NULL),
(268, 99, 'Division Bulk Delete', 'division-bulk-delete', '2021-04-03 18:21:27', NULL),
(269, 99, 'Division Report', 'division-report', '2021-04-03 18:21:27', NULL),
(270, 100, 'Designation Access', 'designation-access', '2021-04-03 18:22:20', NULL),
(271, 100, 'Designation Add', 'designation-add', '2021-04-03 18:22:20', NULL),
(272, 100, 'Designation Edit', 'designation-edit', '2021-04-03 18:22:20', NULL),
(273, 100, 'Designation Delete', 'designation-delete', '2021-04-03 18:22:20', NULL),
(274, 100, 'Designation Bulk Delete', 'designation-bulk-delete', '2021-04-03 18:22:20', NULL),
(275, 100, 'Designation Report', 'designation-report', '2021-04-03 18:22:20', NULL),
(276, 103, 'Employee Access', 'employee-access', '2021-04-03 18:23:18', NULL),
(277, 103, 'Employee Add', 'employee-add', '2021-04-03 18:23:18', NULL),
(278, 103, 'Employee Edit', 'employee-edit', '2021-04-03 18:23:18', NULL),
(279, 103, 'Employee View', 'employee-view', '2021-04-03 18:23:18', NULL),
(280, 103, 'Employee Delete', 'employee-delete', '2021-04-03 18:23:18', NULL),
(281, 103, 'Employee Bulk Delete', 'employee-bulk-delete', '2021-04-03 18:23:18', NULL),
(282, 103, 'Employee Report', 'employee-report', '2021-04-03 18:23:18', NULL),
(283, 105, 'Attendance Access', 'attendance-access', '2021-04-03 18:24:19', NULL),
(284, 105, 'Attendance Add', 'attendance-add', '2021-04-03 18:24:19', NULL),
(285, 105, 'Attendance Edit', 'attendance-edit', '2021-04-03 18:24:19', NULL),
(286, 105, 'Attendance Delete', 'attendance-delete', '2021-04-03 18:24:19', NULL),
(287, 105, 'Attendance Bulk Delete', 'attendance-bulk-delete', '2021-04-03 18:24:19', NULL),
(288, 105, 'Attendance Report', 'attendance-report', '2021-04-03 18:24:19', NULL),
(289, 106, 'Attendance Report Access', 'attendance-report-access', '2021-04-03 18:24:43', NULL),
(290, 113, 'Weekly Holiday Access', 'weekly-holiday-access', '2021-04-03 18:26:00', NULL),
(291, 113, 'Weekly Holiday Add', 'weekly-holiday-add', '2021-04-03 18:26:00', NULL),
(292, 113, 'Weekly Holiday Edit', 'weekly-holiday-edit', '2021-04-03 18:26:00', NULL),
(293, 113, 'Weekly Holiday Delete', 'weekly-holiday-delete', '2021-04-03 18:26:00', NULL),
(294, 113, 'Weekly Holiday Bulk Delete', 'weekly-holiday-bulk-delete', '2021-04-03 18:26:00', NULL),
(295, 113, 'Weekly Holiday Report', 'weekly-holiday-report', '2021-04-03 18:26:00', NULL),
(296, 114, 'Holiday Access', 'holiday-access', '2021-04-03 18:26:54', NULL),
(297, 114, 'Holiday Add', 'holiday-add', '2021-04-03 18:26:54', NULL),
(298, 114, 'Holiday Edit', 'holiday-edit', '2021-04-03 18:26:54', NULL),
(299, 114, 'Holiday Delete', 'holiday-delete', '2021-04-03 18:26:54', NULL),
(300, 114, 'Holiday Bulk Delete', 'holiday-bulk-delete', '2021-04-03 18:26:54', NULL),
(301, 114, 'Holiday Report', 'holiday-report', '2021-04-03 18:26:54', NULL),
(302, 115, 'Leave Type Access', 'leave-type-access', '2021-04-03 18:27:42', NULL),
(303, 115, 'Leave Type Add', 'leave-type-add', '2021-04-03 18:27:42', NULL),
(304, 115, 'Leave Type Edit', 'leave-type-edit', '2021-04-03 18:27:42', NULL),
(305, 115, 'Leave Type Delete', 'leave-type-delete', '2021-04-03 18:27:42', NULL),
(306, 115, 'Leave Type Bulk Delete', 'leave-type-bulk-delete', '2021-04-03 18:27:42', NULL),
(307, 115, 'Leave Type Report', 'leave-type-report', '2021-04-03 18:27:42', NULL),
(308, 116, 'Leave Application Access', 'leave-application-access', '2021-04-03 18:29:45', NULL),
(309, 116, 'Leave Application Add', 'leave-application-add', '2021-04-03 18:29:45', NULL),
(310, 116, 'Leave Application Edit', 'leave-application-edit', '2021-04-03 18:29:45', NULL),
(311, 116, 'Leave Application Delete', 'leave-application-delete', '2021-04-03 18:29:45', NULL),
(312, 116, 'Leave Application Bulk Delete', 'leave-application-bulk-delete', '2021-04-03 18:29:45', NULL),
(313, 116, 'Leave Application Report', 'leave-application-report', '2021-04-03 18:29:45', NULL),
(314, 116, 'Leave Application Approve', 'leave-application-approve', '2021-04-03 18:29:45', NULL),
(315, 108, 'Benifits Access', 'benifits-access', '2021-04-03 18:30:33', NULL),
(316, 108, 'Benifits Add', 'benifits-add', '2021-04-03 18:30:33', NULL),
(317, 108, 'Benifits Edit', 'benifits-edit', '2021-04-03 18:30:33', NULL),
(318, 108, 'Benifits Delete', 'benifits-delete', '2021-04-03 18:30:33', NULL),
(319, 108, 'Benifits Bulk Delete', 'benifits-bulk-delete', '2021-04-03 18:30:33', NULL),
(320, 108, 'Benifits Report', 'benifits-report', '2021-04-03 18:30:33', NULL),
(321, 110, 'Salary Setup Access', 'salary-setup-access', '2021-04-03 18:31:37', NULL),
(322, 110, 'Salary Setup Add', 'salary-setup-add', '2021-04-03 18:31:37', NULL),
(323, 110, 'Salary Setup Edit', 'salary-setup-edit', '2021-04-03 18:31:37', NULL),
(324, 110, 'Salary Setup View', 'salary-setup-view', '2021-04-03 18:31:37', NULL),
(325, 110, 'Salary Setup Delete', 'salary-setup-delete', '2021-04-03 18:31:37', NULL),
(326, 110, 'Salary Setup Bulk Delete', 'salary-setup-bulk-delete', '2021-04-03 18:31:37', NULL),
(327, 110, 'Salary Setup Report', 'salary-setup-report', '2021-04-03 18:31:37', NULL),
(328, 111, 'Salary Generate Access', 'salary-generate-access', '2021-04-03 18:35:39', NULL),
(329, 111, 'Salary Generate Add', 'salary-generate-add', '2021-04-03 18:35:39', NULL),
(330, 111, 'Salary Generate Delete', 'salary-generate-delete', '2021-04-03 18:35:39', NULL),
(331, 111, 'Salary Generate Bulk Delete', 'salary-generate-bulk-delete', '2021-04-03 18:35:39', NULL),
(332, 111, 'Salary Generate Report', 'salary-generate-report', '2021-04-03 18:35:39', NULL),
(333, 101, 'Shift Access', 'shift-access', '2021-04-26 01:14:07', NULL),
(334, 101, 'Shift Add', 'shift-add', '2021-04-26 01:14:07', NULL),
(335, 101, 'Shift Edit', 'shift-edit', '2021-04-26 01:14:07', NULL),
(336, 101, 'Shift Delete', 'shift-delete', '2021-04-26 01:14:07', NULL),
(337, 101, 'Shift Bulk Delete', 'shift-bulk-delete', '2021-04-26 01:14:07', NULL),
(338, 101, 'Shift Report', 'shift-report', '2021-04-26 01:14:07', NULL),
(339, 101, 'Shift Manage Access', 'shift-manage-access', '2021-04-26 01:14:07', NULL),
(340, 101, 'Shift Manage Add', 'shift-manage-add', '2021-04-26 01:14:07', NULL),
(341, 101, 'Shift Manage Edit', 'shift-manage-edit', '2021-04-26 01:14:07', NULL),
(342, 101, 'Shift Manage Delete', 'shift-manage-delete', '2021-04-26 01:14:07', NULL),
(343, 101, 'Shift Manage Bulk Delete', 'shift-manage-bulk-delete', '2021-04-26 01:14:07', NULL),
(344, 101, 'Shift Manage Report', 'shift-manage-report', '2021-04-26 01:14:07', NULL),
(345, 101, 'Employee Shift Change', 'employee-shift-change', '2021-04-26 17:24:58', NULL),
(356, 50, 'Supplier Advance Add', 'supplier-advance-add', '2021-08-11 08:05:49', NULL),
(357, 50, 'Supplier Advance Edit', 'supplier-advance-edit', '2021-08-11 08:05:49', NULL),
(358, 50, 'Supplier Advance Delete', 'supplier-advance-delete', '2021-08-11 08:05:49', NULL),
(359, 50, 'Supplier Advance Bulk Delete', 'supplier-advance-bulk-delete', '2021-08-11 08:05:49', NULL),
(452, 180, 'Closing Access', 'closing-access', '2021-09-06 04:21:08', NULL),
(453, 181, 'Closing Report Access', 'closing-report-access', '2021-09-06 04:21:26', NULL),
(454, 182, 'Today Sales Report Access', 'today-sales-report-access', '2021-09-06 04:25:48', NULL),
(455, 183, 'Sales Report Access', 'sales-report-access', '2021-09-06 04:26:08', NULL),
(462, 190, 'Product Wise Sales Report Access', 'product-wise-sales-report-access', '2021-09-06 04:29:23', NULL),
(466, 194, 'Warehouse Summary Access', 'warehouse-summary-access', '2021-09-06 04:31:26', NULL),
(468, 196, 'Material Stock Alert Report Access', 'material-stock-alert-report-access', '2021-09-06 04:32:12', '2021-09-06 18:30:08'),
(475, 203, 'Debit Voucher Access', 'debit-voucher-access', '2021-09-07 09:57:25', '2021-09-20 09:23:24'),
(476, 204, 'Credit Voucher Access', 'credit-voucher-access', '2021-09-07 09:59:32', '2021-09-20 09:28:19'),
(509, 222, 'Cash Adjustment Access', 'cash-adjustment-access', '2021-09-12 10:44:26', NULL),
(510, 222, 'Cash Adjustment Add', 'cash-adjustment-add', '2021-09-12 10:44:26', NULL),
(511, 222, 'Cash Adjustment Edit', 'cash-adjustment-edit', '2021-09-12 10:44:26', NULL),
(512, 222, 'Cash Adjustment Delete', 'cash-adjustment-delete', '2021-09-12 10:44:26', NULL),
(513, 222, 'Cash Adjustment Approve', 'cash-adjustment-approve', '2021-09-12 10:44:26', NULL),
(514, 225, 'Personal Loan Person Access', 'personal-loan-person-access', '2021-09-13 04:57:47', NULL),
(515, 225, 'Personal Loan Person Add', 'personal-loan-person-add', '2021-09-13 04:57:47', NULL),
(516, 225, 'Personal Loan Person Edit', 'personal-loan-person-edit', '2021-09-13 04:57:47', NULL),
(517, 225, 'Personal Loan Person Delete', 'personal-loan-person-delete', '2021-09-13 04:57:47', NULL),
(518, 225, 'Personal Loan Person Bulk Delete', 'personal-loan-person-bulk-delete', '2021-09-13 04:57:47', NULL),
(519, 226, 'Personal Loan Access', 'personal-loan-access', '2021-09-13 04:58:30', NULL),
(520, 226, 'Personal Loan Add', 'personal-loan-add', '2021-09-13 04:58:30', NULL),
(521, 226, 'Personal Loan Edit', 'personal-loan-edit', '2021-09-13 04:58:30', NULL),
(522, 226, 'Personal Loan Delete', 'personal-loan-delete', '2021-09-13 04:58:30', NULL),
(523, 226, 'Personal Loan Bulk Delete', 'personal-loan-bulk-delete', '2021-09-13 04:58:30', NULL),
(524, 227, 'Personal Loan Installment Access', 'personal-loan-installment-access', '2021-09-13 04:59:11', NULL),
(525, 227, 'Personal Loan Installment Add', 'personal-loan-installment-add', '2021-09-13 04:59:11', NULL),
(526, 227, 'Personal Loan Installment Edit', 'personal-loan-installment-edit', '2021-09-13 04:59:11', NULL),
(527, 227, 'Personal Loan Installment Delete', 'personal-loan-installment-delete', '2021-09-13 04:59:11', NULL),
(528, 227, 'Personal Loan Installment Bulk Delete', 'personal-loan-installment-bulk-delete', '2021-09-13 04:59:11', NULL),
(529, 229, 'Official Loan Access', 'official-loan-access', '2021-09-13 05:00:02', NULL),
(530, 229, 'Official Loan Add', 'official-loan-add', '2021-09-13 05:00:02', NULL),
(531, 229, 'Official Loan Edit', 'official-loan-edit', '2021-09-13 05:00:02', NULL),
(532, 229, 'Official Loan Delete', 'official-loan-delete', '2021-09-13 05:00:02', NULL),
(533, 229, 'Official Loan Bulk Delete', 'official-loan-bulk-delete', '2021-09-13 05:00:02', NULL),
(534, 230, 'Official Loan Installment Access', 'official-loan-installment-access', '2021-09-13 05:00:43', NULL),
(535, 230, 'Official Loan Installment Add', 'official-loan-installment-add', '2021-09-13 05:00:43', NULL),
(536, 230, 'Official Loan Installment Edit', 'official-loan-installment-edit', '2021-09-13 05:00:43', NULL),
(537, 230, 'Official Loan Installment Delete', 'official-loan-installment-delete', '2021-09-13 05:00:43', NULL),
(538, 230, 'Official Loan Installment Bulk Delete', 'official-loan-installment-bulk-delete', '2021-09-13 05:00:43', NULL),
(539, 232, 'Loan Report Access', 'loan-report-access', '2021-09-13 05:01:11', NULL),
(540, 233, 'Balance Sheet Access', 'balance-sheet-access', '2021-09-13 05:22:33', NULL),
(541, 111, 'Salary Payment Access', 'salary-payment-access', '2021-09-13 08:29:23', NULL),
(544, 203, 'Debit Voucher Add', 'debit-voucher-add', '2021-09-20 09:24:08', NULL),
(545, 204, 'Credit Voucher Add', 'credit-voucher-add', '2021-09-20 09:28:51', NULL),
(547, 236, 'Sale Access', 'sale-access', '2021-09-22 09:21:37', NULL),
(548, 236, 'Sale Add', 'sale-add', '2021-09-22 09:21:37', NULL),
(549, 236, 'Sale Edit', 'sale-edit', '2021-09-22 09:21:37', NULL),
(550, 236, 'Sale View', 'sale-view', '2021-09-22 09:21:37', NULL),
(551, 236, 'Sale Delete', 'sale-delete', '2021-09-22 09:21:37', NULL),
(552, 236, 'Sale Bulk Delete', 'sale-bulk-delete', '2021-09-22 09:21:37', NULL),
(553, 237, 'Sale Return Access', 'sale-return-access', '2021-09-23 04:39:13', NULL),
(554, 237, 'Sale Return Add', 'sale-return-add', '2021-09-23 04:39:13', NULL),
(555, 237, 'Sale Return View', 'sale-return-view', '2021-09-23 04:39:13', NULL),
(556, 237, 'Sale Return Delete', 'sale-return-delete', '2021-09-23 04:39:13', NULL),
(558, 238, 'Product Stock Alert Report Access', 'product-stock-alert-report-access', '2021-09-23 10:12:15', NULL),
(559, 240, 'Invoice Report Access', 'invoice-report-access', '2021-10-03 05:44:41', NULL),
(560, 241, 'Salesmen Payment Access', 'salesmen-payment-access', '2021-10-03 09:57:18', NULL),
(561, 242, 'Dealer Ledger Access', 'dealer-ledger-access', '2021-10-03 11:40:46', '2021-10-25 11:16:39'),
(562, 245, 'Damage Access', 'damage-access', '2021-10-05 09:14:28', NULL),
(568, 203, 'Debit Voucher View', 'debit-voucher-view', '2021-10-13 11:18:33', NULL),
(569, 203, 'Debit Voucher Delete', 'debit-voucher-delete', '2021-10-13 11:18:33', NULL),
(570, 204, 'Credit Voucher View', 'credit-voucher-view', '2021-10-13 11:19:06', NULL),
(571, 204, 'Credit Voucher Delete', 'credit-voucher-delete', '2021-10-13 11:19:06', NULL),
(572, 252, 'Material Stock Out Access', 'material-stock-out-access', '2021-10-19 09:44:37', NULL),
(573, 252, 'Material Stock Out Add', 'material-stock-out-add', '2021-10-19 09:44:37', NULL),
(574, 252, 'Material Stock Out Edit', 'material-stock-out-edit', '2021-10-19 09:44:37', NULL),
(575, 252, 'Material Stock Out View', 'material-stock-out-view', '2021-10-19 09:44:37', NULL),
(576, 252, 'Material Stock Out Delete', 'material-stock-out-delete', '2021-10-19 09:44:37', NULL),
(577, 252, 'Material Stock Out Bulk Delete', 'material-stock-out-bulk-delete', '2021-10-19 09:44:37', NULL),
(578, 253, 'Material Stock Out Report Access', 'material-stock-out-report-access', '2021-10-19 09:44:54', NULL),
(586, 22, 'Purchase Payment Add', 'purchase-payment-add', '2021-10-21 05:14:34', NULL),
(587, 22, 'Purchase Payment Edit', 'purchase-payment-edit', '2021-10-21 05:14:34', NULL),
(588, 22, 'Purchase Payment View', 'purchase-payment-view', '2021-10-21 05:14:34', NULL),
(589, 22, 'Purchase Payment Delete', 'purchase-payment-delete', '2021-10-21 05:14:34', NULL),
(590, 258, 'Depo Access', 'depo-access', '2021-10-25 11:17:35', NULL),
(591, 258, 'Depo Add', 'depo-add', '2021-10-25 11:17:35', NULL),
(592, 258, 'Depo Edit', 'depo-edit', '2021-10-25 11:17:35', NULL),
(593, 258, 'Depo Delete', 'depo-delete', '2021-10-25 11:17:35', NULL),
(594, 258, 'Depo Bulk Delete', 'depo-bulk-delete', '2021-10-25 11:17:35', NULL),
(595, 259, 'Depo Ledger Access', 'depo-ledger-access', '2021-10-25 11:17:56', NULL),
(602, 258, 'Depo View', 'depo-view', '2021-10-28 08:15:01', NULL),
(603, 260, 'Depo Receive Access', 'depo-receive-access', '2021-10-30 12:11:12', NULL),
(604, 241, 'Dealer Receive Access', 'dealer-receive-access', '2021-10-30 12:11:31', NULL),
(605, 263, 'Todays-production-order-sheet-access', 'todays-production-order-sheet-access', '2021-10-31 04:39:15', NULL),
(606, 264, 'Production Order Sheet Access', 'production-order-sheet-access', '2021-10-31 04:41:09', NULL),
(607, 264, 'Production Order Sheet View', 'production-order-sheet-view', '2021-10-31 04:41:09', NULL),
(608, 264, 'Production Order Sheet Delete', 'production-order-sheet-delete', '2021-10-31 04:41:09', NULL),
(609, 265, 'Depo Advance Access', 'depo-advance-access', '2021-11-14 19:21:32', NULL),
(610, 265, 'Depo Advance Add', 'depo-advance-add', '2021-11-14 19:21:32', NULL),
(611, 265, 'Depo Advance Edit', 'depo-advance-edit', '2021-11-14 19:21:32', NULL),
(612, 265, 'Depo Advance Delete', 'depo-advance-delete', '2021-11-14 19:21:32', NULL),
(613, 265, 'Depo Advance Bulk Delete', 'depo-advance-bulk-delete', '2021-11-14 19:21:32', NULL),
(614, 266, 'Dealer Advance Access', 'dealer-advance-access', '2021-11-14 19:22:33', NULL),
(615, 266, 'Dealer Advance Add', 'dealer-advance-add', '2021-11-14 19:22:33', NULL),
(616, 266, 'Dealer Advance Edit', 'dealer-advance-edit', '2021-11-14 19:22:33', NULL),
(617, 266, 'Dealer Advance Delete', 'dealer-advance-delete', '2021-11-14 19:22:33', NULL),
(618, 266, 'Dealer Advance Bulk Delete', 'dealer-advance-bulk-delete', '2021-11-14 19:22:33', NULL),
(619, 270, 'Depo Wise Sales Report Access', 'depo-wise-sales-report-access', '2021-11-15 11:44:56', NULL),
(620, 271, 'Dealer Wise Sales Report Access', 'dealer-wise-sales-report-access', '2021-11-15 11:45:13', NULL),
(621, 272, 'Depo Wise Product Sales Report Access', 'depo-wise-product-sales-report-access', '2021-11-15 14:18:03', NULL),
(622, 273, 'Dealer Wise Product Sales Report Access', 'dealer-wise-product-sales-report-access', '2021-11-15 14:18:18', NULL),
(623, 274, 'Product Sales Report Access', 'product-sales-report-access', '2021-11-16 10:32:04', NULL),
(624, 246, 'Damage Product Access', 'damage-product-access', '2021-11-17 06:22:31', NULL),
(625, 246, 'Damage Product Add', 'damage-product-add', '2021-11-17 06:22:31', NULL),
(626, 246, 'Damage Product View', 'damage-product-view', '2021-11-17 06:22:31', NULL),
(627, 246, 'Damage Product Delete', 'damage-product-delete', '2021-11-17 06:22:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2021-08-13 13:57:37', '2021-08-13 13:57:37'),
(36, 100, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(37, 101, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(38, 102, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(39, 103, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(40, 104, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(41, 105, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(42, 106, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(54, 140, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(55, 141, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(56, 142, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(57, 143, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(58, 144, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(59, 145, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(60, 146, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(61, 147, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(62, 148, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(63, 356, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(64, 357, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(65, 358, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(66, 359, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(92, 2, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(93, 3, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(94, 4, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(95, 5, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(96, 6, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(97, 7, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(98, 8, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(99, 9, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(100, 10, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(101, 11, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(102, 12, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(103, 13, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(104, 14, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(105, 15, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(114, 251, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(115, 252, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(116, 253, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(117, 254, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(118, 255, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(119, 256, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(121, 39, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(122, 33, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(123, 34, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(124, 35, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(125, 36, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(126, 37, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(127, 38, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(128, 40, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(129, 41, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(130, 42, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(131, 43, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(132, 44, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(134, 46, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(135, 47, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(136, 48, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(137, 49, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(138, 50, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(139, 51, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(140, 52, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(141, 53, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(142, 54, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(143, 55, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(144, 56, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(145, 57, 2, '2021-08-13 13:57:38', '2021-08-13 13:57:38'),
(146, 73, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(147, 74, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(148, 75, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(149, 76, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(150, 77, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(151, 78, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(152, 79, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(166, 152, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(167, 153, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(168, 154, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(169, 155, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(170, 156, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(174, 160, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(175, 161, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(176, 162, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(177, 163, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(178, 164, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(179, 165, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(181, 509, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(182, 510, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(183, 511, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(184, 512, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(185, 513, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(187, 475, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(189, 476, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(190, 170, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(191, 171, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(192, 172, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(193, 173, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(194, 174, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(195, 175, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(196, 176, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(197, 177, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(198, 178, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(199, 179, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(200, 180, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(201, 181, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(202, 182, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(203, 183, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(204, 184, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(205, 185, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(206, 186, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(207, 187, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(208, 188, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(209, 189, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(210, 540, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(211, 514, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(212, 515, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(213, 516, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(214, 517, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(215, 518, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(216, 519, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(217, 520, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(218, 521, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(219, 522, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(220, 523, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(221, 524, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(222, 525, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(223, 526, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(224, 527, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(225, 528, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(226, 529, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(227, 530, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(228, 531, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(229, 532, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(230, 533, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(231, 534, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(232, 535, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(233, 536, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(234, 537, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(235, 538, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(236, 539, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(237, 258, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(238, 259, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(239, 260, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(240, 261, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(241, 262, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(242, 263, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(243, 264, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(244, 265, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(245, 266, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(246, 267, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(247, 268, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(248, 269, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(249, 270, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(250, 271, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(251, 272, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(252, 273, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(253, 274, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(254, 275, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(255, 333, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(256, 334, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(257, 335, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(258, 336, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(259, 337, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(260, 338, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(261, 339, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(262, 340, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(263, 341, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(264, 342, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(265, 343, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(266, 344, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(267, 345, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(268, 276, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(269, 277, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(270, 278, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(271, 279, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(272, 280, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(273, 281, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(274, 282, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(275, 283, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(276, 284, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(277, 285, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(278, 286, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(279, 287, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(280, 288, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(281, 289, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(282, 290, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(283, 291, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(284, 292, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(285, 293, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(286, 294, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(287, 295, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(288, 296, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(289, 297, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(290, 298, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(291, 299, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(292, 300, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(293, 301, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(294, 302, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(295, 303, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(296, 304, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(297, 305, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(298, 306, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(299, 307, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(300, 308, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(301, 309, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(302, 310, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(303, 311, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(304, 312, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(305, 313, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(306, 314, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(307, 315, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(308, 316, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(309, 317, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(310, 318, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(311, 319, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(312, 320, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(313, 321, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(314, 322, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(315, 323, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(316, 324, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(317, 325, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(318, 326, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(319, 327, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(320, 328, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(321, 329, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(322, 330, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(323, 331, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(324, 332, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(325, 541, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(326, 190, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(327, 191, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(328, 192, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(329, 193, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(330, 194, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(331, 195, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(332, 196, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(333, 197, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(334, 198, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(335, 199, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(336, 200, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(337, 201, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(338, 202, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(339, 203, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(340, 204, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(341, 205, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(342, 206, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(343, 207, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(344, 208, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(345, 209, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(346, 210, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(347, 211, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(348, 212, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(349, 213, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(350, 214, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(351, 215, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(352, 216, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(353, 217, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(354, 218, 2, '2021-09-13 19:18:44', '2021-09-13 19:18:44'),
(379, 544, 2, '2021-09-20 09:42:13', '2021-09-20 09:42:13'),
(380, 545, 2, '2021-09-20 09:42:13', '2021-09-20 09:42:13'),
(381, 547, 2, '2021-09-23 06:57:20', '2021-09-23 06:57:20'),
(382, 548, 2, '2021-09-23 06:57:20', '2021-09-23 06:57:20'),
(383, 549, 2, '2021-09-23 06:57:20', '2021-09-23 06:57:20'),
(384, 550, 2, '2021-09-23 06:57:20', '2021-09-23 06:57:20'),
(385, 551, 2, '2021-09-23 06:57:20', '2021-09-23 06:57:20'),
(386, 552, 2, '2021-09-23 06:57:20', '2021-09-23 06:57:20'),
(387, 553, 2, '2021-09-23 06:57:41', '2021-09-23 06:57:41'),
(388, 554, 2, '2021-09-23 06:57:41', '2021-09-23 06:57:41'),
(389, 555, 2, '2021-09-23 06:57:41', '2021-09-23 06:57:41'),
(390, 556, 2, '2021-09-23 06:57:41', '2021-09-23 06:57:41'),
(396, 562, 2, '2021-10-13 10:19:18', '2021-10-13 10:19:18'),
(399, 560, 2, '2021-10-13 10:19:18', '2021-10-13 10:19:18'),
(402, 561, 2, '2021-10-13 10:19:18', '2021-10-13 10:19:18'),
(403, 568, 2, '2021-10-13 05:29:34', '2021-10-13 05:29:34'),
(404, 569, 2, '2021-10-13 05:29:34', '2021-10-13 05:29:34'),
(405, 570, 2, '2021-10-13 05:29:34', '2021-10-13 05:29:34'),
(406, 571, 2, '2021-10-13 05:29:34', '2021-10-13 05:29:34'),
(407, 572, 2, '2021-10-21 10:02:30', '2021-10-21 10:02:30'),
(408, 573, 2, '2021-10-21 10:02:30', '2021-10-21 10:02:30'),
(409, 574, 2, '2021-10-21 10:02:30', '2021-10-21 10:02:30'),
(410, 575, 2, '2021-10-21 10:02:30', '2021-10-21 10:02:30'),
(411, 576, 2, '2021-10-21 10:02:30', '2021-10-21 10:02:30'),
(412, 577, 2, '2021-10-21 10:02:30', '2021-10-21 10:02:30'),
(413, 578, 2, '2021-10-21 10:02:30', '2021-10-21 10:02:30'),
(421, 1, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(422, 58, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(423, 59, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(424, 60, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(425, 61, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(426, 62, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(427, 63, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(428, 64, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(429, 65, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(430, 66, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(431, 67, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(432, 68, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(433, 69, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(434, 70, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(435, 71, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(436, 564, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(437, 565, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(438, 572, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(439, 573, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(440, 574, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(441, 575, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(442, 576, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(443, 577, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(444, 578, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(445, 73, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(446, 74, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(447, 75, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(448, 76, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(449, 77, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(450, 78, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(451, 79, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(452, 80, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(453, 81, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(454, 82, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(455, 83, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(456, 84, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(457, 85, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(458, 92, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(459, 93, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(460, 94, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(461, 95, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(462, 96, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(463, 97, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(464, 98, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(465, 99, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(466, 100, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(467, 101, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(468, 102, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(469, 103, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(470, 104, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(471, 105, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(472, 106, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(473, 107, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(474, 566, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(475, 567, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(476, 547, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(477, 548, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(478, 549, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(479, 550, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(480, 551, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(481, 552, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(482, 559, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(496, 140, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(497, 141, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(498, 142, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(499, 143, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(500, 144, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(501, 145, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(502, 146, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(503, 147, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(504, 148, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(505, 356, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(506, 357, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(507, 358, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(508, 359, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(509, 360, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(517, 251, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(518, 252, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(519, 253, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(520, 254, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(521, 255, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(522, 256, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(524, 561, 3, '2021-10-21 10:13:39', '2021-10-21 10:13:39'),
(527, 605, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(528, 606, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(529, 607, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(530, 608, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(531, 603, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(532, 219, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(533, 220, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(534, 221, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(535, 222, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(536, 223, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(537, 224, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(538, 225, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(539, 226, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(540, 227, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(541, 228, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(542, 229, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(543, 230, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(544, 237, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(545, 238, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(546, 239, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(547, 240, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(548, 241, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(549, 242, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(550, 590, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(551, 591, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(552, 592, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(553, 593, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(554, 594, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(555, 602, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23'),
(556, 595, 2, '2021-11-03 18:08:23', '2021-11-03 18:08:23');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `barcode_symbology` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cost` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Base Unit wise cost',
  `base_unit_qty` double DEFAULT NULL,
  `alert_quantity` double DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tax_method` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Exclusive, 2=Inclusive',
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `description` text COLLATE utf8mb4_unicode_ci,
  `has_opening_stock` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=Yes,2=No',
  `opening_stock_qty` float DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `code`, `category_id`, `barcode_symbology`, `base_unit_id`, `unit_id`, `cost`, `base_unit_qty`, `alert_quantity`, `image`, `tax_id`, `tax_method`, `status`, `description`, `has_opening_stock`, `opening_stock_qty`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'হানি বান (৫৫ গ্রাম)', '26214950', 13, 'C128', 1, 21, NULL, 64, 10, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 10:37:02', '2021-11-16 12:29:41'),
(2, 'জোড়া বান (১০০ গ্রাম)', '28615960', 13, 'C128', 1, 20, NULL, 25, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 10:38:43', '2021-11-14 19:05:20'),
(3, 'বাটার বান (৮৫গ্রাম)', '06923375', 13, 'C128', 1, 24, NULL, 145, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 10:39:57', '2021-11-14 19:05:20'),
(4, 'মিনি ব্রেড (১০০ গ্রাম)', '03281719', 13, 'C128', 1, 25, NULL, 35, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 10:42:31', '2021-11-14 19:05:20'),
(5, 'মোরব্বা বান (৮০গ্রাম)', '41836520', 9, 'C128', 1, 19, NULL, 4, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 10:43:31', '2021-11-14 19:05:20'),
(6, 'ক্লাসিক ব্রেড (২০০গ্রাম)', '04335356', 13, 'C128', 1, 17, NULL, 28, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 10:44:39', '2021-11-14 19:05:20'),
(7, 'স্ট্যান্ডার্ড ব্রেড (৩০০গ্রাম)', '26245093', 13, 'C128', 1, 17, NULL, 52, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 10:46:40', '2021-11-14 19:05:20'),
(8, 'প্রিমিয়াম ব্রেড (৬৫০গ্রাম)', '78691053', 13, 'C128', 1, 17, NULL, 52, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 10:48:44', '2021-11-16 12:29:41'),
(9, 'মিল্কি ব্রেড (৩০০গ্রাম)', '64054121', 13, 'C128', 1, 17, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 10:51:03', '2021-10-27 08:08:47'),
(10, 'ডিনার বান (২০০গ্রাম)', '98334718', 13, 'C128', 1, 13, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 10:52:34', '2021-10-27 08:09:14'),
(11, 'স্পাইরাল বান (৯০গ্রাম)', '22098313', 13, 'C128', 1, 24, NULL, 50, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 10:53:42', '2021-11-16 12:29:41'),
(12, 'ক্রিম রোল (২০০গ্রাম)', '37122439', 9, 'C128', 1, 13, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 10:55:27', '2021-10-27 08:10:23'),
(13, 'সফট কেক (৪৫গ্রাম)', '40622849', 11, 'C128', 1, 22, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 10:56:47', '2021-10-27 08:10:50'),
(14, 'কাপ কেক (মিল্কি) (১৪ গ্রাম)', '40580181', 11, 'C128', 1, 26, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 10:58:22', '2021-10-27 08:11:37'),
(15, 'ফ্রুট স্লাইস কেক (ছড়া) (৪৫ গ্রাম)', '44950817', 11, 'C128', 1, 23, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:08:14', '2021-10-27 08:13:11'),
(16, 'ফ্যামিলি কেক (৮৫ গ্রাম)', '57948500', 11, 'C128', 1, 18, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:09:22', '2021-10-27 08:15:11'),
(17, 'ফ্রুট ফ্যামিলি কেক (৯০গ্রাম)', '01781740', 11, 'C128', 1, 18, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:10:26', '2021-10-27 08:23:12'),
(18, 'স্লাইস কেক (ছড়া) (৫৫গ্রাম)', '30239282', 11, 'C128', 1, 23, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:12:21', '2021-10-27 08:23:57'),
(19, 'টিফিন কেক (৬০গ্রাম)', '90537450', 11, 'C128', 1, 12, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:13:30', '2021-10-27 08:24:17'),
(20, 'ফ্রুট কেক (মিনি) (৮০ গ্রাম)', '42925318', 11, 'C128', 1, 18, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:14:40', '2021-10-27 08:24:55'),
(21, 'ট্রে কেক (২০০গ্রাম)', '06097281', 11, 'C128', 1, 13, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:15:42', '2021-10-27 08:30:17'),
(22, '১ পাউন্ড কেক (৪০০গ্রাম)', '37103957', 11, 'C128', 1, 13, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:16:54', '2021-10-27 08:30:47'),
(23, 'মিনি ট্রে কেক (১৫০গ্রাম)', '02317954', 11, 'C128', 1, 16, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:17:45', '2021-10-27 08:32:07'),
(24, 'প্লেন কেক (৪০০গ্রাম)', '93118453', 11, 'C128', 1, 12, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:18:31', '2021-10-27 08:32:30'),
(25, 'ফ্রুট কেক(৪০০গ্রাম)', '52237698', 11, 'C128', 1, 12, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:19:42', '2021-10-27 08:32:52'),
(26, 'ফ্রুট কেক স্পেশাল (২৫০গ্রাম)', '57991280', 11, 'C128', 1, 12, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:20:43', '2021-10-27 08:33:13'),
(27, 'সুইচ চীজ কেক (২০০গ্রাম)', '89675193', 11, 'C128', 1, 14, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:21:51', '2021-10-27 08:34:01'),
(28, '১/২ পাউন্ড কেক (২০০গ্রাম)', '05277043', 11, 'C128', 1, 15, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:23:08', '2021-10-27 08:34:39'),
(29, 'বক্স কেক (১২০গ্রাম)', '89479325', 11, 'C128', 1, 13, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:25:00', '2021-10-27 08:34:58'),
(30, 'ড্রাই কেক (নরমাল)৪ (৩৮০গ্রাম)', '29567638', 11, 'C128', 1, 13, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:26:31', '2021-10-27 08:35:30'),
(31, 'ফিংগার টোস্ট (৪০০গ্রাম)', '03152473', 12, 'C128', 1, 13, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:28:41', '2021-10-27 08:35:51'),
(32, 'তিন কোনা টোস্ট (৪০০গ্রাম)', '97225564', 12, 'C128', 1, 13, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:30:08', '2021-10-27 08:36:11'),
(33, 'কলা টোস্ট (৩৫০গ্রাম)', '92446990', 12, 'C128', 1, 13, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:31:45', '2021-10-27 08:36:29'),
(34, 'নলি টোস্ট (৪০০গ্রাম)', '95199738', 12, 'C128', 1, 13, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:33:03', '2021-10-27 08:36:48'),
(35, 'ড্রাই টোস্ট (৪০০গ্রাম)', '75405223', 12, 'C128', 1, 13, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:34:00', '2021-10-27 08:37:05'),
(36, 'বম্বে টোস্ট (৪০০গ্রাম)', '04578034', 12, 'C128', 1, 13, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:38:12', '2021-10-27 08:37:28'),
(37, 'সুইট টোস্ট (৪০০গ্রাম)', '49283699', 12, 'C128', 1, 13, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:39:54', '2021-10-27 08:37:47'),
(38, 'হট টোস্ট (৪০০গ্রাম)', '60322380', 12, 'C128', 1, 13, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:41:56', '2021-10-27 08:38:06'),
(39, 'চান টোস্ট (৪০০গ্রাম)', '32030041', 12, 'C128', 1, 13, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:43:22', '2021-10-27 08:38:27'),
(40, 'ড্রাই কেক (স্পেশাল) (৫০০গ্রাম)', '03250392', 12, 'C128', 1, 13, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:44:51', '2021-10-27 08:39:06'),
(41, 'ড্রাই কেক (মেগা জার) (৭০০ গ্রাম)', '77104938', 12, 'C128', 1, 13, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:47:03', '2021-10-27 08:39:40'),
(42, 'ড্রাই কেক (নরমাল)৫ (৪৮০ গ্রাম)', '52033947', 12, 'C128', 1, 13, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:49:51', '2021-10-27 08:40:23'),
(43, 'হাফ কেক (ড্রাই কেক) (৪০০ গ্রাম)', '10442899', 12, 'C128', 1, 14, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:51:51', '2021-10-27 08:41:08'),
(44, 'টিউব জার (মিক্স) (৮০০ গ্রাম)', '97493063', 12, 'C128', 1, 12, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:53:01', '2021-10-27 08:41:43'),
(45, 'প্যাকেট বিস্কুট (মিক্স) (৩৮০ গ্রাম)', '55046246', 12, 'C128', 1, 13, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:54:17', '2021-10-27 08:42:18'),
(46, 'প্যাকেট বিস্কুট (বড় ফুল) (৩৮০ গ্রাম)', '08561306', 12, 'C128', 1, 13, NULL, NULL, NULL, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:55:24', '2021-10-27 08:42:41'),
(47, 'প্যাকেট বিস্কুট (সল্ট) (৩৮০ গ্রাম)', '35792184', 12, 'C128', 1, 13, NULL, NULL, 20, NULL, NULL, '2', '1', NULL, '2', NULL, 'Admin', 'Super Admin', '2021-10-21 11:56:13', '2021-10-27 08:44:04'),
(48, 'Test Product', '32259001', 12, 'C128', 1, 14, NULL, 50, NULL, NULL, NULL, '2', '1', NULL, '1', 50, 'Super Admin', 'Super Admin', '2021-11-18 11:08:32', '2021-11-18 11:10:24');

-- --------------------------------------------------------

--
-- Table structure for table `product_material`
--

CREATE TABLE `product_material` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_prices`
--

CREATE TABLE `product_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `dealer_group_id` bigint(20) UNSIGNED NOT NULL,
  `base_unit_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Base Unit wise Price',
  `unit_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Base Unit wise Price',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_prices`
--

INSERT INTO `product_prices` (`id`, `product_id`, `dealer_group_id`, `base_unit_price`, `unit_price`, `created_at`, `updated_at`) VALUES
(4, 47, 1, '40', '400.00', '2021-11-07 16:19:12', '2021-11-07 16:19:12'),
(5, 47, 2, '42', '420.00', '2021-11-07 16:19:12', '2021-11-07 16:19:12'),
(6, 47, 3, '45', '450.00', '2021-11-07 16:19:12', '2021-11-07 16:19:12'),
(7, 1, 1, '7.25', '261.00', '2021-11-09 08:21:44', '2021-11-09 08:21:44'),
(8, 1, 2, '7.50', '270.00', '2021-11-09 08:21:44', '2021-11-09 08:21:44'),
(9, 1, 3, '8', '288.00', '2021-11-09 08:21:44', '2021-11-09 08:21:44'),
(10, 2, 1, '7.25', '253.75', '2021-11-09 08:22:42', '2021-11-09 08:22:42'),
(11, 2, 2, '7.50', '262.50', '2021-11-09 08:22:42', '2021-11-09 08:22:42'),
(12, 2, 3, '8.00', '280.00', '2021-11-09 08:22:42', '2021-11-09 08:22:42'),
(13, 3, 1, '5', '250.00', '2021-11-09 08:24:57', '2021-11-09 08:24:57'),
(14, 3, 2, '5.25', '262.50', '2021-11-09 08:24:57', '2021-11-09 08:24:57'),
(15, 3, 3, '5.50', '275.00', '2021-11-09 08:24:57', '2021-11-09 08:24:57'),
(16, 4, 1, '10', '600.00', '2021-11-09 08:27:01', '2021-11-09 08:27:01'),
(17, 4, 2, '11', '660.00', '2021-11-09 08:27:01', '2021-11-09 08:27:01'),
(18, 4, 3, '12', '720.00', '2021-11-09 08:27:01', '2021-11-09 08:27:01'),
(19, 5, 1, '12', '384.00', '2021-11-09 08:27:32', '2021-11-09 08:27:32'),
(20, 5, 2, '13', '416.00', '2021-11-09 08:27:32', '2021-11-09 08:27:32'),
(21, 5, 3, '14', '448.00', '2021-11-09 08:27:32', '2021-11-09 08:27:32'),
(22, 6, 1, '15', '360.00', '2021-11-09 08:28:00', '2021-11-09 08:28:00'),
(23, 6, 2, '17', '408.00', '2021-11-09 08:28:00', '2021-11-09 08:28:00'),
(24, 6, 3, '18', '432.00', '2021-11-09 08:28:00', '2021-11-09 08:28:00'),
(25, 7, 1, '26', '624.00', '2021-11-09 08:29:34', '2021-11-09 08:29:34'),
(26, 7, 2, '28', '672.00', '2021-11-09 08:29:34', '2021-11-09 08:29:34'),
(27, 7, 3, '30', '720.00', '2021-11-09 08:29:34', '2021-11-09 08:29:34'),
(28, 8, 1, '45', '1080.00', '2021-11-09 08:30:09', '2021-11-09 08:30:09'),
(29, 8, 2, '47', '1128.00', '2021-11-09 08:30:09', '2021-11-09 08:30:09'),
(30, 8, 3, '48', '1152.00', '2021-11-09 08:30:09', '2021-11-09 08:30:09'),
(31, 9, 1, '50', '1200.00', '2021-11-09 08:30:48', '2021-11-09 08:30:48'),
(32, 9, 2, '52', '1248.00', '2021-11-09 08:30:48', '2021-11-09 08:30:48'),
(33, 9, 3, '55', '1320.00', '2021-11-09 08:30:48', '2021-11-09 08:30:48'),
(34, 10, 1, '60', '600.00', '2021-11-09 08:31:41', '2021-11-09 08:31:41'),
(35, 10, 2, '62', '620.00', '2021-11-09 08:31:41', '2021-11-09 08:31:41'),
(36, 10, 3, '64', '640.00', '2021-11-09 08:31:41', '2021-11-09 08:31:41'),
(37, 48, 1, '10', '120.00', '2021-11-18 11:08:32', '2021-11-18 11:10:24'),
(38, 48, 2, '9', '108.00', '2021-11-18 11:08:32', '2021-11-18 11:10:24'),
(39, 48, 3, '10.5', '126.00', '2021-11-18 11:08:32', '2021-11-18 11:10:24');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `memo_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `item` double(8,2) NOT NULL,
  `total_qty` double(8,2) NOT NULL,
  `grand_total` double NOT NULL,
  `discount_amount` double DEFAULT NULL,
  `net_total` double NOT NULL,
  `paid_amount` double DEFAULT NULL,
  `due_amount` double NOT NULL,
  `payment_status` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Paid,2=Partial,3=Due',
  `payment_method` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Cash,2=Cheque,3=Mobile',
  `purchase_date` date NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `memo_no`, `warehouse_id`, `supplier_id`, `item`, `total_qty`, `grand_total`, `discount_amount`, `net_total`, `paid_amount`, `due_amount`, `payment_status`, `payment_method`, `purchase_date`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(10, 'PINV-1002', 1, 1, 3.00, 200.00, 15500, 500, 15000, 0, 15000, '3', '1', '2021-11-16', 'Super Admin', NULL, '2021-11-16 06:46:58', '2021-11-16 06:46:58'),
(11, 'PINV-1003', 1, 1, 4.00, 240.00, 18100, 100, 18000, 18000, 0, '1', '1', '2021-11-18', 'Super Admin', 'Super Admin', '2021-11-16 06:52:27', '2021-11-18 08:15:03');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_payments`
--

CREATE TABLE `purchase_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_debit_transaction_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double NOT NULL,
  `payment_method` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Cash,2=Cheque,3=Mobile',
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_note` text COLLATE utf8mb4_unicode_ci,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_payments`
--

INSERT INTO `purchase_payments` (`id`, `purchase_id`, `account_id`, `transaction_id`, `supplier_debit_transaction_id`, `amount`, `payment_method`, `reference_no`, `payment_note`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(3, 11, 23, 83, 82, 5500, '1', NULL, NULL, 'Super Admin', NULL, '2021-11-18 08:07:36', '2021-11-18 08:07:36'),
(4, 11, 23, 85, 84, 12500, '1', NULL, NULL, 'Super Admin', NULL, '2021-11-18 08:15:03', '2021-11-18 08:15:03');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_returns`
--

CREATE TABLE `purchase_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `item` double(8,2) NOT NULL,
  `total_qty` double(8,2) NOT NULL,
  `total_cost` double NOT NULL,
  `total_deduction` double DEFAULT NULL,
  `grand_total` double NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `return_date` date NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_returns`
--

INSERT INTO `purchase_returns` (`id`, `return_no`, `purchase_id`, `item`, `total_qty`, `total_cost`, `total_deduction`, `grand_total`, `reason`, `return_date`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(2, 'PRINV-2111632', 10, 2.00, 10.00, 580, 20, 560, NULL, '2021-11-18', 'Super Admin', NULL, '2021-11-18 04:41:00', '2021-11-18 04:41:00');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_materials`
--

CREATE TABLE `purchase_return_materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_return_id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `return_qty` double NOT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `material_rate` double NOT NULL,
  `deduction_rate` double DEFAULT NULL,
  `deduction_amount` double DEFAULT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_return_materials`
--

INSERT INTO `purchase_return_materials` (`id`, `purchase_return_id`, `material_id`, `return_qty`, `unit_id`, `material_rate`, `deduction_rate`, `deduction_amount`, `total`, `created_at`, `updated_at`) VALUES
(3, 2, 1, 5, 2, 40, 10, 20, 180, NULL, NULL),
(4, 2, 2, 5, 2, 80, 0, 0, 400, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `deletable`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', '1', NULL, NULL, NULL, NULL),
(2, 'Admin', '1', NULL, NULL, NULL, NULL),
(3, 'Manager', '2', NULL, NULL, '2021-10-21 10:13:38', '2021-10-21 10:13:38');

-- --------------------------------------------------------

--
-- Table structure for table `salary_generates`
--

CREATE TABLE `salary_generates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `designation_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `salary_month` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `basic_salary` double DEFAULT NULL,
  `allowance_amount` double DEFAULT NULL,
  `deduction_amount` double DEFAULT NULL,
  `absent` double DEFAULT NULL,
  `absent_amount` double DEFAULT NULL,
  `late_count` double DEFAULT NULL,
  `leave` double DEFAULT NULL,
  `leave_amount` double DEFAULT NULL,
  `ot_hour` double DEFAULT NULL,
  `ot_day` double DEFAULT NULL,
  `ot_amount` double DEFAULT NULL,
  `gross_salary` double DEFAULT NULL,
  `add_deduct_amount` double DEFAULT NULL,
  `adjusted_advance_amount` double DEFAULT NULL,
  `adjusted_loan_amount` double DEFAULT NULL,
  `net_salary` double DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `salary_status` enum('1','2','3','4') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '3' COMMENT '1=Received,2=Partial,3=Pending,4=Ordered',
  `payment_status` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '3' COMMENT '1=Paid,2=Partial,3=Due',
  `payment_method` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Cash,2=Cheque,3=Mobile',
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_generate_payments`
--

CREATE TABLE `salary_generate_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `salary_generated_id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `employee_transaction_id` bigint(20) UNSIGNED NOT NULL,
  `voucher_no` date DEFAULT NULL,
  `voucher_date` date DEFAULT NULL,
  `month` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double NOT NULL,
  `payment_method` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Cash,2=Cheque,3=Mobile',
  `cheque_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_note` text COLLATE utf8mb4_unicode_ci,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_incements`
--

CREATE TABLE `salary_incements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `inc_month` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `percent` int(11) DEFAULT NULL,
  `amount` double NOT NULL,
  `previous_basic` double NOT NULL,
  `current_basic` double NOT NULL,
  `status` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive, 3=Cancel',
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `memo_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `order_from` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Depo,2=Direct Dealer',
  `depo_id` bigint(20) UNSIGNED DEFAULT NULL,
  `dealer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `upazila_id` bigint(20) UNSIGNED NOT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `item` double(8,2) NOT NULL,
  `total_unit_qty` float DEFAULT NULL,
  `total_qty` double(8,2) NOT NULL,
  `total_free_qty` float DEFAULT NULL,
  `grand_total` double NOT NULL,
  `commission_rate` double(8,2) DEFAULT NULL COMMENT 'Commission Rate(%)',
  `total_commission` double DEFAULT NULL COMMENT 'Total Commission',
  `net_total` double DEFAULT NULL,
  `sale_date` date NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivery_status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=Delivered,2=Pending',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `memo_no`, `warehouse_id`, `order_from`, `depo_id`, `dealer_id`, `district_id`, `upazila_id`, `area_id`, `item`, `total_unit_qty`, `total_qty`, `total_free_qty`, `grand_total`, `commission_rate`, `total_commission`, `net_total`, `sale_date`, `delivery_date`, `delivery_status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(3, 'SINV-211110863', 1, '1', 4, 4, 17, 179, 557, 4.00, 7, 317.00, 7, 2250, 10.00, 225, 2025, '2021-11-13', '2021-11-13', '1', 'Super Admin', NULL, '2021-11-09 18:09:54', '2021-11-14 19:05:20'),
(4, 'SINV-211110135', 1, '2', NULL, 1, 6, 104, 559, 6.00, 9.5, 370.00, 10, 3307.5, 8.00, 264.6, 3042.9, '2021-11-13', '2021-11-13', '1', 'Super Admin', 'Super Admin', '2021-11-10 18:06:32', '2021-11-14 19:05:20'),
(5, 'SINV-21111326', 1, '1', 4, 6, 17, 179, 557, 4.00, 7, 252.00, 0, 1900.5, 10.00, 190.05, 1710.45, '2021-11-13', '2021-11-13', '1', 'Super Admin', NULL, '2021-11-13 14:01:57', '2021-11-14 19:05:20'),
(6, 'SINV-211113363', 1, '1', 5, 5, 6, 104, 559, 3.00, 4, 116.00, 0, 2176, 9.50, 206.72, 1969.28, '2021-11-13', '2021-11-13', '1', 'Super Admin', NULL, '2021-11-13 14:03:03', '2021-11-14 19:05:20'),
(7, 'SINV-211113974', 1, '2', NULL, 2, 17, 179, 558, 3.00, 3, 108.00, 0, 2040, 7.00, 142.8, 1897.2, '2021-11-13', '2021-11-13', '1', 'Super Admin', NULL, '2021-11-13 14:03:49', '2021-11-14 19:05:20'),
(8, 'SINV-211116167', 1, '1', 5, 5, 6, 104, 559, 3.00, 3, 110.00, 5, 0, 9.50, 0, 0, '2021-11-16', '2021-11-16', '1', 'Super Admin', NULL, '2021-11-16 12:28:41', '2021-11-16 12:29:41');

-- --------------------------------------------------------

--
-- Table structure for table `sale_products`
--

CREATE TABLE `sale_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `unit_qty` float DEFAULT NULL,
  `qty` double(8,2) NOT NULL,
  `free_qty` float DEFAULT NULL,
  `base_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `net_unit_price` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_products`
--

INSERT INTO `sale_products` (`id`, `sale_id`, `product_id`, `unit_qty`, `qty`, `free_qty`, `base_unit_id`, `unit_id`, `net_unit_price`, `total`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 2, 72.00, 2, 1, 21, 7.5, 540, '2021-11-09 18:09:54', '2021-11-09 18:09:54'),
(2, 3, 2, 1, 35.00, NULL, 1, 20, 7.5, 262.5, '2021-11-09 18:09:54', '2021-11-09 18:09:54'),
(3, 3, 3, 3, 150.00, 5, 1, 24, 5.25, 787.5, '2021-11-09 18:09:54', '2021-11-09 18:09:54'),
(4, 3, 4, 1, 60.00, NULL, 1, 25, 11, 660, '2021-11-09 18:09:54', '2021-11-09 18:09:54'),
(5, 4, 1, 2, 72.00, 5, 1, 21, 7.25, 522, '2021-11-10 18:06:32', '2021-11-10 19:02:23'),
(6, 4, 2, 2, 70.00, NULL, 1, 20, 7.25, 507.5, '2021-11-10 18:06:32', '2021-11-10 19:02:23'),
(7, 4, 3, 1, 50.00, NULL, 1, 24, 5, 250, '2021-11-10 18:06:32', '2021-11-10 19:02:23'),
(8, 4, 4, 1.5, 90.00, 5, 1, 25, 10, 900, '2021-11-10 18:06:32', '2021-11-10 19:02:23'),
(9, 4, 5, 2, 64.00, NULL, 1, 19, 12, 768, '2021-11-10 18:06:32', '2021-11-10 19:02:23'),
(10, 4, 6, 1, 24.00, NULL, 1, 17, 15, 360, '2021-11-10 19:02:23', '2021-11-10 19:02:23'),
(11, 5, 1, 3, 108.00, NULL, 1, 21, 7.25, 783, '2021-11-13 14:01:57', '2021-11-13 14:01:57'),
(12, 5, 2, 2, 70.00, NULL, 1, 20, 7.25, 507.5, '2021-11-13 14:01:57', '2021-11-13 14:01:57'),
(13, 5, 3, 1, 50.00, NULL, 1, 24, 5, 250, '2021-11-13 14:01:57', '2021-11-13 14:01:57'),
(14, 5, 6, 1, 24.00, NULL, 1, 17, 15, 360, '2021-11-13 14:01:57', '2021-11-13 14:01:57'),
(15, 6, 1, 1, 36.00, NULL, 1, 21, 8, 288, '2021-11-13 14:03:03', '2021-11-13 14:03:03'),
(16, 6, 5, 1, 32.00, NULL, 1, 19, 14, 448, '2021-11-13 14:03:03', '2021-11-13 14:03:03'),
(17, 6, 7, 2, 48.00, NULL, 1, 17, 30, 1440, '2021-11-13 14:03:03', '2021-11-13 14:03:03'),
(18, 7, 4, 1, 60.00, NULL, 1, 25, 10, 600, '2021-11-13 14:03:49', '2021-11-13 14:03:49'),
(19, 7, 6, 1, 24.00, NULL, 1, 17, 15, 360, '2021-11-13 14:03:49', '2021-11-13 14:03:49'),
(20, 7, 8, 1, 24.00, NULL, 1, 17, 45, 1080, '2021-11-13 14:03:49', '2021-11-13 14:03:49'),
(21, 8, 1, 1, 36.00, 5, 1, 21, 8, 288, '2021-11-16 12:28:41', '2021-11-16 12:28:41'),
(22, 8, 8, 1, 24.00, NULL, 1, 17, 48, 1152, '2021-11-16 12:28:41', '2021-11-16 12:28:41'),
(23, 8, 11, 1, 50.00, NULL, 1, 24, 0, 0, '2021-11-16 12:28:41', '2021-11-16 12:28:41');

-- --------------------------------------------------------

--
-- Table structure for table `sale_returns`
--

CREATE TABLE `sale_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item` double(8,2) NOT NULL,
  `total_qty` double(8,2) NOT NULL,
  `total_price` double NOT NULL,
  `total_deduction` double DEFAULT NULL,
  `grand_total` double NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `return_date` date NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_return_products`
--

CREATE TABLE `sale_return_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_return_id` bigint(20) UNSIGNED NOT NULL,
  `memo_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `return_qty` double NOT NULL,
  `base_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_rate` double NOT NULL,
  `deduction_rate` double DEFAULT NULL,
  `deduction_amount` double DEFAULT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('AU1RkWXk3CVXdFu8tBzSgJz6P7eLLMoYAlFyq1h6', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:95.0) Gecko/20100101 Firefox/95.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZzhHUTJjV2tJd0pSUUpPVFJmbnBBS2s1N1JmRGxGRjlnVkt2TXdlbyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozODoiaHR0cDovL3NhZmUtZm9vZC50ZXN0L3B1cmNoYXNlL2VkaXQvMTEiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozODoiaHR0cDovL3NhZmUtZm9vZC50ZXN0L3B1cmNoYXNlL2VkaXQvMTEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1637214935),
('xb4zOd1iOED8foL1S3BHTFJDwIQnRxqkSjvqsJGF', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:95.0) Gecko/20100101 Firefox/95.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYXNFRWJMblJoNG96UWtNREQxZXZheFdRVk1IeHpyY2NRYVd5MTRGSCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMzoiaHR0cDovL3NhZmUtZm9vZC50ZXN0L3Byb2R1Y3QvYWRkIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9zYWZlLWZvb2QudGVzdC9wcm9kdWN0L2FkZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1637228017),
('Xt23tdU6ZreVWVJ35KaCXPCB8WqzXQuIHQ9sNk3q', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:95.0) Gecko/20100101 Firefox/95.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoia01PVkJuZUJSYVg4VVY1TFJYamNtb1drSWhPYU9zaXVLelZobG00UiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1NToiaHR0cDovL3NhZmUtZm9vZC50ZXN0L3JldHVybi9wdXJjaGFzZT9tZW1vX25vPVBJTlYtMTAwMiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjU1OiJodHRwOi8vc2FmZS1mb29kLnRlc3QvcmV0dXJuL3B1cmNoYXNlP21lbW9fbm89UElOVi0xMDAyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1637208954);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('zMEmJbarAvTN4IF6xlJBiGiqqAXuzqwdbnchDAfn', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:95.0) Gecko/20100101 Firefox/95.0', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiSzAwbmN6UEljd0dDSGN0ZGp4b1ZIaHIxYldIbzNVSUV1UzU4dDZWYSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM2OiJodHRwOi8vc2FmZS1mb29kLnRlc3QvbWVudS9idWlsZGVyLzEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTU6InVzZXJfcGVybWlzc2lvbiI7YTozOTk6e2k6MDtzOjE2OiJkYXNoYm9hcmQtYWNjZXNzIjtpOjE7czoxMToidXNlci1hY2Nlc3MiO2k6MjtzOjg6InVzZXItYWRkIjtpOjM7czo5OiJ1c2VyLWVkaXQiO2k6NDtzOjk6InVzZXItdmlldyI7aTo1O3M6MTE6InVzZXItZGVsZXRlIjtpOjY7czoxNjoidXNlci1idWxrLWRlbGV0ZSI7aTo3O3M6MTE6InVzZXItcmVwb3J0IjtpOjg7czoxMToicm9sZS1hY2Nlc3MiO2k6OTtzOjg6InJvbGUtYWRkIjtpOjEwO3M6OToicm9sZS1lZGl0IjtpOjExO3M6OToicm9sZS12aWV3IjtpOjEyO3M6MTE6InJvbGUtZGVsZXRlIjtpOjEzO3M6MTY6InJvbGUtYnVsay1kZWxldGUiO2k6MTQ7czoxMToicm9sZS1yZXBvcnQiO2k6MTU7czoxMToibWVudS1hY2Nlc3MiO2k6MTY7czo4OiJtZW51LWFkZCI7aToxNztzOjk6Im1lbnUtZWRpdCI7aToxODtzOjExOiJtZW51LWRlbGV0ZSI7aToxOTtzOjE2OiJtZW51LWJ1bGstZGVsZXRlIjtpOjIwO3M6MTE6Im1lbnUtcmVwb3J0IjtpOjIxO3M6MTk6Im1lbnUtYnVpbGRlci1hY2Nlc3MiO2k6MjI7czoxNToibWVudS1tb2R1bGUtYWRkIjtpOjIzO3M6MTY6Im1lbnUtbW9kdWxlLWVkaXQiO2k6MjQ7czoxODoibWVudS1tb2R1bGUtZGVsZXRlIjtpOjI1O3M6MTc6InBlcm1pc3Npb24tYWNjZXNzIjtpOjI2O3M6MTQ6InBlcm1pc3Npb24tYWRkIjtpOjI3O3M6MTU6InBlcm1pc3Npb24tZWRpdCI7aToyODtzOjE3OiJwZXJtaXNzaW9uLWRlbGV0ZSI7aToyOTtzOjIyOiJwZXJtaXNzaW9uLWJ1bGstZGVsZXRlIjtpOjMwO3M6MTc6InBlcm1pc3Npb24tcmVwb3J0IjtpOjMxO3M6MTY6IndhcmVob3VzZS1hY2Nlc3MiO2k6MzI7czoxMzoid2FyZWhvdXNlLWFkZCI7aTozMztzOjE0OiJ3YXJlaG91c2UtZWRpdCI7aTozNDtzOjE2OiJ3YXJlaG91c2UtZGVsZXRlIjtpOjM1O3M6MjE6IndhcmVob3VzZS1idWxrLWRlbGV0ZSI7aTozNjtzOjE2OiJ3YXJlaG91c2UtcmVwb3J0IjtpOjM3O3M6MjI6ImdlbmVyYWwtc2V0dGluZy1hY2Nlc3MiO2k6Mzg7czoxOToiZGVhbGVyLWdyb3VwLWFjY2VzcyI7aTozOTtzOjE2OiJkZWFsZXItZ3JvdXAtYWRkIjtpOjQwO3M6MTc6ImRlYWxlci1ncm91cC1lZGl0IjtpOjQxO3M6MTk6ImRlYWxlci1ncm91cC1kZWxldGUiO2k6NDI7czoyNDoiZGVhbGVyLWdyb3VwLWJ1bGstZGVsZXRlIjtpOjQzO3M6MTE6InVuaXQtYWNjZXNzIjtpOjQ0O3M6ODoidW5pdC1hZGQiO2k6NDU7czo5OiJ1bml0LWVkaXQiO2k6NDY7czoxMToidW5pdC1kZWxldGUiO2k6NDc7czoxNjoidW5pdC1idWxrLWRlbGV0ZSI7aTo0ODtzOjExOiJ1bml0LXJlcG9ydCI7aTo0OTtzOjEwOiJ0YXgtYWNjZXNzIjtpOjUwO3M6NzoidGF4LWFkZCI7aTo1MTtzOjg6InRheC1lZGl0IjtpOjUyO3M6MTA6InRheC1kZWxldGUiO2k6NTM7czoxNToidGF4LWJ1bGstZGVsZXRlIjtpOjU0O3M6MTA6InRheC1yZXBvcnQiO2k6NTU7czoyNDoibWF0ZXJpYWwtY2F0ZWdvcnktYWNjZXNzIjtpOjU2O3M6MjE6Im1hdGVyaWFsLWNhdGVnb3J5LWFkZCI7aTo1NztzOjIyOiJtYXRlcmlhbC1jYXRlZ29yeS1lZGl0IjtpOjU4O3M6MjQ6Im1hdGVyaWFsLWNhdGVnb3J5LWRlbGV0ZSI7aTo1OTtzOjI5OiJtYXRlcmlhbC1jYXRlZ29yeS1idWxrLWRlbGV0ZSI7aTo2MDtzOjI0OiJtYXRlcmlhbC1jYXRlZ29yeS1yZXBvcnQiO2k6NjE7czoxNToibWF0ZXJpYWwtYWNjZXNzIjtpOjYyO3M6MTI6Im1hdGVyaWFsLWFkZCI7aTo2MztzOjEzOiJtYXRlcmlhbC1lZGl0IjtpOjY0O3M6MTM6Im1hdGVyaWFsLXZpZXciO2k6NjU7czoxNToibWF0ZXJpYWwtZGVsZXRlIjtpOjY2O3M6MjA6Im1hdGVyaWFsLWJ1bGstZGVsZXRlIjtpOjY3O3M6MTU6Im1hdGVyaWFsLXJlcG9ydCI7aTo2ODtzOjI4OiJtYXRlcmlhbC1zdG9jay1yZXBvcnQtYWNjZXNzIjtpOjY5O3M6MTU6InB1cmNoYXNlLWFjY2VzcyI7aTo3MDtzOjEyOiJwdXJjaGFzZS1hZGQiO2k6NzE7czoxMzoicHVyY2hhc2UtZWRpdCI7aTo3MjtzOjEzOiJwdXJjaGFzZS12aWV3IjtpOjczO3M6MTU6InB1cmNoYXNlLWRlbGV0ZSI7aTo3NDtzOjIwOiJwdXJjaGFzZS1idWxrLWRlbGV0ZSI7aTo3NTtzOjE1OiJwdXJjaGFzZS1yZXBvcnQiO2k6NzY7czoyMzoicHJvZHVjdC1jYXRlZ29yeS1hY2Nlc3MiO2k6Nzc7czoyMDoicHJvZHVjdC1jYXRlZ29yeS1hZGQiO2k6Nzg7czoyMToicHJvZHVjdC1jYXRlZ29yeS1lZGl0IjtpOjc5O3M6MjM6InByb2R1Y3QtY2F0ZWdvcnktZGVsZXRlIjtpOjgwO3M6Mjg6InByb2R1Y3QtY2F0ZWdvcnktYnVsay1kZWxldGUiO2k6ODE7czoyMzoicHJvZHVjdC1jYXRlZ29yeS1yZXBvcnQiO2k6ODI7czoxNDoicHJvZHVjdC1hY2Nlc3MiO2k6ODM7czoxMToicHJvZHVjdC1hZGQiO2k6ODQ7czoxMjoicHJvZHVjdC1lZGl0IjtpOjg1O3M6MTI6InByb2R1Y3QtdmlldyI7aTo4NjtzOjE0OiJwcm9kdWN0LWRlbGV0ZSI7aTo4NztzOjE5OiJwcm9kdWN0LWJ1bGstZGVsZXRlIjtpOjg4O3M6MTQ6InByb2R1Y3QtcmVwb3J0IjtpOjg5O3M6MjA6InByaW50LWJhcmNvZGUtYWNjZXNzIjtpOjkwO3M6MjU6ImZpbmlzaC1nb29kcy1zdG9jay1hY2Nlc3MiO2k6OTE7czoyMjoiZmluaXNoLWdvb2RzLXN0b2NrLWFkZCI7aTo5MjtzOjIzOiJmaW5pc2gtZ29vZHMtc3RvY2stZWRpdCI7aTo5MztzOjIzOiJmaW5pc2gtZ29vZHMtc3RvY2stdmlldyI7aTo5NDtzOjI1OiJmaW5pc2gtZ29vZHMtc3RvY2stZGVsZXRlIjtpOjk1O3M6MzA6ImZpbmlzaC1nb29kcy1zdG9jay1idWxrLWRlbGV0ZSI7aTo5NjtzOjI1OiJmaW5pc2gtZ29vZHMtc3RvY2stcmVwb3J0IjtpOjk3O3M6Mjc6InByb2R1Y3Qtc3RvY2stcmVwb3J0LWFjY2VzcyI7aTo5ODtzOjE1OiJzdXBwbGllci1hY2Nlc3MiO2k6OTk7czoxMjoic3VwcGxpZXItYWRkIjtpOjEwMDtzOjEzOiJzdXBwbGllci1lZGl0IjtpOjEwMTtzOjEzOiJzdXBwbGllci12aWV3IjtpOjEwMjtzOjE1OiJzdXBwbGllci1kZWxldGUiO2k6MTAzO3M6MjA6InN1cHBsaWVyLWJ1bGstZGVsZXRlIjtpOjEwNDtzOjE1OiJzdXBwbGllci1yZXBvcnQiO2k6MTA1O3M6MjI6InN1cHBsaWVyLWxlZGdlci1hY2Nlc3MiO2k6MTA2O3M6MjM6InN1cHBsaWVyLWFkdmFuY2UtYWNjZXNzIjtpOjEwNztzOjEzOiJyZXR1cm4tYWNjZXNzIjtpOjEwODtzOjIyOiJwdXJjaGFzZS1yZXR1cm4tYWNjZXNzIjtpOjEwOTtzOjE5OiJwdXJjaGFzZS1yZXR1cm4tYWRkIjtpOjExMDtzOjIwOiJwdXJjaGFzZS1yZXR1cm4tdmlldyI7aToxMTE7czoyMjoicHVyY2hhc2UtcmV0dXJuLWRlbGV0ZSI7aToxMTI7czoxMDoiY29hLWFjY2VzcyI7aToxMTM7czo3OiJjb2EtYWRkIjtpOjExNDtzOjg6ImNvYS1lZGl0IjtpOjExNTtzOjEwOiJjb2EtZGVsZXRlIjtpOjExNjtzOjIyOiJvcGVuaW5nLWJhbGFuY2UtYWNjZXNzIjtpOjExNztzOjIzOiJzdXBwbGllci1wYXltZW50LWFjY2VzcyI7aToxMTg7czoyMToiY29udHJhLXZvdWNoZXItYWNjZXNzIjtpOjExOTtzOjE4OiJjb250cmEtdm91Y2hlci1hZGQiO2k6MTIwO3M6MTk6ImNvbnRyYS12b3VjaGVyLXZpZXciO2k6MTIxO3M6MjE6ImNvbnRyYS12b3VjaGVyLWRlbGV0ZSI7aToxMjI7czoyMjoiam91cm5hbC12b3VjaGVyLWFjY2VzcyI7aToxMjM7czoxOToiam91cm5hbC12b3VjaGVyLWFkZCI7aToxMjQ7czoyMDoiam91cm5hbC12b3VjaGVyLXZpZXciO2k6MTI1O3M6MjI6ImpvdXJuYWwtdm91Y2hlci1kZWxldGUiO2k6MTI2O3M6MTQ6InZvdWNoZXItYWNjZXNzIjtpOjEyNztzOjE1OiJ2b3VjaGVyLWFwcHJvdmUiO2k6MTI4O3M6MTI6InZvdWNoZXItZWRpdCI7aToxMjk7czoxNDoidm91Y2hlci1kZWxldGUiO2k6MTMwO3M6MTY6ImNhc2gtYm9vay1hY2Nlc3MiO2k6MTMxO3M6MjM6ImludmVudG9yeS1sZWRnZXItYWNjZXNzIjtpOjEzMjtzOjE2OiJiYW5rLWJvb2stYWNjZXNzIjtpOjEzMztzOjIzOiJtb2JpbGUtYmFuay1ib29rLWFjY2VzcyI7aToxMzQ7czoyMToiZ2VuZXJhbC1sZWRnZXItYWNjZXNzIjtpOjEzNTtzOjIwOiJ0cmlhbC1iYWxhbmNlLWFjY2VzcyI7aToxMzY7czoxODoicHJvZml0LWxvc3MtYWNjZXNzIjtpOjEzNztzOjE2OiJjYXNoLWZsb3ctYWNjZXNzIjtpOjEzODtzOjE5OiJleHBlbnNlLWl0ZW0tYWNjZXNzIjtpOjEzOTtzOjE2OiJleHBlbnNlLWl0ZW0tYWRkIjtpOjE0MDtzOjE3OiJleHBlbnNlLWl0ZW0tZWRpdCI7aToxNDE7czoxOToiZXhwZW5zZS1pdGVtLWRlbGV0ZSI7aToxNDI7czoyNDoiZXhwZW5zZS1pdGVtLWJ1bGstZGVsZXRlIjtpOjE0MztzOjE5OiJleHBlbnNlLWl0ZW0tcmVwb3J0IjtpOjE0NDtzOjE0OiJleHBlbnNlLWFjY2VzcyI7aToxNDU7czoxMToiZXhwZW5zZS1hZGQiO2k6MTQ2O3M6MTI6ImV4cGVuc2UtZWRpdCI7aToxNDc7czoxNDoiZXhwZW5zZS1kZWxldGUiO2k6MTQ4O3M6MTk6ImV4cGVuc2UtYnVsay1kZWxldGUiO2k6MTQ5O3M6MTQ6ImV4cGVuc2UtcmVwb3J0IjtpOjE1MDtzOjE1OiJleHBlbnNlLWFwcHJvdmUiO2k6MTUxO3M6MjQ6ImV4cGVuc2Utc3RhdGVtZW50LWFjY2VzcyI7aToxNTI7czoxMToiYmFuay1hY2Nlc3MiO2k6MTUzO3M6ODoiYmFuay1hZGQiO2k6MTU0O3M6OToiYmFuay1lZGl0IjtpOjE1NTtzOjExOiJiYW5rLWRlbGV0ZSI7aToxNTY7czoxMToiYmFuay1yZXBvcnQiO2k6MTU3O3M6MjM6ImJhbmstdHJhbnNhY3Rpb24tYWNjZXNzIjtpOjE1ODtzOjE4OiJiYW5rLWxlZGdlci1hY2Nlc3MiO2k6MTU5O3M6MTg6Im1vYmlsZS1iYW5rLWFjY2VzcyI7aToxNjA7czoxNToibW9iaWxlLWJhbmstYWRkIjtpOjE2MTtzOjE2OiJtb2JpbGUtYmFuay1lZGl0IjtpOjE2MjtzOjE4OiJtb2JpbGUtYmFuay1kZWxldGUiO2k6MTYzO3M6MjM6Im1vYmlsZS1iYW5rLWJ1bGstZGVsZXRlIjtpOjE2NDtzOjE4OiJtb2JpbGUtYmFuay1yZXBvcnQiO2k6MTY1O3M6MzA6Im1vYmlsZS1iYW5rLXRyYW5zYWN0aW9uLWFjY2VzcyI7aToxNjY7czoyNToibW9iaWxlLWJhbmstbGVkZ2VyLWFjY2VzcyI7aToxNjc7czoxNToiZGlzdHJpY3QtYWNjZXNzIjtpOjE2ODtzOjEyOiJkaXN0cmljdC1hZGQiO2k6MTY5O3M6MTM6ImRpc3RyaWN0LWVkaXQiO2k6MTcwO3M6MTU6ImRpc3RyaWN0LWRlbGV0ZSI7aToxNzE7czoyMDoiZGlzdHJpY3QtYnVsay1kZWxldGUiO2k6MTcyO3M6MTU6ImRpc3RyaWN0LXJlcG9ydCI7aToxNzM7czoxNDoidXBhemlsYS1hY2Nlc3MiO2k6MTc0O3M6MTE6InVwYXppbGEtYWRkIjtpOjE3NTtzOjEyOiJ1cGF6aWxhLWVkaXQiO2k6MTc2O3M6MTQ6InVwYXppbGEtZGVsZXRlIjtpOjE3NztzOjE5OiJ1cGF6aWxhLWJ1bGstZGVsZXRlIjtpOjE3ODtzOjE0OiJ1cGF6aWxhLXJlcG9ydCI7aToxNzk7czoxMToiYXJlYS1hY2Nlc3MiO2k6MTgwO3M6ODoiYXJlYS1hZGQiO2k6MTgxO3M6OToiYXJlYS1lZGl0IjtpOjE4MjtzOjExOiJhcmVhLWRlbGV0ZSI7aToxODM7czoxNjoiYXJlYS1idWxrLWRlbGV0ZSI7aToxODQ7czoxMToiYXJlYS1yZXBvcnQiO2k6MTg1O3M6MTM6ImRlYWxlci1hY2Nlc3MiO2k6MTg2O3M6MTA6ImRlYWxlci1hZGQiO2k6MTg3O3M6MTE6ImRlYWxlci1lZGl0IjtpOjE4ODtzOjExOiJkZWFsZXItdmlldyI7aToxODk7czoxMzoiZGVhbGVyLWRlbGV0ZSI7aToxOTA7czoxODoiZGVhbGVyLWJ1bGstZGVsZXRlIjtpOjE5MTtzOjE3OiJkZXBhcnRtZW50LWFjY2VzcyI7aToxOTI7czoxNDoiZGVwYXJ0bWVudC1hZGQiO2k6MTkzO3M6MTU6ImRlcGFydG1lbnQtZWRpdCI7aToxOTQ7czoxNzoiZGVwYXJ0bWVudC1kZWxldGUiO2k6MTk1O3M6MjI6ImRlcGFydG1lbnQtYnVsay1kZWxldGUiO2k6MTk2O3M6MTc6ImRlcGFydG1lbnQtcmVwb3J0IjtpOjE5NztzOjE1OiJkaXZpc2lvbi1hY2Nlc3MiO2k6MTk4O3M6MTI6ImRpdmlzaW9uLWFkZCI7aToxOTk7czoxMzoiZGl2aXNpb24tZWRpdCI7aToyMDA7czoxNToiZGl2aXNpb24tZGVsZXRlIjtpOjIwMTtzOjIwOiJkaXZpc2lvbi1idWxrLWRlbGV0ZSI7aToyMDI7czoxNToiZGl2aXNpb24tcmVwb3J0IjtpOjIwMztzOjE4OiJkZXNpZ25hdGlvbi1hY2Nlc3MiO2k6MjA0O3M6MTU6ImRlc2lnbmF0aW9uLWFkZCI7aToyMDU7czoxNjoiZGVzaWduYXRpb24tZWRpdCI7aToyMDY7czoxODoiZGVzaWduYXRpb24tZGVsZXRlIjtpOjIwNztzOjIzOiJkZXNpZ25hdGlvbi1idWxrLWRlbGV0ZSI7aToyMDg7czoxODoiZGVzaWduYXRpb24tcmVwb3J0IjtpOjIwOTtzOjE1OiJlbXBsb3llZS1hY2Nlc3MiO2k6MjEwO3M6MTI6ImVtcGxveWVlLWFkZCI7aToyMTE7czoxMzoiZW1wbG95ZWUtZWRpdCI7aToyMTI7czoxMzoiZW1wbG95ZWUtdmlldyI7aToyMTM7czoxNToiZW1wbG95ZWUtZGVsZXRlIjtpOjIxNDtzOjIwOiJlbXBsb3llZS1idWxrLWRlbGV0ZSI7aToyMTU7czoxNToiZW1wbG95ZWUtcmVwb3J0IjtpOjIxNjtzOjE3OiJhdHRlbmRhbmNlLWFjY2VzcyI7aToyMTc7czoxNDoiYXR0ZW5kYW5jZS1hZGQiO2k6MjE4O3M6MTU6ImF0dGVuZGFuY2UtZWRpdCI7aToyMTk7czoxNzoiYXR0ZW5kYW5jZS1kZWxldGUiO2k6MjIwO3M6MjI6ImF0dGVuZGFuY2UtYnVsay1kZWxldGUiO2k6MjIxO3M6MTc6ImF0dGVuZGFuY2UtcmVwb3J0IjtpOjIyMjtzOjI0OiJhdHRlbmRhbmNlLXJlcG9ydC1hY2Nlc3MiO2k6MjIzO3M6MjE6IndlZWtseS1ob2xpZGF5LWFjY2VzcyI7aToyMjQ7czoxODoid2Vla2x5LWhvbGlkYXktYWRkIjtpOjIyNTtzOjE5OiJ3ZWVrbHktaG9saWRheS1lZGl0IjtpOjIyNjtzOjIxOiJ3ZWVrbHktaG9saWRheS1kZWxldGUiO2k6MjI3O3M6MjY6IndlZWtseS1ob2xpZGF5LWJ1bGstZGVsZXRlIjtpOjIyODtzOjIxOiJ3ZWVrbHktaG9saWRheS1yZXBvcnQiO2k6MjI5O3M6MTQ6ImhvbGlkYXktYWNjZXNzIjtpOjIzMDtzOjExOiJob2xpZGF5LWFkZCI7aToyMzE7czoxMjoiaG9saWRheS1lZGl0IjtpOjIzMjtzOjE0OiJob2xpZGF5LWRlbGV0ZSI7aToyMzM7czoxOToiaG9saWRheS1idWxrLWRlbGV0ZSI7aToyMzQ7czoxNDoiaG9saWRheS1yZXBvcnQiO2k6MjM1O3M6MTc6ImxlYXZlLXR5cGUtYWNjZXNzIjtpOjIzNjtzOjE0OiJsZWF2ZS10eXBlLWFkZCI7aToyMzc7czoxNToibGVhdmUtdHlwZS1lZGl0IjtpOjIzODtzOjE3OiJsZWF2ZS10eXBlLWRlbGV0ZSI7aToyMzk7czoyMjoibGVhdmUtdHlwZS1idWxrLWRlbGV0ZSI7aToyNDA7czoxNzoibGVhdmUtdHlwZS1yZXBvcnQiO2k6MjQxO3M6MjQ6ImxlYXZlLWFwcGxpY2F0aW9uLWFjY2VzcyI7aToyNDI7czoyMToibGVhdmUtYXBwbGljYXRpb24tYWRkIjtpOjI0MztzOjIyOiJsZWF2ZS1hcHBsaWNhdGlvbi1lZGl0IjtpOjI0NDtzOjI0OiJsZWF2ZS1hcHBsaWNhdGlvbi1kZWxldGUiO2k6MjQ1O3M6Mjk6ImxlYXZlLWFwcGxpY2F0aW9uLWJ1bGstZGVsZXRlIjtpOjI0NjtzOjI0OiJsZWF2ZS1hcHBsaWNhdGlvbi1yZXBvcnQiO2k6MjQ3O3M6MjU6ImxlYXZlLWFwcGxpY2F0aW9uLWFwcHJvdmUiO2k6MjQ4O3M6MTU6ImJlbmlmaXRzLWFjY2VzcyI7aToyNDk7czoxMjoiYmVuaWZpdHMtYWRkIjtpOjI1MDtzOjEzOiJiZW5pZml0cy1lZGl0IjtpOjI1MTtzOjE1OiJiZW5pZml0cy1kZWxldGUiO2k6MjUyO3M6MjA6ImJlbmlmaXRzLWJ1bGstZGVsZXRlIjtpOjI1MztzOjE1OiJiZW5pZml0cy1yZXBvcnQiO2k6MjU0O3M6MTk6InNhbGFyeS1zZXR1cC1hY2Nlc3MiO2k6MjU1O3M6MTY6InNhbGFyeS1zZXR1cC1hZGQiO2k6MjU2O3M6MTc6InNhbGFyeS1zZXR1cC1lZGl0IjtpOjI1NztzOjE3OiJzYWxhcnktc2V0dXAtdmlldyI7aToyNTg7czoxOToic2FsYXJ5LXNldHVwLWRlbGV0ZSI7aToyNTk7czoyNDoic2FsYXJ5LXNldHVwLWJ1bGstZGVsZXRlIjtpOjI2MDtzOjE5OiJzYWxhcnktc2V0dXAtcmVwb3J0IjtpOjI2MTtzOjIyOiJzYWxhcnktZ2VuZXJhdGUtYWNjZXNzIjtpOjI2MjtzOjE5OiJzYWxhcnktZ2VuZXJhdGUtYWRkIjtpOjI2MztzOjIyOiJzYWxhcnktZ2VuZXJhdGUtZGVsZXRlIjtpOjI2NDtzOjI3OiJzYWxhcnktZ2VuZXJhdGUtYnVsay1kZWxldGUiO2k6MjY1O3M6MjI6InNhbGFyeS1nZW5lcmF0ZS1yZXBvcnQiO2k6MjY2O3M6MTI6InNoaWZ0LWFjY2VzcyI7aToyNjc7czo5OiJzaGlmdC1hZGQiO2k6MjY4O3M6MTA6InNoaWZ0LWVkaXQiO2k6MjY5O3M6MTI6InNoaWZ0LWRlbGV0ZSI7aToyNzA7czoxNzoic2hpZnQtYnVsay1kZWxldGUiO2k6MjcxO3M6MTI6InNoaWZ0LXJlcG9ydCI7aToyNzI7czoxOToic2hpZnQtbWFuYWdlLWFjY2VzcyI7aToyNzM7czoxNjoic2hpZnQtbWFuYWdlLWFkZCI7aToyNzQ7czoxNzoic2hpZnQtbWFuYWdlLWVkaXQiO2k6Mjc1O3M6MTk6InNoaWZ0LW1hbmFnZS1kZWxldGUiO2k6Mjc2O3M6MjQ6InNoaWZ0LW1hbmFnZS1idWxrLWRlbGV0ZSI7aToyNzc7czoxOToic2hpZnQtbWFuYWdlLXJlcG9ydCI7aToyNzg7czoyMToiZW1wbG95ZWUtc2hpZnQtY2hhbmdlIjtpOjI3OTtzOjIwOiJzdXBwbGllci1hZHZhbmNlLWFkZCI7aToyODA7czoyMToic3VwcGxpZXItYWR2YW5jZS1lZGl0IjtpOjI4MTtzOjIzOiJzdXBwbGllci1hZHZhbmNlLWRlbGV0ZSI7aToyODI7czoyODoic3VwcGxpZXItYWR2YW5jZS1idWxrLWRlbGV0ZSI7aToyODM7czoxNDoiY2xvc2luZy1hY2Nlc3MiO2k6Mjg0O3M6MjE6ImNsb3NpbmctcmVwb3J0LWFjY2VzcyI7aToyODU7czoyNToidG9kYXktc2FsZXMtcmVwb3J0LWFjY2VzcyI7aToyODY7czoxOToic2FsZXMtcmVwb3J0LWFjY2VzcyI7aToyODc7czozMjoicHJvZHVjdC13aXNlLXNhbGVzLXJlcG9ydC1hY2Nlc3MiO2k6Mjg4O3M6MjQ6IndhcmVob3VzZS1zdW1tYXJ5LWFjY2VzcyI7aToyODk7czozNDoibWF0ZXJpYWwtc3RvY2stYWxlcnQtcmVwb3J0LWFjY2VzcyI7aToyOTA7czoyMDoiZGViaXQtdm91Y2hlci1hY2Nlc3MiO2k6MjkxO3M6MjE6ImNyZWRpdC12b3VjaGVyLWFjY2VzcyI7aToyOTI7czoyMjoiY2FzaC1hZGp1c3RtZW50LWFjY2VzcyI7aToyOTM7czoxOToiY2FzaC1hZGp1c3RtZW50LWFkZCI7aToyOTQ7czoyMDoiY2FzaC1hZGp1c3RtZW50LWVkaXQiO2k6Mjk1O3M6MjI6ImNhc2gtYWRqdXN0bWVudC1kZWxldGUiO2k6Mjk2O3M6MjM6ImNhc2gtYWRqdXN0bWVudC1hcHByb3ZlIjtpOjI5NztzOjI3OiJwZXJzb25hbC1sb2FuLXBlcnNvbi1hY2Nlc3MiO2k6Mjk4O3M6MjQ6InBlcnNvbmFsLWxvYW4tcGVyc29uLWFkZCI7aToyOTk7czoyNToicGVyc29uYWwtbG9hbi1wZXJzb24tZWRpdCI7aTozMDA7czoyNzoicGVyc29uYWwtbG9hbi1wZXJzb24tZGVsZXRlIjtpOjMwMTtzOjMyOiJwZXJzb25hbC1sb2FuLXBlcnNvbi1idWxrLWRlbGV0ZSI7aTozMDI7czoyMDoicGVyc29uYWwtbG9hbi1hY2Nlc3MiO2k6MzAzO3M6MTc6InBlcnNvbmFsLWxvYW4tYWRkIjtpOjMwNDtzOjE4OiJwZXJzb25hbC1sb2FuLWVkaXQiO2k6MzA1O3M6MjA6InBlcnNvbmFsLWxvYW4tZGVsZXRlIjtpOjMwNjtzOjI1OiJwZXJzb25hbC1sb2FuLWJ1bGstZGVsZXRlIjtpOjMwNztzOjMyOiJwZXJzb25hbC1sb2FuLWluc3RhbGxtZW50LWFjY2VzcyI7aTozMDg7czoyOToicGVyc29uYWwtbG9hbi1pbnN0YWxsbWVudC1hZGQiO2k6MzA5O3M6MzA6InBlcnNvbmFsLWxvYW4taW5zdGFsbG1lbnQtZWRpdCI7aTozMTA7czozMjoicGVyc29uYWwtbG9hbi1pbnN0YWxsbWVudC1kZWxldGUiO2k6MzExO3M6Mzc6InBlcnNvbmFsLWxvYW4taW5zdGFsbG1lbnQtYnVsay1kZWxldGUiO2k6MzEyO3M6MjA6Im9mZmljaWFsLWxvYW4tYWNjZXNzIjtpOjMxMztzOjE3OiJvZmZpY2lhbC1sb2FuLWFkZCI7aTozMTQ7czoxODoib2ZmaWNpYWwtbG9hbi1lZGl0IjtpOjMxNTtzOjIwOiJvZmZpY2lhbC1sb2FuLWRlbGV0ZSI7aTozMTY7czoyNToib2ZmaWNpYWwtbG9hbi1idWxrLWRlbGV0ZSI7aTozMTc7czozMjoib2ZmaWNpYWwtbG9hbi1pbnN0YWxsbWVudC1hY2Nlc3MiO2k6MzE4O3M6Mjk6Im9mZmljaWFsLWxvYW4taW5zdGFsbG1lbnQtYWRkIjtpOjMxOTtzOjMwOiJvZmZpY2lhbC1sb2FuLWluc3RhbGxtZW50LWVkaXQiO2k6MzIwO3M6MzI6Im9mZmljaWFsLWxvYW4taW5zdGFsbG1lbnQtZGVsZXRlIjtpOjMyMTtzOjM3OiJvZmZpY2lhbC1sb2FuLWluc3RhbGxtZW50LWJ1bGstZGVsZXRlIjtpOjMyMjtzOjE4OiJsb2FuLXJlcG9ydC1hY2Nlc3MiO2k6MzIzO3M6MjA6ImJhbGFuY2Utc2hlZXQtYWNjZXNzIjtpOjMyNDtzOjIxOiJzYWxhcnktcGF5bWVudC1hY2Nlc3MiO2k6MzI1O3M6MTc6ImRlYml0LXZvdWNoZXItYWRkIjtpOjMyNjtzOjE4OiJjcmVkaXQtdm91Y2hlci1hZGQiO2k6MzI3O3M6MTE6InNhbGUtYWNjZXNzIjtpOjMyODtzOjg6InNhbGUtYWRkIjtpOjMyOTtzOjk6InNhbGUtZWRpdCI7aTozMzA7czo5OiJzYWxlLXZpZXciO2k6MzMxO3M6MTE6InNhbGUtZGVsZXRlIjtpOjMzMjtzOjE2OiJzYWxlLWJ1bGstZGVsZXRlIjtpOjMzMztzOjE4OiJzYWxlLXJldHVybi1hY2Nlc3MiO2k6MzM0O3M6MTU6InNhbGUtcmV0dXJuLWFkZCI7aTozMzU7czoxNjoic2FsZS1yZXR1cm4tdmlldyI7aTozMzY7czoxODoic2FsZS1yZXR1cm4tZGVsZXRlIjtpOjMzNztzOjMzOiJwcm9kdWN0LXN0b2NrLWFsZXJ0LXJlcG9ydC1hY2Nlc3MiO2k6MzM4O3M6MjE6Imludm9pY2UtcmVwb3J0LWFjY2VzcyI7aTozMzk7czoyMzoic2FsZXNtZW4tcGF5bWVudC1hY2Nlc3MiO2k6MzQwO3M6MjA6ImRlYWxlci1sZWRnZXItYWNjZXNzIjtpOjM0MTtzOjEzOiJkYW1hZ2UtYWNjZXNzIjtpOjM0MjtzOjI4OiJtYXRlcmlhbC1zdG9jay1sZWRnZXItYWNjZXNzIjtpOjM0MztzOjMxOiJtYXRlcmlhbC1zdG9jay1sZWRnZXItY29zdC12aWV3IjtpOjM0NDtzOjIxOiJwcm9kdWN0LWxlZGdlci1hY2Nlc3MiO2k6MzQ1O3M6MzE6InByb2R1Y3Qtc3RvY2stbGVkZ2VyLXByaWNlLXZpZXciO2k6MzQ2O3M6MTg6ImRlYml0LXZvdWNoZXItdmlldyI7aTozNDc7czoyMDoiZGViaXQtdm91Y2hlci1kZWxldGUiO2k6MzQ4O3M6MTk6ImNyZWRpdC12b3VjaGVyLXZpZXciO2k6MzQ5O3M6MjE6ImNyZWRpdC12b3VjaGVyLWRlbGV0ZSI7aTozNTA7czoyNToibWF0ZXJpYWwtc3RvY2stb3V0LWFjY2VzcyI7aTozNTE7czoyMjoibWF0ZXJpYWwtc3RvY2stb3V0LWFkZCI7aTozNTI7czoyMzoibWF0ZXJpYWwtc3RvY2stb3V0LWVkaXQiO2k6MzUzO3M6MjM6Im1hdGVyaWFsLXN0b2NrLW91dC12aWV3IjtpOjM1NDtzOjI1OiJtYXRlcmlhbC1zdG9jay1vdXQtZGVsZXRlIjtpOjM1NTtzOjMwOiJtYXRlcmlhbC1zdG9jay1vdXQtYnVsay1kZWxldGUiO2k6MzU2O3M6MzI6Im1hdGVyaWFsLXN0b2NrLW91dC1yZXBvcnQtYWNjZXNzIjtpOjM1NztzOjIwOiJwdXJjaGFzZS1wYXltZW50LWFkZCI7aTozNTg7czoyMToicHVyY2hhc2UtcGF5bWVudC1lZGl0IjtpOjM1OTtzOjIxOiJwdXJjaGFzZS1wYXltZW50LXZpZXciO2k6MzYwO3M6MjM6InB1cmNoYXNlLXBheW1lbnQtZGVsZXRlIjtpOjM2MTtzOjExOiJkZXBvLWFjY2VzcyI7aTozNjI7czo4OiJkZXBvLWFkZCI7aTozNjM7czo5OiJkZXBvLWVkaXQiO2k6MzY0O3M6MTE6ImRlcG8tZGVsZXRlIjtpOjM2NTtzOjE2OiJkZXBvLWJ1bGstZGVsZXRlIjtpOjM2NjtzOjE4OiJkZXBvLWxlZGdlci1hY2Nlc3MiO2k6MzY3O3M6MjA6Im9wZW5pbmctc3RvY2stYWNjZXNzIjtpOjM2ODtzOjE3OiJvcGVuaW5nLXN0b2NrLWFkZCI7aTozNjk7czoxODoib3BlbmluZy1zdG9jay1lZGl0IjtpOjM3MDtzOjE4OiJvcGVuaW5nLXN0b2NrLXZpZXciO2k6MzcxO3M6MjA6Im9wZW5pbmctc3RvY2stZGVsZXRlIjtpOjM3MjtzOjI1OiJvcGVuaW5nLXN0b2NrLWJ1bGstZGVsZXRlIjtpOjM3MztzOjk6ImRlcG8tdmlldyI7aTozNzQ7czoxOToiZGVwby1yZWNlaXZlLWFjY2VzcyI7aTozNzU7czoyMToiZGVhbGVyLXJlY2VpdmUtYWNjZXNzIjtpOjM3NjtzOjM2OiJ0b2RheXMtcHJvZHVjdGlvbi1vcmRlci1zaGVldC1hY2Nlc3MiO2k6Mzc3O3M6Mjk6InByb2R1Y3Rpb24tb3JkZXItc2hlZXQtYWNjZXNzIjtpOjM3ODtzOjI3OiJwcm9kdWN0aW9uLW9yZGVyLXNoZWV0LXZpZXciO2k6Mzc5O3M6Mjk6InByb2R1Y3Rpb24tb3JkZXItc2hlZXQtZGVsZXRlIjtpOjM4MDtzOjE5OiJkZXBvLWFkdmFuY2UtYWNjZXNzIjtpOjM4MTtzOjE2OiJkZXBvLWFkdmFuY2UtYWRkIjtpOjM4MjtzOjE3OiJkZXBvLWFkdmFuY2UtZWRpdCI7aTozODM7czoxOToiZGVwby1hZHZhbmNlLWRlbGV0ZSI7aTozODQ7czoyNDoiZGVwby1hZHZhbmNlLWJ1bGstZGVsZXRlIjtpOjM4NTtzOjIxOiJkZWFsZXItYWR2YW5jZS1hY2Nlc3MiO2k6Mzg2O3M6MTg6ImRlYWxlci1hZHZhbmNlLWFkZCI7aTozODc7czoxOToiZGVhbGVyLWFkdmFuY2UtZWRpdCI7aTozODg7czoyMToiZGVhbGVyLWFkdmFuY2UtZGVsZXRlIjtpOjM4OTtzOjI2OiJkZWFsZXItYWR2YW5jZS1idWxrLWRlbGV0ZSI7aTozOTA7czoyOToiZGVwby13aXNlLXNhbGVzLXJlcG9ydC1hY2Nlc3MiO2k6MzkxO3M6MzE6ImRlYWxlci13aXNlLXNhbGVzLXJlcG9ydC1hY2Nlc3MiO2k6MzkyO3M6Mzc6ImRlcG8td2lzZS1wcm9kdWN0LXNhbGVzLXJlcG9ydC1hY2Nlc3MiO2k6MzkzO3M6Mzk6ImRlYWxlci13aXNlLXByb2R1Y3Qtc2FsZXMtcmVwb3J0LWFjY2VzcyI7aTozOTQ7czoyNzoicHJvZHVjdC1zYWxlcy1yZXBvcnQtYWNjZXNzIjtpOjM5NTtzOjIxOiJkYW1hZ2UtcHJvZHVjdC1hY2Nlc3MiO2k6Mzk2O3M6MTg6ImRhbWFnZS1wcm9kdWN0LWFkZCI7aTozOTc7czoxOToiZGFtYWdlLXByb2R1Y3QtdmlldyI7aTozOTg7czoyMToiZGFtYWdlLXByb2R1Y3QtZGVsZXRlIjt9czo5OiJ1c2VyX21lbnUiO086MjY6IlR5cGlDTVNcTmVzdGFibGVDb2xsZWN0aW9uIjo4OntzOjg6IgAqAHRvdGFsIjtpOjI5O3M6MTU6IgAqAHBhcmVudENvbHVtbiI7czo5OiJwYXJlbnRfaWQiO3M6MzM6IgAqAHJlbW92ZUl0ZW1zV2l0aE1pc3NpbmdBbmNlc3RvciI7YjoxO3M6MTQ6IgAqAGluZGVudENoYXJzIjtzOjg6IsKgwqDCoMKgIjtzOjE1OiIAKgBjaGlsZHJlbk5hbWUiO3M6NToiaXRlbXMiO3M6MTc6IgAqAHBhcmVudFJlbGF0aW9uIjtzOjY6InBhcmVudCI7czo4OiIAKgBpdGVtcyI7YToyOTp7aTowO086MTc6IkFwcFxNb2RlbHNcTW9kdWxlIjoyOTp7czoxMToiACoAZmlsbGFibGUiO2E6OTp7aTowO3M6NzoibWVudV9pZCI7aToxO3M6NDoidHlwZSI7aToyO3M6MTE6Im1vZHVsZV9uYW1lIjtpOjM7czoxMzoiZGl2aWRlcl90aXRsZSI7aTo0O3M6MTA6Imljb25fY2xhc3MiO2k6NTtzOjM6InVybCI7aTo2O3M6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ZSI7aToxNTtzOjY6ImV4aXN0cyI7YjoxO3M6MTg6Indhc1JlY2VudGx5Q3JlYXRlZCI7YjowO3M6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDtzOjEzOiIAKgBhdHRyaWJ1dGVzIjthOjEyOntzOjI6ImlkIjtpOjI1MTtzOjc6Im1lbnVfaWQiO2k6MTtzOjQ6InR5cGUiO3M6MToiMiI7czoxMToibW9kdWxlX25hbWUiO3M6MjU6IkNyZWF0ZSBNYXRlcmlhbCBTdG9jayBPdXQiO3M6MTM6ImRpdmlkZXJfdGl0bGUiO047czoxMDoiaWNvbl9jbGFzcyI7TjtzOjM6InVybCI7czoyNToibWF0ZXJpYWwtc3RvY2stb3V0L2NyZWF0ZSI7czo1OiJvcmRlciI7aToxO3M6OToicGFyZW50X2lkIjtpOjI1MDtzOjY6InRhcmdldCI7czo1OiJfc2VsZiI7czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAyMS0xMC0xOSAxNDoxMzo0OCI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyMS0xMC0xOSAxNDoxNDowMCI7fXM6MTE6IgAqAG9yaWdpbmFsIjthOjEyOntzOjI6ImlkIjtpOjI1MTtzOjc6Im1lbnVfaWQiO2k6MTtzOjQ6InR5cGUiO3M6MToiMiI7czoxMToibW9kdWxlX25hbWUiO3M6MjU6IkNyZWF0ZSBNYXRlcmlhbCBTdG9jayBPdXQiO3M6MTM6ImRpdmlkZXJfdGl0bGUiO047czoxMDoiaWNvbl9jbGFzcyI7TjtzOjM6InVybCI7czoyNToibWF0ZXJpYWwtc3RvY2stb3V0L2NyZWF0ZSI7czo1OiJvcmRlciI7aToxO3M6OToicGFyZW50X2lkIjtpOjI1MDtzOjY6InRhcmdldCI7czo1OiJfc2VsZiI7czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAyMS0xMC0xOSAxNDoxMzo0OCI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyMS0xMC0xOSAxNDoxNDowMCI7fXM6MTA6IgAqAGNoYW5nZXMiO2E6MDp7fXM6ODoiACoAY2FzdHMiO2E6MDp7fXM6MTc6IgAqAGNsYXNzQ2FzdENhY2hlIjthOjA6e31zOjg6IgAqAGRhdGVzIjthOjA6e31zOjEzOiIAKgBkYXRlRm9ybWF0IjtOO3M6MTA6IgAqAGFwcGVuZHMiO2E6MDp7fXM6MTk6IgAqAGRpc3BhdGNoZXNFdmVudHMiO2E6MDp7fXM6MTQ6IgAqAG9ic2VydmFibGVzIjthOjA6e31zOjEyOiIAKgByZWxhdGlvbnMiO2E6MTp7czo4OiJjaGlsZHJlbiI7TzoyNjoiVHlwaUNNU1xOZXN0YWJsZUNvbGxlY3Rpb24iOjg6e3M6ODoiACoAdG90YWwiO2k6MDtzOjE1OiIAKgBwYXJlbnRDb2x1bW4iO3M6OToicGFyZW50X2lkIjtzOjMzOiIAKgByZW1vdmVJdGVtc1dpdGhNaXNzaW5nQW5jZXN0b3IiO2I6MTtzOjE0OiIAKgBpbmRlbnRDaGFycyI7czo4OiLCoMKgwqDCoCI7czoxNToiACoAY2hpbGRyZW5OYW1lIjtzOjU6Iml0ZW1zIjtzOjE3OiIAKgBwYXJlbnRSZWxhdGlvbiI7czo2OiJwYXJlbnQiO3M6ODoiACoAaXRlbXMiO2E6MDp7fXM6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDt9fXM6MTA6IgAqAHRvdWNoZXMiO2E6MDp7fXM6MTA6InRpbWVzdGFtcHMiO2I6MTtzOjk6IgAqAGhpZGRlbiI7YTowOnt9czoxMDoiACoAdmlzaWJsZSI7YTowOnt9czoxMDoiACoAZ3VhcmRlZCI7YToxOntpOjA7czoxOiIqIjt9fWk6MTtPOjE3OiJBcHBcTW9kZWxzXE1vZHVsZSI6Mjk6e3M6MTE6IgAqAGZpbGxhYmxlIjthOjk6e2k6MDtzOjc6Im1lbnVfaWQiO2k6MTtzOjQ6InR5cGUiO2k6MjtzOjExOiJtb2R1bGVfbmFtZSI7aTozO3M6MTM6ImRpdmlkZXJfdGl0bGUiO2k6NDtzOjEwOiJpY29uX2NsYXNzIjtpOjU7czozOiJ1cmwiO2k6NjtzOjU6Im9yZGVyIjtpOjc7czo5OiJwYXJlbnRfaWQiO2k6ODtzOjY6InRhcmdldCI7fXM6MTM6IgAqAGNvbm5lY3Rpb24iO3M6NToibXlzcWwiO3M6ODoiACoAdGFibGUiO3M6NzoibW9kdWxlcyI7czoxMzoiACoAcHJpbWFyeUtleSI7czoyOiJpZCI7czoxMDoiACoAa2V5VHlwZSI7czozOiJpbnQiO3M6MTI6ImluY3JlbWVudGluZyI7YjoxO3M6NzoiACoAd2l0aCI7YTowOnt9czoxMjoiACoAd2l0aENvdW50IjthOjA6e31zOjE5OiJwcmV2ZW50c0xhenlMb2FkaW5nIjtiOjA7czoxMDoiACoAcGVyUGFnZSI7aToxNTtzOjY6ImV4aXN0cyI7YjoxO3M6MTg6Indhc1JlY2VudGx5Q3JlYXRlZCI7YjowO3M6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDtzOjEzOiIAKgBhdHRyaWJ1dGVzIjthOjEyOntzOjI6ImlkIjtpOjI1MjtzOjc6Im1lbnVfaWQiO2k6MTtzOjQ6InR5cGUiO3M6MToiMiI7czoxMToibW9kdWxlX25hbWUiO3M6MjU6Ik1hbmFnZSBNYXRlcmlhbCBTdG9jayBPdXQiO3M6MTM6ImRpdmlkZXJfdGl0bGUiO047czoxMDoiaWNvbl9jbGFzcyI7TjtzOjM6InVybCI7czoxODoibWF0ZXJpYWwtc3RvY2stb3V0IjtzOjU6Im9yZGVyIjtpOjI7czo5OiJwYXJlbnRfaWQiO2k6MjUwO3M6NjoidGFyZ2V0IjtzOjU6Il9zZWxmIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDIxLTEwLTE5IDE0OjE0OjMxIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDIxLTEwLTE5IDE0OjE0OjM2Ijt9czoxMToiACoAb3JpZ2luYWwiO2E6MTI6e3M6MjoiaWQiO2k6MjUyO3M6NzoibWVudV9pZCI7aToxO3M6NDoidHlwZSI7czoxOiIyIjtzOjExOiJtb2R1bGVfbmFtZSI7czoyNToiTWFuYWdlIE1hdGVyaWFsIFN0b2NrIE91dCI7czoxMzoiZGl2aWRlcl90aXRsZSI7TjtzOjEwOiJpY29uX2NsYXNzIjtOO3M6MzoidXJsIjtzOjE4OiJtYXRlcmlhbC1zdG9jay1vdXQiO3M6NToib3JkZXIiO2k6MjtzOjk6InBhcmVudF9pZCI7aToyNTA7czo2OiJ0YXJnZXQiO3M6NToiX3NlbGYiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjEtMTAtMTkgMTQ6MTQ6MzEiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjEtMTAtMTkgMTQ6MTQ6MzYiO31zOjEwOiIAKgBjaGFuZ2VzIjthOjA6e31zOjg6IgAqAGNhc3RzIjthOjA6e31zOjE3OiIAKgBjbGFzc0Nhc3RDYWNoZSI7YTowOnt9czo4OiIAKgBkYXRlcyI7YTowOnt9czoxMzoiACoAZGF0ZUZvcm1hdCI7TjtzOjEwOiIAKgBhcHBlbmRzIjthOjA6e31zOjE5OiIAKgBkaXNwYXRjaGVzRXZlbnRzIjthOjA6e31zOjE0OiIAKgBvYnNlcnZhYmxlcyI7YTowOnt9czoxMjoiACoAcmVsYXRpb25zIjthOjE6e3M6ODoiY2hpbGRyZW4iO086MjY6IlR5cGlDTVNcTmVzdGFibGVDb2xsZWN0aW9uIjo4OntzOjg6IgAqAHRvdGFsIjtpOjA7czoxNToiACoAcGFyZW50Q29sdW1uIjtzOjk6InBhcmVudF9pZCI7czozMzoiACoAcmVtb3ZlSXRlbXNXaXRoTWlzc2luZ0FuY2VzdG9yIjtiOjE7czoxNDoiACoAaW5kZW50Q2hhcnMiO3M6ODoiwqDCoMKgwqAiO3M6MTU6IgAqAGNoaWxkcmVuTmFtZSI7czo1OiJpdGVtcyI7czoxNzoiACoAcGFyZW50UmVsYXRpb24iO3M6NjoicGFyZW50IjtzOjg6IgAqAGl0ZW1zIjthOjA6e31zOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7fX1zOjEwOiIAKgB0b3VjaGVzIjthOjA6e31zOjEwOiJ0aW1lc3RhbXBzIjtiOjE7czo5OiIAKgBoaWRkZW4iO2E6MDp7fXM6MTA6IgAqAHZpc2libGUiO2E6MDp7fXM6MTA6IgAqAGd1YXJkZWQiO2E6MTp7aTowO3M6MToiKiI7fX1pOjI7TzoxNzoiQXBwXE1vZGVsc1xNb2R1bGUiOjI5OntzOjExOiIAKgBmaWxsYWJsZSI7YTo5OntpOjA7czo3OiJtZW51X2lkIjtpOjE7czo0OiJ0eXBlIjtpOjI7czoxMToibW9kdWxlX25hbWUiO2k6MztzOjEzOiJkaXZpZGVyX3RpdGxlIjtpOjQ7czoxMDoiaWNvbl9jbGFzcyI7aTo1O3M6MzoidXJsIjtpOjY7czo1OiJvcmRlciI7aTo3O3M6OToicGFyZW50X2lkIjtpOjg7czo2OiJ0YXJnZXQiO31zOjEzOiIAKgBjb25uZWN0aW9uIjtzOjU6Im15c3FsIjtzOjg6IgAqAHRhYmxlIjtzOjc6Im1vZHVsZXMiO3M6MTM6IgAqAHByaW1hcnlLZXkiO3M6MjoiaWQiO3M6MTA6IgAqAGtleVR5cGUiO3M6MzoiaW50IjtzOjEyOiJpbmNyZW1lbnRpbmciO2I6MTtzOjc6IgAqAHdpdGgiO2E6MDp7fXM6MTI6IgAqAHdpdGhDb3VudCI7YTowOnt9czoxOToicHJldmVudHNMYXp5TG9hZGluZyI7YjowO3M6MTA6IgAqAHBlclBhZ2UiO2k6MTU7czo2OiJleGlzdHMiO2I6MTtzOjE4OiJ3YXNSZWNlbnRseUNyZWF0ZWQiO2I6MDtzOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7czoxMzoiACoAYXR0cmlidXRlcyI7YToxMjp7czoyOiJpZCI7aToyNTM7czo3OiJtZW51X2lkIjtpOjE7czo0OiJ0eXBlIjtzOjE6IjIiO3M6MTE6Im1vZHVsZV9uYW1lIjtzOjI1OiJNYXRlcmlhbCBTdG9jayBPdXQgUmVwb3J0IjtzOjEzOiJkaXZpZGVyX3RpdGxlIjtOO3M6MTA6Imljb25fY2xhc3MiO047czozOiJ1cmwiO3M6MjU6Im1hdGVyaWFsLXN0b2NrLW91dC9yZXBvcnQiO3M6NToib3JkZXIiO2k6MztzOjk6InBhcmVudF9pZCI7aToyNTA7czo2OiJ0YXJnZXQiO3M6NToiX3NlbGYiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjEtMTAtMTkgMTQ6MTU6MzUiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjEtMTAtMTkgMTQ6MTU6MzgiO31zOjExOiIAKgBvcmlnaW5hbCI7YToxMjp7czoyOiJpZCI7aToyNTM7czo3OiJtZW51X2lkIjtpOjE7czo0OiJ0eXBlIjtzOjE6IjIiO3M6MTE6Im1vZHVsZV9uYW1lIjtzOjI1OiJNYXRlcmlhbCBTdG9jayBPdXQgUmVwb3J0IjtzOjEzOiJkaXZpZGVyX3RpdGxlIjtOO3M6MTA6Imljb25fY2xhc3MiO047czozOiJ1cmwiO3M6MjU6Im1hdGVyaWFsLXN0b2NrLW91dC9yZXBvcnQiO3M6NToib3JkZXIiO2k6MztzOjk6InBhcmVudF9pZCI7aToyNTA7czo2OiJ0YXJnZXQiO3M6NToiX3NlbGYiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjEtMTAtMTkgMTQ6MTU6MzUiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjEtMTAtMTkgMTQ6MTU6MzgiO31zOjEwOiIAKgBjaGFuZ2VzIjthOjA6e31zOjg6IgAqAGNhc3RzIjthOjA6e31zOjE3OiIAKgBjbGFzc0Nhc3RDYWNoZSI7YTowOnt9czo4OiIAKgBkYXRlcyI7YTowOnt9czoxMzoiACoAZGF0ZUZvcm1hdCI7TjtzOjEwOiIAKgBhcHBlbmRzIjthOjA6e31zOjE5OiIAKgBkaXNwYXRjaGVzRXZlbnRzIjthOjA6e31zOjE0OiIAKgBvYnNlcnZhYmxlcyI7YTowOnt9czoxMjoiACoAcmVsYXRpb25zIjthOjE6e3M6ODoiY2hpbGRyZW4iO086MjY6IlR5cGlDTVNcTmVzdGFibGVDb2xsZWN0aW9uIjo4OntzOjg6IgAqAHRvdGFsIjtpOjA7czoxNToiACoAcGFyZW50Q29sdW1uIjtzOjk6InBhcmVudF9pZCI7czozMzoiACoAcmVtb3ZlSXRlbXNXaXRoTWlzc2luZ0FuY2VzdG9yIjtiOjE7czoxNDoiACoAaW5kZW50Q2hhcnMiO3M6ODoiwqDCoMKgwqAiO3M6MTU6IgAqAGNoaWxkcmVuTmFtZSI7czo1OiJpdGVtcyI7czoxNzoiACoAcGFyZW50UmVsYXRpb24iO3M6NjoicGFyZW50IjtzOjg6IgAqAGl0ZW1zIjthOjA6e31zOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7fX1zOjEwOiIAKgB0b3VjaGVzIjthOjA6e31zOjEwOiJ0aW1lc3RhbXBzIjtiOjE7czo5OiIAKgBoaWRkZW4iO2E6MDp7fXM6MTA6IgAqAHZpc2libGUiO2E6MDp7fXM6MTA6IgAqAGd1YXJkZWQiO2E6MTp7aTowO3M6MToiKiI7fX19czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO319czoxMDoiACoAdG91Y2hlcyI7YTowOnt9czoxMDoidGltZXN0YW1wcyI7YjoxO3M6OToiACoAaGlkZGVuIjthOjA6e31zOjEwOiIAKgB2aXNpYmxlIjthOjA6e31zOjEwOiIAKgBndWFyZGVkIjthOjE6e2k6MDtzOjE6IioiO319aTo2O086MTc6IkFwcFxNb2RlbHNcTW9kdWxlIjoyOTp7czoxMToiACoAZmlsbGFibGUiO2E6OTp7aTowO3M6NzoibWVudV9pZCI7aToxO3M6NDoidHlwZSI7aToyO3M6MTE6Im1vZHVsZV9uYW1lIjtpOjM7czoxMzoiZGl2aWRlcl90aXRsZSI7aTo0O3M6MTA6Imljb25fY2xhc3MiO2k6NTtzOjM6InVybCI7aTo2O3M6NToib3JkZXIiO2k6NztzOjk6InBhcmVudF9pZCI7aTo4O3M6NjoidGFyZ2V0Ijt9czoxMzoiACoAY29ubmVjdGlvbiI7czo1OiJteXNxbCI7czo4OiIAKgB0YWJsZSI7czo3OiJtb2R1bGVzIjtzOjEzOiIAKgBwcmltYXJ5S2V5IjtzOjI6ImlkIjtzOjEwOiIAKgBrZXlUeXBlIjtzOjM6ImludCI7czoxMjoiaW5jcmVtZW50aW5nIjtiOjE7czo3OiIAKgB3aXRoIjthOjA6e31zOjEyOiIAKgB3aXRoQ291bnQiO2E6MDp7fXM6MTk6InByZXZlbnRzTGF6eUxvYWRpbmciO2I6MDtzOjEwOiIAKgBwZXJQYWdlIjtpOjE1O3M6NjoiZXhpc3RzIjtiOjE7czoxODoid2FzUmVjZW50bHlDcmVhdGVkIjtiOjA7czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO3M6MTM6IgAqAGF0dHJpYnV0ZXMiO2E6MTI6e3M6MjoiaWQiO2k6MzM7czo3OiJtZW51X2lkIjtpOjE7czo0OiJ0eXBlIjtzOjE6IjIiO3M6MTE6Im1vZHVsZV9uYW1lIjtzOjEwOiJQcm9kdWN0aW9uIjtzOjEzOiJkaXZpZGVyX3RpdGxlIjtOO3M6MTA6Imljb25fY2xhc3MiO3M6MTU6ImZhcyBmYS1pbmR1c3RyeSI7czozOiJ1cmwiO047czo1OiJvcmRlciI7aTo3O3M6OToicGFyZW50X2lkIjtOO3M6NjoidGFyZ2V0IjtOO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjEtMDctMTMgMTE6NDc6NDciO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjEtMTEtMTggMTc6MjA6MjIiO31zOjExOiIAKgBvcmlnaW5hbCI7YToxMjp7czoyOiJpZCI7aTozMztzOjc6Im1lbnVfaWQiO2k6MTtzOjQ6InR5cGUiO3M6MToiMiI7czoxMToibW9kdWxlX25hbWUiO3M6MTA6IlByb2R1Y3Rpb24iO3M6MTM6ImRpdmlkZXJfdGl0bGUiO047czoxMDoiaWNvbl9jbGFzcyI7czoxNToiZmFzIGZhLWluZHVzdHJ5IjtzOjM6InVybCI7TjtzOjU6Im9yZGVyIjtpOjc7czo5OiJwYXJlbnRfaWQiO047czo2OiJ0YXJnZXQiO047czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAyMS0wNy0xMyAxMTo0Nzo0NyI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyMS0xMS0xOCAxNzoyMDoyMiI7fXM6MTA6IgAqAGNoYW5nZXMiO2E6MDp7fXM6ODoiACoAY2FzdHMiO2E6MDp7fXM6MTc6IgAqAGNsYXNzQ2FzdENhY2hlIjthOjA6e31zOjg6IgAqAGRhdGVzIjthOjA6e31zOjEzOiIAKgBkYXRlRm9ybWF0IjtOO3M6MTA6IgAqAGFwcGVuZHMiO2E6MDp7fXM6MTk6IgAqAGRpc3BhdGNoZXNFdmVudHMiO2E6MDp7fXM6MTQ6IgAqAG9ic2VydmFibGVzIjthOjA6e31zOjEyOiIAKgByZWxhdGlvbnMiO2E6MTp7czo4OiJjaGlsZHJlbiI7TzoyNjoiVHlwaUNNU1xOZXN0YWJsZUNvbGxlY3Rpb24iOjg6e3M6ODoiACoAdG90YWwiO2k6NDtzOjE1OiIAKgBwYXJlbnRDb2x1bW4iO3M6OToicGFyZW50X2lkIjtzOjMzOiIAKgByZW1vdmVJdGVtc1dpdGhNaXNzaW5nQW5jZXN0b3IiO2I6MTtzOjE0OiIAKgBpbmRlbnRDaGFycyI7czo4OiLCoMKgwqDCoCI7czoxNToiACoAY2hpbGRyZW5OYW1lIjtzOjU6Iml0ZW1zIjtzOjE3OiIAKgBwYXJlbnRSZWxhdGlvbiI7czo2OiJwYXJlbnQiO3M6ODoiACoAaXRlbXMiO2E6NDp7aTowO086MTc6IkFwcFxNb2RlbHNcTW9kdWxlIjoyOTp7czoxMToiACoAZmlsbGFibGUiO2E6OTp7aTowO3M6NzoibWVudV9pZCI7aToxO3M6NDoidHlwZSI7aToyO3M6MTE6Im1vZHVsZV9uYW1lIjtpOjM7czoxMzoiZGl2aWRlcl90aXRsZSI7aTo0O3M6MTA6Imljb25fY2xhc3MiO2k6NTtzOjM6InVybCI7aTo2O3M6NToib3JkZXIiO2k6NztzOjk6InBhcmVudF9pZCI7aTo4O3M6NjoidGFyZ2V0Ijt9czoxMzoiACoAY29ubmVjdGlvbiI7czo1OiJteXNxbCI7czo4OiIAKgB0YWJsZSI7czo3OiJtb2R1bGVzIjtzOjEzOiIAKgBwcmltYXJ5S2V5IjtzOjI6ImlkIjtzOjEwOiIAKgBrZXlUeXBlIjtzOjM6ImludCI7czoxMjoiaW5jcmVtZW50aW5nIjtiOjE7czo3OiIAKgB3aXRoIjthOjA6e31zOjEyOiIAKgB3aXRoQ291bnQiO2E6MDp7fXM6MTk6InByZXZlbnRzTGF6eUxvYWRpbmciO2I6MDtzOjEwOiIAKgBwZXJQYWdlIjtpOjE1O3M6NjoiZXhpc3RzIjtiOjE7czoxODoid2FzUmVjZW50bHlDcmVhdGVkIjtiOjA7czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO3M6MTM6IgAqAGF0dHJpYnV0ZXMiO2E6MTI6e3M6MjoiaWQiO2k6Mjk7czo3OiJtZW51X2lkIjtpOjE7czo0OiJ0eXBlIjtzOjE6IjIiO3M6MTE6Im1vZHVsZV9uYW1lIjtzOjIyOiJBZGQgRmluaXNoIEdvb2RzIFN0b2NrIjtzOjEzOiJkaXZpZGVyX3RpdGxlIjtOO3M6MTA6Imljb25fY2xhc3MiO047czozOiJ1cmwiO3M6MjI6ImZpbmlzaC1nb29kcy1zdG9jay9hZGQiO3M6NToib3JkZXIiO2k6MTtzOjk6InBhcmVudF9pZCI7aTozMztzOjY6InRhcmdldCI7czo1OiJfc2VsZiI7czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAyMS0wNy0xMyAxMDo1NDoyMSI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyMS0xMC0yNyAxNDo1OTozNCI7fXM6MTE6IgAqAG9yaWdpbmFsIjthOjEyOntzOjI6ImlkIjtpOjI5O3M6NzoibWVudV9pZCI7aToxO3M6NDoidHlwZSI7czoxOiIyIjtzOjExOiJtb2R1bGVfbmFtZSI7czoyMjoiQWRkIEZpbmlzaCBHb29kcyBTdG9jayI7czoxMzoiZGl2aWRlcl90aXRsZSI7TjtzOjEwOiJpY29uX2NsYXNzIjtOO3M6MzoidXJsIjtzOjIyOiJmaW5pc2gtZ29vZHMtc3RvY2svYWRkIjtzOjU6Im9yZGVyIjtpOjE7czo5OiJwYXJlbnRfaWQiO2k6MzM7czo2OiJ0YXJnZXQiO3M6NToiX3NlbGYiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjEtMDctMTMgMTA6NTQ6MjEiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjEtMTAtMjcgMTQ6NTk6MzQiO31zOjEwOiIAKgBjaGFuZ2VzIjthOjA6e31zOjg6IgAqAGNhc3RzIjthOjA6e31zOjE3OiIAKgBjbGFzc0Nhc3RDYWNoZSI7YTowOnt9czo4OiIAKgBkYXRlcyI7YTowOnt9czoxMzoiACoAZGF0ZUZvcm1hdCI7TjtzOjEwOiIAKgBhcHBlbmRzIjthOjA6e31zOjE5OiIAKgBkaXNwYXRjaGVzRXZlbnRzIjthOjA6e31zOjE0OiIAKgBvYnNlcnZhYmxlcyI7YTowOnt9czoxMjoiACoAcmVsYXRpb25zIjthOjE6e3M6ODoiY2hpbGRyZW4iO086MjY6IlR5cGlDTVNcTmVzdGFibGVDb2xsZWN0aW9uIjo4OntzOjg6IgAqAHRvdGFsIjtpOjA7czoxNToiACoAcGFyZW50Q29sdW1uIjtzOjk6InBhcmVudF9pZCI7czozMzoiACoAcmVtb3ZlSXRlbXNXaXRoTWlzc2luZ0FuY2VzdG9yIjtiOjE7czoxNDoiACoAaW5kZW50Q2hhcnMiO3M6ODoiwqDCoMKgwqAiO3M6MTU6IgAqAGNoaWxkcmVuTmFtZSI7czo1OiJpdGVtcyI7czoxNzoiACoAcGFyZW50UmVsYXRpb24iO3M6NjoicGFyZW50IjtzOjg6IgAqAGl0ZW1zIjthOjA6e31zOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7fX1zOjEwOiIAKgB0b3VjaGVzIjthOjA6e31zOjEwOiJ0aW1lc3RhbXBzIjtiOjE7czo5OiIAKgBoaWRkZW4iO2E6MDp7fXM6MTA6IgAqAHZpc2libGUiO2E6MDp7fXM6MTA6IgAqAGd1YXJkZWQiO2E6MTp7aTowO3M6MToiKiI7fX1pOjE7TzoxNzoiQXBwXE1vZGVsc1xNb2R1bGUiOjI5OntzOjExOiIAKgBmaWxsYWJsZSI7YTo5OntpOjA7czo3OiJtZW51X2lkIjtpOjE7czo0OiJ0eXBlIjtpOjI7czoxMToibW9kdWxlX25hbWUiO2k6MztzOjEzOiJkaXZpZGVyX3RpdGxlIjtpOjQ7czoxMDoiaWNvbl9jbGFzcyI7aTo1O3M6MzoidXJsIjtpOjY7czo1OiJvcmRlciI7aTo3O3M6OToicGFyZW50X2lkIjtpOjg7czo2OiJ0YXJnZXQiO31zOjEzOiIAKgBjb25uZWN0aW9uIjtzOjU6Im15c3FsIjtzOjg6IgAqAHRhYmxlIjtzOjc6Im1vZHVsZXMiO3M6MTM6IgAqAHByaW1hcnlLZXkiO3M6MjoiaWQiO3M6MTA6IgAqAGtleVR5cGUiO3M6MzoiaW50IjtzOjEyOiJpbmNyZW1lbnRpbmciO2I6MTtzOjc6IgAqAHdpdGgiO2E6MDp7fXM6MTI6IgAqAHdpdGhDb3VudCI7YTowOnt9czoxOToicHJldmVudHNMYXp5TG9hZGluZyI7YjowO3M6MTA6IgAqAHBlclBhZ2UiO2k6MTU7czo2OiJleGlzdHMiO2I6MTtzOjE4OiJ3YXNSZWNlbnRseUNyZWF0ZWQiO2I6MDtzOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7czoxMzoiACoAYXR0cmlidXRlcyI7YToxMjp7czoyOiJpZCI7aTozMDtzOjc6Im1lbnVfaWQiO2k6MTtzOjQ6InR5cGUiO3M6MToiMiI7czoxMToibW9kdWxlX25hbWUiO3M6MjU6Ik1hbmFnZSBGaW5pc2ggR29vZHMgU3RvY2siO3M6MTM6ImRpdmlkZXJfdGl0bGUiO047czoxMDoiaWNvbl9jbGFzcyI7TjtzOjM6InVybCI7czoxODoiZmluaXNoLWdvb2RzLXN0b2NrIjtzOjU6Im9yZGVyIjtpOjI7czo5OiJwYXJlbnRfaWQiO2k6MzM7czo2OiJ0YXJnZXQiO3M6NToiX3NlbGYiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjEtMDctMTMgMTA6NTU6MjMiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjEtMTAtMjcgMTQ6NTk6NDAiO31zOjExOiIAKgBvcmlnaW5hbCI7YToxMjp7czoyOiJpZCI7aTozMDtzOjc6Im1lbnVfaWQiO2k6MTtzOjQ6InR5cGUiO3M6MToiMiI7czoxMToibW9kdWxlX25hbWUiO3M6MjU6Ik1hbmFnZSBGaW5pc2ggR29vZHMgU3RvY2siO3M6MTM6ImRpdmlkZXJfdGl0bGUiO047czoxMDoiaWNvbl9jbGFzcyI7TjtzOjM6InVybCI7czoxODoiZmluaXNoLWdvb2RzLXN0b2NrIjtzOjU6Im9yZGVyIjtpOjI7czo5OiJwYXJlbnRfaWQiO2k6MzM7czo2OiJ0YXJnZXQiO3M6NToiX3NlbGYiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjEtMDctMTMgMTA6NTU6MjMiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjEtMTAtMjcgMTQ6NTk6NDAiO31zOjEwOiIAKgBjaGFuZ2VzIjthOjA6e31zOjg6IgAqAGNhc3RzIjthOjA6e31zOjE3OiIAKgBjbGFzc0Nhc3RDYWNoZSI7YTowOnt9czo4OiIAKgBkYXRlcyI7YTowOnt9czoxMzoiACoAZGF0ZUZvcm1hdCI7TjtzOjEwOiIAKgBhcHBlbmRzIjthOjA6e31zOjE5OiIAKgBkaXNwYXRjaGVzRXZlbnRzIjthOjA6e31zOjE0OiIAKgBvYnNlcnZhYmxlcyI7YTowOnt9czoxMjoiACoAcmVsYXRpb25zIjthOjE6e3M6ODoiY2hpbGRyZW4iO086MjY6IlR5cGlDTVNcTmVzdGFibGVDb2xsZWN0aW9uIjo4OntzOjg6IgAqAHRvdGFsIjtpOjA7czoxNToiACoAcGFyZW50Q29sdW1uIjtzOjk6InBhcmVudF9pZCI7czozMzoiACoAcmVtb3ZlSXRlbXNXaXRoTWlzc2luZ0FuY2VzdG9yIjtiOjE7czoxNDoiACoAaW5kZW50Q2hhcnMiO3M6ODoiwqDCoMKgwqAiO3M6MTU6IgAqAGNoaWxkcmVuTmFtZSI7czo1OiJpdGVtcyI7czoxNzoiACoAcGFyZW50UmVsYXRpb24iO3M6NjoicGFyZW50IjtzOjg6IgAqAGl0ZW1zIjthOjA6e31zOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7fX1zOjEwOiIAKgB0b3VjaGVzIjthOjA6e31zOjEwOiJ0aW1lc3RhbXBzIjtiOjE7czo5OiIAKgBoaWRkZW4iO2E6MDp7fXM6MTA6IgAqAHZpc2libGUiO2E6MDp7fXM6MTA6IgAqAGd1YXJkZWQiO2E6MTp7aTowO3M6MToiKiI7fX1pOjI7TzoxNzoiQXBwXE1vZGVsc1xNb2R1bGUiOjI5OntzOjExOiIAKgBmaWxsYWJsZSI7YTo5OntpOjA7czo3OiJtZW51X2lkIjtpOjE7czo0OiJ0eXBlIjtpOjI7czoxMToibW9kdWxlX25hbWUiO2k6MztzOjEzOiJkaXZpZGVyX3RpdGxlIjtpOjQ7czoxMDoiaWNvbl9jbGFzcyI7aTo1O3M6MzoidXJsIjtpOjY7czo1OiJvcmRlciI7aTo3O3M6OToicGFyZW50X2lkIjtpOjg7czo2OiJ0YXJnZXQiO31zOjEzOiIAKgBjb25uZWN0aW9uIjtzOjU6Im15c3FsIjtzOjg6IgAqAHRhYmxlIjtzOjc6Im1vZHVsZXMiO3M6MTM6IgAqAHByaW1hcnlLZXkiO3M6MjoiaWQiO3M6MTA6IgAqAGtleVR5cGUiO3M6MzoiaW50IjtzOjEyOiJpbmNyZW1lbnRpbmciO2I6MTtzOjc6IgAqAHdpdGgiO2E6MDp7fXM6MTI6IgAqAHdpdGhDb3VudCI7YTowOnt9czoxOToicHJldmVudHNMYXp5TG9hZGluZyI7YjowO3M6MTA6IgAqAHBlclBhZ2UiO2k6MTU7czo2OiJleGlzdHMiO2I6MTtzOjE4OiJ3YXNSZWNlbnRseUNyZWF0ZWQiO2I6MDtzOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7czoxMzoiACoAYXR0cmlidXRlcyI7YToxMjp7czoyOiJpZCI7aToyNjM7czo3OiJtZW51X2lkIjtpOjE7czo0OiJ0eXBlIjtzOjE6IjIiO3M6MTE6Im1vZHVsZV9uYW1lIjtzOjMwOiJUb2RheSdzIFByb2R1Y3Rpb24gT3JkZXIgU2hlZXQiO3M6MTM6ImRpdmlkZXJfdGl0bGUiO047czoxMDoiaWNvbl9jbGFzcyI7TjtzOjM6InVybCI7czoyOToidG9kYXlzLXByb2R1Y3Rpb24tb3JkZXItc2hlZXQiO3M6NToib3JkZXIiO2k6MztzOjk6InBhcmVudF9pZCI7aTozMztzOjY6InRhcmdldCI7czo1OiJfc2VsZiI7czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAyMS0xMC0zMSAxMDozMzozOCI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyMS0xMC0zMSAxMDozNDozOSI7fXM6MTE6IgAqAG9yaWdpbmFsIjthOjEyOntzOjI6ImlkIjtpOjI2MztzOjc6Im1lbnVfaWQiO2k6MTtzOjQ6InR5cGUiO3M6MToiMiI7czoxMToibW9kdWxlX25hbWUiO3M6MzA6IlRvZGF5J3MgUHJvZHVjdGlvbiBPcmRlciBTaGVldCI7czoxMzoiZGl2aWRlcl90aXRsZSI7TjtzOjEwOiJpY29uX2NsYXNzIjtOO3M6MzoidXJsIjtzOjI5OiJ0b2RheXMtcHJvZHVjdGlvbi1vcmRlci1zaGVldCI7czo1OiJvcmRlciI7aTozO3M6OToicGFyZW50X2lkIjtpOjMzO3M6NjoidGFyZ2V0IjtzOjU6Il9zZWxmIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDIxLTEwLTMxIDEwOjMzOjM4IjtzOjEwOiJ1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dGhDb3VudCI7YTowOnt9czoxOToicHJldmVudHNMYXp5TG9hZGluZyI7YjowO3M6MTA6IgAqAHBlclBhZ2UiO2k6MTU7czo2OiJleGlzdHMiO2I6MTtzOjE4OiJ3YXNSZWNlbnRseUNyZWF0ZWQiO2I6MDtzOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7czoxMzoiACoAYXR0cmlidXRlcyI7YToxMjp7czoyOiJpZCI7aTo4MDtzOjc6Im1lbnVfaWQiO2k6MTtzOjQ6InR5cGUiO3M6MToiMiI7czoxMToibW9kdWxlX25hbWUiO3M6MTM6IkRlYml0IFZvdWNoZXIiO3M6MTM6ImRpdmlkZXJfdGl0bGUiO047czoxMDoiaWNvbl9jbGFzcyI7TjtzOjM6InVybCI7czoyMDoiZGViaXQtdm91Y2hlci9jcmVhdGUiO3M6NToib3JkZXIiO2k6ODtzOjk6InBhcmVudF9pZCI7aTo3NDtzOjY6InRhcmdldCI7czo1OiJfc2VsZiI7czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAyMS0wMy0yNyAwMDo1NDo1MiI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyMS0xMC0zMSAxMDozNDozOSI7fXM6MTE6IgAqAG9yaWdpbmFsIjthOjEyOntzOjI6ImlkIjtpOjgwO3M6NzoibWVudV9pZCI7aToxO3M6NDoidHlwZSI7czoxOiIyIjtzOjExOiJtb2R1bGVfbmFtZSI7czoxMzoiRGViaXQgVm91Y2hlciI7czoxMzoiZGl2aWRlcl90aXRsZSI7TjtzOjEwOiJpY29uX2NsYXNzIjtOO3M6MzoidXJsIjtzOjIwOiJkZWJpdC12b3VjaGVyL2NyZWF0ZSI7czo1OiJvcmRlciI7aTo4O3M6OToicGFyZW50X2lkIjtpOjc0O3M6NjoidGFyZ2V0IjtzOjU6Il9zZWxmIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDIxLTAzLTI3IDAwOjU0OjUyIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDIxLTEwLTMxIDEwOjM0OjM5Ijt9czoxMDoiACoAY2hhbmdlcyI7YTowOnt9czo4OiIAKgBjYXN0cyI7YTow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Ont9czoxOToicHJldmVudHNMYXp5TG9hZGluZyI7YjowO3M6MTA6IgAqAHBlclBhZ2UiO2k6MTU7czo2OiJleGlzdHMiO2I6MTtzOjE4OiJ3YXNSZWNlbnRseUNyZWF0ZWQiO2I6MDtzOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7czoxMzoiACoAYXR0cmlidXRlcyI7YToxMjp7czoyOiJpZCI7aTo4NDtzOjc6Im1lbnVfaWQiO2k6MTtzOjQ6InR5cGUiO3M6MToiMiI7czoxMToibW9kdWxlX25hbWUiO3M6MTU6IkpvdXJuYWwgVm91Y2hlciI7czoxMzoiZGl2aWRlcl90aXRsZSI7TjtzOjEwOiJpY29uX2NsYXNzIjtOO3M6MzoidXJsIjtzOjIyOiJqb3VybmFsLXZvdWNoZXIvY3JlYXRlIjtzOjU6Im9yZGVyIjtpOjE0O3M6OToicGFyZW50X2lkIjtpOjc0O3M6NjoidGFyZ2V0IjtzOjU6Il9zZWxmIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDIxLTAzLTI3IDAwOjU1OjUwIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDIxLTEwLTMxIDEwOjM0OjM5Ijt9czoxMToiACoAb3JpZ2luYWwiO2E6MTI6e3M6MjoiaWQiO2k6ODQ7czo3OiJtZW51X2lkIjtpOjE7czo0OiJ0eXBlIjtzOjE6IjIiO3M6MTE6Im1vZHVsZV9uYW1lIjtzOjE1OiJKb3VybmFsIFZvdWNoZXIiO3M6MTM6ImRpdmlkZXJfdGl0bGUiO047czoxMDoiaWNvbl9jbGFzcyI7TjtzOjM6InVybCI7czoyMjoiam91cm5hbC12b3VjaGVyL2NyZWF0ZSI7czo1OiJvcmRlciI7aToxNDtzOjk6InBhcmVudF9pZCI7aTo3NDtzOjY6InRhcmdldCI7czo1OiJfc2VsZiI7czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAyMS0wMy0yNyAwMDo1NTo1MCI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyMS0xMC0zMSAxMDozNDozOSI7fXM6MTA6IgAqAGNoYW5nZXMiO2E6MDp7fXM6ODoiACoAY2FzdHMiO2E6MDp7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AHdpdGhDb3VudCI7YTowOnt9czoxOToicHJldmVudHNMYXp5TG9hZGluZyI7YjowO3M6MTA6IgAqAHBlclBhZ2UiO2k6MTU7czo2OiJleGlzdHMiO2I6MTtzOjE4OiJ3YXNSZWNlbnRseUNyZWF0ZWQiO2I6MDtzOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7czoxMzoiACoAYXR0cmlidXRlcyI7YToxMjp7czoyOiJpZCI7aToyMjc7czo3OiJtZW51X2lkIjtpOjE7czo0OiJ0eXBlIjtzOjE6IjIiO3M6MTE6Im1vZHVsZV9uYW1lIjtzOjIzOiJMb2FuIEluc3RhbGxtZW50IE1hbmFnZSI7czoxMzoiZGl2aWRlcl90aXRsZSI7TjtzOjEwOiJpY29uX2NsYXNzIjtOO3M6MzoidXJsIjtzOjI1OiJwZXJzb25hbC1sb2FuLWluc3RhbGxtZW50IjtzOjU6Im9yZGVyIjtpOjM7czo5OiJwYXJlbnRfaWQiO2k6MjI0O3M6NjoidGFyZ2V0IjtOO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjEtMDktMTMgMTA6MzM6MTMiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjEtMDktMTMgMTA6MzM6NDAiO31zOjExOiIAKgBvcmlnaW5hbCI7YToxMjp7czoyOiJpZCI7aToyMjc7czo3OiJtZW51X2lkIjtpOjE7czo0OiJ0eXBlIjtzOjE6IjIiO3M6MTE6Im1vZHVsZV9uYW1lIjtzOjIzOiJMb2FuIEluc3RhbGxtZW50IE1hbmFnZSI7czoxMzoiZGl2aWRlcl90aXRsZSI7TjtzOjEwOiJpY29uX2NsYXNzIjtOO3M6MzoidXJsIjtzOjI1OiJwZXJzb25hbC1sb2FuLWluc3RhbGxtZW50IjtzOjU6Im9yZGVyIjtpOjM7czo5OiJwYXJlbnRfaWQiO2k6MjI0O3M6NjoidGFyZ2V0IjtOO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjEtMDktMTMgMTA6MzM6MTMiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjEtMDktMTMgMTA6MzM6NDAiO31zOjEwOiIAKgBjaGFuZ2VzIjthOjA6e31z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YTowOnt9czoxMjoiACoAd2l0aENvdW50IjthOjA6e31zOjE5OiJwcmV2ZW50c0xhenlMb2FkaW5nIjtiOjA7czoxMDoiACoAcGVyUGFnZSI7aToxNTtzOjY6ImV4aXN0cyI7YjoxO3M6MTg6Indhc1JlY2VudGx5Q3JlYXRlZCI7YjowO3M6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDtzOjEzOiIAKgBhdHRyaWJ1dGVzIjthOjEyOntzOjI6ImlkIjtpOjExNjtzOjc6Im1lbnVfaWQiO2k6MTtzOjQ6InR5cGUiO3M6MToiMiI7czoxMToibW9kdWxlX25hbWUiO3M6MjQ6Ik1hbmFnZSBMZWF2ZSBBcHBsaWNhdGlvbiI7czoxMzoiZGl2aWRlcl90aXRsZSI7TjtzOjEwOiJpY29uX2NsYXNzIjtOO3M6MzoidXJsIjtzOjE3OiJsZWF2ZS1hcHBsaWNhdGlvbiI7czo1OiJvcmRlciI7aTo0O3M6OToicGFyZW50X2lkIjtpOjExMjtzOjY6InRhcmdldCI7TjtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDIxLTA0LTAzIDE4OjA0OjMxIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDIxLTA0LTI2IDA3OjExOjAwIjt9czoxMToiACoAb3JpZ2luYWwiO2E6MTI6e3M6MjoiaWQiO2k6MTE2O3M6NzoibWVudV9pZCI7aToxO3M6NDoidHlwZSI7czoxOiIyIjtzOjExOiJtb2R1bGVfbmFtZSI7czoyNDoiTWFuYWdlIExlYXZlIEFwcGxpY2F0aW9uIjtzOjEzOiJkaXZpZGVyX3RpdGxlIjtOO3M6MTA6Imljb25fY2xhc3MiO047czozOiJ1cmwiO3M6MTc6ImxlYXZlLWFwcGxpY2F0aW9uIjtzOjU6Im9yZGVyIjtpOjQ7czo5OiJwYXJlbnRfaWQiO2k6MTEyO3M6NjoidGFyZ2V0IjtOO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjEtMDQtMDMgMTg6MDQ6MzEiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjEtMDQtMjYgMDc6MTE6MDAiO31zOjEwOiIAKgBjaGFuZ2VzIjthOjA6e31z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bnRpbmciO2I6MTtzOjc6IgAqAHdpdGgiO2E6MDp7fXM6MTI6IgAqAHdpdGhDb3VudCI7YTowOnt9czoxOToicHJldmVudHNMYXp5TG9hZGluZyI7YjowO3M6MTA6IgAqAHBlclBhZ2UiO2k6MTU7czo2OiJleGlzdHMiO2I6MTtzOjE4OiJ3YXNSZWNlbnRseUNyZWF0ZWQiO2I6MDtzOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7czoxMzoiACoAYXR0cmlidXRlcyI7YToxMjp7czoyOiJpZCI7aToxOTA7czo3OiJtZW51X2lkIjtpOjE7czo0OiJ0eXBlIjtzOjE6IjIiO3M6MTE6Im1vZHVsZV9uYW1lIjtzOjI1OiJQcm9kdWN0IFdpc2UgU2FsZXMgUmVwb3J0IjtzOjEzOiJkaXZpZGVyX3RpdGxlIjtOO3M6MTA6Imljb25fY2xhc3MiO047czozOiJ1cmwiO3M6MjU6InByb2R1Y3Qtd2lzZS1zYWxlcy1yZXBvcnQiO3M6NToib3JkZXIiO2k6ODtzOjk6InBhcmVudF9pZCI7aToxNzk7czo2OiJ0YXJnZXQiO3M6NToiX3NlbGYiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjEtMDktMDYgMTA6MTE6MzUiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjEtMTEtMTUgMTY6Mzk6MzYiO31zOjExOiIAKgBvcmlnaW5hbCI7YToxMjp7czoyOiJpZCI7aToxOTA7czo3OiJtZW51X2lkIjtpOjE7czo0OiJ0eXBlIjtzOjE6IjIiO3M6MTE6Im1vZHVsZV9uYW1lIjtzOjI1OiJQcm9kdWN0IFdpc2UgU2FsZXMgUmVwb3J0IjtzOjEzOiJkaXZpZGVyX3RpdGxlIjtOO3M6MTA6Imljb25fY2xhc3MiO047czozOiJ1cmwiO3M6MjU6InByb2R1Y3Qtd2lzZS1zYWxlcy1yZXBvcnQiO3M6NToib3JkZXIiO2k6ODtzOjk6InBhcmVudF9pZCI7aToxNzk7czo2OiJ0YXJnZXQiO3M6NToiX3NlbGYiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjEtMDktMDYgMTA6MTE6MzUiO3M6MTA6InVw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cmVhdGVkIjtiOjA7czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO3M6MTM6IgAqAGF0dHJpYnV0ZXMiO2E6MTI6e3M6MjoiaWQiO2k6MjczO3M6NzoibWVudV9pZCI7aToxO3M6NDoidHlwZSI7czoxOiIyIjtzOjExOiJtb2R1bGVfbmFtZSI7czozMjoiRGVhbGVyIFdpc2UgUHJvZHVjdCBTYWxlcyBSZXBvcnQiO3M6MTM6ImRpdmlkZXJfdGl0bGUiO047czoxMDoiaWNvbl9jbGFzcyI7TjtzOjM6InVybCI7czozMjoiZGVhbGVyLXdpc2UtcHJvZHVjdC1zYWxlcy1yZXBvcnQiO3M6NToib3JkZXIiO2k6MTI7czo5OiJwYXJlbnRfaWQiO2k6MTc5O3M6NjoidGFyZ2V0IjtzOjU6Il9zZWxmIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDIxLTExLTE1IDE2OjQ0OjAyIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDIxLTExLTE1IDE2OjQ0OjEzIjt9czoxMToiACoAb3JpZ2luYWwiO2E6MTI6e3M6MjoiaWQiO2k6MjczO3M6NzoibWVudV9pZCI7aToxO3M6NDoidHlwZSI7czoxOiIyIjtzOjExOiJtb2R1bGVfbmFtZSI7czozMjoiRGVhbGVyIFdpc2UgUHJvZHVjdCBTYWxlcyBSZXBvcnQiO3M6MTM6ImRpdmlkZXJfdGl0bGUiO047czoxMDoiaWNvbl9jbGFzcyI7TjtzOjM6InVybCI7czozMjoiZGVhbGVyLXdpc2UtcHJvZHVjdC1zYWxlcy1yZXBvcnQiO3M6NToib3JkZXIiO2k6MTI7czo5OiJwYXJlbnRfaWQiO2k6MTc5O3M6NjoidGFyZ2V0IjtzOjU6Il9zZWxmIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDIxLTExLTE1IDE2OjQ0OjAyIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDIxLTExLTE1IDE2OjQ0OjEzIjt9czoxMDoiACoAY2hhbmdlcyI7YTowOnt9czo4OiIAKgBjYXN0cyI7YTowOnt9czoxNzoiACoAY2xhc3NDYXN0Q2FjaGUiO2E6MDp7fXM6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', 1637235895);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'title', 'সেফ ফুড এন্ড বেভারেজ (শালুক)', NULL, NULL),
(2, 'email', NULL, NULL, NULL),
(3, 'contact_no', '01711-526078', NULL, NULL),
(4, 'address', 'বেপাড়ি পাড়া, হেলাল মার্কেট, উত্তরখান, ঢাকা।', NULL, NULL),
(5, 'currency_code', 'BDT', NULL, NULL),
(6, 'currency_symbol', 'Tk', NULL, NULL),
(7, 'currency_position', '2', NULL, NULL),
(8, 'timezone', 'Asia/Dhaka', NULL, NULL),
(9, 'date_format', 'd-M-Y', NULL, NULL),
(10, 'logo', 'safe-food-logo.png', NULL, NULL),
(11, 'favicon', 'safe-food-favicon.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `night_status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Day, 2=Night',
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shift_manages`
--

CREATE TABLE `shift_manages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `presentstatus` int(11) DEFAULT NULL,
  `status` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Pending, 2=Accepted, 3=Cancel',
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_outs`
--

CREATE TABLE `stock_outs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_out_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `item` double(8,2) NOT NULL,
  `total_qty` double(8,2) NOT NULL,
  `grand_total` double NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_outs`
--

INSERT INTO `stock_outs` (`id`, `stock_out_no`, `warehouse_id`, `date`, `item`, `total_qty`, `grand_total`, `note`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, '1001', 1, '2021-10-21', 2.00, 90.00, 2907.5, NULL, 'Super Admin', NULL, '2021-10-21 10:36:10', '2021-10-21 10:36:10');

-- --------------------------------------------------------

--
-- Table structure for table `stock_out_materials`
--

CREATE TABLE `stock_out_materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_out_id` bigint(20) UNSIGNED NOT NULL,
  `batch_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qty` double NOT NULL,
  `net_unit_cost` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_out_materials`
--

INSERT INTO `stock_out_materials` (`id`, `stock_out_id`, `batch_no`, `material_id`, `unit_id`, `qty`, `net_unit_cost`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, '1000', 1, 2, 50, 23.75, 1187.5, '2021-10-21 00:00:00', NULL),
(2, 1, '1000', 2, 2, 40, 43, 1720, '2021-10-21 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `company_name`, `mobile`, `email`, `city`, `zipcode`, `address`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'Mr. A', 'AAA', '01521225963', NULL, NULL, NULL, NULL, '1', 'Super Admin', NULL, '2021-11-15 08:20:32', '2021-11-15 08:20:32');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chart_of_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `voucher_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voucher_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voucher_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `debit` double DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `is_opening` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=Yes, 2=No',
  `posted` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Yes, 2=No',
  `approve` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Yes, 2=No,3=Pending',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `chart_of_account_id`, `warehouse_id`, `voucher_no`, `voucher_type`, `voucher_date`, `description`, `debit`, `credit`, `is_opening`, `posted`, `approve`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(2, 52, 1, 'CC3PDEKHHR', 'PR Balance', '2021-10-28', 'Debit Amount 2000Tk From Depo মিল্লাদ', 2000, 0, '2', '1', '1', 'Super Admin', NULL, '2021-10-28 08:23:30', NULL),
(3, 17, 1, 'CC3PDEKHHR', 'PR Balance', '2021-10-28', 'Inventory Credit Amount 2000Tk For Old Sale From মিল্লাদ', 0, 2000, '2', '1', '1', 'Super Admin', NULL, '2021-10-28 08:23:30', NULL),
(6, 56, 1, 'BOUO6QUYP4', 'PR Balance', '2021-10-28', 'Debit Amount 3000Tk From Dealer মিলন এন্টারপ্রাইজ', 3000, 0, '2', '1', '1', 'Super Admin', NULL, '2021-10-28 08:39:45', NULL),
(7, 17, 1, 'BOUO6QUYP4', 'PR Balance', '2021-10-28', 'Inventory Credit Amount 3000Tk For Old Sale From মিলন এন্টারপ্রাইজ', 0, 3000, '2', '1', '1', 'Super Admin', NULL, '2021-10-28 08:39:45', NULL),
(11, 17, 1, 'SINV-211030977', 'INVOICE', '2021-10-30', 'Inventory Credit For Invoice No SINV-211030977', 0, 0, '2', '1', '1', 'Super Admin', NULL, '2021-10-30 07:53:01', NULL),
(12, 49, 1, 'SINV-211030977', 'INVOICE', '2021-10-30', 'Debit Amount 6425.00Tk For Sale Memo No. -  SINV-211030977 From বিল্লাল', 6425, 0, '2', '1', '1', 'Super Admin', NULL, '2021-10-30 07:53:01', NULL),
(13, 8, 1, 'SINV-211030977', 'INVOICE', '2021-10-30', 'Sale Income For Memo No. - SINV-211030977 From বিল্লাল', 0, 6425, '2', '1', '1', 'Super Admin', NULL, '2021-10-30 07:53:01', NULL),
(14, 17, 1, 'SINV-211030342', 'INVOICE', '2021-10-30', 'Inventory Credit For Invoice No SINV-211030342', 0, 0, '2', '1', '1', 'Super Admin', NULL, '2021-10-30 08:45:48', NULL),
(15, 49, 1, 'SINV-211030342', 'INVOICE', '2021-10-30', 'Debit Amount 9650.00Tk For Sale Memo No. -  SINV-211030342 From বিল্লাল', 9650, 0, '2', '1', '1', 'Super Admin', NULL, '2021-10-30 08:45:48', NULL),
(16, 8, 1, 'SINV-211030342', 'INVOICE', '2021-10-30', 'Sale Income For Memo No. - SINV-211030342 From বিল্লাল', 0, 9650, '2', '1', '1', 'Super Admin', NULL, '2021-10-30 08:45:48', NULL),
(17, 49, 1, 'CR-211030932', 'CR', '2021-10-30', 'Due Amount 6075TK cash received from Billal Depo', 0, 6075, '2', '1', '1', 'Super Admin', NULL, '2021-10-30 12:18:05', '2021-10-30 12:18:05'),
(18, 23, 1, 'CR-211030932', 'CR', '2021-10-30', 'Cash In Hand For বিল্লাল', 6075, 0, '2', '1', '1', 'Super Admin', NULL, '2021-10-30 12:18:05', '2021-10-30 12:18:05'),
(19, 56, 1, 'CR-211030581', 'CR', '2021-10-30', 'Due Amount 1500Tk cash received from Milon Enterprise', 0, 1500, '2', '1', '1', 'Super Admin', NULL, '2021-10-30 12:28:07', '2021-10-30 12:28:07'),
(20, 23, 1, 'CR-211030581', 'CR', '2021-10-30', 'Cash In Hand For মিলন এন্টারপ্রাইজ', 1500, 0, '2', '1', '1', 'Super Admin', NULL, '2021-10-30 12:28:07', '2021-10-30 12:28:07'),
(21, 17, 1, 'SINV-211104245', 'INVOICE', '2021-11-04', 'Inventory Credit For Invoice No SINV-211104245', 0, 0, '2', '1', '1', 'Admin', NULL, '2021-11-04 10:47:16', NULL),
(22, 49, 1, 'SINV-211104245', 'INVOICE', '2021-11-04', 'Debit Amount 362.50Tk For Sale Memo No. -  SINV-211104245 From বিল্লাল', 362.5, 0, '2', '1', '1', 'Admin', NULL, '2021-11-04 10:47:16', NULL),
(23, 8, 1, 'SINV-211104245', 'INVOICE', '2021-11-04', 'Sale Income For Memo No. - SINV-211104245 From বিল্লাল', 0, 362.5, '2', '1', '1', 'Admin', NULL, '2021-11-04 10:47:16', NULL),
(24, 17, 1, 'SINV-211104732', 'INVOICE', '2021-11-04', 'Inventory Credit For Invoice No SINV-211104732', 0, 0, '2', '1', '1', 'Admin', NULL, '2021-11-04 11:46:15', NULL),
(25, 49, 1, 'SINV-211104732', 'INVOICE', '2021-11-04', 'Debit Amount 1015.00Tk For Sale Memo No. -  SINV-211104732 From বিল্লাল', 1015, 0, '2', '1', '1', 'Admin', NULL, '2021-11-04 11:46:15', NULL),
(26, 8, 1, 'SINV-211104732', 'INVOICE', '2021-11-04', 'Sale Income For Memo No. - SINV-211104732 From বিল্লাল', 0, 1015, '2', '1', '1', 'Admin', NULL, '2021-11-04 11:46:15', NULL),
(27, 17, 1, 'SINV-211104938', 'INVOICE', '2021-11-04', 'Inventory Credit For Invoice No SINV-211104938', 0, 0, '2', '1', '1', 'Admin', NULL, '2021-11-04 11:49:31', NULL),
(28, 49, 1, 'SINV-211104938', 'INVOICE', '2021-11-04', 'Debit Amount 2070.00Tk For Sale Memo No. -  SINV-211104938 From বিল্লাল', 2070, 0, '2', '1', '1', 'Admin', NULL, '2021-11-04 11:49:31', NULL),
(29, 8, 1, 'SINV-211104938', 'INVOICE', '2021-11-04', 'Sale Income For Memo No. - SINV-211104938 From বিল্লাল', 0, 2070, '2', '1', '1', 'Admin', NULL, '2021-11-04 11:49:31', NULL),
(30, 17, 1, 'SINV-211110863', 'INVOICE', '2021-11-10', 'Inventory credit for Memo No. - SINV-211110863', 0, 0, '2', '1', '1', 'Super Admin', NULL, '2021-11-09 18:09:54', NULL),
(31, 49, 1, 'SINV-211110863', 'INVOICE', '2021-11-10', 'Debit amount 2025.00Tk for sale Memo No. -  SINV-211110863 from বিল্লাল', 2025, 0, '2', '1', '1', 'Super Admin', NULL, '2021-11-09 18:09:54', NULL),
(32, 8, 1, 'SINV-211110863', 'INVOICE', '2021-11-10', 'Sale income for Memo No. - SINV-211110863 from বিল্লাল', 0, 2025, '2', '1', '1', 'Super Admin', NULL, '2021-11-09 18:09:54', NULL),
(36, 17, 1, 'SINV-211110135', 'INVOICE', '2021-11-10', 'Inventory credit for Memo No. - SINV-211110135', 0, 0, '2', '1', '1', 'Super Admin', NULL, '2021-11-10 19:02:23', NULL),
(37, 55, 1, 'SINV-211110135', 'INVOICE', '2021-11-10', 'Debit amount 3042.90Tk for sale Memo No. -  SINV-211110135 from সানজা এন্টারপ্রাইজ', 3042.9, 0, '2', '1', '1', 'Super Admin', NULL, '2021-11-10 19:02:23', NULL),
(38, 8, 1, 'SINV-211110135', 'INVOICE', '2021-11-10', 'Sale income for Memo No. - SINV-211110135 from সানজা এন্টারপ্রাইজ', 0, 3042.9, '2', '1', '1', 'Super Admin', NULL, '2021-11-10 19:02:23', NULL),
(39, 17, 1, 'SINV-21111326', 'INVOICE', '2021-11-13', 'Inventory credit for Memo No. - SINV-21111326', 0, 0, '2', '1', '1', 'Super Admin', NULL, '2021-11-13 14:01:57', NULL),
(40, 49, 1, 'SINV-21111326', 'INVOICE', '2021-11-13', 'Debit amount 1710.45Tk for sale Memo No. -  SINV-21111326 from বিল্লাল', 1710.45, 0, '2', '1', '1', 'Super Admin', NULL, '2021-11-13 14:01:57', NULL),
(41, 8, 1, 'SINV-21111326', 'INVOICE', '2021-11-13', 'Sale income for Memo No. - SINV-21111326 from বিল্লাল', 0, 1710.45, '2', '1', '1', 'Super Admin', NULL, '2021-11-13 14:01:57', NULL),
(42, 17, 1, 'SINV-211113363', 'INVOICE', '2021-11-13', 'Inventory credit for Memo No. - SINV-211113363', 0, 0, '2', '1', '1', 'Super Admin', NULL, '2021-11-13 14:03:03', NULL),
(43, 50, 1, 'SINV-211113363', 'INVOICE', '2021-11-13', 'Debit amount 1969.28Tk for sale Memo No. -  SINV-211113363 from হুসাইন', 1969.28, 0, '2', '1', '1', 'Super Admin', NULL, '2021-11-13 14:03:03', NULL),
(44, 8, 1, 'SINV-211113363', 'INVOICE', '2021-11-13', 'Sale income for Memo No. - SINV-211113363 from হুসাইন', 0, 1969.28, '2', '1', '1', 'Super Admin', NULL, '2021-11-13 14:03:03', NULL),
(45, 17, 1, 'SINV-211113974', 'INVOICE', '2021-11-13', 'Inventory credit for Memo No. - SINV-211113974', 0, 0, '2', '1', '1', 'Super Admin', NULL, '2021-11-13 14:03:49', NULL),
(46, 56, 1, 'SINV-211113974', 'INVOICE', '2021-11-13', 'Debit amount 1897.20Tk for sale Memo No. -  SINV-211113974 from মিলন এন্টারপ্রাইজ', 1897.2, 0, '2', '1', '1', 'Super Admin', NULL, '2021-11-13 14:03:49', NULL),
(47, 8, 1, 'SINV-211113974', 'INVOICE', '2021-11-13', 'Sale income for Memo No. - SINV-211113974 from মিলন এন্টারপ্রাইজ', 0, 1897.2, '2', '1', '1', 'Super Admin', NULL, '2021-11-13 14:03:49', NULL),
(52, 49, 1, '3HBW9VB6H3', 'Advance', '2021-11-15', 'Advance from depo বিল্লাল', 0, 2000, '2', '1', '1', 'Super Admin', NULL, '2021-11-15 07:25:55', NULL),
(53, 23, 1, '3HBW9VB6H3', 'Advance', '2021-11-15', 'Cash in Hand For বিল্লাল', 2000, 0, '2', '1', '1', 'Super Admin', NULL, '2021-11-15 07:25:55', NULL),
(54, 52, 1, 'CR-211115389', 'CR', '2021-11-15', '1000TK received from Millad Depo', 0, 1000, '2', '1', '1', 'Super Admin', NULL, '2021-11-15 08:21:33', '2021-11-15 08:21:33'),
(55, 23, 1, 'CR-211115389', 'CR', '2021-11-15', 'Cash In Hand For মিল্লাদ', 1000, 0, '2', '1', '1', 'Super Admin', NULL, '2021-11-15 08:21:33', '2021-11-15 08:21:33'),
(56, 55, 1, 'CR-211115361', 'CR', '2021-11-15', '1000Tk received from Sanja Enterprise', 0, 1000, '2', '1', '1', 'Super Admin', NULL, '2021-11-15 08:24:10', '2021-11-15 08:24:10'),
(57, 23, 1, 'CR-211115361', 'CR', '2021-11-15', 'Cash In Hand For সানজা এন্টারপ্রাইজ', 1000, 0, '2', '1', '1', 'Super Admin', NULL, '2021-11-15 08:24:10', '2021-11-15 08:24:10'),
(60, 57, 1, 'FJJCWJ983M', 'Advance', '2021-11-15', 'Advance to Mr. A', 1000, 0, '2', '1', '1', 'Super Admin', NULL, '2021-11-15 09:30:09', NULL),
(61, 23, 1, 'FJJCWJ983M', 'Advance', '2021-11-15', 'Cash in Hand For Mr. A', 0, 1000, '2', '1', '1', 'Super Admin', NULL, '2021-11-15 09:30:09', NULL),
(65, 57, NULL, 'PINV-1002', 'Purchase', '2021-11-16', 'Supplier Mr. A', 0, 15000, '2', '1', '1', 'Super Admin', NULL, '2021-11-16 06:46:58', NULL),
(66, 17, NULL, 'PINV-1002', 'Purchase', '2021-11-16', 'Inventory Debit For Supplier Mr. A', 15000, 0, '2', '1', '1', 'Super Admin', NULL, '2021-11-16 06:46:58', NULL),
(67, 11, NULL, 'PINV-1002', 'Purchase', '2021-11-16', 'Company Credit For Supplier Mr. A', 15000, 0, '2', '1', '1', 'Super Admin', NULL, '2021-11-16 06:46:58', NULL),
(68, 57, NULL, 'PINV-1003', 'Purchase', '2021-11-18', 'Supplier Mr. A', 0, 18000, '2', '1', '1', 'Super Admin', 'Super Admin', '2021-11-16 06:52:27', '2021-11-18 08:14:21'),
(69, 17, NULL, 'PINV-1003', 'Purchase', '2021-11-18', 'Inventory Debit For Supplier Mr. A', 18000, 0, '2', '1', '1', 'Super Admin', 'Super Admin', '2021-11-16 06:52:27', '2021-11-18 08:14:21'),
(70, 11, NULL, 'PINV-1003', 'Purchase', '2021-11-18', 'Company Credit For Supplier Mr. A', 18000, 0, '2', '1', '1', 'Super Admin', 'Super Admin', '2021-11-16 06:52:27', '2021-11-18 08:14:21'),
(75, 56, 1, 'SINV-211113974', 'PRODUCT DAMAGE', '2021-11-17', 'Credit amount 95.00Tk for product damage Memo No. :- SINV-211113974', 0, 95, '2', '1', '1', 'Super Admin', NULL, '2021-11-17 06:56:04', '2021-11-17 06:56:04'),
(77, 57, 1, 'PINV-1002', 'PURCHASE RETURN', '2021-11-18', 'Debit amount 560.00Tk for material return Memo No. - PINV-1002', 560, 0, '2', '1', '1', 'Super Admin', NULL, '2021-11-18 04:41:00', '2021-11-18 04:41:00'),
(82, 57, NULL, '11', 'Purchase', '2021-11-16', 'Supplier .Mr. A', 5500, 0, '2', '1', '1', 'Super Admin', NULL, '2021-11-18 08:07:36', '2021-11-18 08:07:36'),
(83, 23, NULL, '11', 'Purchase', '2021-11-16', 'Cash in Hand For Supplier Mr. A', 0, 5500, '2', '1', '1', 'Super Admin', NULL, '2021-11-18 08:07:36', '2021-11-18 08:07:36'),
(84, 57, NULL, '11', 'Purchase', '2021-11-18', 'Supplier .Mr. A', 12500, 0, '2', '1', '1', 'Super Admin', NULL, '2021-11-18 08:15:03', '2021-11-18 08:15:03'),
(85, 23, NULL, '11', 'Purchase', '2021-11-18', 'Cash in Hand For Supplier Mr. A', 0, 12500, '2', '1', '1', 'Super Admin', NULL, '2021-11-18 08:15:03', '2021-11-18 08:15:03');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `base_unit` int(10) UNSIGNED DEFAULT NULL,
  `operator` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '*',
  `operation_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=active,2=inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit_name`, `unit_code`, `base_unit`, `operator`, `operation_value`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'Piece', 'Pc', NULL, '*', '1', '1', 'Super Admin', NULL, '2021-07-13 19:14:39', '2021-07-13 19:14:39'),
(2, 'Kilogram', 'Kg', NULL, '*', '1', '1', 'Super Admin', NULL, '2021-07-13 19:14:57', '2021-07-13 19:14:57'),
(3, 'Gram', 'gm', 2, '/', '1000', '1', 'Super Admin', NULL, '2021-07-13 19:15:24', '2021-07-13 19:15:24'),
(9, 'Drum', 'drum', NULL, '*', '1', '1', 'Super Admin', NULL, '2021-07-31 09:26:42', '2021-07-31 09:26:42'),
(10, 'Liter', 'Ltr', NULL, '*', '1', '1', 'Super Admin', NULL, '2021-07-31 09:27:05', '2021-07-31 09:27:05'),
(11, 'Carton', 'Ctn', NULL, '*', '1', '1', 'Super Admin', NULL, '2021-07-31 09:27:18', '2021-07-31 09:27:18'),
(12, '6CTN', '6CTN', 1, '*', '6', '1', 'Super Admin', 'Super Admin', '2021-10-27 06:08:21', '2021-10-27 06:13:01'),
(13, '10CTN', '10CTN', 1, '*', '10', '1', 'Super Admin', 'Super Admin', '2021-10-27 06:08:46', '2021-10-27 06:13:14'),
(14, '12CTN', '12CTN', 1, '*', '12', '1', 'Super Admin', NULL, '2021-10-27 06:13:32', '2021-10-27 06:13:32'),
(15, '20CTN', '20CTN', 1, '*', '20', '1', 'Super Admin', NULL, '2021-10-27 06:13:55', '2021-10-27 06:13:55'),
(16, '22CTN', '22CTN', 1, '*', '22', '1', 'Super Admin', NULL, '2021-10-27 06:14:12', '2021-10-27 06:14:12'),
(17, '24CTN', '24CTN', 1, '*', '24', '1', 'Super Admin', NULL, '2021-10-27 06:14:30', '2021-10-27 06:14:30'),
(18, '30CTN', '30CTN', 1, '*', '30', '1', 'Super Admin', NULL, '2021-10-27 06:14:51', '2021-10-27 06:14:51'),
(19, '32CTN', '32CTN', 1, '*', '32', '1', 'Super Admin', NULL, '2021-10-27 06:15:10', '2021-10-27 06:15:10'),
(20, '35CTN', '35CTN', 1, '*', '35', '1', 'Super Admin', NULL, '2021-10-27 06:15:28', '2021-10-27 06:15:28'),
(21, '36CTN', '36CTN', 1, '*', '36', '1', 'Super Admin', NULL, '2021-10-27 06:15:50', '2021-10-27 06:15:50'),
(22, '40CTN', '40CTN', 1, '*', '40', '1', 'Super Admin', NULL, '2021-10-27 06:16:10', '2021-10-27 06:16:10'),
(23, '48CTN', '48CTN', 1, '*', '48', '1', 'Super Admin', NULL, '2021-10-27 06:16:28', '2021-10-27 06:16:28'),
(24, '50CTN', '50CTN', 1, '*', '50', '1', 'Super Admin', NULL, '2021-10-27 06:16:47', '2021-10-27 06:16:47'),
(25, '60CTN', '60CTN', 1, '*', '60', '1', 'Super Admin', NULL, '2021-10-27 06:17:04', '2021-10-27 06:17:04'),
(26, '72CTN', '72CTN', 1, '*', '72', '1', 'Super Admin', NULL, '2021-10-27 06:17:27', '2021-10-27 06:17:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Male,2=Female,3=Other',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `username`, `email`, `phone`, `avatar`, `gender`, `password`, `status`, `deletable`, `created_by`, `modified_by`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Super Admin', 'SuperAdmin', 'superadmin@mail.com', '01521225987', NULL, '1', '$2y$10$oyBQnkvC8WZEQffhpEEsyeZPPqXEHmpaErfi62fsfyAw.UMwIzS/m', '1', '1', NULL, NULL, NULL, '2021-03-26 17:49:24', '2021-03-26 17:49:24'),
(2, 2, 'Admin', 'Admin', 'admin@mail.com', '01711154960', NULL, '1', '$2y$10$KF7BIkSLDeOwTMgh6KtAVOrUOGfKQjWxDqXOO7UmR2Lpdrh1C9IKC', '1', '1', 'Admin', NULL, 'phanNvS47WRlDN0HDynw0NZaCuqqCbHWheFFPyKWjkn0S75uuPstVQS9zgsH', '2021-03-26 17:49:24', '2021-05-04 11:10:35'),
(3, 3, 'Mr. Arman', 'Arman', NULL, '01521225982', NULL, '1', '$2y$10$QOpyPCjrUmhIkuxMIURHy.7x8SfMXvjnBzM3bK9tPYqnfisJ0dibu', '1', '2', 'Admin', NULL, NULL, '2021-10-21 10:14:48', '2021-10-21 10:14:48');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `name`, `phone`, `email`, `address`, `district_id`, `status`, `deletable`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'Main Warehouse', NULL, NULL, NULL, 1, '1', '1', 'Super Admin', 'Super Admin', '2021-10-11 06:41:53', '2021-10-20 09:34:26');

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_material`
--

CREATE TABLE `warehouse_material` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `qty` double(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warehouse_material`
--

INSERT INTO `warehouse_material` (`id`, `warehouse_id`, `material_id`, `qty`, `created_at`, `updated_at`) VALUES
(4, 1, 1, 195.00, '2021-11-16 06:46:58', '2021-11-18 08:14:21'),
(5, 1, 2, 95.00, '2021-11-16 06:46:58', '2021-11-18 08:14:21'),
(6, 1, 3, 100.00, '2021-11-16 06:46:58', '2021-11-18 08:14:21'),
(13, 1, 10, 40.00, '2021-11-18 08:14:21', '2021-11-18 08:14:21');

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_product`
--

CREATE TABLE `warehouse_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warehouse_product`
--

INSERT INTO `warehouse_product` (`id`, `warehouse_id`, `product_id`, `qty`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 64, '2021-10-27 09:06:24', '2021-11-16 12:29:41'),
(2, 1, 2, 25, '2021-10-27 09:06:24', '2021-11-14 19:05:20'),
(3, 1, 3, 145, '2021-10-27 09:06:24', '2021-11-14 19:05:20'),
(4, 1, 11, 50, '2021-11-09 06:33:11', '2021-11-16 12:29:41'),
(5, 1, 4, 35, '2021-11-13 17:00:48', '2021-11-14 19:05:20'),
(6, 1, 5, 4, '2021-11-13 17:00:48', '2021-11-14 19:05:20'),
(7, 1, 6, 28, '2021-11-13 17:00:48', '2021-11-14 19:05:20'),
(8, 1, 7, 52, '2021-11-13 17:00:48', '2021-11-14 19:05:20'),
(9, 1, 8, 52, '2021-11-13 17:00:48', '2021-11-16 12:29:41'),
(10, 1, 48, 50, '2021-11-18 11:08:32', '2021-11-18 11:08:32');

-- --------------------------------------------------------

--
-- Table structure for table `weekly_holiday_assigns`
--

CREATE TABLE `weekly_holiday_assigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `weekly_holiday_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive, 3=Cancel',
  `deletable` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=No, 2=Yes',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adjustments`
--
ALTER TABLE `adjustments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `adjustments_adjustment_no_unique` (`adjustment_no`),
  ADD KEY `adjustments_warehouse_id_foreign` (`warehouse_id`);

--
-- Indexes for table `adjustment_products`
--
ALTER TABLE `adjustment_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adjustment_products_adjustment_id_foreign` (`adjustment_id`),
  ADD KEY `adjustment_products_product_id_foreign` (`product_id`),
  ADD KEY `adjustment_products_base_unit_id_foreign` (`base_unit_id`);

--
-- Indexes for table `allowance_deductions`
--
ALTER TABLE `allowance_deductions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `allowance_deduction_manages`
--
ALTER TABLE `allowance_deduction_manages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `allowance_deduction_manages_allowance_deduction_id_foreign` (`allowance_deduction_id`),
  ADD KEY `allowance_deduction_manages_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `banks_account_number_unique` (`account_number`),
  ADD KEY `banks_warehouse_id_foreign` (`warehouse_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD UNIQUE KEY `cache_key_unique` (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chart_of_accounts_code_unique` (`code`),
  ADD KEY `chart_of_accounts_customer_id_foreign` (`customer_id`),
  ADD KEY `chart_of_accounts_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `daily_closings`
--
ALTER TABLE `daily_closings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `daily_closings_warehouse_id_foreign` (`warehouse_id`);

--
-- Indexes for table `damages`
--
ALTER TABLE `damages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `damages_damage_no_unique` (`damage_no`),
  ADD KEY `damages_sale_id_foreign` (`sale_id`);

--
-- Indexes for table `damage_products`
--
ALTER TABLE `damage_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `damage_products_damage_id_foreign` (`damage_id`),
  ADD KEY `damage_products_product_id_foreign` (`product_id`),
  ADD KEY `damage_products_base_unit_id_foreign` (`base_unit_id`);

--
-- Indexes for table `dealers`
--
ALTER TABLE `dealers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dealers_mobile_no_unique` (`mobile_no`),
  ADD KEY `dealers_district_id_foreign` (`district_id`),
  ADD KEY `dealers_upazila_id_foreign` (`upazila_id`),
  ADD KEY `dealers_area_id_foreign` (`area_id`);

--
-- Indexes for table `dealer_groups`
--
ALTER TABLE `dealer_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dealer_groups_group_name_unique` (`group_name`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_name_unique` (`name`);

--
-- Indexes for table `depos`
--
ALTER TABLE `depos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `depos_mobile_no_unique` (`mobile_no`),
  ADD KEY `depos_district_id_foreign` (`district_id`),
  ADD KEY `depos_upazila_id_foreign` (`upazila_id`),
  ADD KEY `depos_area_id_foreign` (`area_id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `designations_name_unique` (`name`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `divisions_name_unique` (`name`),
  ADD KEY `divisions_department_id_foreign` (`department_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_phone_unique` (`phone`),
  ADD UNIQUE KEY `employees_employee_id_unique` (`employee_id`),
  ADD UNIQUE KEY `employees_finger_id_unique` (`finger_id`),
  ADD KEY `employees_shift_id_foreign` (`shift_id`),
  ADD KEY `employees_department_id_foreign` (`department_id`),
  ADD KEY `employees_division_id_foreign` (`division_id`),
  ADD KEY `employees_joining_designation_id_foreign` (`joining_designation_id`),
  ADD KEY `employees_current_designation_id_foreign` (`current_designation_id`);

--
-- Indexes for table `employee_education`
--
ALTER TABLE `employee_education`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_education_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `employee_professional_information`
--
ALTER TABLE `employee_professional_information`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_professional_information_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `employee_routes`
--
ALTER TABLE `employee_routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expenses_voucher_no_unique` (`voucher_no`),
  ADD KEY `expenses_warehouse_id_foreign` (`warehouse_id`),
  ADD KEY `expenses_expense_item_id_foreign` (`expense_item_id`),
  ADD KEY `expenses_account_id_foreign` (`account_id`);

--
-- Indexes for table `expense_items`
--
ALTER TABLE `expense_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expense_items_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_application_manages`
--
ALTER TABLE `leave_application_manages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_application_manages_leave_id_foreign` (`leave_id`),
  ADD KEY `leave_application_manages_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loans_employee_id_foreign` (`employee_id`),
  ADD KEY `loans_person_id_foreign` (`person_id`),
  ADD KEY `loans_account_id_foreign` (`account_id`);

--
-- Indexes for table `loan_installments`
--
ALTER TABLE `loan_installments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_installments_loan_id_foreign` (`loan_id`),
  ADD KEY `loan_installments_employee_id_foreign` (`employee_id`),
  ADD KEY `loan_installments_person_id_foreign` (`person_id`),
  ADD KEY `loan_installments_account_id_foreign` (`account_id`);

--
-- Indexes for table `loan_people`
--
ALTER TABLE `loan_people`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `loan_people_name_unique` (`name`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `materials_material_code_unique` (`material_code`),
  ADD KEY `materials_category_id_foreign` (`category_id`),
  ADD KEY `materials_unit_id_foreign` (`unit_id`),
  ADD KEY `materials_purchase_unit_id_foreign` (`purchase_unit_id`),
  ADD KEY `materials_tax_id_foreign` (`tax_id`),
  ADD KEY `materials_opening_warehouse_id_foreign` (`opening_warehouse_id`);

--
-- Indexes for table `material_purchase`
--
ALTER TABLE `material_purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_purchase_purchase_id_foreign` (`purchase_id`),
  ADD KEY `material_purchase_material_id_foreign` (`material_id`),
  ADD KEY `material_purchase_purchase_unit_id_foreign` (`purchase_unit_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_menu_name_unique` (`menu_name`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mobile_banks`
--
ALTER TABLE `mobile_banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mobile_banks_warehouse_id_foreign` (`warehouse_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modules_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `module_role`
--
ALTER TABLE `module_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_role_module_id_foreign` (`module_id`),
  ADD KEY `module_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `opening_stocks`
--
ALTER TABLE `opening_stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `opening_stocks_opening_no_unique` (`opening_no`),
  ADD KEY `opening_stocks_warehouse_id_foreign` (`warehouse_id`);

--
-- Indexes for table `opening_stock_products`
--
ALTER TABLE `opening_stock_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `opening_stock_products_opening_stock_id_foreign` (`opening_stock_id`),
  ADD KEY `opening_stock_products_product_id_foreign` (`product_id`),
  ADD KEY `opening_stock_products_base_unit_id_foreign` (`base_unit_id`);

--
-- Indexes for table `order_sheets`
--
ALTER TABLE `order_sheets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_sheets_sheet_no_unique` (`sheet_no`);

--
-- Indexes for table `order_sheet_memos`
--
ALTER TABLE `order_sheet_memos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_sheet_memos_order_sheet_id_foreign` (`order_sheet_id`),
  ADD KEY `order_sheet_memos_sale_id_foreign` (`sale_id`);

--
-- Indexes for table `order_sheet_products`
--
ALTER TABLE `order_sheet_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_sheet_products_order_sheet_id_foreign` (`order_sheet_id`),
  ADD KEY `order_sheet_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_module_id_foreign` (`module_id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_code_unique` (`code`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_base_unit_id_foreign` (`base_unit_id`),
  ADD KEY `products_unit_id_foreign` (`unit_id`),
  ADD KEY `products_tax_id_foreign` (`tax_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `product_material`
--
ALTER TABLE `product_material`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_material_product_id_foreign` (`product_id`),
  ADD KEY `product_material_material_id_foreign` (`material_id`);

--
-- Indexes for table `product_prices`
--
ALTER TABLE `product_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_prices_product_id_foreign` (`product_id`),
  ADD KEY `product_prices_dealer_group_id_foreign` (`dealer_group_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchases_memo_no_unique` (`memo_no`),
  ADD KEY `purchases_warehouse_id_foreign` (`warehouse_id`),
  ADD KEY `purchases_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `purchase_payments`
--
ALTER TABLE `purchase_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_payments_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_payments_account_id_foreign` (`account_id`),
  ADD KEY `purchase_payments_transaction_id_foreign` (`transaction_id`),
  ADD KEY `purchase_payments_supplier_debit_transaction_id_foreign` (`supplier_debit_transaction_id`);

--
-- Indexes for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_returns_return_no_unique` (`return_no`),
  ADD KEY `purchase_returns_purchase_id_foreign` (`purchase_id`);

--
-- Indexes for table `purchase_return_materials`
--
ALTER TABLE `purchase_return_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_return_materials_purchase_return_id_foreign` (`purchase_return_id`),
  ADD KEY `purchase_return_materials_material_id_foreign` (`material_id`),
  ADD KEY `purchase_return_materials_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_role_name_unique` (`role_name`);

--
-- Indexes for table `salary_generates`
--
ALTER TABLE `salary_generates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `salary_generates_voucher_no_unique` (`voucher_no`),
  ADD KEY `salary_generates_employee_id_foreign` (`employee_id`),
  ADD KEY `salary_generates_designation_id_foreign` (`designation_id`),
  ADD KEY `salary_generates_department_id_foreign` (`department_id`),
  ADD KEY `salary_generates_division_id_foreign` (`division_id`);

--
-- Indexes for table `salary_generate_payments`
--
ALTER TABLE `salary_generate_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_generate_payments_salary_generated_id_foreign` (`salary_generated_id`),
  ADD KEY `salary_generate_payments_account_id_foreign` (`account_id`),
  ADD KEY `salary_generate_payments_transaction_id_foreign` (`transaction_id`),
  ADD KEY `salary_generate_payments_employee_transaction_id_foreign` (`employee_transaction_id`);

--
-- Indexes for table `salary_incements`
--
ALTER TABLE `salary_incements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_incements_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_memo_no_unique` (`memo_no`),
  ADD KEY `sales_depo_id_foreign` (`depo_id`),
  ADD KEY `sales_dealer_id_foreign` (`dealer_id`),
  ADD KEY `sales_district_id_foreign` (`district_id`),
  ADD KEY `sales_upazila_id_foreign` (`upazila_id`),
  ADD KEY `sales_area_id_foreign` (`area_id`);

--
-- Indexes for table `sale_products`
--
ALTER TABLE `sale_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_products_sale_id_foreign` (`sale_id`),
  ADD KEY `sale_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `sale_returns`
--
ALTER TABLE `sale_returns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sale_returns_return_no_unique` (`return_no`),
  ADD KEY `sale_returns_sale_id_foreign` (`sale_id`);

--
-- Indexes for table `sale_return_products`
--
ALTER TABLE `sale_return_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_return_products_sale_return_id_foreign` (`sale_return_id`),
  ADD KEY `sale_return_products_product_id_foreign` (`product_id`),
  ADD KEY `sale_return_products_base_unit_id_foreign` (`base_unit_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_name_unique` (`name`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shift_manages`
--
ALTER TABLE `shift_manages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shift_manages_shift_id_foreign` (`shift_id`),
  ADD KEY `shift_manages_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `stock_outs`
--
ALTER TABLE `stock_outs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stock_outs_stock_out_no_unique` (`stock_out_no`),
  ADD KEY `stock_outs_warehouse_id_foreign` (`warehouse_id`);

--
-- Indexes for table `stock_out_materials`
--
ALTER TABLE `stock_out_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_out_materials_stock_out_id_foreign` (`stock_out_id`),
  ADD KEY `stock_out_materials_material_id_foreign` (`material_id`),
  ADD KEY `stock_out_materials_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `taxes_name_unique` (`name`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_chart_of_account_id_foreign` (`chart_of_account_id`),
  ADD KEY `transactions_warehouse_id_foreign` (`warehouse_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `warehouses_name_unique` (`name`),
  ADD KEY `warehouses_district_id_foreign` (`district_id`);

--
-- Indexes for table `warehouse_material`
--
ALTER TABLE `warehouse_material`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warehouse_material_warehouse_id_foreign` (`warehouse_id`),
  ADD KEY `warehouse_material_material_id_foreign` (`material_id`);

--
-- Indexes for table `warehouse_product`
--
ALTER TABLE `warehouse_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warehouse_id` (`warehouse_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `weekly_holiday_assigns`
--
ALTER TABLE `weekly_holiday_assigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weekly_holiday_assigns_employee_id_foreign` (`employee_id`),
  ADD KEY `weekly_holiday_assigns_weekly_holiday_id_foreign` (`weekly_holiday_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adjustments`
--
ALTER TABLE `adjustments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `adjustment_products`
--
ALTER TABLE `adjustment_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `allowance_deductions`
--
ALTER TABLE `allowance_deductions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `allowance_deduction_manages`
--
ALTER TABLE `allowance_deduction_manages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `daily_closings`
--
ALTER TABLE `daily_closings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `damages`
--
ALTER TABLE `damages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `damage_products`
--
ALTER TABLE `damage_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dealers`
--
ALTER TABLE `dealers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `dealer_groups`
--
ALTER TABLE `dealer_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `depos`
--
ALTER TABLE `depos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_education`
--
ALTER TABLE `employee_education`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_professional_information`
--
ALTER TABLE `employee_professional_information`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_routes`
--
ALTER TABLE `employee_routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_items`
--
ALTER TABLE `expense_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_application_manages`
--
ALTER TABLE `leave_application_manages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_installments`
--
ALTER TABLE `loan_installments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_people`
--
ALTER TABLE `loan_people`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=561;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `material_purchase`
--
ALTER TABLE `material_purchase`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `mobile_banks`
--
ALTER TABLE `mobile_banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=278;

--
-- AUTO_INCREMENT for table `module_role`
--
ALTER TABLE `module_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT for table `opening_stocks`
--
ALTER TABLE `opening_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `opening_stock_products`
--
ALTER TABLE `opening_stock_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_sheets`
--
ALTER TABLE `order_sheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_sheet_memos`
--
ALTER TABLE `order_sheet_memos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_sheet_products`
--
ALTER TABLE `order_sheet_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=628;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=557;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `product_material`
--
ALTER TABLE `product_material`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_prices`
--
ALTER TABLE `product_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `purchase_payments`
--
ALTER TABLE `purchase_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_return_materials`
--
ALTER TABLE `purchase_return_materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `salary_generates`
--
ALTER TABLE `salary_generates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_generate_payments`
--
ALTER TABLE `salary_generate_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_incements`
--
ALTER TABLE `salary_incements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sale_products`
--
ALTER TABLE `sale_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `sale_returns`
--
ALTER TABLE `sale_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_return_products`
--
ALTER TABLE `sale_return_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shift_manages`
--
ALTER TABLE `shift_manages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_outs`
--
ALTER TABLE `stock_outs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_out_materials`
--
ALTER TABLE `stock_out_materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `warehouse_material`
--
ALTER TABLE `warehouse_material`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `warehouse_product`
--
ALTER TABLE `warehouse_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `weekly_holiday_assigns`
--
ALTER TABLE `weekly_holiday_assigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adjustments`
--
ALTER TABLE `adjustments`
  ADD CONSTRAINT `adjustments_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `adjustment_products`
--
ALTER TABLE `adjustment_products`
  ADD CONSTRAINT `adjustment_products_adjustment_id_foreign` FOREIGN KEY (`adjustment_id`) REFERENCES `adjustments` (`id`),
  ADD CONSTRAINT `adjustment_products_base_unit_id_foreign` FOREIGN KEY (`base_unit_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `adjustment_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `allowance_deduction_manages`
--
ALTER TABLE `allowance_deduction_manages`
  ADD CONSTRAINT `allowance_deduction_manages_allowance_deduction_id_foreign` FOREIGN KEY (`allowance_deduction_id`) REFERENCES `allowance_deductions` (`id`),
  ADD CONSTRAINT `allowance_deduction_manages_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `banks`
--
ALTER TABLE `banks`
  ADD CONSTRAINT `banks_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `damages`
--
ALTER TABLE `damages`
  ADD CONSTRAINT `damages_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`);

--
-- Constraints for table `damage_products`
--
ALTER TABLE `damage_products`
  ADD CONSTRAINT `damage_products_base_unit_id_foreign` FOREIGN KEY (`base_unit_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `damage_products_damage_id_foreign` FOREIGN KEY (`damage_id`) REFERENCES `damages` (`id`),
  ADD CONSTRAINT `damage_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `dealers`
--
ALTER TABLE `dealers`
  ADD CONSTRAINT `dealers_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `dealers_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `dealers_upazila_id_foreign` FOREIGN KEY (`upazila_id`) REFERENCES `locations` (`id`);

--
-- Constraints for table `depos`
--
ALTER TABLE `depos`
  ADD CONSTRAINT `depos_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `depos_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `depos_upazila_id_foreign` FOREIGN KEY (`upazila_id`) REFERENCES `locations` (`id`);

--
-- Constraints for table `opening_stocks`
--
ALTER TABLE `opening_stocks`
  ADD CONSTRAINT `opening_stocks_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `opening_stock_products`
--
ALTER TABLE `opening_stock_products`
  ADD CONSTRAINT `opening_stock_products_base_unit_id_foreign` FOREIGN KEY (`base_unit_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `opening_stock_products_opening_stock_id_foreign` FOREIGN KEY (`opening_stock_id`) REFERENCES `opening_stocks` (`id`),
  ADD CONSTRAINT `opening_stock_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `order_sheet_memos`
--
ALTER TABLE `order_sheet_memos`
  ADD CONSTRAINT `order_sheet_memos_order_sheet_id_foreign` FOREIGN KEY (`order_sheet_id`) REFERENCES `order_sheets` (`id`),
  ADD CONSTRAINT `order_sheet_memos_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`);

--
-- Constraints for table `order_sheet_products`
--
ALTER TABLE `order_sheet_products`
  ADD CONSTRAINT `order_sheet_products_order_sheet_id_foreign` FOREIGN KEY (`order_sheet_id`) REFERENCES `order_sheets` (`id`),
  ADD CONSTRAINT `order_sheet_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_prices`
--
ALTER TABLE `product_prices`
  ADD CONSTRAINT `product_prices_dealer_group_id_foreign` FOREIGN KEY (`dealer_group_id`) REFERENCES `dealer_groups` (`id`),
  ADD CONSTRAINT `product_prices_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD CONSTRAINT `purchase_returns_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`);

--
-- Constraints for table `purchase_return_materials`
--
ALTER TABLE `purchase_return_materials`
  ADD CONSTRAINT `purchase_return_materials_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`),
  ADD CONSTRAINT `purchase_return_materials_purchase_return_id_foreign` FOREIGN KEY (`purchase_return_id`) REFERENCES `purchase_returns` (`id`),
  ADD CONSTRAINT `purchase_return_materials_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `sales_dealer_id_foreign` FOREIGN KEY (`dealer_id`) REFERENCES `dealers` (`id`),
  ADD CONSTRAINT `sales_depo_id_foreign` FOREIGN KEY (`depo_id`) REFERENCES `depos` (`id`),
  ADD CONSTRAINT `sales_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `sales_upazila_id_foreign` FOREIGN KEY (`upazila_id`) REFERENCES `locations` (`id`);

--
-- Constraints for table `sale_products`
--
ALTER TABLE `sale_products`
  ADD CONSTRAINT `sale_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `sale_products_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`);

--
-- Constraints for table `sale_returns`
--
ALTER TABLE `sale_returns`
  ADD CONSTRAINT `sale_returns_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`);

--
-- Constraints for table `sale_return_products`
--
ALTER TABLE `sale_return_products`
  ADD CONSTRAINT `sale_return_products_base_unit_id_foreign` FOREIGN KEY (`base_unit_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `sale_return_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `sale_return_products_sale_return_id_foreign` FOREIGN KEY (`sale_return_id`) REFERENCES `sale_returns` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
