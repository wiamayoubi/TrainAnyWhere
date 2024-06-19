-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2024 at 06:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trainanywhere`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`name`, `username`, `password`) VALUES
('Wiam', 'Wiam11', 'Wiam11');

-- --------------------------------------------------------

--
-- Table structure for table `admin_inquiries`
--

CREATE TABLE `admin_inquiries` (
  `inquiry_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `receiver_type` enum('gym','trainer') NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `admin_inquiries`
--

INSERT INTO `admin_inquiries` (`inquiry_id`, `user_id`, `receiver_type`, `receiver_id`, `message`, `created_at`, `is_read`) VALUES
(1, 11, 'gym', 16, 'Great ', '2024-05-27 21:56:27', 0),
(3, 11, 'gym', 23, 'Hello', '2024-05-27 22:39:11', 0);

-- --------------------------------------------------------

--
-- Table structure for table `approved_class_registrations`
--

CREATE TABLE `approved_class_registrations` (
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `approved_personal_training_registrations`
--

CREATE TABLE `approved_personal_training_registrations` (
  `user_id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `approved_personal_training_registrations`
--

INSERT INTO `approved_personal_training_registrations` (`user_id`, `registration_id`, `status`) VALUES
(11, 35, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  `gym_id` int(11) NOT NULL,
  `training_id` int(11) NOT NULL,
  `Time` varchar(40) NOT NULL,
  `day_of_week` varchar(100) NOT NULL,
  `class_type` enum('man','woman') NOT NULL,
  `Cost` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `trainer_id`, `gym_id`, `training_id`, `Time`, `day_of_week`, `class_type`, `Cost`) VALUES
(79, 20, 16, 26, '10:00 AM - 11:30 AM', 'Monday,Wednesday,Friday', 'woman', 50.00),
(80, 20, 14, 26, '10:00 AM - 11:30 AM', 'Monday,Tuesday,Thursday', 'man', 50.00),
(81, 20, 16, 27, '02:30 PM - 04:00 PM', 'Monday,Wednesday,Friday', 'man', 60.00),
(82, 23, 14, 28, '05:30 PM - 07:00 PM', 'Wednesday,Friday,Saturday', 'man', 30.00);

-- --------------------------------------------------------

--
-- Table structure for table `classregistration`
--

CREATE TABLE `classregistration` (
  `registration_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `gym_id` int(11) NOT NULL,
  `time` time DEFAULT NULL,
  `day_of_week` varchar(10) DEFAULT NULL,
  `class_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `classregistration`
--

INSERT INTO `classregistration` (`registration_id`, `user_id`, `class_id`, `status`, `gym_id`, `time`, `day_of_week`, `class_type`) VALUES
(62, 11, 79, 'approved', 0, NULL, NULL, NULL),
(63, 11, 81, 'approved', 0, NULL, NULL, NULL),
(64, 11, 82, 'approved', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gym`
--

CREATE TABLE `gym` (
  `gym_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `gym`
--

INSERT INTO `gym` (`gym_id`, `name`, `location`) VALUES
(14, 'Kfarhata', 'Kfarhata - El-Koura-Main Road'),
(16, 'Fitness360', 'Batroun-coffe Streat');

-- --------------------------------------------------------

--
-- Table structure for table `personaltraining`
--

CREATE TABLE `personaltraining` (
  `id` int(11) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  `training_name` varchar(255) DEFAULT NULL,
  `training_description` text DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `training_provided` enum('gym','online') DEFAULT NULL,
  `time` time NOT NULL,
  `day_of_week` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `personaltraining`
--

INSERT INTO `personaltraining` (`id`, `trainer_id`, `training_name`, `training_description`, `cost`, `training_provided`, `time`, `day_of_week`) VALUES
(14, 20, 'injury', 'help to back from injury', 70.00, 'gym', '17:00:00', 'Wednesday,Friday,Saturday');

-- --------------------------------------------------------

--
-- Table structure for table `personaltrainingregistration`
--

CREATE TABLE `personaltrainingregistration` (
  `registration_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `training_id` int(11) NOT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `training_provided` varchar(255) DEFAULT NULL,
  `day_of_week` varchar(10) DEFAULT NULL,
  `time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `personaltrainingregistration`
--

INSERT INTO `personaltrainingregistration` (`registration_id`, `user_id`, `training_id`, `status`, `training_provided`, `day_of_week`, `time`) VALUES
(35, 11, 14, 'approved', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ratingtrainer`
--

CREATE TABLE `ratingtrainer` (
  `rating_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trainer_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `trainer`
--

CREATE TABLE `trainer` (
  `trainer_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `trainer`
--

INSERT INTO `trainer` (`trainer_id`, `name`, `email`, `mobile`, `username`, `password`) VALUES
(20, 'Mohamad Al Ayoubi', 'Mohamadayoubi@gmail.com', '70123456', 'Mohammad.AlAyoubi', 'Mayoubi'),
(21, 'Moustafa Jamal ', 'moustafa@gmail.com', '01020304', 'Moustafa.jamal', 'Moustafa@123'),
(23, 'Omar Ali', 'omarali@gmail.com', '71717171', 'Omar.Ali', 'Omar@123');

-- --------------------------------------------------------

--
-- Table structure for table `trainer_applications`
--

CREATE TABLE `trainer_applications` (
  `application_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `certificate_file` varchar(255) NOT NULL,
  `resume_file` varchar(255) NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `trainer_inquiries`
--

CREATE TABLE `trainer_inquiries` (
  `inquiry_id` int(11) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `receiver_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `trainer_inquiries`
--

INSERT INTO `trainer_inquiries` (`inquiry_id`, `trainer_id`, `user_id`, `message`, `created_at`, `is_read`, `receiver_id`) VALUES
(4, 20, 11, 'Hello Coach ', '2024-05-27 15:09:59', 0, NULL),
(5, 23, 11, 'Hello ', '2024-05-27 19:48:27', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `training`
--

CREATE TABLE `training` (
  `training_id` int(11) NOT NULL,
  `trainer_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `training`
--

INSERT INTO `training` (`training_id`, `trainer_id`, `name`, `description`, `cost`) VALUES
(26, 20, 'Fitness', 'Fitness full body ', 50.00),
(27, 20, 'crosfet', 'fireeee', 60.00),
(28, 23, 'football', 'play with team', 30.00);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `bod` date DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `email`, `gender`, `mobile`, `bod`, `username`, `password`, `address`) VALUES
(11, 'Walid', 'Hachem', 'walid@gmail.com', 'Male', '71717171', '2002-02-23', 'Walid.Hachem', 'Walid@123', 'Bednayel-El-Koura');

-- --------------------------------------------------------

--
-- Table structure for table `user_inquiries`
--

CREATE TABLE `user_inquiries` (
  `inquiry_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `receiver_type` enum('trainer','admin') NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `admin_inquiries`
--
ALTER TABLE `admin_inquiries`
  ADD PRIMARY KEY (`inquiry_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `receiver_type` (`receiver_type`),
  ADD KEY `receiver_type_2` (`receiver_type`);

--
-- Indexes for table `approved_class_registrations`
--
ALTER TABLE `approved_class_registrations`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_class_id` (`class_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `approved_personal_training_registrations`
--
ALTER TABLE `approved_personal_training_registrations`
  ADD PRIMARY KEY (`user_id`,`registration_id`),
  ADD KEY `fk_registration_id` (`registration_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `class_ibfk_2` (`gym_id`),
  ADD KEY `class_ibfk_3` (`training_id`),
  ADD KEY `class_ibfk_1` (`trainer_id`);

--
-- Indexes for table `classregistration`
--
ALTER TABLE `classregistration`
  ADD PRIMARY KEY (`registration_id`),
  ADD KEY `classregistration_ibfk_1` (`user_id`),
  ADD KEY `classregistration_ibfk_2` (`class_id`),
  ADD KEY `gym_id` (`gym_id`);

--
-- Indexes for table `gym`
--
ALTER TABLE `gym`
  ADD PRIMARY KEY (`gym_id`);

--
-- Indexes for table `personaltraining`
--
ALTER TABLE `personaltraining`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `personaltrainingregistration`
--
ALTER TABLE `personaltrainingregistration`
  ADD PRIMARY KEY (`registration_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `training_id` (`training_id`);

--
-- Indexes for table `ratingtrainer`
--
ALTER TABLE `ratingtrainer`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `fk_trainer` (`trainer_id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `trainer`
--
ALTER TABLE `trainer`
  ADD PRIMARY KEY (`trainer_id`);

--
-- Indexes for table `trainer_applications`
--
ALTER TABLE `trainer_applications`
  ADD PRIMARY KEY (`application_id`);

--
-- Indexes for table `trainer_inquiries`
--
ALTER TABLE `trainer_inquiries`
  ADD PRIMARY KEY (`inquiry_id`),
  ADD KEY `trainer_id` (`trainer_id`),
  ADD KEY `trainer_inquiries_ibfk_2` (`user_id`);

--
-- Indexes for table `training`
--
ALTER TABLE `training`
  ADD PRIMARY KEY (`training_id`),
  ADD KEY `training_ibfk_1` (`trainer_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_inquiries`
--
ALTER TABLE `user_inquiries`
  ADD PRIMARY KEY (`inquiry_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `receiver_id` (`receiver_id`,`receiver_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_inquiries`
--
ALTER TABLE `admin_inquiries`
  MODIFY `inquiry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `classregistration`
--
ALTER TABLE `classregistration`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `gym`
--
ALTER TABLE `gym`
  MODIFY `gym_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `personaltraining`
--
ALTER TABLE `personaltraining`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personaltrainingregistration`
--
ALTER TABLE `personaltrainingregistration`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `ratingtrainer`
--
ALTER TABLE `ratingtrainer`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `trainer`
--
ALTER TABLE `trainer`
  MODIFY `trainer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `trainer_applications`
--
ALTER TABLE `trainer_applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `trainer_inquiries`
--
ALTER TABLE `trainer_inquiries`
  MODIFY `inquiry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `training`
--
ALTER TABLE `training`
  MODIFY `training_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_inquiries`
--
ALTER TABLE `user_inquiries`
  MODIFY `inquiry_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_inquiries`
--
ALTER TABLE `admin_inquiries`
  ADD CONSTRAINT `admin_inquiries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `approved_class_registrations`
--
ALTER TABLE `approved_class_registrations`
  ADD CONSTRAINT `fk_class_id` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `approved_personal_training_registrations`
--
ALTER TABLE `approved_personal_training_registrations`
  ADD CONSTRAINT `fk_registration_id` FOREIGN KEY (`registration_id`) REFERENCES `personaltrainingregistration` (`registration_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_id_personal` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_ibfk_2` FOREIGN KEY (`gym_id`) REFERENCES `gym` (`gym_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_ibfk_3` FOREIGN KEY (`training_id`) REFERENCES `training` (`training_id`) ON DELETE CASCADE;

--
-- Constraints for table `classregistration`
--
ALTER TABLE `classregistration`
  ADD CONSTRAINT `classregistration_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `classregistration_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE CASCADE;

--
-- Constraints for table `personaltraining`
--
ALTER TABLE `personaltraining`
  ADD CONSTRAINT `personaltraining_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `trainer` (`trainer_id`);

--
-- Constraints for table `personaltrainingregistration`
--
ALTER TABLE `personaltrainingregistration`
  ADD CONSTRAINT `personaltrainingregistration_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `personaltrainingregistration_ibfk_2` FOREIGN KEY (`training_id`) REFERENCES `personaltraining` (`id`);

--
-- Constraints for table `ratingtrainer`
--
ALTER TABLE `ratingtrainer`
  ADD CONSTRAINT `fk_trainer` FOREIGN KEY (`trainer_id`) REFERENCES `trainer` (`trainer_id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `trainer_inquiries`
--
ALTER TABLE `trainer_inquiries`
  ADD CONSTRAINT `trainer_inquiries_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `trainer` (`trainer_id`),
  ADD CONSTRAINT `trainer_inquiries_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_inquiries`
--
ALTER TABLE `user_inquiries`
  ADD CONSTRAINT `user_inquiries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
