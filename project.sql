-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-11-18 13:04:38
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `project`
--

-- --------------------------------------------------------

--
-- 資料表結構 `device_usage`
--

CREATE TABLE `device_usage` (
  `user_id` int(11) NOT NULL,
  `appliance_change` int(11) DEFAULT 0,
  `drawing_gesture_count` int(11) DEFAULT 0,
  `volume_increase_gesture_count` int(11) DEFAULT 0,
  `volume_decrease_gesture_count` int(11) DEFAULT 0,
  `next_music_gesture_count` int(11) DEFAULT 0,
  `previous_music_gesture_count` int(11) DEFAULT 0,
  `scroll_up_gesture_count` int(11) DEFAULT 0,
  `scroll_down_gesture_count` int(11) DEFAULT 0,
  `next_slide_gesture_count` int(11) DEFAULT 0,
  `previous_slide_gesture_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `device_usage`
--

INSERT INTO `device_usage` (`user_id`, `appliance_change`, `drawing_gesture_count`, `volume_increase_gesture_count`, `volume_decrease_gesture_count`, `next_music_gesture_count`, `previous_music_gesture_count`, `scroll_up_gesture_count`, `scroll_down_gesture_count`, `next_slide_gesture_count`, `previous_slide_gesture_count`) VALUES
(1, 3, 6, 1, 1, 0, 10, 4, 1, 0, 0),
(3, 1, 2, 1, 0, 1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `ir_codes`
--

CREATE TABLE `ir_codes` (
  `ir_code_id` int(11) NOT NULL,
  `address` varchar(5) NOT NULL,
  `ir_code_name` varchar(10) NOT NULL,
  `command` varchar(5) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `gesture` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `ir_codes`
--

INSERT INTO `ir_codes` (`ir_code_id`, `address`, `ir_code_name`, `command`, `user_id`, `gesture`) VALUES
(2, '48', '開關', '136', 1, 1),
(3, '48', '擺頭', '133', 1, 2);

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`) VALUES
(1, 'user1', '1234'),
(3, 'user2', '1234'),
(4, 'user3', '1234');

-- --------------------------------------------------------

--
-- 資料表結構 `user_activity`
--

CREATE TABLE `user_activity` (
  `user_id` int(11) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `activity_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `user_activity`
--

INSERT INTO `user_activity` (`user_id`, `activity`, `activity_time`) VALUES
(1, 'scroll_up_gesture_count', '2024-11-15 13:18:46'),
(1, 'scroll_up_gesture_count', '2024-11-15 13:19:45'),
(1, 'scroll_up_gesture_count', '2024-11-15 13:20:03'),
(1, 'scroll_down_gesture_count', '2024-11-15 13:20:29'),
(1, 'scroll_up_gesture_count', '2024-11-15 13:24:32'),
(1, 'scroll_up_gesture_count', '2024-11-15 13:24:36'),
(1, 'scroll_down_gesture_count', '2024-11-15 13:24:40'),
(1, 'scroll_up_gesture_count', '2024-11-15 13:24:45'),
(1, 'scroll_up_gesture_count', '2024-11-15 13:24:49'),
(1, 'scroll_up_gesture_count', '2024-11-15 13:25:08'),
(1, 'scroll_up_gesture_count', '2024-11-15 13:25:38'),
(1, 'drawing_gesture_count', '2024-11-18 14:31:41'),
(1, 'drawing_gesture_count', '2024-11-18 14:31:44'),
(1, 'drawing_gesture_count', '2024-11-18 14:33:05'),
(1, 'drawing_gesture_count', '2024-11-18 14:33:12'),
(1, 'drawing_gesture_count', '2024-11-18 14:33:22'),
(1, 'drawing_gesture_count', '2024-11-18 14:33:38'),
(1, 'volume_increase_gesture_count', '2024-11-18 14:37:03'),
(1, 'appliance_change', '2024-11-18 14:37:11'),
(1, 'previous_music_gesture_count', '2024-11-18 14:37:42'),
(1, 'previous_music_gesture_count', '2024-11-18 14:37:43'),
(1, 'appliance_change', '2024-11-18 14:38:00'),
(1, 'appliance_change', '2024-11-18 14:38:01'),
(1, 'previous_music_gesture_count', '2024-11-18 14:38:35'),
(1, 'previous_music_gesture_count', '2024-11-18 14:39:22'),
(1, 'previous_music_gesture_count', '2024-11-18 14:39:24'),
(1, 'previous_music_gesture_count', '2024-11-18 14:39:48'),
(1, 'previous_music_gesture_count', '2024-11-18 14:40:11'),
(1, 'previous_music_gesture_count', '2024-11-18 14:40:12'),
(1, 'previous_music_gesture_count', '2024-11-18 14:40:13'),
(1, 'scroll_up_gesture_count', '2024-11-18 14:41:18'),
(1, 'scroll_up_gesture_count', '2024-11-18 14:41:19'),
(1, 'previous_music_gesture_count', '2024-11-18 14:41:31'),
(1, 'volume_decrease_gesture_count', '2024-11-18 14:42:23'),
(1, 'scroll_up_gesture_count', '2024-11-18 14:42:42'),
(1, 'scroll_up_gesture_count', '2024-11-18 14:42:43'),
(1, 'scroll_down_gesture_count', '2024-11-18 14:43:06');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `device_usage`
--
ALTER TABLE `device_usage`
  ADD PRIMARY KEY (`user_id`);

--
-- 資料表索引 `ir_codes`
--
ALTER TABLE `ir_codes`
  ADD PRIMARY KEY (`ir_code_id`),
  ADD KEY `user_id` (`user_id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 資料表索引 `user_activity`
--
ALTER TABLE `user_activity`
  ADD PRIMARY KEY (`user_id`,`activity_time`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `ir_codes`
--
ALTER TABLE `ir_codes`
  MODIFY `ir_code_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user_activity`
--
ALTER TABLE `user_activity`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `device_usage`
--
ALTER TABLE `device_usage`
  ADD CONSTRAINT `device_usage_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `ir_codes`
--
ALTER TABLE `ir_codes`
  ADD CONSTRAINT `ir_codes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- 資料表的限制式 `user_activity`
--
ALTER TABLE `user_activity`
  ADD CONSTRAINT `user_activity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
