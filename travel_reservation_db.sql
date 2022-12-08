-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 08, 2022 at 04:05 AM
-- Server version: 10.5.16-MariaDB
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id19938515_travel_reservation_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blog_id` int(10) NOT NULL,
  `images` varchar(100) NOT NULL,
  `blog_title` varchar(100) NOT NULL,
  `blog_description` varchar(1000) NOT NULL,
  `publisher` varchar(100) NOT NULL,
  `date_published` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`blog_id`, `images`, `blog_title`, `blog_description`, `publisher`, `date_published`) VALUES
(21, 'images/2022cb.png', 'Highlights of Cebu Tour 4D/3N', 'Our team picks you up in the morning in the hotel lobby, and then we will get to know the municipality of Cordova. We will plant some propagules in the Mangrove Forest and then head to the pier in Cordova. From there, you will set sail in a typical Philippine Bangka. There are great snorkeling opportunities and of course, a sumptuous Filipino lunch is also included!\r\n\r\n(Stay at the Costabella Tropical Beach Hotel in the Superior Room incl. breakfast)', 'James Miller', '2022-12-04'),
(22, 'images/2022my.png', 'Mayon Volcano, Albay', 'Probably one of the moat unforgettable travel experience. There\'s a lot to discover in Bicol more that just the majestic Mayon which in itself a great attraction. Very nice and well-organized tour and we highly recommend of you want to have a perfect nature adventure. To the tour operator ZCHEDULISTA, thank you for organizing our Bicol tour and making it memorable.', 'Wednesday Addams', '2022-10-05');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `place` varchar(100) NOT NULL,
  `rate` varchar(10) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `descriptions` varchar(1000) NOT NULL,
  `charge` varchar(100) NOT NULL,
  `schedule_date` varchar(100) NOT NULL,
  `discount` varchar(100) NOT NULL DEFAULT '0',
  `is_package` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_id`, `title`, `place`, `rate`, `amount`, `picture`, `link`, `descriptions`, `charge`, `schedule_date`, `discount`, `is_package`) VALUES
