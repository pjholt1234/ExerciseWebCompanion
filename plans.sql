-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2021 at 08:51 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exercise_web_companion`
--

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `user_ID` int(8) NOT NULL,
  `plan_ID` int(8) NOT NULL,
  `plan_name` varchar(100) NOT NULL,
  `plan_desc` longtext NOT NULL,
  `last_used` date NOT NULL,
  `user_made` tinyint(1) NOT NULL,
  `workout_ID_0` int(8) NOT NULL,
  `workout_ID_1` int(8) NOT NULL,
  `workout_ID_2` int(8) NOT NULL,
  `workout_ID_3` int(8) NOT NULL,
  `workout_ID_4` int(8) NOT NULL,
  `workout_ID_5` int(8) NOT NULL,
  `workout_ID_6` int(8) NOT NULL,
  `workout_ID_7` int(8) NOT NULL,
  `workout_order` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD UNIQUE KEY `plan_ID` (`plan_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
