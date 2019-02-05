-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 07, 2019 at 01:25 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Sugoph`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `errand_category`
--

CREATE TABLE `errand_category` (
  `errand_category_id` int(11) NOT NULL,
  `errand_name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `booking_fee` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `errand_category`
--

INSERT INTO `errand_category` (`errand_category_id`, `errand_name`, `description`, `booking_fee`) VALUES
(1, 'Bills Payment', 'Payment of bills', '50'),
(2, 'Bank Transaction', 'Bank transaction', '50');

-- --------------------------------------------------------

--
-- Table structure for table `services_offered`
--

CREATE TABLE `services_offered` (
  `user_id` int(11) NOT NULL,
  `errand_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `birthdate` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `street` varchar(50) NOT NULL,
  `barangay` varchar(50) NOT NULL,
  `education_level` varchar(50) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `rating` varchar(5) NOT NULL,
  `current_location` varchar(100) NOT NULL,
  `report_count` varchar(1) NOT NULL,
  `wallet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `type`, `username`, `password`, `firstname`, `middlename`, `lastname`, `birthdate`, `city`, `street`, `barangay`, `education_level`, `contact`, `email`, `status`, `rating`, `current_location`, `report_count`, `wallet_id`) VALUES
(141, 'erunner', 'van123', 'vAn123', 'Van', 'May', 'Diongzon', '2017-3-8', 'Cebu123', '123Rizal', '123Ticad', 'College Level', '09495969701', 'android.support.v7.widget.AppCompatEditText{d9483c', 'pending', '0', 'Not set', '0', 0),
(142, 'erunner', 'sid123', 'sId123', 'Sidney', 'May', 'Diongzon', '1995-12-12', 'Cebu', 'Rizal', 'Ticad2121', 'College Level', '09495979513', 's123@gmail.com', 'active', '3.4', '', '', 0),
(143, 'erunner', 'jol123', 'jOl123', 'Jl', 'Can', 'Ret', '2019-1-3', 'Cebu', 'Rizal', 'Raa', 'College Level', '09394847312', 'd123@gmail.com', 'pending', '0', 'Not set', '0', 0),
(144, 'erunner', 'bench123', 'bEnch123', 'Bench', 'Lee', 'Giganto', '2019-1-3', 'Cebu', 'Rixal', 'Ticad', 'College Level', '09494959523', 'be123@gmail.cm', 'pending', '0', '15.0-172.0', '0', 0),
(145, 'eseeker', 'toto123', 'tOto123', 'Toto', 'Mama', 'Papa', '2019-1-3', 'Dsds', 'Dsd', 'Dsds', 'Senior Highschool Level', '09394958341', 'dsd123@gmail.com', 'active', '0', 'N/A', '0', 0),
(146, 'erunner', 'vava123', 'vOv123', 'Kaka', 'Wawa', 'Lala', '2019-1-6', 'Cebu', 'Rizal', 'Ticad', 'College Level', '09394858212', 'r123@gmail.com', 'pending', '0', '15.0-172.0', '0', 0),
(147, 'erunner', 'vov123', 'vAv123', 'Tatat', 'Toto', 'Wawa', '2019-1-6', 'Cebu', 'Rizal', 'TICAD', 'College Level', '09395857261', 't123@gmail.com', 'pending', '0', '15.0-172.0', '0', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `errand_category`
--
ALTER TABLE `errand_category`
  ADD PRIMARY KEY (`errand_category_id`);

--
-- Indexes for table `services_offered`
--
ALTER TABLE `services_offered`
  ADD KEY `errand_category_id` (`errand_category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `errand_category`
--
ALTER TABLE `errand_category`
  MODIFY `errand_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `services_offered`
--
ALTER TABLE `services_offered`
  ADD CONSTRAINT `services_offered_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
