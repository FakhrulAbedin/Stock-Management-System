-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2025 at 08:43 PM
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
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `administration`
--

CREATE TABLE `administration` (
  `Admin_ID` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administration`
--

INSERT INTO `administration` (`Admin_ID`) VALUES
(12345),
(11111111);

-- --------------------------------------------------------

--
-- Table structure for table `assigns`
--

CREATE TABLE `assigns` (
  `Assign_ID` int(11) NOT NULL,
  `Admin_ID` int(8) NOT NULL,
  `Staff_ID` int(8) NOT NULL,
  `Assign_date` date NOT NULL,
  `Assign_time` time NOT NULL,
  `Task_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assigns`
--

INSERT INTO `assigns` (`Assign_ID`, `Admin_ID`, `Staff_ID`, `Assign_date`, `Assign_time`, `Task_description`) VALUES
(1, 12345, 123, '2025-01-04', '01:10:09', ''),
(2, 12345, 123456, '2025-01-04', '01:10:21', ''),
(3, 12345, 123456, '2025-01-04', '01:24:14', ''),
(4, 12345, 123, '2025-01-04', '15:44:25', ''),
(5, 12345, 123456, '2025-01-04', '15:54:15', ''),
(6, 12345, 123, '2025-01-04', '16:03:58', ''),
(7, 12345, 123, '2025-01-04', '16:11:14', ''),
(8, 12345, 123456, '2025-01-04', '16:57:45', ''),
(9, 12345, 123, '2025-01-04', '17:02:12', ''),
(10, 12345, 123, '2025-01-04', '18:02:45', ''),
(11, 12345, 123456, '2025-01-04', '18:03:05', ''),
(12, 12345, 123, '2025-01-04', '18:48:42', ''),
(13, 12345, 123456, '2025-01-04', '18:54:32', ''),
(14, 12345, 123, '2025-01-04', '19:07:42', ''),
(15, 11111111, 123456, '2025-01-05', '00:09:02', '');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `Equipment_ID` int(11) NOT NULL,
  `Equipment_name` varchar(200) NOT NULL,
  `Category` varchar(100) NOT NULL,
  `room_number` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`Equipment_ID`, `Equipment_name`, `Category`, `room_number`) VALUES
(1, 'Keyboard', 'Accessories', '10E27L'),
(2, 'Keyboard', 'Accessories', '10E27L'),
(3, 'mouse', 'Accessories', '10E27L'),
(4, 'Keyboard', 'Accessories', '10E27L'),
(5, 'mouse', 'Accessories', '10E27L'),
(6, 'Monitor', 'Accessories', '12F30L'),
(7, 'Monitor', 'Accessories', '12F30L'),
(8, 'mouse', 'Accessories', '12F30L'),
(9, 'mouse', 'Accessories', '12F30L'),
(12, 'mouse', 'Accessories', '12F30L'),
(13, 'mouse', 'Accessories', '12F30L'),
(14, 'mouse', 'Accessories', '12F30L'),
(15, 'monitor', 'Accessories', '12D26L'),
(16, 'Printer', 'Accessories', '12F31L'),
(17, 'Monitor', 'Accessories', '12F31L'),
(18, 'Printer', 'Accessories', '12F30L'),
(19, 'mouse', 'Accessories', '12F30L'),
(20, 'mouse', 'Accessories', '12F30L'),
(21, 'Monitor', 'networking', '10E31L'),
(22, 'Monitor', 'networking', '10E31L'),
(23, 'Monitor', 'networking', '10 R 4 '),
(24, 'Monitor', 'networking', '10 R 4 '),
(25, 'Monitor', 'networking', '10 R 4 ');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `Faculty_ID` int(8) NOT NULL,
  `Department` text NOT NULL,
  `Designation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`Faculty_ID`, `Department`, `Designation`) VALUES
(1234, 'CSE', 'Lecturer');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` varchar(8) NOT NULL,
  `description` text NOT NULL,
  `time` datetime NOT NULL,
  `response` text NOT NULL,
  `user_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `description`, `time`, `response`, `user_id`) VALUES
