-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 10, 2026 at 07:05 AM
-- Server version: 10.4.34-MariaDB-cll-lve
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mmconsul_reslife_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_details`
--

CREATE TABLE `additional_details` (
  `detail_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `category_path` varchar(255) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `power` varchar(50) DEFAULT NULL,
  `warranty` varchar(100) DEFAULT NULL,
  `non_stick` varchar(10) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `whats_in_box` text DEFAULT NULL,
  `dishwasher_safe` varchar(10) DEFAULT NULL,
  `appliance_type` varchar(100) DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `additional_details`
--

INSERT INTO `additional_details` (`detail_id`, `item_id`, `category_path`, `brand`, `power`, `warranty`, `non_stick`, `model`, `whats_in_box`, `dishwasher_safe`, `appliance_type`, `barcode`) VALUES
(2, 22, '', 'Lampco', '12v', 'No', 'No', '1', 'The lamp and adapter', 'No', 'Electronic', ''),
(3, 23, '', 'Asus', '12v', 'N/A', 'No', 'Notebook 1', 'Kaptop\r\nLaptop Chager', 'No', 'Laptop', '235677877erw');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@example.com', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(13) NOT NULL,
  `category` varchar(50) NOT NULL,
  `itemName` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `condition` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `category`, `itemName`, `description`, `image`, `price`, `condition`, `user_id`) VALUES
(11, 'Furniture', 'Kettle', 'It\'s a new kettle. never used', 'kettle.jpg', 126, 'New', 'mygmail@gmail.com'),
(15, 'Thrift', 'Jordan 4', 'Size 4', 'download.jpg', 3000, 'New', 'mygmail@gmail.com'),
(16, 'Books/Stationery', 'Calculator FXZ82', 'I did maths for 1 block lol', 'v4-460px-Use-a-Calculator-Step-1.jpg', 600, 'Used - Like New', 'mygmail@gmail.com'),
(17, 'Books/Stationery', 'Technical Science Textbook', 'its new. just buy the book', 'images.jpg', 400, 'New', 'mygmail@gmail.com'),
(22, 'Furniture', 'Study Lamp', 'It\'s a study lamp', 'images (1).jpg', 400, 'New', 'mygmail@gmail.com'),
(23, 'Electronics', 'Laptop', 'Asus laptop', 'Verse of the day (21).jpg', 3000, 'Used - Good', 'mygmail@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `buyer_email` varchar(255) NOT NULL,
  `seller_email` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`purchase_id`, `item_id`, `buyer_email`, `seller_email`, `status`, `timestamp`) VALUES
(1, 3, 'mygmail@gmail.com', '', 'Delivered', '2025-06-24 22:34:10'),
(2, 4, 'mygmail@gmail.com', '', 'Pending', '2025-06-24 22:34:10'),
(3, 17, 'mygmail@gmail.com', 'mygmail@gmail.com', 'Delivered', '2025-06-24 22:34:10'),
(4, 12, 'mygmail@gmail.com', 'mygmail@gmail.com', 'Pending', '2025-06-24 22:34:10'),
(5, 14, 'mygmail@gmail.com', 'mygmail@gmail.com', 'Pending', '2025-06-30 13:35:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `password`) VALUES
(0, 'Lusa', 'Surname', 'lusa@gmail.com', '4a9e7cdac0543c857ea11db0ee66c1f1'),
(0, 'Lusa', 'Marcus', 'lusa1@gmail.com', '73b7a9296aef420372b3146e44404fa8'),
(0, 'Mark', 'Mang', 'Myaccount@gmail.com', '43c2b6ae2468bf53877f3765b8847710'),
(0, 'Zeke', 'Luther', 'mygmail@gmail.com', 'bec70f7545102f39dc1aa775d9e5b2ef'),
(0, 'Mpho', 'Rampho', 'mphor@gmail.com', 'e175637e6b997bc33f81aaf13713b980'),
(0, 'Gundo', 'Mudau', 'mudau1@gmail.com', 'dc647eb65e6711e155375218212b3964'),
(0, ' >>> https://t.me/+zvj8c2b  #Lolllukazzzur333\r\n <<', ' >>> https://t.me/+zvj8c2b  #Lolllukazzzur333\r\n <<', 'ok2@kirzzioh.store\r\n', 'dd6b2dbc722040cc97722210f9055fc1'),
(0, 'Khuthadzo', 'Rasifudi', 'krasifudi@gamil.com', '34888db5ec6b54ad5d46868158e90e9b'),
(0, 'Khuthadzo', 'Rasifudi', 'krasifudi@gmail.com', '56baf9e5eaeb3ba8936e09c6a93daf41');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `student_number` varchar(50) DEFAULT NULL,
  `university` varchar(255) DEFAULT NULL,
  `delivery_address` text DEFAULT NULL,
  `pickup_address` text DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `email`, `student_number`, `university`, `delivery_address`, `pickup_address`, `last_updated`) VALUES
(1, 'mygmail@gmail.com', '45840012', 'Eduvos', '123 Abby Lane', '123 Pickup street', '2025-07-02 11:45:40'),
(2, 'mphor@gmail.com', '458400123', 'University of Pretoria', NULL, NULL, '2025-06-25 00:19:11'),
(3, 'mudau1@gmail.com', '45840012=3', 'Stellenbosch University', NULL, NULL, '2025-06-30 14:59:41'),
(4, 'ok2@kirzzioh.store\r\n', '', 'Walter Sisulu University', NULL, NULL, '2025-08-21 14:18:07'),
(5, 'krasifudi@gamil.com', '225112944', 'University of Johannesburg', NULL, NULL, '2026-01-24 07:28:55'),
(6, 'krasifudi@gmail.com', '225112944', 'University of Johannesburg', NULL, NULL, '2026-01-24 07:30:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_details`
--
ALTER TABLE `additional_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_details`
--
ALTER TABLE `additional_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `additional_details`
--
ALTER TABLE `additional_details`
  ADD CONSTRAINT `additional_details_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
