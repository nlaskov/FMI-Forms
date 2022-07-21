-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2022 at 06:01 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webproject`
--
CREATE DATABASE IF NOT EXISTS `webproject` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `webproject`;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` int(11) NOT NULL,
  `title` text DEFAULT NULL,
  `created_by` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `title`, `created_by`, `description`) VALUES
(40, 'Title One', 'temp@mail.com', 'Description of this form'),
(47, 'Shared form', 'kokolaskov@gmail.com', 'Shared form'),
(48, 'Form 3', 'temp@mail.com', '3'),
(49, 'Long form', 'temp@mail.com', 'More than one question');

-- --------------------------------------------------------

--
-- Table structure for table `shared`
--

CREATE TABLE `shared` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `form_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shared`
--

INSERT INTO `shared` (`id`, `email`, `form_id`) VALUES
(15, 'kokolaskov@gmail.com', 40),
(16, 'temp@mail.com', 47);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(255) NOT NULL,
  `fk` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `fk`, `name`, `password`) VALUES
('', '0', 'kokolaskov@gmail.com', '$2y$10$0CRqcNqjDSgUSiBoFHhDtePK9ZUay34bmaETK4FmRchUh3aSZ0tti'),
('kokolaskov@g123mail.com', '0', 'kokolaskov@g32mail.com1', '$2y$10$SUtx9Ik8phGvIcJsBOQUsOmotESMisfA5eN8x8R/BUGZ9dR5Cpu0S'),
('kokolaskov@gmail.com', '62429', 'Nikola Laskov', '$2y$10$TBaAPZCWgpTSh5eVY0JBheFgnIhVQUDKS9PZzgPkU10l3mxJbIjsS'),
('kokolaskov@gmail.com1', '62429', 'kokolaskov@gmail.com', '$2y$10$wOZuEKeyvoyh5aGZraUIG.8r68wHEBMbmXrStIKv7C0VsEWsAYrCO'),
('temp@mail.com', '0', 'Ivan', '$2y$10$/3OfWjUJsGktxB8TnyJBn.LoZbVWCYR61fQP5DaNuoP50cVUdZdqq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forms_ibfk_1` (`created_by`);

--
-- Indexes for table `shared`
--
ALTER TABLE `shared`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_results_ibfk_1` (`form_id`),
  ADD KEY `form_results_ibfk_2` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `shared`
--
ALTER TABLE `shared`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `forms`
--
ALTER TABLE `forms`
  ADD CONSTRAINT `forms_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`email`);

--
-- Constraints for table `shared`
--
ALTER TABLE `shared`
  ADD CONSTRAINT `form_results_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`),
  ADD CONSTRAINT `form_results_ibfk_2` FOREIGN KEY (`email`) REFERENCES `users` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;