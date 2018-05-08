-- phpMyAdmin SQL Dump
-- version 4.0.10.19
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 08, 2018 at 08:47 PM
-- Server version: 5.6.36-log
-- PHP Version: 5.4.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `abcjobs`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `procSaveUser`(IN `i_id` INT, IN `i_firstname` VARCHAR(50), IN `i_lastname` VARCHAR(50), IN `i_email` VARCHAR(50), IN `i_password` VARCHAR(255), IN `i_creation_time` DATETIME, IN `i_role` VARCHAR(20), IN `i_salt` VARCHAR(50), IN `i_subscribe` BOOLEAN)
BEGIN
    if(i_id=0) then
      insert into tb_user(firstname,lastname,email,password,account_creation_time,role,salt,subscribe) values(i_firstname,i_lastname,i_email,i_password,i_creation_time,i_role,i_salt,i_subscribe);
    Else
                 update tb_user set firstname=i_firstname,lastname=i_lastname,email=i_email,password=i_password,role=i_role,salt=i_salt,subscribe=i_subscribe where id=i_id;
    end if;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_feedback`
--

CREATE TABLE IF NOT EXISTS `tb_feedback` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `comments` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE IF NOT EXISTS `tb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `salt` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `account_creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(20) NOT NULL,
  `subscribe` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
