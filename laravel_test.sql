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
  `input_box_type` tinyint(4) NOT NULL,
  `input_value_type` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.attr 的数据：~2 rows (大约)
/*!40000 ALTER TABLE `attr` DISABLE KEYS */;
INSERT INTO `attr` (`id`, `name`, `input_box_type`, `input_value_type`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
	(1, '颜色', 3, 1, 1, 1, '2016-08-04 03:58:21', '2016-08-04 03:58:21'),
	(2, '型号', 3, 1, 1, 0, '2016-08-04 07:24:40', '2016-08-04 07:24:40');
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

-- 正在导出表  laravel_test.attr_attr_value 的数据：~2 rows (大约)
/*!40000 ALTER TABLE `attr_attr_value` DISABLE KEYS */;
INSERT INTO `attr_attr_value` (`attr_id`, `attr_value_id`) VALUES
	(1, 1),
	(2, 2);
/*!40000 ALTER TABLE `attr_attr_value` ENABLE KEYS */;


-- 导出  表 laravel_test.attr_value 结构
CREATE TABLE IF NOT EXISTS `attr_value` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.attr_value 的数据：~2 rows (大约)
/*!40000 ALTER TABLE `attr_value` DISABLE KEYS */;
INSERT INTO `attr_value` (`id`, `name`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
	(1, '红色', 1, 1, '2016-08-04 12:47:27', '2016-08-04 12:47:28'),
	(2, 'ios32123123', 1, 112, '2016-08-04 09:10:09', '2016-08-04 10:10:35');
/*!40000 ALTER TABLE `attr_value` ENABLE KEYS */;


-- 导出  表 laravel_test.brand 结构
CREATE TABLE IF NOT EXISTS `brand` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.brand 的数据：~1 rows (大约)
/*!40000 ALTER TABLE `brand` DISABLE KEYS */;
INSERT INTO `brand` (`id`, `name`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
	(1, '小米1', 1, 1, '2016-08-03 02:17:38', '2016-08-03 02:18:01');
/*!40000 ALTER TABLE `brand` ENABLE KEYS */;


-- 导出  表 laravel_test.category 结构
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.category 的数据：~2 rows (大约)
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`id`, `pid`, `name`, `status`, `created_at`, `updated_at`) VALUES
	(2, 0, '手机123', 1, '2016-08-03 06:14:15', '2016-08-03 06:34:43'),
	(3, 2, '电脑下级1', 1, '2016-08-03 06:19:59', '2016-08-03 06:34:31');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;


-- 导出  表 laravel_test.migrations 结构
CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.migrations 的数据：~9 rows (大约)
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
	('2016_08_05_014337_create_product_table', 5);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;


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
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.permissions 的数据：~11 rows (大约)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `pid`, `name`, `label`, `route`, `description`, `is_display`, `sort_order`, `created_at`, `updated_at`) VALUES
	(1, 0, '权限模块', '权限模块', '#', NULL, 1, '', '2016-07-29 07:17:35', '2016-07-29 07:17:35'),
	(4, 1, '管理员管理', '管理员管理', '/admin/admins', NULL, 1, '', NULL, NULL),
	(5, 4, '管理员添加', '管理员管理-添加', '/admin/admins/create', NULL, 0, '', NULL, NULL),
	(6, 1, '菜单管理', '菜单管理', '/admin/menus', NULL, 1, '', NULL, NULL),
	(17, 1, '权限组管理', '权限组管理', '/admin/roles', '权限组管理', 1, '', '2016-07-29 07:17:35', '2016-07-29 07:17:35'),
	(18, 0, '商品管理', '商品模块', '#', '商品模块', 1, '', '2016-08-02 04:16:00', '2016-08-02 04:16:00'),
	(19, 18, '商品列表', '商品列表', '/product/products', '商品列表', 1, '', '2016-08-02 04:26:34', '2016-08-02 04:26:34'),
	(20, 18, '商品分类', '商品分类', '/product/category', '商品分类', 1, '2', '2016-08-02 06:37:23', '2016-08-02 06:37:23'),
	(21, 18, '供应商列表', '供应商列表', '/product/supplier', '供应商列表', 1, '3', '2016-08-02 07:50:38', '2016-08-02 07:50:38'),
	(22, 18, '品牌管理', '品牌管理', '/product/brand', '品牌管理', 1, '4', '2016-08-02 09:40:43', '2016-08-02 09:40:43'),
	(23, 18, '属性管理', '属性管理', '/product/attr', '属性管理', 1, '4', '2016-08-03 06:48:28', '2016-08-03 06:48:28');
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

-- 正在导出表  laravel_test.permission_role 的数据：~13 rows (大约)
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
	(1, 3),
	(4, 3),
	(5, 3),
	(6, 3),
	(17, 3),
	(18, 3),
	(19, 3),
	(20, 3),
	(21, 3),
	(22, 3),
	(23, 3),
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
  `details` text COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `public_attr` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.product 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`id`, `supplier_id`, `brand_id`, `category_id`, `name`, `details`, `description`, `seo_keywords`, `seo_description`, `label`, `public_attr`, `created_at`, `updated_at`) VALUES
	(1, 3, 1, 2, '测试商品1', '测试商品1', '测试商品1', '测试商品1', '测试商品1', '测试商品1', '', '2016-08-05 08:02:12', '2016-08-05 08:02:12');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;


