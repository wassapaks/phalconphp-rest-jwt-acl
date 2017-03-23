-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 23, 2017 at 03:33 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phalconrestjwt`
--

-- --------------------------------------------------------

--
-- Table structure for table `api`
--

CREATE TABLE `api` (
  `client_id` int(10) UNSIGNED NOT NULL,
  `public_id` char(64) NOT NULL DEFAULT '',
  `private_key` char(64) NOT NULL DEFAULT '',
  `status` enum('ACTIVE','INACTIVE') DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `api`
--

INSERT INTO `api` (`client_id`, `public_id`, `private_key`, `status`) VALUES
(1, '', '593fe6ed77014f9507761028801aa376f141916bd26b1b3f0271b5ec3135b989', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `logininfo`
--

CREATE TABLE `logininfo` (
  `memberid` varchar(250) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logininfo`
--

INSERT INTO `logininfo` (`memberid`, `status`) VALUES
('4C085AF7-C337-40BA-AE38-B0BEB961ECAE', 'active'),
('5DF7B009-E1C7-4BBB-98B3-BADFAC14464C', 'active'),
('993E2021-89CB-4E36-B47E-F90332664A96', 'active'),
('BDA49676-2D69-4531-9061-5BB66F2CDB18', 'first'),
('C0A13197-7711-40CF-8C24-0AE55CBB16F4', 'security'),
('F19B637C-F4E9-4DBD-AB87-607BA2F6834E', 'first');

-- --------------------------------------------------------

--
-- Table structure for table `roleitems`
--

CREATE TABLE `roleitems` (
  `id` int(11) NOT NULL,
  `roleGroup` char(6) DEFAULT NULL,
  `roleCode` char(5) NOT NULL,
  `roleName` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roleitems`
--

INSERT INTO `roleitems` (`id`, `roleGroup`, `roleCode`, `roleName`) VALUES
(1, NULL, 'addUs', 'Add User'),
(2, NULL, 'delUs', 'Delete User'),
(3, NULL, 'editU', 'Edit User'),
(4, NULL, 'ex1', 'Example 1'),
(5, NULL, 'ex2', 'Example 2');

-- --------------------------------------------------------

--
-- Table structure for table `userlevel`
--

CREATE TABLE `userlevel` (
  `id` int(11) UNSIGNED NOT NULL,
  `userLevel` char(10) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userlevel`
--

INSERT INTO `userlevel` (`id`, `userLevel`, `description`) VALUES
(1, 'OWNER', 'Owner of memberships'),
(2, 'ADMIN', 'Administrator of the Owner'),
(3, 'USER', 'Users under administrator');

-- --------------------------------------------------------

--
-- Table structure for table `userroles`
--

CREATE TABLE `userroles` (
  `id` int(11) NOT NULL,
  `userid` varchar(250) NOT NULL,
  `role` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userroles`
--

INSERT INTO `userroles` (`id`, `userid`, `role`) VALUES
(1, '993E2021-89CB-4E36-B47E-F90332664A96', 's4'),
(2, '993E2021-89CB-4E36-B47E-F90332664A96', 's2'),
(3, '4C085AF7-C337-40BA-AE38-B0BEB961ECAE', 's4'),
(4, '4C085AF7-C337-40BA-AE38-B0BEB961ECAE', 's2');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` varchar(250) NOT NULL,
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
  `employeetype` varchar(100) NOT NULL,
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
  `userLevel` char(10) DEFAULT NULL,
  `datecreated` datetime NOT NULL,
  `dateedited` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `permission` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `email`, `password`, `firstname`, `lastname`, `suffix`, `birthdate`, `gender`, `credential`, `title`, `employeetype`, `ssn`, `employeeid`, `address1`, `address2`, `city`, `state`, `zip`, `phone`, `mobile`, `picture`, `userLevel`, `datecreated`, `dateedited`, `permission`) VALUES
('4C085AF7-C337-40BA-AE38-B0BEB961ECAE', 'nurseJANINE', 'janinehazellabadia@geeksnest.com', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', 'J', 'L', '', '2017-04-01', 'Other', 'None', 'CEO', '0', '11111111111', '1', '11111\n111\n111\n111\n111\n111\n1', '', 'Tempe', 'TN', '1', '(222)222-2222', '(222)222-2222', 'default.jpg', 'ADMIN', '2016-06-23 04:26:06', '2016-07-08 16:58:40', NULL),
('993E2021-89CB-4E36-B47E-F90332664A96', 'superagent', 'superagent@mailinator.com', '7c222fb2927d828af22f592134e8932480637c0d', 'superagent', 'superagent', '', '2016-06-10', 'Other', '0', '0', 'OWNER', '123-12-3123', '23123', '123132', 'sda', '0', '0', '123123', '(123)213-1231', '(123)123-1231', 'default.jpg', 'OWNER', '2016-06-10 14:02:24', '2017-03-23 22:54:06', NULL),
('a55f38d3-94b6-4376-8f77-17f0ff945a9e', 'efren', 'efren@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'efren', 'bautista', '', '2016-06-10', 'Other', '', '', '0', '', '', '', NULL, '', '', '', '', '', NULL, 'ADMIN', '2016-06-23 23:18:12', '2016-07-08 16:59:03', NULL),
('BDA49676-2D69-4531-9061-5BB66F2CDB18', 'n2', 'janine@mailinator.com', '3da541559918a808c2402bba5012f6c60b27661c', 'janine', 'labadia', '', '2016-07-08', 'Female', 'RN', 'CEO', '0', '22222222222', '12', '21', '21', 'DC1', 'WY', '21', '(111)111-1111', '1111111111111', 'default.jpg', 'USER', '2016-06-23 04:47:11', '2016-07-08 16:59:00', NULL),
('C0A13197-7711-40CF-8C24-0AE55CBB16F4', 'jacintolola', 'jacintololo@mailinator.com', 'f10e2821bbbea527ea02200352313bc059445190', 'jacinto', 'lola', '', '2016-06-22', 'Female', 'DO', 'Certified Nurse Aide', '0', '235-23-5235', '32525235', 'dfdfg dfgdfgdfhg4643 fdhd', '', 'sdffs', 'CO', '2523525', '1111111111111', '1111111111111', 'default.jpg', 'USER', '2016-06-23 23:18:12', '2016-07-08 16:59:03', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api`
--
ALTER TABLE `api`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `private_key` (`private_key`),
  ADD UNIQUE KEY `public_id` (`public_id`);

--
-- Indexes for table `logininfo`
--
ALTER TABLE `logininfo`
  ADD PRIMARY KEY (`memberid`);

--
-- Indexes for table `roleitems`
--
ALTER TABLE `roleitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userlevel`
--
ALTER TABLE `userlevel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userroles`
--
ALTER TABLE `userroles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api`
--
ALTER TABLE `api`
  MODIFY `client_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `roleitems`
--
ALTER TABLE `roleitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `userlevel`
--
ALTER TABLE `userlevel`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `userroles`
--
ALTER TABLE `userroles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
