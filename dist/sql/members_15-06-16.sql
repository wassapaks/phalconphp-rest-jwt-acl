-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 15, 2016 at 02:30 PM
-- Server version: 5.6.30-0ubuntu0.15.10.1
-- PHP Version: 5.6.11-1ubuntu3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbhcare`
--

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `memberid` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(500) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `suffix` char(10) DEFAULT NULL,
  `birthdate` date NOT NULL,
  `gender` char(10) NOT NULL,
  `credential` varchar(150) NOT NULL,
  `title` varchar(150) NOT NULL,
  `employeetype` int(11) NOT NULL,
  `ssn` varchar(250) NOT NULL,
  `employeeid` varchar(250) NOT NULL,
  `address1` text NOT NULL,
  `address2` text,
  `city` varchar(250) NOT NULL,
  `state` varchar(250) NOT NULL,
  `zip` varchar(250) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `mobile` varchar(250) NOT NULL,
  `picture` text,
  `datecreated` datetime NOT NULL,
  `dateedited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`memberid`, `username`, `email`, `password`, `firstname`, `lastname`, `suffix`, `birthdate`, `gender`, `credential`, `title`, `employeetype`, `ssn`, `employeeid`, `address1`, `address2`, `city`, `state`, `zip`, `phone`, `mobile`, `picture`, `datecreated`, `dateedited`) VALUES
('44B11111-0A6F-422B-B323-1CBF7751B9F2', 'hartjo', 'llarenasjanrainier@gmail.com', '9e6c9d8ae3a0201fa8c6bc12bcd811129ace90f4', 'Jan Rainier', 'Llarenas', NULL, '2016-03-10', 'Male', '0', '0', 0, '', '', '', NULL, '', '', '123123', '', '', '11yUwWLPmYjVSe1WbVJ025d2D5LO6ARu.jpg', '2016-03-10 00:00:00', '2016-06-10 07:47:22'),
('993E2021-89CB-4E36-B47E-F90332664A96', 'superagent', 'superagent@mailinator.com', '7c222fb2927d828af22f592134e8932480637c0d', 'superagent', 'superagent', '', '2016-06-10', 'Male', '0', '0', 0, '123-12-3123', '23123', '123132', 'sda', '0', '0', '123123', '(123)213-1231', '(123)123-1231', 'default.jpg', '2016-06-10 14:02:24', '2016-06-10 06:02:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`memberid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