(55, 'Mayon Volcano, Albay', 'Bicol', '10', '2450', 'images/2022my.png', 'https://www.youtube.com/embed/DBFmCgFuBCk', 'One of the top natural landmarks in the Philippines and one of the most-visited tourist spots in Albay, it is already a wonderful experience seeing the volcano from afar. But if you are an adrenaline junkie, you can soak up all its beauty while gliding through a zipline in Lignon Hill or going on a Mayon Volcano tour via a Mayon ATV ride in Bicol. Visit the Cagsawa Ruins for another unique and historic viewing point of the Mayon Volcano.', '100', '2022-12-22', 'None', 0),
(56, 'Coron Ultimate Island Day Tour', 'Coron, Palawan', '9', '4430', 'images/2022s9lpttmqcffplez8zjiy.webp', 'https://youtu.be/SkDGDxuUGjE', 'Itinerary\r\nActivity Schedule\r\nThis tour is available on\r\nMonday-Sunday\r\nItinerary\r\nTour stops and highlights: Kayangan Lake, Twin Lagoon, Atwayan Beach, Skeleton Wreck, CYC Beach, and Coral Garden\r\nItinerary Reminder\r\nThe schedule is subject to change depending on traffic and weather conditions on your activity date\r\n', '300', '2022-12-12', '2', 1),
(57, 'Aloha Boracay Hotel 3D2N Staycation with Island Hopping & Transfers', 'Boracay Island, Aklan', '8.9', '6889', 'images/2022ceac1m872lkf2dmglktb.webp', 'https://youtu.be/61QuUPnxZuU', 'Day 1: Arrival/Check-In/Free Time\r\nArrive at Caticlan Airport\r\nMeet Southwest respresentative\r\nOvernight stay at Aloha Boracay Hotel\r\nDay 2: Island Hopping Tour\r\nBreakfast at the hotel\r\nMeeting place: Astoria Hotel beach front at 8:30am\r\nTour highlights (duration: 4-5 hours): Boracay Island Point to Point tour, Puka Beach (weather dependent), Balinghai Beach, Coral Garden, Snorkeling Gear, Crystal Cove (weather dependent), Buffet lunch at Picnic Area, Kawa Bath photo op\r\nAfter the tour, guests will be transfered back to the hotel\r\nOvernight stay at Aloha Boracay Hotel\r\nDay 3: Free Time/Hotel Check Out\r\nAfter breakfast, enjoy free time until check out from the hotel\r\nTransfer our to Caticlan Airport', '200', '2022-12-19', '2', 1),
(58, 'Sky Ranch Tagaytay Ride-All-You-Can Day Pass', 'Tagaytay, Cavite', '9.1', '400', 'images/2022sk.png', 'https://www.youtube.com/embed/9dcLUL66S_Y', 'Escape the metropolitan heat with a family trip to Sky Ranch Tagaytay! Spend a day riding all 14 of their attractions with the Ride-All-You-Can day pass, available through Klook. The amusement park and favorite leisure spot in Tagaytay span 5-hectares and home to several attractions fit for kids and kids-at-heart. Adults will have the time of their life at Sky Ranch’s thrill rides like the Drop Tower, Super Viking, and Log Coaster. Kids will also love their adorable attractions, including the Toy Swing, Baby Bumper, and Fun Bike. Of course, a visit to Sky Ranch Tagaytay will not be complete without trying their horseback riding and famous Sky Eye.', '100', '2022-12-04', 'None', 0),
(59, '3D2N El Nido Palawan Package | South Anchorage Inn with Daily Breakfast', 'El Nido, Palawan', '8.7', '3450', 'images/2022el.png', 'https://www.youtube.com/embed/4ZI5DZBrWog', 'Have a quick getaway in El Nido, Palawan with this 3-day, 2-night tour package. This vacation package is great for those searching for convenience and accessibility to attractions, as it includes accommodations at the South Anchorage Inn with daily breakfast, complimentary Wi-Fi and use of the amenities and services.', '100', '2022-12-09', '0', 1),
(60, '3D2N Bohol Budget Tour Package | Resort Stay + Add-on Tours + Transfer3D2N Bohol Budget Tour', 'Bohol, Visayas', '8', '5738', 'images/2022bh.png', 'https://www.youtube.com/embed/3ul2vFVOweQhttps://www.youtube.com/embed/3ul2vFVOweQ', 'Fly to Bohol and enjoy a quick vacation with this 3 days and 2 nights holiday package. This is perfect for those who want to go on a short trip to the island hassle-free, as it already comes with a 2-night stay at a budget resort in Panglao, roundtrip transfers from and to Bohol Airport, and daily breakfast.Fly to Bohol and enjoy a quick vacation with this 3 days and 2 nights holiday package. This is perfect for those who want to go on a short trip to the island hassle-free, as it already comes with a 2-night stay at a budget resort in Panglao, roundtrip transfers from and to Bohol Airport, and daily breakfast.', '200', '2022-12-16', '0', 1),
(61, 'Batanes Sabtang Island Private Day Tour with Lunch & Transfers', 'Batanes Island', '9', '4000', 'images/2022bt.png', 'https://www.youtube.com/embed/329nSGO1a9E', 'Explore the idyllic Sabtang Island in Batanes when you book this day tour. This trip is perfect for first-time visitors as it will show you there is more to Batanes than its main island. This tour includes private transfers, DOT-accredited tour guide, complimentary lunch, environmental and registration fees, and pick-up and drop-off from within Basco town proper and Chanarian. Explore the idyllic Sabtang Island in Batanes when you book this day tour. This trip is perfect for first-time visitors as it will show you there is more to Batanes than its main island. This tour includes private transfers, DOT-accredited tour guide, complimentary lunch, environmental and registration fees, and pick-up and drop-off from within Basco town proper and Chanarian. ', '100', '2022-12-10', '0', 0),
(62, 'Highlights of Cebu Tour 4D/3N', 'Cebu City', '9.1', '7590', 'images/2022cb.png', 'https://www.youtube.com/embed/gcEc0qS2pxs', 'Start and end in Cebu City! With the In-depth Cultural tour Highlights of Cebu Tour 4D/3N, you have a 4 days tour package taking you through Cebu City, Philippines. Highlights of Cebu Tour 4D/3N includes accommodation in a hotel as well as an expert guide, insurance, meals and more.', '200', '2022-12-22', '3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `is_admin` smallint(1) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `is_admin`, `fullname`, `email`) VALUES
(1, '5bNGAOA=', '5bNGAOAYRiA=', 1, 'FernandoJose', ''),
(2, '8aROGw==', '8aROG78bRw==', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `reservationlist`
--

CREATE TABLE `reservationlist` (
  `reservation_id` int(10) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `person` varchar(100) NOT NULL,
  `acco` varchar(100) NOT NULL,
  `place` varchar(100) NOT NULL,
  `charged` varchar(100) NOT NULL,
  `totals` varchar(100) NOT NULL,
  `discount_amount` varchar(100) NOT NULL,
  `is_cancel` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservationlist`
--

INSERT INTO `reservationlist` (`reservation_id`, `fullname`, `email`, `phone`, `person`, `acco`, `place`, `charged`, `totals`, `discount_amount`, `is_cancel`) VALUES
(202, '4rJZB+9HEHyqBp2Z', '5RlCAYWCJ04GReCjV7UHXVaPolOCwMOogcXmbOfpdWQ=', 'vXyJOJd+mOwTyqF3q+ZZvw==', '3', 'yes', 'Coron, Palawan', '300', '13590', '271.8', 0),
(203, '475HC+tbAA==', 'vy7jfXbs9+/kYogmUlUz/h3I7Ql7OXCU5UC42iWguq8=', 'c9iTVV4/NbT44VuNJKk/Zw==', '2', 'yes', 'Coron, Palawan', '300', '9160', '183.20000000000002', 0),
(204, 'z79SG+8=', '9P0CXi9oA/TCtSgj5Fg64DTHqjCSXlJs0NNva+KaswA=', 'YooE7INblD0ACKW98u3/+A==', '10', 'yes', 'Boracay Island, Aklan', '200', '69090', '1381.8', 1),
(205, 'w75HC+tbAA==', 'Z5jUXD9NXICKecOfDPz5Y15iz02ybe2B5Dc/RVAyf5Y=', 'pK2NL3BDs2Q+5wJHU0J+iw==', '2', 'yes', 'Coron, Palawan', '300', '9160', '183.20000000000002', 1),
(206, '9aBOG/pQAQ==', 'UMiqlhjlGdgMBMD7iPStWQ==', 'MH1md8gvoFwGXC1srcMK4Q==', '3', 'yes', 'Tagaytay, Cavite', '100', '1300', '0', 1),
(207, '9aBaHv9e', 'CeSsht9mdQcvoBzPgNm66Q==', 'qfGkTSDguA03cQh5VPu4hg==', '2', 'yes', 'Bicol', '100', '5000', '0', 1),
(208, '9aBaHv9e', 'Db67tA0RYwLlpTjnC0pSXg==', 'qfGkTSDguA03cQh5VPu4hg==', '3', 'yes', 'Coron, Palawan', '300', '13590', '271.8', 1),
(209, '9aBOG/pQAXqw', '5RlCAYWCJ04GReCjV7UHXVaPolOCwMOogcXmbOfpdWQ=', 'vXyJOJd+mOwTyqF3q+ZZvw==', '3', 'yes', 'Coron, Palawan', '300', '13590', '13318.2', 1),
(210, '4rJZB+9HEHzgI4GPS3nYo8lDiSWMlQ==', 'GsOk+RQJS8nESuPmVg3KjNE0ammD8ij4mnjJO8+7Uq8=', 'VLCDUdUALhVtQPtP+BflDw==', '3', 'yes', 'Bicol', '100', '7450', '0', 1),
(211, '4rJZB+9HEHzgJQ==', 'CI1Y8GFw3QkHxs4Z7GUXgw==', 'ikhH1qPKzNb0VjMqbBrarQ==', '3', 'yes', 'Bicol', '100', '7450', '0', 1),
(212, '4rJZB+9HEHzgA4GPSw==', '5RlCAYWCJ04GReCjV7UHXVaPolOCwMOogcXmbOfpdWQ=', 'ikhH1qPKzNb0VjMqbBrarQ==', '2', 'yes', 'Cebu City', '200', '15380', '14918.6', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservationlist`
--
ALTER TABLE `reservationlist`
  ADD PRIMARY KEY (`reservation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blog_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reservationlist`
--
ALTER TABLE `reservationlist`
  MODIFY `reservation_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=213;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
