-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2021 at 02:56 AM
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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `catagory_ID` int(8) NOT NULL,
  `catagory_name` varchar(255) NOT NULL,
  `catagory_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`catagory_ID`, `catagory_name`, `catagory_desc`) VALUES
(1, 'Cardio', 'Cardio exercise simply means that you\'re doing a rhythmic activity that raises your heart rate into your target heart rate zone, the zone where you\'ll burn the most fat and calories.'),
(2, 'Chest', 'Working out the chest means working out the pectoral muscles, better known as the “pecs.” While the pecs are the largest muscles in the chest, there are actually several smaller muscles that support the pectoral muscles, including the latissimus dorsi muscles (or “lats”) on the sides of the chest and the trapezius.');

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

-- --------------------------------------------------------

--
-- Table structure for table `run`
--

CREATE TABLE `run` (
  `run_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `distance` int(11) NOT NULL,
  `catagory_ID` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `userprofile`
--

CREATE TABLE `userprofile` (
  `user_ID` int(8) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `fav_workout` int(8) NOT NULL,
  `fav_workout_plan` int(8) NOT NULL,
  `calander_enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userprofile`
--

INSERT INTO `userprofile` (`user_ID`, `user_name`, `user_pass`, `user_email`, `fav_workout`, `fav_workout_plan`, `calander_enabled`) VALUES
(9, 'demo', '$2y$10$by51nU5q9hbDVlKrq.j3PuvLxML0BET1jyleGAZEnfH2FDvrq7Ide', 'demo3@demo3.com', 0, 0, 0),
(10, 'Molly', '$2y$10$iYWiOygw44BYu1L2a5sG0uKz8LYhSBKRCqh9xUib7Eh2BnhZG1OtK', 'mollyshutt2000@gmail.com', 0, 0, 0),
(11, 'demo1', '$2y$10$s2TsYDoO/7MJWBPq7WhzA./7g1H9g/jXyuOvADACmlgh50vcJVw5e', 'pjholt1234@gmail.com', 0, 0, 0),
(12, 'blah', '$2y$10$iRMw9PApDOHe7c5Hm8AnjutjKfb2DUnDPcg4PKoc2MJLUf9mKJVXW', 'blah', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `workouts`
--

CREATE TABLE `workouts` (
  `workout_ID` int(8) NOT NULL,
  `workout_name` varchar(255) NOT NULL,
  `workout_desc` text NOT NULL,
  `user_ID` int(8) DEFAULT NULL,
  `user_made` tinyint(1) NOT NULL,
  `catagory_ID` int(8) NOT NULL,
  `repstime` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `workouts`
--

INSERT INTO `workouts` (`workout_ID`, `workout_name`, `workout_desc`, `user_ID`, `user_made`, `catagory_ID`, `repstime`) VALUES
(2, 'Bench Press', 'The bench press is an upper-body weight training exercise in which the trainee presses a weight upwards while lying on a weight training bench. The exercise uses the pectoralis major, the anterior deltoids, and the triceps, among other stabilizing muscles.', NULL, 0, 2, 0),
(3, 'Dumbbell Flies', 'The dumbbell chest fly is an upper body exercise that can help to strengthen the chest and shoulders. The traditional way to perform a dumbbell chest fly is to do the move while lying on your back on a flat or incline bench. There\'s also a standing variation.', NULL, 0, 2, 0),
(4, 'Pushups', 'A conditioning exercise performed in a prone position by raising and lowering the body with the straightening and bending of the arms while keeping the back straight and supporting the body on the hands and toes.', NULL, 0, 2, 0),
(5, 'Incline dumbbell press', 'The incline dumbbell press is a free weight exercise designed to target the chest, shoulders, and triceps, hitting each side of the body independently.', NULL, 0, 2, 0),
(6, 'Jumping Jacks', 'A conditioning exercise performed from a standing position by jumping to a position with legs spread and arms raised and then to the original position', NULL, 0, 1, 1),
(7, 'Dancing', 'Dance, the movement of the body in a rhythmic way, usually to music and within a given space', NULL, 0, 1, 1),
(8, 'Jump Rope', 'The activity, game or exercise in which a person must jump, bounce or skip repeatedly while a length of rope is swung over and under.', NULL, 0, 1, 1),
(9, 'Cycling', 'Riding a bicycle.', NULL, 0, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`catagory_ID`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD UNIQUE KEY `plan_ID` (`plan_ID`);

--
-- Indexes for table `plans_history`
--
ALTER TABLE `plans_history`
  ADD PRIMARY KEY (`history_ID`);

--
-- Indexes for table `run`
--
ALTER TABLE `run`
  ADD PRIMARY KEY (`run_id`);

--
-- Indexes for table `userprofile`
--
ALTER TABLE `userprofile`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_pass` (`user_pass`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `workouts`
--
ALTER TABLE `workouts`
  ADD PRIMARY KEY (`workout_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `catagory_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `userprofile`
--
ALTER TABLE `userprofile`
  MODIFY `user_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `workouts`
--
ALTER TABLE `workouts`
  MODIFY `workout_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
