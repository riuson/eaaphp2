-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июл 02 2011 г., 12:26
-- Версия сервера: 5.1.54
-- Версия PHP: 5.3.5-1ubuntu7.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `eaaphp2db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `api_account_balance`
--

CREATE TABLE IF NOT EXISTS `api_account_balance` (
  `recordId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `accountId` bigint(40) NOT NULL,
  `accountKey` bigint(20) NOT NULL,
  `balance` double NOT NULL,
  `balanceUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`recordId`),
  UNIQUE KEY `account` (`accountId`,`accountKey`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Структура таблицы `api_alliances`
--

CREATE TABLE IF NOT EXISTS `api_alliances` (
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `shortName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `allianceId` bigint(20) unsigned NOT NULL,
  `executorCorpId` bigint(20) unsigned NOT NULL,
  `memberCount` bigint(20) unsigned NOT NULL,
  `startDate` date NOT NULL,
  `updateFlag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`allianceId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='alliance''s list';

-- --------------------------------------------------------

--
-- Структура таблицы `api_bots`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `eaaphp2db`.`api_bots` AS select count(0) AS `c`,`eaaphp2db`.`api_test_visitors`.`address` AS `address` from `eaaphp2db`.`api_test_visitors` where (`eaaphp2db`.`api_test_visitors`.`login` like '') group by `eaaphp2db`.`api_test_visitors`.`address` order by count(0) desc;

-- --------------------------------------------------------

--
-- Структура таблицы `api_cache`
--

CREATE TABLE IF NOT EXISTS `api_cache` (
  `recordId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `accountId` bigint(40) NOT NULL,
  `uri` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `cached` datetime NOT NULL COMMENT 'update time',
  `cachedUntil` datetime NOT NULL COMMENT 'next update time',
  `cachedValue` mediumtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'server response',
  PRIMARY KEY (`recordId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=510 ;

-- --------------------------------------------------------

--
-- Структура таблицы `api_corporations`
--

CREATE TABLE IF NOT EXISTS `api_corporations` (
  `corporationId` bigint(20) unsigned NOT NULL,
  `startDate` datetime NOT NULL,
  `allianceId` bigint(20) NOT NULL,
  `updateFlag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`corporationId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='corporation''s list';

-- --------------------------------------------------------

--
-- Структура таблицы `api_corporation_divisions`
--

CREATE TABLE IF NOT EXISTS `api_corporation_divisions` (
  `recordId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `accountId` bigint(20) NOT NULL,
  `accountKey` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '0 - wallet division, 1 - division',
  `divisionName` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`recordId`),
  UNIQUE KEY `uniqueId` (`accountId`,`accountKey`,`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Структура таблицы `api_errors_log`
--

CREATE TABLE IF NOT EXISTS `api_errors_log` (
  `recordId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `_date_` datetime NOT NULL,
  `message` varchar(1023) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`recordId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `api_outposts`
--

CREATE TABLE IF NOT EXISTS `api_outposts` (
  `stationId` bigint(20) unsigned NOT NULL,
  `stationName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stationTypeId` bigint(20) unsigned NOT NULL,
  `solarSystemId` bigint(20) unsigned NOT NULL,
  `corporationId` bigint(20) unsigned NOT NULL,
  `corporationName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateFlag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`stationId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `api_reftypes`
--

CREATE TABLE IF NOT EXISTS `api_reftypes` (
  `refTypeId` bigint(20) NOT NULL,
  `refTypeName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateFlag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`refTypeId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `api_users`
--

CREATE TABLE IF NOT EXISTS `api_users` (
  `accountId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT 'login for this site',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'md5 password',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'email',
  `master` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT 'master account login, if empty - it is master',
  `userId` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'eve online userId',
  `apiKey` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT 'full api key',
  `characterId` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'characterId for api requests',
  `characterName` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unknown' COMMENT 'characterName of player character',
  `access` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'list of enabled modes',
  PRIMARY KEY (`accountId`),
  UNIQUE KEY `indexLogin` (`login`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user accounts' AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Структура таблицы `api_visitors`
--

CREATE TABLE IF NOT EXISTS `api_visitors` (
  `recordId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `_date_` datetime NOT NULL,
  `address` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `agent` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`recordId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22086 ;

-- --------------------------------------------------------

--
-- Структура таблицы `api_wallet_journal`
--

CREATE TABLE IF NOT EXISTS `api_wallet_journal` (
  `recordId` bigint(20) NOT NULL AUTO_INCREMENT,
  `accountId` int(40) NOT NULL,
  `accountKey` bigint(20) NOT NULL,
  `refId` bigint(20) NOT NULL,
  `_date_` datetime NOT NULL,
  `refTypeId` bigint(20) NOT NULL,
  `ownerName1` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ownerId1` bigint(20) NOT NULL,
  `ownerName2` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ownerId2` bigint(20) NOT NULL,
  `argName1` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `argId1` bigint(20) NOT NULL,
  `amount` double NOT NULL,
  `balance` double NOT NULL,
  `reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  PRIMARY KEY (`recordId`),
  UNIQUE KEY `unique_record` (`accountId`,`refId`,`_date_`,`accountKey`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63208 ;

-- --------------------------------------------------------

--
-- Структура таблицы `api_wallet_transactions`
--

CREATE TABLE IF NOT EXISTS `api_wallet_transactions` (
  `recordId` bigint(20) NOT NULL AUTO_INCREMENT,
  `accountId` bigint(40) NOT NULL,
  `accountKey` bigint(20) NOT NULL,
  `transId` bigint(20) NOT NULL,
  `_date_` datetime NOT NULL,
  `quantity` bigint(20) NOT NULL,
  `typeName` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `typeId` bigint(20) NOT NULL,
  `price` double NOT NULL,
  `clientId` bigint(20) NOT NULL,
  `clientName` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `characterId` bigint(20) NOT NULL,
  `characterName` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `stationId` bigint(20) NOT NULL,
  `stationName` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `transactionType` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `transactionFor` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`recordId`),
  UNIQUE KEY `unique_record` (`accountId`,`transId`,`accountKey`,`_date_`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8250 ;
