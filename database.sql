-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `sharepic`;
CREATE DATABASE `sharepic` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `sharepic`;

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `avatar`;
CREATE TABLE `avatar` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `local_uri` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `User_id` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `avatar` (`id`, `local_uri`, `User_id`, `added_at`) VALUES
(1,	'uploads/0aced9fd55612acbfaac13dcb23312e6_5c92684f1c837.png',	1,	'2019-03-20 16:20:31');

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Publication_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `comment` (`id`, `text`, `added_at`, `Publication_id`, `User_id`) VALUES
(1,	'I am a comment',	'2019-03-22 04:23:22',	2,	1),
(2,	'Test',	'2019-03-22 04:36:45',	2,	1);

DROP TABLE IF EXISTS `connection`;
CREATE TABLE `connection` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expires_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `User_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `connection` (`id`, `token`, `ip`, `expires_at`, `created_at`, `User_id`) VALUES
(1,	'02d28392731e6be48973f7ace92f391691f23784',	'172.30.0.1',	'2019-03-24 13:11:30',	'2019-03-20 16:18:12',	1);

DROP TABLE IF EXISTS `conversation`;
CREATE TABLE `conversation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `User_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `conversation` (`id`, `name`, `User_id`) VALUES
(1,	'Test',	0),
(2,	'Testd',	1);

DROP TABLE IF EXISTS `conversation_has_user`;
CREATE TABLE `conversation_has_user` (
  `User_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Conversation_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `conversation_has_user` (`User_id`, `Conversation_id`, `added_at`) VALUES
('1',	'2',	'2019-03-22 08:59:20'),
('1',	'1',	'2019-03-22 09:51:28');

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Conversation_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `added_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `message` (`id`, `value`, `Conversation_id`, `User_id`, `added_at`) VALUES
(1,	'This is my message',	1,	1,	'2019-03-22 09:41:26'),
(2,	'This is my other message',	1,	1,	'2019-03-22 09:41:29');

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(19,	'2014_10_12_000000_create_user_table',	1),
(20,	'2016_06_01_000001_create_oauth_auth_codes_table',	1),
(21,	'2016_06_01_000002_create_oauth_access_tokens_table',	1),
(22,	'2016_06_01_000003_create_oauth_refresh_tokens_table',	1),
(23,	'2016_06_01_000004_create_oauth_clients_table',	1),
(24,	'2016_06_01_000005_create_oauth_personal_access_clients_table',	1),
(25,	'2019_03_19_083035_create_publication_table',	1),
(26,	'2019_03_19_083953_create_avatar_table',	1),
(27,	'2019_03_19_084116_create_comment_table',	1),
(28,	'2019_03_19_084220_create_photo_table',	1),
(29,	'2019_03_19_084421_create_notification_table',	1),
(30,	'2019_03_19_084806_create_subscription_table',	1),
(31,	'2019_03_19_085024_create_conversation_has_user_table',	1),
(32,	'2019_03_19_085158_create_conversation_table',	1),
(33,	'2019_03_19_085230_create_message_table',	1),
(34,	'2019_03_19_085625_create_connection_table',	1),
(35,	'2019_03_19_085751_create_reaction_table',	1),
(36,	'2019_03_19_090027_create_publication_reaction_table',	1);

DROP TABLE IF EXISTS `notification`;
CREATE TABLE `notification` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Publication_id` int(11) DEFAULT NULL,
  `Target_User_id` int(11) DEFAULT NULL,
  `seen` int(11) NOT NULL DEFAULT '0',
  `User_id` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `notification` (`id`, `message`, `Publication_id`, `Target_User_id`, `seen`, `User_id`, `added_at`) VALUES
(2,	'I am a notification',	NULL,	NULL,	1,	1,	'2019-03-21 10:17:56'),
(3,	'A second notification',	NULL,	NULL,	0,	2,	'2019-03-21 10:30:24');

DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE `oauth_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `photo`;
CREATE TABLE `photo` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `local_uri` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fingerprint` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `publication`;
CREATE TABLE `publication` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ids` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `geolocation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `User_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `publication_ids_unique` (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `publication` (`id`, `ids`, `description`, `geolocation`, `User_id`, `created_at`) VALUES
(2,	'UFJ09QJF9JF09QJFQZ0',	'Test',	'test',	1,	'2019-03-22 02:54:32');

DROP TABLE IF EXISTS `publication_photo`;
CREATE TABLE `publication_photo` (
  `Publication_id` bigint(20) NOT NULL,
  `Photo_id` bigint(20) NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `publication_reaction`;
CREATE TABLE `publication_reaction` (
  `Publication_id` bigint(20) unsigned NOT NULL,
  `User_id` bigint(20) unsigned NOT NULL,
  `reacted_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `Reaction_id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `publication_reaction` (`Publication_id`, `User_id`, `reacted_at`, `Reaction_id`) VALUES
(2,	1,	'2019-03-22 03:22:12',	1);

DROP TABLE IF EXISTS `reaction`;
CREATE TABLE `reaction` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_uri` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `reaction` (`id`, `name`, `image_uri`) VALUES
(1,	'Like',	'https://upload.wikimedia.org/wikipedia/commons/thumb/1/13/Facebook_like_thumb.png/220px-Facebook_like_thumb.png');

DROP TABLE IF EXISTS `subscription`;
CREATE TABLE `subscription` (
  `Subscribed_User_id` int(11) DEFAULT NULL,
  `Subscriber_User_id` int(11) DEFAULT NULL,
  `subscribed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ids` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_ids_unique` (`ids`),
  UNIQUE KEY `user_username_unique` (`username`),
  UNIQUE KEY `user_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user` (`id`, `ids`, `username`, `password`, `first_name`, `last_name`, `registered_at`, `email`) VALUES
(1,	'433ce36fa1d30d88427aac0b5064d48631aca017',	'flavienb',	'$2y$10$t.5wsCqxEaoC5n5FY0OFgO5CkOwtwDAC6LHPlYJDGD1AcVVazt65O',	'Flavien',	'Berwick',	'2019-03-20 16:18:12',	'flavien@berwick.fr');

-- 2019-03-22 13:56:35