('67794d37', 'There is a issue.', '2025-01-04 21:01:11', 'bye', 0),
('67794f10', 'Thanks vai', '2025-01-04 21:09:04', 'ok', 0),
('6779788a', 'la illusion', '2025-01-05 00:06:02', 'ok', 1),
('67797a11', 'come league', '2025-01-05 00:12:33', 'shobji', 3434),
('67797d2c', 'do that', '2025-01-05 00:25:48', 'those', 1);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `Request_ID` varchar(30) NOT NULL,
  `stud_fac_ID` int(8) NOT NULL,
  `Equipment_name` varchar(255) NOT NULL,
  `Assigned_Staff_ID` int(8) DEFAULT NULL,
  `Quantity` int(99) NOT NULL,
  `Room_no` varchar(30) NOT NULL,
  `Status` enum('Pending','Approved','Rejected','In Progress') NOT NULL,
  `Request_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`Request_ID`, `stud_fac_ID`, `Equipment_name`, `Assigned_Staff_ID`, `Quantity`, `Room_no`, `Status`, `Request_date`) VALUES
('677834e860bfa', 22201740, 'mouse', 123, 1, '10E27L', 'Approved', '2025-01-04'),
('6778356348657', 22201740, 'Keyboard', 123456, 2, '10E27L', 'Approved', '2025-01-04'),
('6778358b5bb4a', 22201740, 'monitor', NULL, 2, '10E27L', 'Rejected', '2025-01-04'),
('6778391be735d', 1234, 'mouse', 123456, 5, '10E27L', 'Approved', '2025-01-04'),
('677902c034c18', 22201740, 'monitor', 123, 2, '12F30L', 'Approved', '2025-01-04'),
('6779052607769', 22201740, 'mouse', 123456, 2, '12F30L', 'Approved', '2025-01-04'),
('6779076b95974', 22201740, 'mouse', 123, 2, '12F30L', 'Approved', '2025-01-04'),
('67790924e761c', 22201740, 'mouse', 123, 1, '12F30L', 'Approved', '2025-01-04'),
('677913ffd7a2e', 22201740, 'mouse', 123456, 2, '12F30L', 'Approved', '2025-01-04'),
('67791500bfe6c', 22201740, 'monitor', 123, 1, '12D26L', 'Approved', '2025-01-04'),
('6779229f2e03f', 22201773, 'Printer', 123, 1, '12F31L', 'Approved', '2025-01-04'),
('6779233a5e27c', 22201773, 'Monitor', 123456, 1, '12F31L', 'Approved', '2025-01-04'),
('6779240571492', 22201773, 'Printer', 123, 1, '12F30L', 'Approved', '2025-01-04'),
('67792dea87343', 22201740, 'mouse', 123456, 1, '12F30L', 'Approved', '2025-01-04'),
('67792f6e07a7f', 22201740, 'mouse', 123, 1, '12F30L', 'Approved', '2025-01-04'),
('67797875d7696', 1, 'router', 123456, 1, '08E-20L', 'In Progress', '2025-01-05'),
('67797d1f1b8ce', 1, 'router', NULL, 2, '08E-20L', 'Pending', '2025-01-05');

-- --------------------------------------------------------

--
-- Table structure for table `request_assing`
--

CREATE TABLE `request_assing` (
  `Request_ID` varchar(30) NOT NULL,
  `Assign_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_assing`
--

INSERT INTO `request_assing` (`Request_ID`, `Assign_ID`) VALUES
('677834e860bfa', 1),
('6778356348657', 2),
('6778391be735d', 3),
('677902c034c18', 4),
('6779052607769', 5),
('6779076b95974', 6),
('67790924e761c', 7),
('677913ffd7a2e', 8),
('67791500bfe6c', 9),
('6779229f2e03f', 10),
('6779233a5e27c', 11),
('6779240571492', 12),
('67792dea87343', 13),
('67792f6e07a7f', 14),
('67797875d7696', 15);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `Staff_ID` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`Staff_ID`) VALUES
(3),
(123),
(123456);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Student_ID` int(8) NOT NULL,
  `Department` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Student_ID`, `Department`) VALUES
(1, 'CS'),
(3434, 'BBA'),
(22201740, 'CS'),
(22201773, 'CS'),
(24241333, 'CSE');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `Assign_ID` int(11) NOT NULL,
  `Task_description` text NOT NULL,
  `Status` enum('Pending','Completed') NOT NULL,
  `Completion_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`Assign_ID`, `Task_description`, `Status`, `Completion_date`) VALUES
