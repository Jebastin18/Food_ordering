-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2025 at 02:35 PM
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
-- Database: `food_ordering`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT 'default-category.jpg',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `image`, `status`, `created_at`) VALUES
(1, 'Biriyani', 'Fragrant rice dish with spices and meat or vegetables', 'Ambur-Chicken-Biriyani.jpg', 'active', '2025-05-10 10:46:40'),
(2, 'Burger', 'Delicious sandwiches with various fillings', 'burger.jpg', 'active', '2025-05-10 10:46:40'),
(3, 'Chapathi', 'Flatbread made from wheat flour', 'chapathi.jpg', 'active', '2025-05-10 10:46:40'),
(4, 'Dosa', 'Crispy fermented crepes made from rice batter', 'dossa.jpg', 'active', '2025-05-10 10:46:40'),
(5, 'Meals', 'Complete meal sets with rice and sides', 'meals.jpg', 'active', '2025-05-10 10:46:40'),
(6, 'Pizza', 'Italian dish with various toppings on flatbread', 'pizza.jpg', 'active', '2025-05-10 10:46:40'),
(7, 'Idli', 'Steamed rice cakes, a popular breakfast item', 'iddli.jpg', 'active', '2025-05-10 10:46:40'),
(8, 'Soup', 'Warm and comforting liquid food', 'soup.jpg', 'active', '2025-05-10 10:46:40'),
(9, 'Vada', 'Savory fried snack with a crispy exterior', 'vadai.jpg', 'active', '2025-05-10 10:46:40');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT 'default-item.jpg',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `category_id`, `name`, `description`, `price`, `image`, `status`, `created_at`) VALUES
(1, 1, 'Chicken Biriyani', 'Aromatic basmati rice cooked with tender chicken pieces and spices', 180.00, 'chettinadu-chicken-biriyani-1-3.jpg', 'active', '2025-05-10 10:46:40'),
(2, 1, 'Mutton Biriyani', 'Fragrant rice dish with succulent mutton pieces', 220.00, 'Mutton-Biryani.jpg', 'active', '2025-05-10 10:46:40'),
(3, 1, 'Veg Biriyani', 'Flavorful rice with mixed vegetables and aromatic spices', 150.00, 'veg-biriyani.jpg', 'active', '2025-05-10 10:46:40'),
(4, 1, 'Egg Biriyani', 'Spiced rice with boiled eggs', 160.00, 'disp3.jpg', 'active', '2025-05-10 10:46:40'),
(5, 2, 'Classic Burger', 'Juicy beef patty with lettuce, tomato, and cheese', 120.00, 'classic-burger.jpg', 'active', '2025-05-10 10:46:41'),
(6, 2, 'Chicken Burger', 'Grilled chicken patty with special sauce', 110.00, 'chicken-burger.jpg', 'active', '2025-05-10 10:46:41'),
(7, 2, 'Veggie Burger', 'Mixed vegetable patty with fresh toppings', 100.00, 'veggie-burger.jpg', 'active', '2025-05-10 10:46:41'),
(8, 3, 'Plain Chapathi', 'Soft whole wheat flatbread', 15.00, 'plain-chapathi.jpg', 'active', '2025-05-10 10:46:41'),
(9, 3, 'Butter Chapathi', 'Chapathi topped with butter', 20.00, 'butter-chapathi.jpg', 'active', '2025-05-10 10:46:41'),
(10, 3, 'Chapathi Curry Combo', 'Chapathi served with vegetable curry', 80.00, 'chapathi-combo.jpg', 'active', '2025-05-10 10:46:41'),
(11, 4, 'Plain Dosa', 'Crispy rice crepe served with sambar and chutney', 60.00, 'plain-dosa.jpg', 'active', '2025-05-10 10:46:41'),
(12, 4, 'Masala Dosa', 'Dosa filled with spiced potato filling', 80.00, 'masala-dosa.jpg', 'active', '2025-05-10 10:46:41'),
(13, 4, 'Ghee Roast', 'Extra crispy dosa made with ghee', 90.00, 'ghee-roast.jpg', 'active', '2025-05-10 10:46:41'),
(14, 4, 'Onion Dosa', 'Dosa topped with chopped onions', 70.00, 'onion-dosa.jpg', 'active', '2025-05-10 10:46:41'),
(15, 5, 'South Indian Meals', 'Rice with sambar, rasam, and vegetable curries', 120.00, 'south-meals.jpg', 'active', '2025-05-10 10:46:41'),
(16, 5, 'North Indian Thali', 'Roti, rice, dal, and paneer dish', 150.00, 'north-thali.jpg', 'active', '2025-05-10 10:46:41'),
(17, 5, 'Executive Lunch', 'Premium meal with extra sides and dessert', 180.00, 'executive-lunch.jpg', 'active', '2025-05-10 10:46:41'),
(18, 6, 'Margherita Pizza', 'Classic pizza with tomato sauce, mozzarella, and basil', 180.00, 'margherita-pizza.jpg', 'active', '2025-05-10 10:46:41'),
(19, 6, 'Pepperoni Pizza', 'Pizza topped with pepperoni slices', 220.00, 'pepperoni-pizza.jpg', 'active', '2025-05-10 10:46:41'),
(20, 6, 'Veggie Supreme', 'Pizza loaded with assorted vegetables', 200.00, 'veggie-pizza.jpg', 'active', '2025-05-10 10:46:41'),
(21, 7, 'Plain Idli', 'Steamed rice cakes served with sambar and chutney', 50.00, 'plain-idli.jpg', 'active', '2025-05-10 10:46:41'),
(22, 7, 'Rava Idli', 'Idli made with semolina', 60.00, 'rava-idli.jpg', 'active', '2025-05-10 10:46:41'),
(23, 7, 'Mini Idli Sambar', 'Small idlis soaked in sambar', 70.00, 'mini-idli.jpg', 'active', '2025-05-10 10:46:41'),
(24, 8, 'Tomato Soup', 'Creamy tomato soup with herbs', 60.00, 'tomato-soup.jpg', 'active', '2025-05-10 10:46:41'),
(25, 8, 'Sweet Corn Soup', 'Corn soup with vegetables', 70.00, 'corn-soup.jpg', 'active', '2025-05-10 10:46:41'),
(26, 8, 'Manchow Soup', 'Spicy Chinese soup with vegetables', 80.00, 'manchow-soup.jpg', 'active', '2025-05-10 10:46:41'),
(27, 9, 'Medu Vada', 'Crispy lentil donuts served with sambar and chutney', 50.00, 'medu-vada.jpg', 'active', '2025-05-10 10:46:41'),
(28, 9, 'Dahi Vada', 'Vada soaked in yogurt with spices', 60.00, 'dahi-vada.jpg', 'active', '2025-05-10 10:46:41'),
(29, 9, 'Sambar Vada', 'Vada soaked in sambar', 60.00, 'sambar-vada.jpg', 'active', '2025-05-10 10:46:41');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `payment_method` enum('cash','card','upi') NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') DEFAULT 'pending',
  `token_number` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_date` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `customer_phone`, `payment_method`, `total_amount`, `status`, `token_number`, `created_at`, `order_date`) VALUES
(1, 'jebastin', '6369592504', 'cash', 180.00, 'pending', 620, '2025-05-10 10:48:15', '2025-05-10'),
(2, 'jebastin', '6789897878', 'cash', 160.00, 'pending', 2, '2025-05-10 11:16:07', '2025-05-10'),
(3, 'jebastin', '7689786767', 'cash', 20.00, 'pending', 3, '2025-05-10 11:34:12', '2025-05-10'),
(4, 'hhh', '8888888', 'cash', 60.00, 'pending', 4, '2025-05-10 11:40:37', '2025-05-10'),
(5, 'jebatin', '8978787878', 'cash', 15.00, 'pending', 5, '2025-05-10 11:48:42', '2025-05-10');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `item_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 180.00),
(2, 2, 4, 1, 160.00),
(3, 3, 9, 1, 20.00),
(4, 4, 28, 1, 60.00),
(5, 5, 8, 1, 15.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `item_id` (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
