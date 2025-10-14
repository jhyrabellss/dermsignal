-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2024 at 02:41 PM
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
-- Database: `dermsignal_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account`
--

CREATE TABLE `tbl_account` (
  `ac_id` int(11) NOT NULL,
  `ac_username` varchar(255) NOT NULL,
  `ac_email` varchar(400) NOT NULL,
  `ac_password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `account_status_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_account`
--

INSERT INTO `tbl_account` (`ac_id`, `ac_username`, `ac_email`, `ac_password`, `role_id`, `account_status_id`) VALUES
(1, 'jhaymark198', 'jhaymark198@gmail.com', '$2y$10$HjBNvFzie99.EtPoRxTn6./MLQ4FF63PIwlDvTPz5iGcvElsczSK2', 1, 1),
(2, 'shibal1', 'shibal@gmail.com', '$2y$10$p2Mbo9cxssQGcOe2vPpVCuxnxOlTdPySyrbfQ0GzwydLBI2HK5SNe', 1, 1),
(3, 'uniform1', 'uniform@gmail.com', '$2y$10$6X5caxJ7hgH2jHJTVSMhVer80umvvkjZlKnYvhko6dTOdt.duBZIK', 1, 2),
(4, 'lelouch1', 'lelouch@gmail.com', '$2y$10$4tGORYUvKk4PmBJY8WNqdOgZgDTqq6/rUgmKv7UStyv06XX1wQy36', 1, 1),
(5, 'kiko1', 'kiko@gmail.com', '$2y$10$d69zFFkiMBnrYJyVixN.ieoydzdc/bsOiH7Nppy1mdwFSmFyCsTwS', 1, 1),
(6, 'admin', 'admin@gmail.com', '$2y$10$egNxXzs.VSGfoHHq23iaR.mUC5za/vs3UwOF2OvSHHtIPooXIxl1i', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account_details`
--

CREATE TABLE `tbl_account_details` (
  `ac_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `contact` varchar(15) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_account_details`
--

INSERT INTO `tbl_account_details` (`ac_id`, `first_name`, `middle_name`, `last_name`, `gender`, `contact`, `address`) VALUES
(1, 'Jhaymark', 'Magat', 'Marquez', 'Male', '', ''),
(2, 'Shibal', 'Magat', 'Mandusay', 'Male', '', ''),
(3, 'Uniform', 'Resource', 'Locator', 'Male', '', ''),
(4, 'lelouch', 'hitler', 'luoda', 'Male', '', ''),
(5, 'Kiko ', 'Miranda', 'Music', 'Male', '', ''),
(6, 'Admin', 'Jhyra', 'Jhyra', 'Male', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ac_status`
--

CREATE TABLE `tbl_ac_status` (
  `ac_status_id` int(11) NOT NULL,
  `ac_status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_estonian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_ac_status`
--

INSERT INTO `tbl_ac_status` (`ac_status_id`, `ac_status`) VALUES
(1, 'Active'),
(2, 'Deactivated');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_audit_log`
--

CREATE TABLE `tbl_audit_log` (
  `log_user_id` int(11) DEFAULT NULL,
  `log_username` varchar(50) DEFAULT NULL,
  `log_user_type` varchar(50) DEFAULT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_audit_log`
--

INSERT INTO `tbl_audit_log` (`log_user_id`, `log_username`, `log_user_type`, `log_date`) VALUES
(6, 'admin', '2', '2024-12-11 11:52:16'),
(1, 'jhaymark198', '1', '2024-12-11 13:39:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_audit_trail`
--

CREATE TABLE `tbl_audit_trail` (
  `trail_user_id` int(11) DEFAULT NULL,
  `trail_username` varchar(50) DEFAULT NULL,
  `trail_activity` varchar(50) DEFAULT NULL,
  `trail_user_type` varchar(50) DEFAULT NULL,
  `trail_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_audit_trail`
--

INSERT INTO `tbl_audit_trail` (`trail_user_id`, `trail_username`, `trail_activity`, `trail_user_type`, `trail_date`) VALUES
(6, 'admin', 'Deactivated Account ID: 3', 'Admin', '2024-12-11 11:59:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_best_seller`
--

CREATE TABLE `tbl_best_seller` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `prod_price` int(11) NOT NULL,
  `concern_id` int(11) NOT NULL,
  `ingredients_id` int(11) NOT NULL,
  `prod_stocks` int(11) NOT NULL,
  `prod_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_billing_details`
--

CREATE TABLE `tbl_billing_details` (
  `ac_details_id` int(11) NOT NULL,
  `ac_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `unit_number` varchar(50) NOT NULL,
  `barangay` varchar(50) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `city` varchar(50) NOT NULL,
  `region` varchar(20) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `payment_type_id` int(11) NOT NULL,
  `delivery_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_billing_details`
--

INSERT INTO `tbl_billing_details` (`ac_details_id`, `ac_id`, `email`, `first_name`, `middle_name`, `last_name`, `unit_number`, `barangay`, `postal_code`, `city`, `region`, `phone_number`, `payment_type_id`, `delivery_type_id`) VALUES
(1, 4, 'lelouch@gmail.com', 'lelouch', NULL, 'luoda', 'Rosal', 'Sabang', '3006', 'Baliuag', 'Region 4', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `item_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `prod_qnty` int(11) NOT NULL,
  `order_date` date DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT 1,
  `account_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_cart`
--

INSERT INTO `tbl_cart` (`item_id`, `prod_id`, `prod_qnty`, `order_date`, `status_id`, `account_id`) VALUES
(1, 8, 1, '2024-12-11', 5, 4),
(2, 14, 1, '2024-12-11', 5, 4),
(3, 9, 1, '2024-12-11', 5, 4),
(4, 3, 1, '2024-12-11', 5, 4),
(5, 8, 1, '2024-12-11', 2, 2),
(6, 7, 1, '2024-12-11', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_concern`
--

CREATE TABLE `tbl_concern` (
  `concern_id` int(11) NOT NULL,
  `concern_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_concern`
--

INSERT INTO `tbl_concern` (`concern_id`, `concern_name`) VALUES
(1, 'Acne'),
(2, 'Acne Scars'),
(3, 'Open Pores'),
(4, 'Pigmentation');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_us`
--

CREATE TABLE `tbl_contact_us` (
  `comment_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_delivery_type`
--

CREATE TABLE `tbl_delivery_type` (
  `delivery_type_id` int(11) NOT NULL,
  `delivery_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_delivery_type`
--

INSERT INTO `tbl_delivery_type` (`delivery_type_id`, `delivery_type`) VALUES
(1, 'ship'),
(2, 'pickup');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ingredients`
--

CREATE TABLE `tbl_ingredients` (
  `ingredients_id` int(11) NOT NULL,
  `ingredient_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_ingredients`
--

INSERT INTO `tbl_ingredients` (`ingredients_id`, `ingredient_name`) VALUES
(1, 'Salicylic Acid'),
(2, 'Niacinamide'),
(3, 'Glycolic Acid'),
(4, 'Retinol'),
(5, 'Vitamin C');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_item_reviews`
--

CREATE TABLE `tbl_item_reviews` (
  `rv_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `rv_comment` varchar(255) NOT NULL,
  `rating` int(5) NOT NULL,
  `rv_date` date NOT NULL DEFAULT current_timestamp(),
  `ac_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_item_reviews`
--

INSERT INTO `tbl_item_reviews` (`rv_id`, `prod_id`, `rv_comment`, `rating`, `rv_date`, `ac_id`) VALUES
(1, 3, 'dwaddawd', 3, '2024-12-10', 5),
(2, 3, 'okane kase kyu oraewa wasta', 3, '2024-12-10', 5),
(3, 3, 'this is so cool bro', 3, '2024-12-10', 5),
(4, 6, 'so good ', 4, '2024-12-10', 5),
(5, 3, 'wow', 3, '2024-12-10', 5),
(6, 3, 'So wonderfully good sarap sa balat yah', 4, '2024-12-10', 1),
(7, 11, 'Damn so good', 3, '2024-12-10', 1),
(8, 5, 'damn son so good', 1, '2024-12-10', 1),
(9, 5, 'damn son', 1, '2024-12-10', 1),
(10, 1, 'potato ', 3, '2024-12-10', 4),
(11, 12, '3 ', 3, '2024-12-10', 4),
(12, 1, 'jhjhjhjh', 4, '2024-12-11', 1),
(13, 1, 'dwadaw', 4, '2024-12-11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_type`
--

CREATE TABLE `tbl_payment_type` (
  `payment_type_id` int(11) NOT NULL,
  `payment_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_payment_type`
--

INSERT INTO `tbl_payment_type` (`payment_type_id`, `payment_type`) VALUES
(1, 'gcash'),
(2, 'cash');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `prod_price` int(11) NOT NULL,
  `prod-short-desc` varchar(255) NOT NULL,
  `prod_description` text NOT NULL,
  `concern_id` int(11) NOT NULL,
  `ingredients_id` int(11) NOT NULL,
  `prod_stocks` int(11) NOT NULL,
  `prod_discount` int(11) NOT NULL,
  `prod_img` varchar(255) NOT NULL,
  `prod_hover_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_nopad_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`prod_id`, `prod_name`, `prod_price`, `prod-short-desc`, `prod_description`, `concern_id`, `ingredients_id`, `prod_stocks`, `prod_discount`, `prod_img`, `prod_hover_img`) VALUES
(1, 'Acne Refining Foaming Cleanser', 500, 'Deep Cleansing | Reduces Breakouts', 'DermSignal Acne Refining Foaming Cleanser has a synergistic blend of Iris, Zinc, Vitamin A, and Niacinamide designed for oily and acne prone skin. It helps in reducing sebum production and acne breakouts.', 3, 2, 50, 20, 'prod-1-ref-cleanser.png', 'prod-1-ref-cleanser-hover.png'),
(2, 'Acne Refining Gel', 260, 'Targets Acne | Controls Oil Production', 'DermSignal Acne Refining Gel is a water-based gel that has a synergistic blend of Iris, Zinc, Vitamin A, and Niacinamide designed for oily and acne prone skin. It helps in reducing sebum production and acne breakouts.', 1, 4, 50, 10, 'prod-2-ref-gel.png', 'prod-2-ref-gel-hover'),
(3, 'Acne Refining Spot Corrector', 300, 'Precision Treatment | Reduces Pimples Fast', 'DermSignal Acne Refining Spot Corrector is a serum that has a synergistic blend of Iris, Zinc, Vitamin A, Niacinamide, and Salicylic Acid designed for oily and acne prone skin. It helps in reducing sebum production and acne breakouts.', 1, 2, 50, 10, 'prod-3-ref-spot.png', 'prod-3-ref-spot-hover.png'),
(4, 'Acne Refining Toner', 450, 'Balances Skin | Minimizes Pores', 'A DermSignal Acne Refining Toner is an alcohol-free toner that has a synergistic blend of Iris, Zinc, Vitamin A, and Niacinamide designed for oily and acne prone skin.\r\nIt helps in reducing sebum production and acne breakouts.', 1, 1, 50, 10, 'prod-4-ref-toner.png', 'prod-4-ref-toner-hover.png'),
(5, 'Skin Renewal Foaming Cleanser', 460, 'Gentle Cleansing | Refreshes & Revives Skin', 'DermSignal Skin Renewal Foaming Cleanser contains salicylic acid that helps hydrate, remove dirt and excess oil on the face.', 3, 1, 50, 10, 'prod-5-renew-cleanser.png', 'prod-5-renew-cleanser-hover.png'),
(6, 'Skin Renewal Creme', 500, 'Nourishing Hydration | Restores Skin\'s Radiance', 'DermSignal Skin Renewal Creme contains natural AHAs that help increase the production of collagen and glycosaminoglycan that are responsible for reducing surface wrinkles, fine lines, and smoothen rough skin.', 2, 3, 50, 10, 'prod-6-renew-cream.png', 'prod-6-renew-cream-hover.png'),
(7, 'Skin Renewal Fruit Mix Booster', 340, 'Revitalizing Formula | Boosts Skin Glow', 'DermSignal Skin Renewal Fruit Mix Booster contains natural AHAs. This product helps increase the production of collagen and glycosaminoglycan that are responsible for reducing surface wrinkles, fine lines, and smoothens rough skin.', 2, 5, 49, 10, 'prod-7-renew-spot.png', 'prod-7-renew-spot-hover.png'),
(8, 'Skin Renewal Tonic', 600, 'Refreshing Toner | Rejuvenates & Hydrates Skin', 'DermSignal Skin Renewal Tonic contains natural AHAs. This product helps increase the production of collagen and glycosaminoglycan that are responsible for reducing surface wrinkles, fine lines, and smoothens rough skin.', 2, 4, 49, 10, 'prod-8-renew-toner.png', 'prod-8-renew-toner-hover.png'),
(9, 'Skin Lightening Soap', 300, 'Brightening Formula | Evens Skin Tone', 'DermSignal Skin Lightening Soap harnesses the power of Vitamin C, a potent antioxidant known for its brightening and skin-tone-evening properties. This gentle formula helps reduce the appearance of dark spots, leaving your skin looking radiant, smooth, an', 4, 5, 50, 10, 'prod-9-light-soap.png', 'prod-9-light-soap-hover.png'),
(10, 'Skin Lightening Night Booster', 650, 'Overnight Brightening | Reduces Dark Spots', 'DermSignal Skin Lightening Night Booster is enriched with Glycolic Acid, a powerful exfoliant that helps fade dark spots, even out skin tone, and promote a brighter, smoother complexion. Wake up to revitalized, glowing skin as it works overnight to reveal', 4, 3, 50, 15, 'prod-10-light-spot.png', 'prod-10-light-spot-hover.png'),
(11, 'Skin Lightening Toner', 475, 'Clarifying Formula | Evens Skin Tone', 'DermSignal Skin Lightening Toner combines the brightening power of Vitamin C with the exfoliating benefits of Glycolic Acid to gently cleanse, even out skin tone, and reduce the appearance of dark spots. Achieve a refreshed, radiant complexion with this d', 4, 5, 50, 10, 'prod-11-light-toner.png', 'prod-11-light-toner-hover.png'),
(12, '[Rx] TREVISO Isotretinoin 10mg (Box of 30s)', 1500, 'Clear Skin Treatment | Reduces Severe Acne', 'An established prescription acne medication that deactivates hyperactive oil glands: the center of acne pathology. Correct dosing and treatment protocols may give an 80% chance of cure. Ideal for patients who have recurring acne and do not respond to diff', 1, 4, 50, 20, 'prod-12-iso.webp', 'prod-12-iso-hover.webp'),
(13, '[Rx] ACRESIL Clindamycin Capsule 300mg (28s)', 560, 'Bacterial Infection Treatment | Effective Antibiotic', '\r\n[Rx] ACRESIL Clindamycin 300mg (28s) is an antibiotic for treating bacterial infections, including skin, respiratory, and bone infections. Use as prescribed by your healthcare provider.', 1, 4, 50, 10, 'prod-13-acresil.jpg', 'prod-13-acre-hover.webp'),
(14, '[Rx] Betamethasone Valerate 1mg/g 0.1% (w/w) Topical Cream 15g', 380, 'Inflammation Relief | Reduces Skin Redness & Itching', '[Rx] Betamethasone Valerate 0.1% Topical Cream (15g) is a corticosteroid used to relieve inflammation, redness, and itching associated with skin conditions like eczema and psoriasis. Apply as directed by your healthcare provider.', 4, 3, 50, 10, 'prod-14-beta.webp', 'prod-14-beta-hover.webp'),
(15, '[Rx] PIDCLIN Doxycycline Capsule 100mg', 720, 'Broad-Spectrum Antibiotic | Treats Bacterial Infections', '[Rx] PIDCLIN Doxycycline 100mg Capsule is an antibiotic used to treat various bacterial infections, including respiratory, skin, and urinary tract infections. It also treats acne and certain sexually transmitted infections. Use as prescribed by your healt', 1, 4, 50, 10, 'prod-15-doxy.webp', 'prod-15-doxy-hover.webp'),
(16, 'BatongBakalHydrocloride', 200, '', '', 4, 2, 50, 0, '6757fddbe5dfb.jpeg', ''),
(17, 'BatongBakalHydrocloride', 200, '', '', 2, 3, 50, 0, '675955629fb47.jpeg', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_prod_bestseller`
--

CREATE TABLE `tbl_prod_bestseller` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `prod_price` int(11) NOT NULL,
  `prod-short-desc` varchar(255) NOT NULL,
  `prod_description` text NOT NULL,
  `concern_id` int(11) NOT NULL,
  `ingredients_id` int(11) NOT NULL,
  `prod_stocks` int(11) NOT NULL,
  `prod_discount` int(11) NOT NULL,
  `prod_img` varchar(255) NOT NULL,
  `prod_hover_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_nopad_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_prod_bestseller`
--

INSERT INTO `tbl_prod_bestseller` (`prod_id`, `prod_name`, `prod_price`, `prod-short-desc`, `prod_description`, `concern_id`, `ingredients_id`, `prod_stocks`, `prod_discount`, `prod_img`, `prod_hover_img`) VALUES
(1, 'Acne Refining Foaming Cleanser', 500, 'Deep Cleansing | Reduces Breakouts', 'DermSignal Acne Refining Foaming Cleanser has a synergistic blend of Iris, Zinc, Vitamin A, and Niacinamide designed for oily and acne prone skin. It helps in reducing sebum production and acne breakouts.', 3, 2, 50, 20, 'prod-1-ref-cleanser.png', 'prod-1-ref-cleanser-hover.png'),
(3, 'Acne Refining Spot Corrector', 300, 'Precision Treatment | Reduces Pimples Fast', 'DermSignal Acne Refining Spot Corrector is a serum that has a synergistic blend of Iris, Zinc, Vitamin A, Niacinamide, and Salicylic Acid designed for oily and acne prone skin. It helps in reducing sebum production and acne breakouts.', 1, 2, 50, 10, 'prod-3-ref-spot.png', 'prod-3-ref-spot-hover.png'),
(6, 'Skin Renewal Creme', 500, 'Nourishing Hydration | Restores Skin\'s Radiance', 'DermSignal Skin Renewal Creme contains natural AHAs that help increase the production of collagen and glycosaminoglycan that are responsible for reducing surface wrinkles, fine lines, and smoothen rough skin.', 2, 3, 50, 10, 'prod-6-renew-cream.png', 'prod-6-renew-cream-hover.webp'),
(7, 'Skin Renewal Fruit Mix Booster', 340, 'Revitalizing Formula | Boosts Skin Glow', 'DermSignal Skin Renewal Fruit Mix Booster contains natural AHAs. This product helps increase the production of collagen and glycosaminoglycan that are responsible for reducing surface wrinkles, fine lines, and smoothens rough skin.', 2, 5, 50, 10, 'prod-7-renew-spot.png', 'prod-7-renew-spot-hover.png'),
(11, 'Skin Lightening Toner', 475, 'Clarifying Formula | Evens Skin Tone', 'DermSignal Skin Lightening Toner combines the brightening power of Vitamin C with the exfoliating benefits of Glycolic Acid to gently cleanse, even out skin tone, and reduce the appearance of dark spots. Achieve a refreshed, radiant complexion with this d', 4, 5, 50, 10, 'prod-11-light-toner.png', 'prod-11-light-toner-hover.png'),
(12, '[Rx] TREVISO Isotretinoin 10mg (Box of 30s)', 1500, 'Clear Skin Treatment | Reduces Severe Acne', 'An established prescription acne medication that deactivates hyperactive oil glands: the center of acne pathology. Correct dosing and treatment protocols may give an 80% chance of cure. Ideal for patients who have recurring acne and do not respond to diff', 1, 4, 50, 20, 'prod-12-iso.webp', 'prod-12-iso-hover.webp'),
(13, '[Rx] ACRESIL Clindamycin Capsule 300mg (28s)', 560, 'Bacterial Infection Treatment | Effective Antibiotic', '\r\n[Rx] ACRESIL Clindamycin 300mg (28s) is an antibiotic for treating bacterial infections, including skin, respiratory, and bone infections. Use as prescribed by your healthcare provider.', 1, 4, 50, 10, 'prod-13-acresil.jpg', 'prod-13-acre-hover.webp'),
(15, '[Rx] PIDCLIN Doxycycline Capsule 100mg', 720, 'Broad-Spectrum Antibiotic | Treats Bacterial Infections', '[Rx] PIDCLIN Doxycycline 100mg Capsule is an antibiotic used to treat various bacterial infections, including respiratory, skin, and urinary tract infections. It also treats acne and certain sexually transmitted infections. Use as prescribed by your healt', 1, 4, 50, 10, 'prod-15-doxy.webp', 'prod-15-doxy.webp');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_prod_newarrivals`
--

CREATE TABLE `tbl_prod_newarrivals` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `prod_price` int(11) NOT NULL,
  `prod-short-desc` varchar(255) NOT NULL,
  `prod_description` text NOT NULL,
  `concern_id` int(11) NOT NULL,
  `ingredients_id` int(11) NOT NULL,
  `prod_stocks` int(11) NOT NULL,
  `prod_discount` int(11) NOT NULL,
  `prod_img` varchar(255) NOT NULL,
  `prod_hover_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_nopad_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_prod_newarrivals`
--

INSERT INTO `tbl_prod_newarrivals` (`prod_id`, `prod_name`, `prod_price`, `prod-short-desc`, `prod_description`, `concern_id`, `ingredients_id`, `prod_stocks`, `prod_discount`, `prod_img`, `prod_hover_img`) VALUES
(2, 'Acne Refining Gel', 260, 'Targets Acne | Controls Oil Production', 'DermSignal Acne Refining Gel is a water-based gel that has a synergistic blend of Iris, Zinc, Vitamin A, and Niacinamide designed for oily and acne prone skin. It helps in reducing sebum production and acne breakouts.', 1, 4, 50, 10, 'prod-2-ref-gel.png', 'prod-2-ref-gel-hover'),
(4, 'Acne Refining Toner', 450, 'Balances Skin | Minimizes Pores', 'A DermSignal Acne Refining Toner is an alcohol-free toner that has a synergistic blend of Iris, Zinc, Vitamin A, and Niacinamide designed for oily and acne prone skin.\r\nIt helps in reducing sebum production and acne breakouts.', 1, 1, 50, 10, 'prod-4-ref-toner.png', 'prod-4-ref-toner-hover.png'),
(5, 'Skin Renewal Foaming Cleanser', 460, 'Gentle Cleansing | Refreshes & Revives Skin', 'DermSignal Skin Renewal Foaming Cleanser contains salicylic acid that helps hydrate, remove dirt and excess oil on the face.', 3, 1, 50, 10, 'prod-5-renew-cleanser.png', 'prod-5-renew-cleanser-hover.png'),
(7, 'Skin Renewal Fruit Mix Booster', 340, 'Revitalizing Formula | Boosts Skin Glow', 'DermSignal Skin Renewal Fruit Mix Booster contains natural AHAs. This product helps increase the production of collagen and glycosaminoglycan that are responsible for reducing surface wrinkles, fine lines, and smoothens rough skin.', 2, 5, 50, 10, 'prod-7-renew-spot.png', 'prod-7-renew-spot-hover.png'),
(9, 'Skin Lightening Soap', 300, 'Brightening Formula | Evens Skin Tone', 'DermSignal Skin Lightening Soap harnesses the power of Vitamin C, a potent antioxidant known for its brightening and skin-tone-evening properties. This gentle formula helps reduce the appearance of dark spots, leaving your skin looking radiant, smooth, an', 4, 5, 50, 10, 'prod-9-light-soap.png', 'prod-9-light-soap-hover.png'),
(10, 'Skin Lightening Night Booster', 650, 'Overnight Brightening | Reduces Dark Spots', 'DermSignal Skin Lightening Night Booster is enriched with Glycolic Acid, a powerful exfoliant that helps fade dark spots, even out skin tone, and promote a brighter, smoother complexion. Wake up to revitalized, glowing skin as it works overnight to reveal', 4, 3, 50, 15, 'prod-10-light-spot.png', 'prod-10-light-spot-hover.png'),
(11, 'Skin Lightening Toner', 475, 'Clarifying Formula | Evens Skin Tone', 'DermSignal Skin Lightening Toner combines the brightening power of Vitamin C with the exfoliating benefits of Glycolic Acid to gently cleanse, even out skin tone, and reduce the appearance of dark spots. Achieve a refreshed, radiant complexion with this d', 4, 5, 50, 10, 'prod-11-light-toner.png', 'prod-11-light-toner-hover.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ratings`
--

CREATE TABLE `tbl_ratings` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_receipt`
--

CREATE TABLE `tbl_receipt` (
  `receipt_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `receipt_img` varchar(255) NOT NULL,
  `receipt_number` varchar(50) NOT NULL,
  `deposit_amount` int(11) NOT NULL,
  `uploaded_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_receipt`
--

INSERT INTO `tbl_receipt` (`receipt_id`, `account_id`, `receipt_img`, `receipt_number`, `deposit_amount`, `uploaded_date`) VALUES
(1, 4, '6758ec27af450.jpeg', '2332323232176', 3000, '2024-12-11'),
(2, 4, '6758eedbb6917.jpeg', '2332323232176', 3000, '2024-12-11'),
(3, 4, '6758fd69d8467.jpeg', '2332323232176', 1760, '2024-12-11'),
(4, 4, '6758fddbd8a7a.jpeg', '2332323232176', 100, '2024-12-11'),
(5, 4, '675900317d407.jpeg', '2332323232176', 500, '2024-12-11'),
(6, 2, '6759025f2eada.jpeg', '2332323232171', 1760, '2024-12-11'),
(7, 2, '67590bc02f2ce.jpeg', '1222312311331', 3000, '2024-12-11'),
(8, 1, '675915a0ebd77.jpeg', '2332323232171', 1760, '2024-12-11'),
(9, 4, '675926d22d7ba.jpeg', '2332323232176', 1760, '2024-12-11'),
(10, 4, '67592719eaa62.jpeg', '2332323232176', 3000, '2024-12-11'),
(11, 4, '675927ffc19da.jpeg', '2332323232171', 3000, '2024-12-11'),
(12, 4, '67592a5c27ea4.jpeg', '2332323232176', 1760, '2024-12-11'),
(13, 2, '67595422b6619.jpeg', '2332323232171', 3000, '2024-12-11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role`
--

CREATE TABLE `tbl_role` (
  `role_Id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_role`
--

INSERT INTO `tbl_role` (`role_Id`, `role_name`) VALUES
(1, 'user'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status`
--

CREATE TABLE `tbl_status` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_status`
--

INSERT INTO `tbl_status` (`status_id`, `status_name`) VALUES
(1, 'PENDING'),
(2, 'DELIVERED'),
(3, 'PROCESS'),
(4, 'OUT FOR DELIVERY'),
(5, 'CANCELED'),
(6, 'RESERVE');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transactions`
--

CREATE TABLE `tbl_transactions` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `user_activity` varchar(100) NOT NULL,
  `activity_date` date NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_account`
--
ALTER TABLE `tbl_account`
  ADD PRIMARY KEY (`ac_id`);

--
-- Indexes for table `tbl_account_details`
--
ALTER TABLE `tbl_account_details`
  ADD PRIMARY KEY (`ac_id`);

--
-- Indexes for table `tbl_ac_status`
--
ALTER TABLE `tbl_ac_status`
  ADD PRIMARY KEY (`ac_status_id`);

--
-- Indexes for table `tbl_best_seller`
--
ALTER TABLE `tbl_best_seller`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `tbl_billing_details`
--
ALTER TABLE `tbl_billing_details`
  ADD PRIMARY KEY (`ac_details_id`);

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `tbl_concern`
--
ALTER TABLE `tbl_concern`
  ADD PRIMARY KEY (`concern_id`);

--
-- Indexes for table `tbl_contact_us`
--
ALTER TABLE `tbl_contact_us`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `tbl_delivery_type`
--
ALTER TABLE `tbl_delivery_type`
  ADD PRIMARY KEY (`delivery_type_id`);

--
-- Indexes for table `tbl_ingredients`
--
ALTER TABLE `tbl_ingredients`
  ADD PRIMARY KEY (`ingredients_id`);

--
-- Indexes for table `tbl_item_reviews`
--
ALTER TABLE `tbl_item_reviews`
  ADD PRIMARY KEY (`rv_id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `tbl_prod_bestseller`
--
ALTER TABLE `tbl_prod_bestseller`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `tbl_prod_newarrivals`
--
ALTER TABLE `tbl_prod_newarrivals`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `tbl_receipt`
--
ALTER TABLE `tbl_receipt`
  ADD PRIMARY KEY (`receipt_id`);

--
-- Indexes for table `tbl_role`
--
ALTER TABLE `tbl_role`
  ADD PRIMARY KEY (`role_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_account`
--
ALTER TABLE `tbl_account`
  MODIFY `ac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_account_details`
--
ALTER TABLE `tbl_account_details`
  MODIFY `ac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_ac_status`
--
ALTER TABLE `tbl_ac_status`
  MODIFY `ac_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_best_seller`
--
ALTER TABLE `tbl_best_seller`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_billing_details`
--
ALTER TABLE `tbl_billing_details`
  MODIFY `ac_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_concern`
--
ALTER TABLE `tbl_concern`
  MODIFY `concern_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_contact_us`
--
ALTER TABLE `tbl_contact_us`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_delivery_type`
--
ALTER TABLE `tbl_delivery_type`
  MODIFY `delivery_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_ingredients`
--
ALTER TABLE `tbl_ingredients`
  MODIFY `ingredients_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_item_reviews`
--
ALTER TABLE `tbl_item_reviews`
  MODIFY `rv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_prod_bestseller`
--
ALTER TABLE `tbl_prod_bestseller`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_prod_newarrivals`
--
ALTER TABLE `tbl_prod_newarrivals`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_receipt`
--
ALTER TABLE `tbl_receipt`
  MODIFY `receipt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_role`
--
ALTER TABLE `tbl_role`
  MODIFY `role_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  ADD CONSTRAINT `tbl_ratings_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `tbl_account` (`ac_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_ratings_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_products` (`prod_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
