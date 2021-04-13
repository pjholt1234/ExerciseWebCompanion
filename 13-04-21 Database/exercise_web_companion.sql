-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2021 at 10:32 PM
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
  `catagory_desc` text NOT NULL,
  `user_made` tinyint(1) NOT NULL,
  `user_ID` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`catagory_ID`, `catagory_name`, `catagory_desc`, `user_made`, `user_ID`) VALUES
(1, 'Custom', 'Custom category', 0, NULL),
(2, 'Chest', 'Working out the chest means working out the pectoral muscles, better known as the “pecs.” While the pecs are the largest muscles in the chest, there are actually several smaller muscles that support the pectoral muscles, including the latissimus dorsi muscles (or “lats”) on the sides of the chest and the trapezius.', 0, NULL),
(3, 'Cardio', 'Cardio exercise simply means that you\'re doing a rhythmic activity that raises your heart rate into your target heart rate zone, the zone where you\'ll burn the most fat and calories.', 0, NULL),
(4, 'Abs', 'Abdominal exercises are a type of strength exercise that affect the abdominal muscles (colloquially known as the stomach muscles or \"abs\").', 0, NULL),
(7, 'Other', 'Undefined', 0, NULL),
(9, 'Legs', 'Use a leg workout for definition that targets the quads and hamstrings to fatigue your leg muscles so that you can build them up, bigger and better.', 1, 11),
(10, 'Back', 'The back muscles help you to twist your torso, pull your arms in and down from overhead, and, most importantly, stabilize your spine. When you train these essential muscles, you’ll be more efficient at pulling and twisting motions in general.', 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_event` datetime NOT NULL,
  `end_event` datetime NOT NULL,
  `user_ID` int(11) NOT NULL,
  `plan_ID` int(11) NOT NULL,
  `allDay` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `start_event`, `end_event`, `user_ID`, `plan_ID`, `allDay`) VALUES
(94, 'Abs Workout', '2021-03-23 00:00:00', '2021-03-23 00:00:00', 11, 40, 1),
(97, 'Abs 2', '2021-03-23 00:00:00', '2021-03-23 00:00:00', 11, 66, 1),
(101, 'Legs', '2021-03-22 00:00:00', '2021-03-22 00:00:00', 11, 70, 1),
(102, 'Cardio Workout', '2021-03-18 00:00:00', '2021-03-18 00:00:00', 11, 3, 1),
(103, 'Abs Workout', '2021-03-09 00:00:00', '2021-03-09 00:00:00', 11, 40, 1),
(104, 'Chest Workout', '2021-03-24 00:00:00', '2021-03-24 00:00:00', 11, 4, 1),
(105, 'Abs Workout', '2021-03-03 00:00:00', '2021-03-03 00:00:00', 11, 40, 1),
(106, 'Legs', '2021-02-08 00:00:00', '2021-02-08 00:00:00', 11, 70, 1),
(111, 'Abs 2', '2021-03-30 08:00:00', '2021-03-30 14:00:00', 11, 66, 0),
(112, 'Legs', '2021-03-16 00:00:00', '2021-03-16 00:00:00', 11, 70, 1),
(114, 'Test Exercise Plan', '2021-04-07 00:00:00', '2021-04-07 00:00:00', 11, 74, 1),
(117, 'Test Exercise Plan', '2021-04-03 08:00:00', '2021-04-03 09:00:00', 11, 74, 0),
(118, 'Test Exercise Plan', '2021-04-04 07:00:00', '2021-04-04 07:00:00', 11, 74, 0),
(119, 'Chest Workout', '2021-04-12 00:00:00', '2021-04-12 00:00:00', 11, 4, 1),
(120, 'Abs Workout', '2021-04-05 16:00:00', '2021-04-05 17:00:00', 11, 40, 0),
(121, 'Abs 2', '2021-05-01 00:00:00', '2021-05-01 00:00:00', 11, 66, 1);

-- --------------------------------------------------------

--
-- Table structure for table `goals`
--

CREATE TABLE `goals` (
  `user_ID` int(11) NOT NULL,
  `monthly_goal` int(11) NOT NULL,
  `weekly_goal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `goals`
--

INSERT INTO `goals` (`user_ID`, `monthly_goal`, `weekly_goal`) VALUES
(11, 3, 4),
(17, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `user_ID` int(8) DEFAULT NULL,
  `plan_ID` int(8) NOT NULL,
  `plan_name` text NOT NULL,
  `plan_desc` longtext NOT NULL,
  `last_used` date NOT NULL,
  `user_made` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`user_ID`, `plan_ID`, `plan_name`, `plan_desc`, `last_used`, `user_made`) VALUES
(11, 3, 'Cardio Workout', 'plan_desc', '2021-02-06', 1),
(11, 4, 'Chest Workout', 'plan_desc', '2021-02-06', 1),
(12, 9, 'Cardio Workout', 'plan_desc', '2021-02-07', 1),
(17, 39, 'PJs Chest Workout', 'plan_desc', '2021-02-26', 1),
(11, 40, 'Abs Workout', 'plan_desc', '2021-03-11', 1),
(11, 66, 'Abs 2', 'plan_desc', '2021-03-24', 1),
(11, 70, 'Legs', 'plan_desc', '2021-03-24', 1),
(17, 73, 'abs test', 'plan_desc', '2021-03-28', 1),
(11, 74, 'Test Exercise Plan', 'plan_desc', '2021-04-02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `plans_workouts`
--

CREATE TABLE `plans_workouts` (
  `plan_name` text NOT NULL,
  `catagory_name` text NOT NULL,
  `workout_name` text NOT NULL,
  `unit` text NOT NULL,
  `reps` int(11) NOT NULL,
  `weight` double NOT NULL,
  `duration` double NOT NULL,
  `plan_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `workout_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plans_workouts`
--

INSERT INTO `plans_workouts` (`plan_name`, `catagory_name`, `workout_name`, `unit`, `reps`, `weight`, `duration`, `plan_ID`, `user_ID`, `ID`, `workout_ID`) VALUES
('Cardio Workout', 'Cardio', 'Jumping Jacks', 'Duration', 0, 0, 1.5, 3, 11, 11, 6),
('Cardio Workout', 'Cardio', 'Cycling', 'Duration', 0, 0, 10, 3, 11, 12, 9),
('Cardio Workout', 'Cardio', 'Dancing', 'Duration', 0, 0, 10, 3, 11, 13, 7),
('Chest Workout', 'Chest', 'Bench Press', 'Reps', 8, 40, 0, 4, 11, 14, 2),
('Chest Workout', 'Chest', 'Bench Press', 'Reps', 8, 35, 0, 4, 11, 15, 2),
('Chest Workout', 'Chest', 'Bench Press', 'Reps', 8, 30, 0, 4, 11, 16, 2),
('Chest Workout', 'Chest', 'Dumbbell Flies', 'Reps', 10, 20, 0, 4, 11, 17, 3),
('Chest Workout', 'Chest', 'Dumbbell Flies', 'Reps', 10, 15, 0, 4, 11, 18, 3),
('Chest Workout', 'Chest', 'Dumbbell Flies', 'Reps', 10, 10, 0, 4, 11, 19, 3),
('Chest Workout', 'Chest', 'Pushups', 'Reps', 10, 0, 0, 4, 11, 20, 4),
('Cardio Workout', 'Cardio', 'Jumping Jacks', 'Duration', 0, 0, 1, 9, 12, 30, 6),
('Cardio Workout', 'Cardio', 'Cycling', 'Duration', 0, 0, 10, 9, 12, 31, 9),
('Cardio Workout', 'Cardio', 'Dancing', 'Duration', 0, 0, 10, 9, 12, 32, 7),
('PJs Chest Workout', 'Chest ', 'Bench Press', 'Reps  ', 1, 0, 0, 39, 17, 131, 2),
('PJs Chest Workout', 'Chest ', 'Dumbbell Flies', 'Reps  ', 1, 0, 0, 39, 17, 132, 3),
('PJs Chest Workout', 'Chest ', 'Incline dumbbell press', 'Reps  ', 1, 0, 0, 39, 17, 133, 5),
('Abs Workout', 'Abs ', 'Crunches', 'Reps  ', 30, 0, 0, 40, 11, 134, 11),
('Abs Workout', 'Abs ', 'Crunches', 'Reps  ', 30, 0, 0, 40, 11, 135, 11),
('Abs Workout', 'Abs ', 'Crunches', 'Reps  ', 30, 0, 0, 40, 11, 136, 11),
('Abs Workout', 'Abs ', 'Air Bike', 'Reps  ', 30, 0, 0, 40, 11, 137, 15),
('Abs Workout', 'Abs ', 'Air Bike', 'Reps  ', 30, 0, 0, 40, 11, 138, 15),
('Abs Workout', 'Abs ', 'Air Bike', 'Reps  ', 30, 0, 0, 40, 11, 139, 15),
('Abs Workout', 'Abs ', 'Leg Up Touch', 'Reps  ', 30, 0, 0, 40, 11, 140, 17),
('Abs Workout', 'Abs ', 'Leg Up Touch', 'Reps  ', 30, 0, 0, 40, 11, 141, 17),
('Abs Workout', 'Abs ', 'Leg Up Touch', 'Reps  ', 30, 0, 0, 40, 11, 142, 17),
('Abs 2', 'Abs ', 'Crunches', 'Reps  ', 10, 0, 0, 66, 11, 189, 11),
('Abs 2', 'Abs ', 'Crunches', 'Reps  ', 10, 0, 0, 66, 11, 190, 11),
('Abs 2', 'Abs ', 'Crunches', 'Reps  ', 10, 0, 0, 66, 11, 191, 11),
('Abs 2', 'Abs ', 'Air Bike', 'Reps  ', 10, 0, 0, 66, 11, 192, 15),
('Abs 2', 'Abs ', 'Air Bike', 'Reps  ', 10, 0, 0, 66, 11, 193, 15),
('Abs 2', 'Abs ', 'Air Bike', 'Reps  ', 10, 0, 0, 66, 11, 194, 15),
('Legs', 'Legs ', 'Squats', 'Reps  ', 30, 11, 0, 70, 11, 207, 12),
('Legs', 'Legs ', 'Squats', 'Reps  ', 30, 11, 0, 70, 11, 208, 12),
('Legs', 'Legs ', 'Squats', 'Reps  ', 30, 11, 0, 70, 11, 209, 12),
('Legs', 'Legs ', 'Box Jumps', 'Reps  ', 30, 0, 0, 70, 11, 210, 19),
('Legs', 'Legs ', 'Box Jumps', 'Reps  ', 30, 0, 0, 70, 11, 211, 19),
('Legs', 'Legs ', 'Box Jumps', 'Reps  ', 30, 0, 0, 70, 11, 212, 19),
('abs test', 'Abs ', 'Crunches', 'Reps  ', 100, 22, 0, 73, 17, 222, 22),
('abs test', 'Abs ', 'Crunches', 'Reps  ', 100, 22, 0, 73, 17, 223, 22),
('abs test', 'Abs ', 'Crunches', 'Reps  ', 100, 22, 0, 73, 17, 224, 22),
('abs test', 'Abs ', 'Crunches', 'Reps  ', 100, 22, 0, 73, 17, 225, 22),
('Test Exercise Plan', 'Legs  ', 'Box Jumps', 'Reps    ', 30, 0, 0, 74, 11, 226, 19),
('Test Exercise Plan', 'Legs  ', 'Squats', 'Reps    ', 30, 11, 0, 74, 11, 227, 12),
('Test Exercise Plan', 'Legs  ', 'Squats', 'Reps    ', 30, 11, 0, 74, 11, 228, 12),
('Test Exercise Plan', 'Legs  ', 'Squats', 'Reps    ', 30, 11, 0, 74, 11, 229, 12),
('Test Exercise Plan', 'Legs  ', 'Box Jumps', 'Reps    ', 30, 0, 0, 74, 11, 230, 19),
('Test Exercise Plan', 'Legs  ', 'Box Jumps', 'Reps    ', 30, 0, 0, 74, 11, 231, 19);

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
(12, 'blah', '$2y$10$iRMw9PApDOHe7c5Hm8AnjutjKfb2DUnDPcg4PKoc2MJLUf9mKJVXW', 'blah', 0, 0, 0),
(13, 'me2-shutt', '$2y$10$DouMl2HFYgcVS7RXpT1Eme4cs.O7c59LFZ0xOx6jckCMSnt6UkfPe', '', 0, 0, 0),
(16, 'PJ Holt', '$2y$10$.RgCmKa9VuPEIIPWRvPfQOd6nLg4ijNh4k4mSfEzAOujMB5CukEha', 'index', 0, 0, 0),
(17, 'test', '$2y$10$ugD6x3lYeLI3/Y0vWsfo6OZBP42omsxlkq9np4dBtl6.SRwV7sOZG', 'test@test.com', 0, 0, 0),
(18, 'testcase', '$2y$10$qor193q8IAQxrekkOLGDP.N0Mm4EVKsnUFzJG74/p6Y1QsIx7DaVO', 'testcase@testcase.com', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `weight`
--

CREATE TABLE `weight` (
  `ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `weight` double NOT NULL,
  `entry_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `weight`
--

INSERT INTO `weight` (`ID`, `user_ID`, `weight`, `entry_date`) VALUES
(5, 11, 70, '2021-03-25 11:49:56'),
(6, 11, 71, '2021-03-25 11:50:06'),
(7, 11, 80, '2021-03-25 11:53:15'),
(8, 11, 77, '2021-03-26 07:10:30'),
(9, 11, 81, '2021-03-26 11:04:12'),
(10, 17, 11, '2021-03-28 03:23:09'),
(11, 11, 85, '2021-03-30 02:28:37'),
(12, 11, 70, '2021-04-05 01:20:33'),
(13, 11, 99, '2021-04-05 10:46:22'),
(14, 11, 10, '2021-04-05 10:52:27');

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
(6, 'Jumping Jacks', 'A conditioning exercise performed from a standing position by jumping to a position with legs spread and arms raised and then to the original position', NULL, 0, 3, 1),
(7, 'Dancing', 'Dance, the movement of the body in a rhythmic way, usually to music and within a given space', NULL, 0, 3, 1),
(8, 'Jump Rope', 'The activity, game or exercise in which a person must jump, bounce or skip repeatedly while a length of rope is swung over and under.', NULL, 0, 3, 1),
(9, 'Cycling', 'Riding a bicycle.', NULL, 0, 3, 1),
(11, 'Crunches', 'The crunch is a classic core exercise. It specifically trains your abdominal muscles, which are part of your core.', 11, 1, 4, 0),
(12, 'Squats', 'A squat is a strength exercise in which the trainee lowers their hips from a standing position and then stands back up. During the descent of a squat, the hip and knee joints flex while the ankle joint dorsiflexes; conversely the hip and knee joints extend and the ankle joint plantarflexes when standing up.', 11, 1, 9, 0),
(13, 'Cable Flyes', 'The standing cable fly is a variation of the chest fly and an exercise used to strengthen the pushing muscles of the body including the chest, triceps, and shoulders.', 11, 1, 2, 0),
(14, 'Yoga', 'Yoga is a mind and body practice with a 5,000-year history in ancient Indian philosophy. Various styles of yoga combine physical postures, breathing techniques, and meditation or relaxation', 11, 1, 7, 1),
(15, 'Air Bike', 'Air Bike, Bicycle Legs', 11, 1, 4, 0),
(17, 'Leg Up Touch', 'Lay on your back and do crunch while reach for shins', 11, 1, 4, 0),
(18, 'Deadlift', 'The deadlift is a weight training exercise in which a loaded barbell or bar is lifted off the ground to the level of the hips, torso perpendicular to the floor, before being placed back on the ground. ', 11, 1, 9, 0),
(19, 'Box Jumps', 'The box jump is a plyometric move that strengthens your main lower-body muscles – glutes, quads, calves and hamstrings.', 11, 1, 9, 0),
(20, 'Leg Press', 'Sit in the leg press machine with your back flat against the chair. Adjust the machine so that you are in the bottom of a squat position from the start, with your knees at a 90-degree angle.', 11, 1, 9, 0),
(21, 'Pull Ups', 'A PULL-UP is when your hands are facing away from you. This will work your back and biceps.', 11, 1, 10, 0),
(22, 'Crunches', 'None', 17, 1, 4, 0),
(23, 'Running', 'running', 11, 1, 3, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`catagory_ID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `goals`
--
ALTER TABLE `goals`
  ADD PRIMARY KEY (`user_ID`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD UNIQUE KEY `plan_ID` (`plan_ID`);

--
-- Indexes for table `plans_workouts`
--
ALTER TABLE `plans_workouts`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `userprofile`
--
ALTER TABLE `userprofile`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_pass` (`user_pass`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `weight`
--
ALTER TABLE `weight`
  ADD PRIMARY KEY (`ID`);

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
  MODIFY `catagory_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `plan_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `plans_workouts`
--
ALTER TABLE `plans_workouts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT for table `userprofile`
--
ALTER TABLE `userprofile`
  MODIFY `user_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `weight`
--
ALTER TABLE `weight`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `workouts`
--
ALTER TABLE `workouts`
  MODIFY `workout_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
