-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Apr 26, 2024 at 01:45 PM
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
-- Database: `db_expenses`
--
CREATE DATABASE IF NOT EXISTS `db_expenses` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_expenses`;

-- --------------------------------------------------------

--
-- Table structure for table `tb_expense`
--

CREATE TABLE `tb_expense` (
  `ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Expen_Date` date DEFAULT NULL,
  `Expen_item_name` varchar(255) DEFAULT NULL,
  `Expen_Price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_role`
--

CREATE TABLE `tb_role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_role`
--

INSERT INTO `tb_role` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'usuario registrado');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `ID` int(11) NOT NULL,
  `Full_Name` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Phone_Num` varchar(20) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `signup_date` date DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`ID`, `Full_Name`, `Email`, `Phone_Num`, `Password`, `signup_date`, `role_id`) VALUES
(48, 'Admin', 'admin@example.com', '1234567', '$2y$10$2rbmBOGSz9k57McJXAPUH.oVOkiAKHrI0Hlp1ZBU7OqOe7k06fdda', '2024-03-22', 1),
(50, 'Arturo Marin', 'arturo@example.com', '123456789', '$2y$10$52ThX/M9b7rcJ/z.PJcIFuBRQnRh9zDT6DiANFAnlfCWZVJRuPsaG', '2024-04-02', 2),
(51, 'Fabiola Galvan', 'fabiola@example.com', '123456789', '$2y$10$yckRjQItocSqIqA4nWy1kuOZduaKloGDKr/20lEvclofyB7aV2fBi', '2024-04-02', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_expense`
--
ALTER TABLE `tb_expense`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `tb_role`
--
ALTER TABLE `tb_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_expense`
--
ALTER TABLE `tb_expense`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_role`
--
ALTER TABLE `tb_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_expense`
--
ALTER TABLE `tb_expense`
  ADD CONSTRAINT `tb_expense_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `tb_user` (`ID`);

--
-- Constraints for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `tb_role` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
