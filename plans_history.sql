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
-- Table structure for table `plans_history`
--

CREATE TABLE `plans_history` (
  `history_ID` int(16) NOT NULL,
  `plan_ID` int(16) NOT NULL,
  `user_ID` int(16) NOT NULL,
  `plan_name` varchar(100) NOT NULL,
  `plan_desc` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `duration` time NOT NULL,
  `sets` int(255) NOT NULL,
  `reps` int(255) NOT NULL,
  `user_made` tinyint(1) NOT NULL,
  `workout_ID_0` int(8) NOT NULL,
  `workout_ID_1` int(11) NOT NULL,
  `workout_ID_2` int(11) NOT NULL,
  `workout_ID_3` int(11) NOT NULL,
  `workout_ID_4` int(11) NOT NULL,
  `workout_ID_5` int(11) NOT NULL,
  `workout_ID_6` int(11) NOT NULL,
  `workout_ID_7` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `plans_history`
--
ALTER TABLE `plans_history`
  ADD PRIMARY KEY (`history_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
