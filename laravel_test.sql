-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.6.17 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win64
-- HeidiSQL 版本:                  9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 导出 laravel_test 的数据库结构
CREATE DATABASE IF NOT EXISTS `laravel_test` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `laravel_test`;


-- 导出  表 laravel_test.attr 结构
CREATE TABLE IF NOT EXISTS `attr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `input_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `input_box_type` tinyint(4) NOT NULL,
  `input_value_type` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.attr 的数据：~9 rows (大约)
/*!40000 ALTER TABLE `attr` DISABLE KEYS */;
INSERT INTO `attr` (`id`, `name`, `input_name`, `input_box_type`, `input_value_type`, `status`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(2, '型号', 'model', 1, 1, 1, 0, '2016-08-04 07:24:40', '2016-08-22 06:35:54', NULL),
	(3, '颜色', 'color', 3, 1, 1, 1, '2016-08-10 10:02:37', '2016-08-10 10:02:37', NULL),
	(4, '多选框test', 'check_box', 2, 1, 1, 1, '2016-08-10 10:11:16', '2016-08-10 10:11:16', NULL),
	(5, '选项测试2', 'option_test', 2, 1, 1, 1, '2016-08-11 03:32:39', '2016-08-11 03:32:39', NULL),
	(6, '选项测试3', 'option_tests', 2, 1, 1, 1, '2016-08-11 04:12:35', '2016-08-11 04:12:35', NULL),
	(9, '属性组关联属性停用测试', 'attr_test', 1, 1, 0, 1, '2016-08-14 07:03:29', '2016-08-14 12:25:38', NULL),
	(10, '选项组测试选项停用', 'option_test123', 2, 1, 0, 1, '2016-08-14 08:01:55', '2016-08-14 12:20:53', NULL),
	(12, '1111111111', '', 1, 1, 1, 0, '2016-08-17 07:06:43', '2016-08-17 07:06:43', NULL);
/*!40000 ALTER TABLE `attr` ENABLE KEYS */;


-- 导出  表 laravel_test.attr_attr_value 结构
CREATE TABLE IF NOT EXISTS `attr_attr_value` (
  `attr_id` int(10) unsigned NOT NULL,
  `attr_value_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`attr_id`,`attr_value_id`),
  KEY `attr_attr_value_attr_value_id_foreign` (`attr_value_id`),
  CONSTRAINT `attr_attr_value_attr_id_foreign` FOREIGN KEY (`attr_id`) REFERENCES `attr` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attr_attr_value_attr_value_id_foreign` FOREIGN KEY (`attr_value_id`) REFERENCES `attr_value` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.attr_attr_value 的数据：~13 rows (大约)
/*!40000 ALTER TABLE `attr_attr_value` DISABLE KEYS */;
INSERT INTO `attr_attr_value` (`attr_id`, `attr_value_id`) VALUES
	(2, 2),
	(2, 3),
	(3, 4),
	(3, 5),
	(4, 6),
	(4, 7),
	(5, 8),
	(5, 9),
	(6, 10),
	(6, 11),
	(6, 12),
	(10, 13),
	(10, 14),
	(6, 15),
	(3, 16);
/*!40000 ALTER TABLE `attr_attr_value` ENABLE KEYS */;


-- 导出  表 laravel_test.attr_group 结构
CREATE TABLE IF NOT EXISTS `attr_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `sort_order` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.attr_group 的数据：~1 rows (大约)
/*!40000 ALTER TABLE `attr_group` DISABLE KEYS */;
INSERT INTO `attr_group` (`id`, `name`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
	(10, 'test', 1, '1', '2016-08-22 02:31:05', '2016-08-22 02:31:05');
/*!40000 ALTER TABLE `attr_group` ENABLE KEYS */;


-- 导出  表 laravel_test.attr_group_attr 结构
CREATE TABLE IF NOT EXISTS `attr_group_attr` (
  `attr_group_id` int(10) unsigned NOT NULL,
  `attr_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`attr_group_id`,`attr_id`),
  KEY `attr_group_attr_attr_id_foreign` (`attr_id`),
  CONSTRAINT `attr_group_attr_attr_group_id_foreign` FOREIGN KEY (`attr_group_id`) REFERENCES `attr_group` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attr_group_attr_attr_id_foreign` FOREIGN KEY (`attr_id`) REFERENCES `attr` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.attr_group_attr 的数据：~2 rows (大约)
/*!40000 ALTER TABLE `attr_group_attr` DISABLE KEYS */;
INSERT INTO `attr_group_attr` (`attr_group_id`, `attr_id`) VALUES
	(10, 2),
	(10, 3);
/*!40000 ALTER TABLE `attr_group_attr` ENABLE KEYS */;


-- 导出  表 laravel_test.attr_value 结构
CREATE TABLE IF NOT EXISTS `attr_value` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.attr_value 的数据：~17 rows (大约)
/*!40000 ALTER TABLE `attr_value` DISABLE KEYS */;
INSERT INTO `attr_value` (`id`, `name`, `status`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, '红色', 1, 1, '2016-08-04 12:47:27', '2016-08-04 12:47:28', NULL),
	(2, 'ios32123123', 1, 112, '2016-08-04 09:10:09', '2016-08-25 06:32:40', '2016-08-25 06:32:40'),
	(3, 'ios64', 1, 2, '2016-08-10 07:17:58', '2016-08-10 07:17:58', NULL),
	(4, '红色', 1, 1, '2016-08-10 10:02:46', '2016-08-10 10:02:46', NULL),
	(5, '黄色', 1, 1, '2016-08-10 10:02:57', '2016-08-10 10:02:57', NULL),
	(6, '多选1', 1, 1, '2016-08-10 10:11:28', '2016-08-10 10:11:28', NULL),
	(7, '多选2', 1, 1, '2016-08-10 10:11:38', '2016-08-10 10:11:38', NULL),
	(8, '测试选项2-1', 1, 1, '2016-08-11 03:33:02', '2016-08-11 03:33:02', NULL),
	(9, '测试选项2-2', 1, 1, '2016-08-11 03:33:16', '2016-08-11 03:33:16', NULL),
	(10, '测试选项3-1', 1, 1, '2016-08-11 04:12:51', '2016-08-11 04:12:51', NULL),
	(11, '测试选项3-2', 1, 2, '2016-08-11 04:13:04', '2016-08-11 04:13:04', NULL),
	(12, '测试选项3-3', 1, 3, '2016-08-11 04:13:18', '2016-08-11 04:13:18', NULL),
	(13, 'test1', 1, 1, '2016-08-14 08:02:07', '2016-08-14 08:02:07', NULL),
	(14, 'test2', 1, 2, '2016-08-14 08:04:06', '2016-08-14 08:04:06', NULL),
	(15, '6666666666', 1, 0, '2016-08-17 07:02:33', '2016-08-17 07:02:33', NULL),
	(16, '888888', 1, 0, '2016-08-17 07:05:27', '2016-08-17 07:05:27', NULL);
/*!40000 ALTER TABLE `attr_value` ENABLE KEYS */;


-- 导出  表 laravel_test.brand 结构
CREATE TABLE IF NOT EXISTS `brand` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.brand 的数据：~2 rows (大约)
/*!40000 ALTER TABLE `brand` DISABLE KEYS */;
INSERT INTO `brand` (`id`, `name`, `status`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, '小米1', 1, 1, '2016-08-03 02:17:38', '2016-08-03 02:18:01', NULL),
	(3, '测试软删除', 1, 1, '2016-08-14 06:00:47', '2016-08-14 06:00:50', '2016-08-14 06:00:50'),
	(4, '测试44444', 1, 0, '2016-08-17 07:20:53', '2016-08-17 07:20:53', NULL);
/*!40000 ALTER TABLE `brand` ENABLE KEYS */;


-- 导出  表 laravel_test.category 结构
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.category 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`id`, `pid`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(7, 0, '分类1', 1, '2016-08-17 09:57:41', '2016-08-17 09:58:45', NULL),
	(8, 0, '分类2', 1, '2016-08-22 01:48:20', '2016-08-22 01:48:20', NULL),
	(9, 7, '分类1-1', 1, '2016-08-22 01:48:42', '2016-08-22 01:48:42', NULL),
	(10, 9, '分类1-1-1', 1, '2016-08-22 02:05:00', '2016-08-22 02:05:00', NULL);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;


-- 导出  表 laravel_test.category_attr_group 结构
CREATE TABLE IF NOT EXISTS `category_attr_group` (
  `category_id` int(10) unsigned NOT NULL,
  `attr_group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`category_id`,`attr_group_id`),
  KEY `category_attr_group_attr_group_id_foreign` (`attr_group_id`),
  CONSTRAINT `category_attr_group_attr_group_id_foreign` FOREIGN KEY (`attr_group_id`) REFERENCES `attr_group` (`id`) ON DELETE CASCADE,
  CONSTRAINT `category_attr_group_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.category_attr_group 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `category_attr_group` DISABLE KEYS */;
INSERT INTO `category_attr_group` (`category_id`, `attr_group_id`) VALUES
	(7, 10),
	(8, 10),
	(9, 10),
	(10, 10);
/*!40000 ALTER TABLE `category_attr_group` ENABLE KEYS */;


-- 导出  表 laravel_test.category_option_group 结构
CREATE TABLE IF NOT EXISTS `category_option_group` (
  `category_id` int(10) unsigned NOT NULL,
  `option_group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`category_id`,`option_group_id`),
  KEY `category_option_group_option_group_id_foreign` (`option_group_id`),
  CONSTRAINT `category_option_group_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  CONSTRAINT `category_option_group_option_group_id_foreign` FOREIGN KEY (`option_group_id`) REFERENCES `option_group` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.category_option_group 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `category_option_group` DISABLE KEYS */;
INSERT INTO `category_option_group` (`category_id`, `option_group_id`) VALUES
	(7, 6),
	(8, 6),
	(9, 6),
	(10, 6);
/*!40000 ALTER TABLE `category_option_group` ENABLE KEYS */;


-- 导出  表 laravel_test.channel 结构
CREATE TABLE IF NOT EXISTS `channel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_sync` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11317 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.channel 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `channel` DISABLE KEYS */;
INSERT INTO `channel` (`id`, `name`, `is_sync`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(11315, '分销12', 1, '2016-08-17 07:21:41', '2016-08-17 07:38:39', NULL),
	(11316, '123', 1, '2016-08-17 07:29:33', '2016-08-17 07:42:22', '2016-08-17 07:42:22');
/*!40000 ALTER TABLE `channel` ENABLE KEYS */;


-- 导出  表 laravel_test.channel_product_sub 结构
CREATE TABLE IF NOT EXISTS `channel_product_sub` (
  `channel_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`channel_id`,`product_id`),
  KEY `channel_product_sub_product_id_foreign` (`product_id`),
  CONSTRAINT `channel_product_sub_channel_id_foreign` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`id`) ON DELETE CASCADE,
  CONSTRAINT `channel_product_sub_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `product_sub` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.channel_product_sub 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `channel_product_sub` DISABLE KEYS */;
/*!40000 ALTER TABLE `channel_product_sub` ENABLE KEYS */;


-- 导出  表 laravel_test.migrations 结构
CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.migrations 的数据：~14 rows (大约)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`migration`, `batch`) VALUES
	('2014_10_12_000000_create_users_table', 1),
	('2014_10_12_100000_create_password_resets_table', 1),
	('2016_07_25_065139_create_roles_table', 1),
	('2016_07_25_065155_create_permissions_table', 1),
	('2016_08_02_070146_create_category_table', 2),
	('2016_08_02_071945_create_supplier_table', 2),
	('2016_08_02_094924_create_brand_table', 3),
	('2016_08_03_064923_create_attr_table', 4),
	('2016_08_05_014337_create_product_table', 5),
	('2016_08_09_014505_create_attr_group_table', 6),
	('2016_08_09_014551_create_option_group_table', 6),
	('2016_08_09_025322_create_category_option_group_table', 7),
	('2016_08_09_025352_create_category_attr_group_table', 7),
	('2016_08_17_030444_create_channel_table', 8),
	('2016_08_25_030524_create_sync_table', 9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;


-- 导出  表 laravel_test.option_group 结构
CREATE TABLE IF NOT EXISTS `option_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `sort_order` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.option_group 的数据：~1 rows (大约)
/*!40000 ALTER TABLE `option_group` DISABLE KEYS */;
INSERT INTO `option_group` (`id`, `name`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
	(6, '选项test1', 1, '1', '2016-08-22 02:55:22', '2016-08-22 02:55:22');
/*!40000 ALTER TABLE `option_group` ENABLE KEYS */;


-- 导出  表 laravel_test.option_group_attr 结构
CREATE TABLE IF NOT EXISTS `option_group_attr` (
  `option_group_id` int(10) unsigned NOT NULL,
  `attr_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`option_group_id`,`attr_id`),
  KEY `option_group_attr_attr_id_foreign` (`attr_id`),
  CONSTRAINT `option_group_attr_attr_id_foreign` FOREIGN KEY (`attr_id`) REFERENCES `attr` (`id`) ON DELETE CASCADE,
  CONSTRAINT `option_group_attr_option_group_id_foreign` FOREIGN KEY (`option_group_id`) REFERENCES `option_group` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.option_group_attr 的数据：~3 rows (大约)
/*!40000 ALTER TABLE `option_group_attr` DISABLE KEYS */;
INSERT INTO `option_group_attr` (`option_group_id`, `attr_id`) VALUES
	(6, 4),
	(6, 5),
	(6, 6);
/*!40000 ALTER TABLE `option_group_attr` ENABLE KEYS */;


-- 导出  表 laravel_test.password_resets 结构
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.password_resets 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;


-- 导出  表 laravel_test.permissions 结构
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `route` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_display` tinyint(4) NOT NULL,
  `sort_order` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `label` (`label`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.permissions 的数据：~16 rows (大约)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `pid`, `name`, `label`, `route`, `description`, `is_display`, `sort_order`, `created_at`, `updated_at`) VALUES
	(1, 0, '权限模块', '权限模块', '/admin', '权限模块', 1, '', '2016-07-29 07:17:35', '2016-07-29 07:17:35'),
	(4, 1, '管理员管理', '管理员管理', '/admin/admins', '管理员管理', 1, '', '2016-08-12 09:37:42', '2016-08-12 09:37:44'),
	(5, 4, '管理员添加', '管理员管理-添加', '/admin/admins/create', '管理员添加', 1, '', '2016-08-12 09:37:45', '2016-08-12 09:37:46'),
	(6, 1, '菜单管理', '菜单管理', '/admin/menus', '菜单管理', 1, '', '2016-08-12 09:37:46', '2016-08-12 09:37:47'),
	(17, 1, '权限组管理', '权限组管理', '/admin/roles', '权限组管理', 1, '', '2016-07-29 07:17:35', '2016-07-29 07:17:35'),
	(18, 0, '商品管理', '商品模块', '/product', '商品模块', 1, '', '2016-08-02 04:16:00', '2016-08-02 04:16:00'),
	(19, 18, '商品列表', '商品列表', '/product/products', '商品列表', 1, '', '2016-08-02 04:26:34', '2016-08-02 04:26:34'),
	(20, 18, '商品类型', '商品类型', '/product/category', '商品分类', 1, '2', '2016-08-02 06:37:23', '2016-08-02 06:37:23'),
	(21, 18, '供应商列表', '供应商列表', '/product/supplier', '供应商列表', 1, '3', '2016-08-02 07:50:38', '2016-08-02 07:50:38'),
	(22, 18, '品牌管理', '品牌管理', '/product/brand', '品牌管理', 1, '4', '2016-08-02 09:40:43', '2016-08-02 09:40:43'),
	(23, 18, '属性管理', '属性管理', '/product/property', '属性管理', 1, '4', '2016-08-03 06:48:28', '2016-08-03 06:48:28'),
	(24, 18, '属性组管理', '属性组管理', '/product/attr_group', '属性组管理', 1, '4', '2016-08-09 01:32:37', '2016-08-09 01:32:37'),
	(25, 18, '选项组管理', '选项组管理', '/product/option_group', '选项组管理', 1, '6', '2016-08-09 01:33:27', '2016-08-09 01:33:27'),
	(26, 0, '营销模块', '营销模块', '/channel', '营销模块', 1, '3', '2016-08-17 03:36:52', '2016-08-17 03:36:52'),
	(27, 26, '渠道管理', '渠道管理', '/channel/channels', '渠道管理', 1, '1', '2016-08-17 03:37:45', '2016-08-17 03:37:45'),
	(29, 19, '子商品列表', '子商品列表', '/product/product_sub/{id}', '子商品列表', 1, '1', '2016-08-17 08:24:44', '2016-08-17 08:24:44'),
	(30, 4, '管理员修改', '管理员管理-修改', '/admin/admins/edit', '管理员修改', 1, '', '2016-08-12 09:37:45', '2016-08-12 09:37:46'),
	(31, 4, '管理员删除', '管理员管理-删除', '/admin/admins/destroy', '管理员删除', 1, '3', '2016-08-25 03:59:19', '2016-08-25 03:59:19'),
	(32, 4, '管理权限分配', '管理员管理-权限分配', '/admin/admins/assign', '管理权限分配', 1, '4', '2016-08-25 04:00:54', '2016-08-25 04:00:54'),
	(33, 6, '菜单添加', '菜单管理-添加', '/admin/menus/create', '菜单添加', 1, '1', '2016-08-25 04:02:16', '2016-08-25 04:02:16'),
	(34, 6, '菜单修改', '菜单管理-修改', '/admin/menus/edit', '菜单修改', 1, '2', '2016-08-25 04:09:51', '2016-08-25 04:09:51'),
	(35, 6, '菜单删除', '菜单管理-删除', '/admin/menus/destroy', '菜单删除', 1, '3', '2016-08-25 04:10:54', '2016-08-25 04:10:54'),
	(36, 17, '权限组添加', '权限组管理-添加', '/admin/roles/create', '权限组添加', 1, '1', '2016-08-25 04:16:01', '2016-08-25 04:16:01'),
	(37, 17, '权限组修改', '权限组管理-修改', '/admin/roles/edit', '', 1, '', '2016-08-25 04:18:43', '2016-08-25 04:18:43'),
	(38, 17, '权限组删除', '权限组管理-删除', '/admin/roles/destroy', '', 1, '3', '2016-08-25 04:21:35', '2016-08-25 04:21:35'),
	(39, 17, '权限组分配权限', '权限组管理-权限分配', '/admin/roles/assign', '', 1, '', '2016-08-25 04:23:08', '2016-08-25 04:23:08'),
	(40, 20, '商品类型添加', '商品类型-添加', '/product/category/create', '', 1, '', '2016-08-25 04:42:14', '2016-08-25 04:42:14'),
	(41, 20, '商品类型修改', '商品类型-修改', '/product/category/edit', '', 1, '', '2016-08-25 05:35:23', '2016-08-25 05:35:23'),
	(42, 20, '商品类型删除', '商品类型-删除', '/product/category/destroy', '', 1, '', '2016-08-25 05:36:58', '2016-08-25 05:36:58'),
	(43, 21, '供应商添加', '供应商管理-添加', '/product/supplier/create', '', 1, '', '2016-08-25 05:41:48', '2016-08-25 05:41:48'),
	(44, 21, '供应商修改', '供应商管理-修改', '/product/supplier/edit', '', 1, '', '2016-08-25 05:43:18', '2016-08-25 05:43:18'),
	(45, 21, '供应商删除', '供应商管理-删除', '/product/supplier/destory', '', 1, '', '2016-08-25 05:44:48', '2016-08-25 05:44:48'),
	(46, 22, '品牌添加', '品牌管理-添加', '/product/brand/create', '', 1, '', '2016-08-25 05:46:29', '2016-08-25 05:46:29'),
	(47, 22, '品牌修改', '品牌管理-修改', '/product/brand/edit', '', 1, '', '2016-08-25 05:47:32', '2016-08-25 05:47:32'),
	(48, 22, '品牌删除', '品牌管理-删除', '/product/brand/destory', '', 1, '', '2016-08-25 05:50:58', '2016-08-25 05:50:58'),
	(49, 23, '属性添加', '属性管理-添加', '/product/property/create', '', 1, '', '2016-08-25 06:03:35', '2016-08-25 06:03:35'),
	(50, 23, '属性修改', '属性管理-修改', '/product/property/edit', '', 1, '', '2016-08-25 06:18:24', '2016-08-25 06:18:24'),
	(51, 23, '属性值列表', '属性值列表', '/product/attr_value/{id}', '', 1, '', '2016-08-25 06:21:06', '2016-08-25 06:21:06'),
	(52, 51, '属性值添加', '属性值管理-添加', '/product/attr_value/create_value', '', 1, '', '2016-08-25 06:27:29', '2016-08-25 06:27:29'),
	(53, 51, '属性值删除', '属性值删除', '/product/attr_value/destroy', '', 1, '', '2016-08-25 06:33:57', '2016-08-25 06:33:57'),
	(54, 24, '属性组添加', '属性组管理-添加', '/product/attr_group/create', '', 1, '', '2016-08-25 06:38:26', '2016-08-25 06:38:26'),
	(55, 24, '属性组修改', '属性组管理-修改', '/product/attr_group/edit', '', 1, '', '2016-08-25 06:41:23', '2016-08-25 06:41:23'),
	(56, 24, '属性组关联属性', '属性组管理-关联属性', '/product/attr_group/relevance', '', 1, '', '2016-08-25 06:42:47', '2016-08-25 06:42:47'),
	(57, 25, '选项组添加', '选项组管理-添加', '/product/option_group/create', '', 1, '', '2016-08-25 06:45:15', '2016-08-25 06:45:15'),
	(58, 25, '选项组修改', '选项组管理-修改', '/product/option_group/edit', '', 1, '', '2016-08-25 06:46:11', '2016-08-25 06:46:11'),
	(59, 25, '选项组关联属性', '选项组管理-关联属性', '/product/option_group/relevance', '', 1, '', '2016-08-25 06:47:48', '2016-08-25 06:47:48'),
	(60, 27, '渠道添加', '渠道管理-添加', '/channel/channels/create', '', 1, '', '2016-08-25 06:51:57', '2016-08-25 06:51:57'),
	(61, 27, '渠道修改', '渠道管理-修改', '/channel/channels/edit', '', 1, '', '2016-08-25 06:53:48', '2016-08-25 06:53:48'),
	(62, 27, '渠道删除', '渠道管理-删除', '/channel/channels/destory', '', 1, '', '2016-08-25 06:55:47', '2016-08-25 06:55:47'),
	(63, 19, '主商品添加', '主商品列表-添加', '/product/products/create', '', 1, '', '2016-08-25 07:00:17', '2016-08-25 07:00:17'),
	(64, 19, '主商品查看', '主商品列表-查看', '/product/products/{id}', '', 1, '', '2016-08-25 07:03:04', '2016-08-25 07:03:04'),
	(65, 19, '主商品编辑', '主商品列表-编辑', '/product/products/edit', '', 1, '', '2016-08-25 07:05:08', '2016-08-25 07:05:08'),
	(66, 19, '主商品删除', '主商品列表-删除', '/product/products/destory', '', 1, '', '2016-08-25 07:06:00', '2016-08-25 07:06:00'),
	(67, 19, '商品批处理', '商品批处理', '/product/products/batch', '', 1, '', '2016-08-25 07:07:57', '2016-08-25 07:07:57'),
	(68, 29, '子商品添加', '子商品列表-添加', '/product/product_sub/create', '', 1, '', '2016-08-25 07:11:59', '2016-08-25 07:11:59'),
	(69, 29, '子商品查看', '子商品列表-查看', '/product/product_sub/show_details', '', 1, '', '2016-08-25 07:13:29', '2016-08-25 07:13:29'),
	(70, 29, '子商品编辑', '子商品列表-修改', '/product/product_sub/edit', '', 1, '', '2016-08-25 07:14:01', '2016-08-25 07:14:01'),
	(71, 29, '子商品删除', '子商品列表-删除', '/product/product_sub/destory', '', 1, '', '2016-08-25 07:14:33', '2016-08-25 07:14:33');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;


-- 导出  表 laravel_test.permission_role 结构
CREATE TABLE IF NOT EXISTS `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.permission_role 的数据：~18 rows (大约)
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
	(1, 3),
	(4, 3),
	(6, 3),
	(17, 3),
	(18, 3),
	(19, 3),
	(20, 3),
	(21, 3),
	(22, 3),
	(23, 3),
	(24, 3),
	(25, 3),
	(26, 3),
	(27, 3),
	(29, 3),
	(33, 3),
	(34, 3),
	(35, 3),
	(39, 3),
	(51, 3),
	(56, 3),
	(1, 4),
	(17, 4);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;


-- 导出  表 laravel_test.product 结构
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` text COLLATE utf8_unicode_ci,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_attr` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.product 的数据：~1 rows (大约)
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`id`, `supplier_id`, `brand_id`, `category_id`, `name`, `details`, `description`, `seo_keywords`, `seo_description`, `label`, `public_attr`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(6, 3, 1, 7, '123', '&lt;p&gt;123123123&lt;/p&gt;', '', '', '', '', '{"model":"123","color":{"4":"\\u7ea2\\u8272"}}', '2016-08-25 02:37:30', '2016-08-25 02:37:30', NULL);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;


-- 导出  表 laravel_test.product_sub 结构
CREATE TABLE IF NOT EXISTS `product_sub` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `productNo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sale_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `review` tinyint(4) NOT NULL,
  `is_show` tinyint(4) NOT NULL,
  `sort_order` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `private_attr` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.product_sub 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `product_sub` DISABLE KEYS */;
INSERT INTO `product_sub` (`id`, `product_id`, `productNo`, `price`, `sale_price`, `image`, `review`, `is_show`, `sort_order`, `private_attr`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(15, 2, '1231231231231231', 123123.00, 123123.00, '', 1, 1, '123', '{"option_test":{"8":"\\u6d4b\\u8bd5\\u9009\\u98792-1"}}', '2016-08-22 10:01:46', '2016-08-23 01:58:21', '2016-08-23 01:58:21'),
	(16, 2, '1231231231231231', 123123.00, 123123.00, '', 1, 1, '123', '{"option_test":{"9":"\\u6d4b\\u8bd5\\u9009\\u98792-2"}}', '2016-08-22 10:01:46', '2016-08-23 01:58:21', '2016-08-23 01:58:21'),
	(17, 3, '123123123', 123.00, 123.00, 'avatar-mini.jpg', 1, 0, '1', '{"option_test":{"8":"\\u6d4b\\u8bd5\\u9009\\u98792-1"},"option_tests":{"10":"\\u6d4b\\u8bd5\\u9009\\u98793-1"}}', '2016-08-23 01:59:31', '2016-08-25 02:27:43', NULL),
	(18, 3, '123123123', 123.00, 123.00, '', 1, 1, '1', '{"option_test":{"9":"\\u6d4b\\u8bd5\\u9009\\u98792-2"},"option_tests":{"10":"\\u6d4b\\u8bd5\\u9009\\u98793-1"}}', '2016-08-23 01:59:31', '2016-08-23 08:30:11', NULL),
	(19, 6, '007252737', 1.00, 1.00, '', 1, 1, '1', '{"check_box":{"6":"\\u591a\\u90091"},"option_test":{"8":"\\u6d4b\\u8bd5\\u9009\\u98792-1"},"option_tests":{"10":"\\u6d4b\\u8bd5\\u9009\\u98793-1"}}', '2016-08-25 07:11:07', '2016-08-25 07:11:07', NULL);
/*!40000 ALTER TABLE `product_sub` ENABLE KEYS */;


-- 导出  表 laravel_test.roles 结构
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.roles 的数据：~2 rows (大约)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `label`, `description`, `created_at`, `updated_at`) VALUES
	(3, '超级管理员', '超级管理员', '超级管理员', '2016-07-29 07:57:28', '2016-07-29 07:57:28'),
	(4, '编辑', '编辑', '编辑', '2016-08-02 02:31:41', '2016-08-02 02:31:41'),
	(5, '测试999', '123', '321', '2016-08-17 08:39:06', '2016-08-17 08:39:06');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;


-- 导出  表 laravel_test.role_user 结构
CREATE TABLE IF NOT EXISTS `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`user_id`),
  KEY `role_user_user_id_foreign` (`user_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.role_user 的数据：~3 rows (大约)
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
	(4, 3),
	(4, 4),
	(4, 5);
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;


-- 导出  表 laravel_test.supplier 结构
CREATE TABLE IF NOT EXISTS `supplier` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.supplier 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` (`id`, `name`, `status`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(3, '爱康国宾', 1, '爱康国宾', '2016-08-02 09:34:55', '2016-08-02 09:35:06', NULL),
	(4, '测试软删除', 1, '测试软删除测试软删除测试软删除', '2016-08-14 06:04:00', '2016-08-14 06:04:04', '2016-08-14 06:04:04'),
	(5, '测试8888', 1, '', '2016-08-17 07:16:52', '2016-08-17 07:16:52', NULL),
	(6, 'cedhi 44444', 0, '55555', '2016-08-18 03:21:39', '2016-08-18 03:21:39', NULL);
/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;


-- 导出  表 laravel_test.sync 结构
CREATE TABLE IF NOT EXISTS `sync` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `mall_product_id` int(11) NOT NULL,
  `fenxiao_product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.sync 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `sync` DISABLE KEYS */;
INSERT INTO `sync` (`id`, `product_id`, `mall_product_id`, `fenxiao_product_id`, `created_at`, `updated_at`) VALUES
	(4, 6, 8, 0, '2016-08-25 03:36:11', '2016-08-25 03:36:11');
/*!40000 ALTER TABLE `sync` ENABLE KEYS */;


-- 导出  表 laravel_test.users 结构
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.users 的数据：~3 rows (大约)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `status`, `created_at`, `updated_at`) VALUES
	(4, 'test', 'test@mall.com', '$2y$10$6UHFhxrHLlutS15KogGVVeGpOqrc0y30JvXtN8/i27IDkMnNcg30a', 'axvjOawBD0fMXRJwbmXY9PDV5u4WTRxsdUtQZCzAm8Gj9UKEynOFggsEdHeM', 1, '2016-07-27 05:10:54', '2016-08-17 08:46:59'),
	(5, 'test', 'test@ikang.com', '$2y$10$jBxl4N9/DxZPBlfIk4ifwuwKInrQ6Wt4wieBdge9r/Q0nWxicqjWG', 'U8NjBZRP3PTJjFFvVQwXvB8xdvLUq6ansRXmQumZcngYfsrirnzavQegU7hg', 1, '2016-07-28 03:24:01', '2016-08-19 02:36:43'),
	(6, 'test', 'test@mall1.com', '$2y$10$Nlb6zTi2v9ReT5YZKtngC.WKUu8tgGm9Fgh8VfIRr89o.J6qH/2qG', 'r60FdyqzMGnCSGNo51wXRz4duNjBZuwXK0z4WPcqDoVFJjWqccZeLvK7UtTK', 1, '2016-07-28 03:28:47', '2016-07-28 03:40:58');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