(1, 'Kaaj kor beda', 'Completed', '2025-01-04'),
(2, 'Kaam kor', 'Completed', '2025-01-04'),
(3, 'kaaj kor', 'Completed', '2025-01-04'),
(4, 'Kaam kor vai', 'Completed', '2025-01-04'),
(5, 'Kaam kor vai', 'Completed', '2025-01-04'),
(6, 'kaam kor', 'Completed', '2025-01-04'),
(7, 'kaam kor', 'Completed', '2025-01-04'),
(8, 'kaam kor vai', 'Completed', '2025-01-04'),
(9, 'Kaam kor\r\n', 'Completed', '2025-01-04'),
(10, 'Kaam kor', 'Completed', '2025-01-04'),
(11, 'Kaam kor', 'Completed', '2025-01-04'),
(12, 'Printer Lagbe', 'Completed', '2025-01-04'),
(13, 'Mouse lagbe\r\n', 'Completed', '2025-01-04'),
(14, 'Kaaj koro', 'Completed', '2025-01-04'),
(15, 'kam kor', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(8) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Contact_no` varchar(15) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `Name`, `Contact_no`, `Email`, `Password`) VALUES
(1, 'riv', '2', 'r@r', '$2y$10$5bYX4TYlw0quXLbaKNTcGuSZVXdYxynLAYboiwy5ymoQ1Xwx1byYW'),
(3, 'goru', '121323234', 'goru@goru', '$2y$10$O75u1AnI7du7rUQeet0GIuh5obAMGCTLAk0Dfz1pXkFve5TIrO0ky'),
(123, '123', '123', '123@gmail.com', '$2y$10$.JIJgSWlDPsD9ceam4IIQOMI50R3XZmhAvcld6O4/ifI3q.OrkRqa'),
(1234, '1234', '1234', '1234@gmail.com', '$2y$10$Fruh6q8sAKNKvhHLTLN3VeYoiR1K4qgmENrNqBz9SjWpKsBVIF8Xq'),
(3434, 'emon', '444444444444444', 'emon@gmail.com', '$2y$10$LL4QnA7PTROatDq2mhVTuO9K2BvpTnO5QhEaJiCa.nXMtTFKEaf2C'),
(12345, '12345', '12345', '12345@gmail.com', '$2y$10$VnDn3.Wa4Slc4Np6XP64PeaaEbFgJq58Cf3Dr2UyJ437fl073ICO.'),
(123456, '123456', '123456', '123456@gmail.com', '$2y$10$x0SHCILetpaklzpG1tX/3OAfPcPSPlxqAwcezHt7TZt9FCPXq7Vhq'),
(11111111, 'abul', '111111', 'abul@abul', '$2y$10$EiLtDXkAxAPbFGwJWO9Kr.GDIExEk1CbxBiamJXmkTmWehQ8JYbJ2'),
(22201740, 'shohrub', '01876848291', 'shohrub@gmail.com', '$2y$10$1UeKvLL4SPUYT5tp.KbM3.4vLreO5Kdc5P3ADNSIF80GyRZOkO4uO'),
(22201773, 'Afifa Ahmed', '01739938988', 'afifa.ahmed@g.bracu.ac.bd', '$2y$10$lueQw361HNqQzqlQ8PS13.7nYpw9/6gG5nsfLlGjpeLJMmmsPBIKW'),
(24241333, 'fashohrub', '01815711925', 'fashohrub@gmail.com', '$2y$10$Ko/kNSDwu0WS5lrgMlvhGeNEK2EmlIuSMOUYBaWlkMrkMMCh7cUEy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administration`
--
ALTER TABLE `administration`
  ADD PRIMARY KEY (`Admin_ID`);

--
-- Indexes for table `assigns`
--
ALTER TABLE `assigns`
  ADD PRIMARY KEY (`Assign_ID`),
  ADD KEY `Admin_ID` (`Admin_ID`),
  ADD KEY `Staff_ID` (`Staff_ID`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`Equipment_ID`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`Faculty_ID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`Request_ID`),
  ADD KEY `User_ID` (`stud_fac_ID`);

--
-- Indexes for table `request_assing`
--
ALTER TABLE `request_assing`
  ADD PRIMARY KEY (`Request_ID`),
  ADD UNIQUE KEY `Assign_ID` (`Assign_ID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`Staff_ID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Student_ID`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`Assign_ID`),
  ADD KEY `Assign_ID` (`Assign_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assigns`
--
ALTER TABLE `assigns`
  MODIFY `Assign_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `Equipment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24241334;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administration`
--
ALTER TABLE `administration`
  ADD CONSTRAINT `administration_ibfk_1` FOREIGN KEY (`Admin_ID`) REFERENCES `user` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `assigns`
--
ALTER TABLE `assigns`
  ADD CONSTRAINT `assigns_ibfk_1` FOREIGN KEY (`Admin_ID`) REFERENCES `administration` (`Admin_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `assigns_ibfk_2` FOREIGN KEY (`Staff_ID`) REFERENCES `staff` (`Staff_ID`) ON DELETE CASCADE;

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `faculty_ibfk_1` FOREIGN KEY (`Faculty_ID`) REFERENCES `user` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`stud_fac_ID`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `request_assing`
--
ALTER TABLE `request_assing`
  ADD CONSTRAINT `request_assing_ibfk_1` FOREIGN KEY (`Request_ID`) REFERENCES `request` (`Request_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `request_assing_ibfk_2` FOREIGN KEY (`Assign_ID`) REFERENCES `assigns` (`Assign_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`Staff_ID`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`Assign_ID`) REFERENCES `assigns` (`Assign_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
