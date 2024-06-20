-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2024 at 11:14 AM
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
-- Database: `hfoms`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `checkout` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_infos`
--

CREATE TABLE `customer_infos` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `dietcart_id` int(11) NOT NULL,
  `weight` varchar(100) NOT NULL,
  `height` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `physical_activity` int(11) NOT NULL,
  `intolerances` text NOT NULL,
  `likes` text NOT NULL,
  `dislikes` text NOT NULL,
  `plan_choice` varchar(100) NOT NULL,
  `time_plan` varchar(100) NOT NULL,
  `order_type` varchar(100) NOT NULL,
  `pending` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` double NOT NULL,
  `image` varchar(100) NOT NULL,
  `calories` double NOT NULL,
  `fats` double NOT NULL,
  `carbs` double NOT NULL,
  `protein` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `category`, `price`, `image`, `calories`, `fats`, `carbs`, `protein`) VALUES
(1, 'Stir-Fried Egg and Tomato', 'breakfast', 5, 'Images\\breakfast\\eggs.jpg', 193, 14, 6, 10),
(4, 'Goat Cheese and Herb Omelet', 'breakfast', 5.5, 'Images\\breakfast\\omelette.jpg', 462, 37, 3, 28),
(5, 'Black Beans and Rice', 'lunch', 8, 'Images\\lunch\\riceandbeans.jpg', 310, 4, 56, 13),
(6, 'Classic Garlic Sauteed Broccoli', 'lunch', 5, 'Images\\lunch\\broccoli.jpg', 228, 15, 21, 9),
(7, 'Cauliflower Tots', 'snack', 4, 'Images\\snacks\\cauliflowe.jpg', 189, 9, 19, 11),
(8, 'Spiced Honey Pretzels', 'snack', 3, 'Images\\snacks\\pretzels.jpg', 285, 3, 57, 7),
(9, 'Green Kale Salad', 'dinner', 5, 'Images\\dinner\\kalesalad.jpg', 72, 2, 11, 4),
(10, 'Asian Quinoa Salad', 'dinner', 8, 'Images\\dinner\\quinoasalad.jpg', 234, 7, 34, 9),
(11, 'Dairy-Free Protein and Cocoa Shake', 'shakes', 6, 'Images\\shakes\\shake2.jpg', 211, 2, 24, 26),
(12, 'Very Green Veggie Protein Smoothie', 'shakes', 6, 'Images\\shakes\\shake6.jpg', 147, 6, 10, 14),
(13, 'Black Bean Brownie', 'dessert', 5.5, 'Images\\desserts\\dessert8.jpg', 71, 3, 8, 4),
(14, 'Cinnamon Apples with Yogurt', 'dessert', 4, 'Images\\desserts\\dessert3.jpg', 175, 2, 35, 7);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` varchar(100) NOT NULL,
  `rating` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_username` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `dob` datetime NOT NULL,
  `zip_code` int(11) NOT NULL,
  `city` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `card_nb` int(11) NOT NULL,
  `exp_year` int(11) NOT NULL,
  `security_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `age` int(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `login_status` int(11) NOT NULL,
  `gender` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `age`, `role`, `login_status`, `gender`) VALUES
(1, 'dana', 'dana.gmail.com', '123', 22, 'user', 0, 'female'),
(2, 'admin', 'admin@gmail.com', '123', 33, 'admin', 1, 'Male'),
(5, 'dietitian', 'dietitian@gmail.com', '123', 21, 'dietitian', 0, 'female'),
(6, 'admin1', 'admin1@gmail.com', '123', 40, 'admin', 0, 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `user_items`
--

CREATE TABLE `user_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `Day` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_infos`
--
ALTER TABLE `customer_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `dietcart_id` (`dietcart_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_items`
--
ALTER TABLE `user_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`user_id`),
  ADD KEY `itemid` (`item_id`),
  ADD KEY `cartID` (`cart_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_infos`
--
ALTER TABLE `customer_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_items`
--
ALTER TABLE `user_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_infos`
--
ALTER TABLE `customer_infos`
  ADD CONSTRAINT `customer_id` FOREIGN KEY (`customer_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `dietcart_id` FOREIGN KEY (`dietcart_id`) REFERENCES `cart` (`id`);

--
-- Constraints for table `user_items`
--
ALTER TABLE `user_items`
  ADD CONSTRAINT `cartID` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  ADD CONSTRAINT `itemid` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `userid` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