-- 导出  表 laravel_test.product_sub 结构
CREATE TABLE IF NOT EXISTS `product_sub` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `productNo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `review` tinyint(4) NOT NULL,
  `is_show` tinyint(4) NOT NULL,
  `sort_order` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `private_attr` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.product_sub 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `product_sub` DISABLE KEYS */;
INSERT INTO `product_sub` (`id`, `product_id`, `productNo`, `price`, `sale_price`, `image`, `review`, `is_show`, `sort_order`, `private_attr`, `created_at`, `updated_at`) VALUES
	(1, 1, '111', 1.00, 0.00, '', 0, 0, '', '', '2016-08-05 16:10:25', '2016-08-05 16:10:27');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.roles 的数据：~3 rows (大约)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `label`, `description`, `created_at`, `updated_at`) VALUES
	(3, '超级管理员', '超级管理员', '超级管理员', '2016-07-29 07:57:28', '2016-07-29 07:57:28'),
	(4, '编辑', '编辑', '编辑', '2016-08-02 02:31:41', '2016-08-02 02:31:41');
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

-- 正在导出表  laravel_test.role_user 的数据：~1 rows (大约)
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
	(4, 3);
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;


-- 导出  表 laravel_test.supplier 结构
CREATE TABLE IF NOT EXISTS `supplier` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  laravel_test.supplier 的数据：~1 rows (大约)
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` (`id`, `name`, `status`, `description`, `created_at`, `updated_at`) VALUES
	(3, '爱康国宾', 1, '爱康国宾', '2016-08-02 09:34:55', '2016-08-02 09:35:06');
/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;


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

-- 正在导出表  laravel_test.users 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `status`, `created_at`, `updated_at`) VALUES
	(4, 'test', 'test@mall.com', '$2y$10$6UHFhxrHLlutS15KogGVVeGpOqrc0y30JvXtN8/i27IDkMnNcg30a', '0RvpnjABhZuM0KZAp94oPlm0CzgM4dDpHdcoTesmTgYYpfoGT3mUyO5smwLN', 1, '2016-07-27 05:10:54', '2016-07-28 07:20:38'),
	(5, 'test', 'test@ikang.com', '$2y$10$jBxl4N9/DxZPBlfIk4ifwuwKInrQ6Wt4wieBdge9r/Q0nWxicqjWG', 'wHvB7u0ehN344LhRVO3E6jKP7L9xWdVSmTEsVtIj8NXIrmmjRX7eEOofTdqU', 1, '2016-07-28 03:24:01', '2016-07-28 03:26:07'),
	(6, 'test', 'test@mall1.com', '$2y$10$Nlb6zTi2v9ReT5YZKtngC.WKUu8tgGm9Fgh8VfIRr89o.J6qH/2qG', 'r60FdyqzMGnCSGNo51wXRz4duNjBZuwXK0z4WPcqDoVFJjWqccZeLvK7UtTK', 1, '2016-07-28 03:28:47', '2016-07-28 03:40:58');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
