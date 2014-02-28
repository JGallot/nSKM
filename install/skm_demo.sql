-- phpMyAdmin SQL Dump
-- version 2.11.3deb1ubuntu1.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 17, 2010 at 09:51 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.4-2ubuntu5.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `skm`
--

-- --------------------------------------------------------
use skm;

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
(1, 'root'),
(126, 'DevAccount1');

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

INSERT INTO `groups` (`id`, `name`) VALUES
(10, 'Production'),
(11, 'Development'),
(12, 'Quality Assurance');

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

INSERT INTO `hak` (`id_host`, `id_account`, `id_keyring`, `id_key`, `expand`) VALUES
(319, 1, 88, 0, 'Y'),
(319, 1, 0, 1, 'N'),
(320, 1, 0, 1, 'N'),
(320, 126, 0, 272, 'Y'),
(321, 1, 0, 1, 'N'),
(322, 1, 0, 1, 'N');

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

INSERT INTO `hosts` (`id`, `name`, `ip`, `expand`, `id_group`, `serialno`, `memory`, `osversion`, `cabinet`, `uloc`, `cageno`, `model`, `procno`, `provider`, `install_dt`, `po`, `cost`, `maint_cost`, `maint_provider`, `maint_po`, `maint_end_dt`, `life_end_dt`, `ostype`, `osvers`, `intf1`, `intf2`, `defaultgw`, `monitor`, `selinux`, `datechgroot`, `id_direction`, `pdu_circuit`, `owner`, `tagnum`, `pdu_circuit2`, `pdu_circuit3`) VALUES
(320, 'DevHost1', '192.168.102.2', 'N', 11, 'BCD5678', '', '', '', '', '', '35', '', '', '0000-00-00', 0, 0.00, 0.00, '', 0, '0000-00-00', '0000-00-00', 'AIX', '5.3', '', '', '', '', '', '0000-00-00', 1, '', '', '', '', ''),
(319, 'ProdHost1', '192.168.10.2', 'N', 10, 'ABC12345', '2', '', '', '', '', 'MOD123', 'Dual core', 'DELL', '0000-00-00', 0, 0.00, 0.00, '', 0, '0000-00-00', '0000-00-00', 'RHEL', '5.4', '192.168.10.2', '', '', 'Spong', '', '0000-00-00', 1, '', '', '', '', ''),
(321, 'ProdHost2', '192.168.10.3', 'N', 10, 'CDEF1234', '2', '', '', '', '', 'Sun Fire V100', 'Sparc V4', 'SUN', '0000-00-00', 0, 0.00, 0.00, '', 0, '0000-00-00', '0000-00-00', 'Solaris', '10', '', '', '', 'BigBrother', '', '0000-00-00', 1, '', '', '', '', ''),
(322, 'ProdHost3', '192.168.10.4', 'N', 10, 'EFGH1234', '4', '', '', '', '', '3550', 'RISC', 'IBM', '0000-00-00', 0, 0.00, 0.00, '', 0, '0000-00-00', '0000-00-00', 'AIX', '5.3', '', '', '', '', '', '0000-00-00', 1, '', '', '', '', '');

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

INSERT INTO `hosts-accounts` (`id_host`, `id_account`, `expand`) VALUES
(320, 126, 'Y'),
(319, 1, 'Y'),
(320, 1, 'Y'),
(321, 1, 'N'),
(322, 1, 'N');

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

INSERT INTO `keyrings` (`id`, `name`, `expand`) VALUES
(88, 'Administrators', 'Y');

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

INSERT INTO `keyrings-keys` (`id_keyring`, `id_key`, `expand`) VALUES
(88, 274, 'N'),
(88, 275, 'N');

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
(272, 'user1', 0x7373682d72736120666a6b6473616a666b6c6461736a66647468697369736172616e646f6d6b6579666b646c616a666b646c61736a66646166646b6a61666b6c646a616b6c6664616a6b6c666a6461736b6c666a6461736b6c666a646b616c733b6a66646b61736c3b6a6664207573657231),
(273, 'user2', 0x7373682d727361206b666a646c736a666b646c61736a666b6c646a616a6b6c746869736973616e6f7468657272616e646f6d6b65796a666b646c736a61666b6c6473616a666b6c6461736a666b6c64736a616b6c666a6b666c676a6b6c66647367687472756968676a6b686e6a666b766473207573657232),
(274, 'adminuser1', 0x7373682d727361206667646b6c736a6b6c66646a73676b6c66736b6c676a666b6c73766d636e6d762c6e63787569666872756569686a64667368676a6e636d6276666a68647367666a73646c68676a666b646c7368676a747275696c6875696c68736e67666a6b736e766a666e732061646d696e7573657231),
(275, 'adminuser2', 0x7373682d72736120666a646b736a666a6b6473616e666a6e7564696861666a6e646a6b6e61666a6b6d646e617569666869726a686e676a6b66646e67736a6b766e66646b73766a6b6673646e766a6b66686e736b6e6664736a6b68667569676866736a696b676e666a6b736a6b6673646e6b6a6673642061646d696e7573657232),
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

