-- phpMyAdmin SQL Dump
-- version 2.11.3deb1ubuntu1.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 17, 2010 at 10:05 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.4-2ubuntu5.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `skm`
--
DROP DATABASE IF EXISTS `skm`;
CREATE DATABASE `skm` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `skm`;

SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ANSI';
USE skm ;
DROP PROCEDURE IF EXISTS skm.drop_user_if_exists ;
DELIMITER $$
CREATE PROCEDURE skm.drop_user_if_exists()
BEGIN
  DECLARE foo BIGINT DEFAULT 0 ;
  SELECT COUNT(*)
  INTO foo
    FROM mysql.user
      WHERE User = 'skmadmin' and  Host = 'localhost';
   IF foo > 0 THEN
         DROP USER 'skmadmin'@'localhost' ;
  END IF;
END ;$$
DELIMITER ;
CALL skm.drop_user_if_exists() ;
DROP PROCEDURE IF EXISTS skm.drop_users_if_exists ;
SET SQL_MODE=@OLD_SQL_MODE ;

CREATE USER 'skmadmin'@'localhost' IDENTIFIED BY 'demo';

GRANT USAGE ON * . * TO 'skmadmin'@'localhost' IDENTIFIED BY 'demo' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;

GRANT ALL PRIVILEGES ON `skm` . * TO 'skmadmin'@'localhost' WITH GRANT OPTION ;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=127 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`) VALUES
(1, 'root');

-- --------------------------------------------------------

--
-- Table structure for table `direction`
--

DROP TABLE IF EXISTS `direction`;
CREATE TABLE IF NOT EXISTS `direction` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(35) NOT NULL default '',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `direction`
--


-- --------------------------------------------------------

--
-- Table structure for table `globalfiles`
--

DROP TABLE IF EXISTS `globalfiles`;
CREATE TABLE IF NOT EXISTS `globalfiles` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `destfile` varchar(255) NOT NULL default '',
  `localfile` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `globalfiles`
--


-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `groups`
--


-- --------------------------------------------------------

--
-- Table structure for table `hak`
--

DROP TABLE IF EXISTS `hak`;
CREATE TABLE IF NOT EXISTS `hak` (
  `id_host` int(11) NOT NULL default '0',
  `id_account` int(11) NOT NULL default '0',
  `id_keyring` int(11) NOT NULL default '0',
  `id_key` int(11) NOT NULL default '0',
  `expand` char(1) NOT NULL default 'N',
  PRIMARY KEY  (`id_host`,`id_account`,`id_keyring`,`id_key`),
  KEY `id_key` (`id_key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hak`
--


-- --------------------------------------------------------

--
-- Table structure for table `hosts`
--

DROP TABLE IF EXISTS `hosts`;
CREATE TABLE IF NOT EXISTS `hosts` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `ip` varchar(15) character set utf8 collate utf8_unicode_ci NOT NULL,
  `expand` char(1) NOT NULL default 'N',
  `id_group` int(11) NOT NULL default '1',
  `serialno` varchar(40) NOT NULL default '',
  `memory` varchar(11) NOT NULL default '',
  `osversion` varchar(20) NOT NULL default '',
  `cabinet` varchar(30) NOT NULL default '',
  `uloc` varchar(10) NOT NULL default '',
  `cageno` varchar(10) NOT NULL default '',
  `model` varchar(20) NOT NULL default '',
  `procno` varchar(50) NOT NULL default '',
  `provider` varchar(30) NOT NULL default '',
  `install_dt` date NOT NULL default '0000-00-00',
  `po` int(11) NOT NULL default '0',
  `cost` decimal(9,2) NOT NULL default '0.00',
  `maint_cost` decimal(9,2) NOT NULL default '0.00',
  `maint_provider` varchar(30) NOT NULL default '',
  `maint_po` int(11) NOT NULL default '0',
  `maint_end_dt` date NOT NULL default '0000-00-00',
  `life_end_dt` date NOT NULL default '0000-00-00',
  `ostype` varchar(20) NOT NULL default '',
  `osvers` varchar(255) NOT NULL default '',
  `intf1` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `intf2` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `defaultgw` varchar(15) NOT NULL default '',
  `monitor` varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL,
  `selinux` varchar(30) NOT NULL default '',
  `datechgroot` date NOT NULL default '0000-00-00',
  `id_direction` int(11) NOT NULL default '1',
  `pdu_circuit` varchar(18) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `owner` varchar(20) NOT NULL default '',
  `tagnum` varchar(10) NOT NULL default '',
  `pdu_circuit2` varchar(20) NOT NULL default '',
  `pdu_circuit3` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=323 ;

--
-- Dumping data for table `hosts`
--


-- --------------------------------------------------------

--
-- Table structure for table `hosts-accounts`
--

DROP TABLE IF EXISTS `hosts-accounts`;
CREATE TABLE IF NOT EXISTS `hosts-accounts` (
  `id_host` int(11) NOT NULL default '0',
  `id_account` int(11) NOT NULL default '0',
  `expand` char(1) NOT NULL default 'N',
  PRIMARY KEY  (`id_host`,`id_account`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hosts-accounts`
--


-- --------------------------------------------------------

--
-- Table structure for table `hosts-groups`
--

DROP TABLE IF EXISTS `hosts-groups`;
CREATE TABLE IF NOT EXISTS `hosts-groups` (
  `id_host` int(11) NOT NULL default '0',
  `id_group` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_host`,`id_group`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hosts-groups`
--


-- --------------------------------------------------------

--
-- Table structure for table `keyrings`
--

DROP TABLE IF EXISTS `keyrings`;
CREATE TABLE IF NOT EXISTS `keyrings` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `expand` char(1) NOT NULL default 'N',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ;

--
-- Dumping data for table `keyrings`
--


-- --------------------------------------------------------

--
-- Table structure for table `keyrings-keys`
--

DROP TABLE IF EXISTS `keyrings-keys`;
CREATE TABLE IF NOT EXISTS `keyrings-keys` (
  `id_keyring` int(11) NOT NULL default '0',
  `id_key` int(11) NOT NULL default '0',
  `expand` char(1) NOT NULL default 'N',
  PRIMARY KEY  (`id_keyring`,`id_key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `keyrings-keys`
--


-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

DROP TABLE IF EXISTS `keys`;
CREATE TABLE IF NOT EXISTS `keys` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `key` blob NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=277 ;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `name`, `key`) VALUES
(1, 'skm_default_key', 0x7373682d727361206a666b646a61666c6461666a646b616c666a646b6c616a666b6c64616a666b6c646a616b6c66646a616b6c666e646b6a6e6a6b64666e676a6b666473676a6b6673686a676b6866736a6b6768666a646b7368676a6b667364676a6b66647320736b6d5f64656661756c745f6b6579);

-- --------------------------------------------------------

--
-- Table structure for table `security`
--

DROP TABLE IF EXISTS `security`;
CREATE TABLE IF NOT EXISTS `security` (
  `id` int(11) NOT NULL auto_increment,
  `password` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `security`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `email` varchar(50) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `password` varchar(40) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `firstname` varchar(20) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `lastname` varchar(20) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `role` varchar(20) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

