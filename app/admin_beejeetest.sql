-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 10, 2020 at 01:12 PM
-- Server version: 5.5.62-0+deb8u1
-- PHP Version: 5.6.40-0+deb8u8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `admin_beejeetest`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
`id` int(11) NOT NULL,
  `name_field` varchar(64) NOT NULL,
  `text_field` text,
  `email_field` varchar(64) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `modified` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `name_field`, `text_field`, `email_field`, `timestamp`, `status`, `modified`) VALUES
(5, 'test', 'test job (edited)', 'test@test.com', NULL, 0, 1),
(6, 'test2', '&lt;script&gt;alert(‘test’);&lt;/script&gt;', 'test2@test.com', NULL, 0, 0),
(7, 'test3', 'test job 2', 'test3@test.com', NULL, 1, 0),
(8, 'test4', 'test job 3 (edited)', 'test4@test.com', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(36) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
