-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2018 at 04:46 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_auditorium`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_customer`
--

CREATE TABLE `tb_customer` (
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `email` text NOT NULL,
  `address` text NOT NULL,
  `pnum1` int(10) NOT NULL,
  `pnum2` int(10) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_customer`
--

INSERT INTO `tb_customer` (`fname`, `lname`, `email`, `address`, `pnum1`, `pnum2`, `password`) VALUES
('Akila', 'Rasad', 'akilarasad@outlook.com', 'No.11, Wimalasara Mawatha, gorakana, Keselwatta, Panadura.', 755008855, 769611911, 'ar123');

-- --------------------------------------------------------

--
-- Table structure for table `tb_deco`
--

CREATE TABLE `tb_deco` (
  `did` varchar(5) NOT NULL,
  `descrp` varchar(200) NOT NULL,
  `plus` varchar(20) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_deco`
--

INSERT INTO `tb_deco` (`did`, `descrp`, `plus`, `price`) VALUES
('0001', 'Podium', 'fresh flowers', 5000),
('0002', 'Oil Lamp + Podium', 'fresh flowers', 9000),
('0009', 'Podium', 'artificial flowers', 3500),
('0010', 'Oil Lamp + Podium', 'artificial flowers', 6000),
('0017', 'Podium', 'baloons', 3000),
('0018', 'Oil Lamp + Podium', 'baloons', 5000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_food`
--

CREATE TABLE `tb_food` (
  `fid` int(5) NOT NULL,
  `descrp` varchar(60) NOT NULL,
  `price` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_food`
--

INSERT INTO `tb_food` (`fid`, `descrp`, `price`) VALUES
(1, 'Vadei', 40),
(2, 'Plain Tea', 10);

-- --------------------------------------------------------

--
-- Table structure for table `tb_reservation`
--

CREATE TABLE `tb_reservation` (
  `no` int(5) NOT NULL,
  `uid` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(15) NOT NULL,
  `packs` int(4) NOT NULL,
  `purpose` varchar(200) NOT NULL,
  `fid` int(5) NOT NULL,
  `did` int(5) NOT NULL,
  `tid` int(5) NOT NULL,
  `total` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_reservation`
--

INSERT INTO `tb_reservation` (`no`, `uid`, `date`, `time`, `packs`, `purpose`, `fid`, `did`, `tid`, `total`) VALUES
(1, 'akilarasad@outlook.com', '0000-00-00', 'morning', 150, 'hrhr', 1, 1, 1001, 90),
(2, 'akilamanuwantha@gmail.com', '0000-00-00', 'morning', 150, 'tyjytj', 1, 1, 1001, 100),
(3, 'subhanimadhushani@gmail.com', '0000-00-00', 'morning', 150, 'kjhlkj', 1, 1, 1001, 500),
(4, 'akilarasad@outlook.com', '0000-00-00', 'morning', 150, 'knklknlk', 2, 1, 1001, 90),
(5, 'akilarasad@outlook.com', '0000-00-00', 'evening', 300, 'ooooooooooooo', 2, 9, 1003, 9000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_technical`
--

CREATE TABLE `tb_technical` (
  `tid` int(5) NOT NULL,
  `descrp` varchar(100) NOT NULL,
  `price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_technical`
--

INSERT INTO `tb_technical` (`tid`, `descrp`, `price`) VALUES
(1001, 'Review Sound needs + Review equipment needs', 2500),
(1002, 'Review Lightning + Review equipment needs', 2500),
(1003, 'Review Lightning + Review Sound needs + Review equipment needs', 5000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_customer`
--
ALTER TABLE `tb_customer`
  ADD PRIMARY KEY (`email`(50));

--
-- Indexes for table `tb_deco`
--
ALTER TABLE `tb_deco`
  ADD PRIMARY KEY (`did`);

--
-- Indexes for table `tb_food`
--
ALTER TABLE `tb_food`
  ADD PRIMARY KEY (`fid`);

--
-- Indexes for table `tb_reservation`
--
ALTER TABLE `tb_reservation`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `tb_technical`
--
ALTER TABLE `tb_technical`
  ADD PRIMARY KEY (`tid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_reservation`
--
ALTER TABLE `tb_reservation`
  MODIFY `no` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
