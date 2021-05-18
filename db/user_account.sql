-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2021 at 07:17 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `puzzle_auth`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `id` int(11) NOT NULL,
  `fullname` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `passwrd` varchar(1000) NOT NULL,
  `picture` varchar(1000) NOT NULL,
  `grid_size` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`id`, `fullname`, `username`, `email`, `passwrd`, `picture`, `grid_size`) VALUES
(14, 'ADERINOLA SEGUN', 'lowskill', 'segunjames554@gmail.com', 'cfcd208495d565ef66e7dff9f98764da,c4ca4238a0b923820dcc509a6f75849b,c81e728d9d4c2f636f067f89cc14862c,eccbc87e4b5ce2fe28308fd9f2a7baf3,c9f0f895fb98ab9159f51fd0297e236d,a87ff679a2f3e71d9181a67b7542122c,1679091c5a880faf6fb5e6087eb1b2dc,8f14e45fceea167a5a36dedd4bea2543,e4da3b7fbbce2345d7772b0674a318d5', 'IMG_20171019_120654.jpg', '3'),
(18, 'ADERINOLA SEGUN', 'lozkey554', 'aderinolasegun9@gmail.com', 'cfcd208495d565ef66e7dff9f98764da,c4ca4238a0b923820dcc509a6f75849b,eccbc87e4b5ce2fe28308fd9f2a7baf3,c81e728d9d4c2f636f067f89cc14862c', 'IMG_20171201_130217.jpg', '2'),
(19, 'Omoloye Isaiah', 'admin', 'adewalebob15@gmail.com', 'eccbc87e4b5ce2fe28308fd9f2a7baf3,cfcd208495d565ef66e7dff9f98764da,c81e728d9d4c2f636f067f89cc14862c,c4ca4238a0b923820dcc509a6f75849b', 'IMG_20180202_010006_506.JPG', '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
