-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 17, 2017 at 07:09 PM
-- Server version: 10.1.20-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id559194_todo_task`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `oauth_provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `oauth_uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_no` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `picture_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `oauth_provider`, `oauth_uid`, `first_name`, `last_name`, `email`, `phone_no`, `gender`, `locale`, `picture_url`, `profile_url`, `created`, `modified`) VALUES
(1, 'facebook', '1322862497752343', 'Surya', 'Kumar', 'suryaakumarrsc@gmail.com', NULL, 'female', 'en_US', 'https://scontent.xx.fbcdn.net/v/t1.0-1/p50x50/15578565_1294449953926931_5059806156410377839_n.jpg?oh=f71fda97b1ba23be12538308d96da021&oe=58DD3127', 'https://www.facebook.com/1322862497752343', 1484679990, 1484679990);

-- --------------------------------------------------------

--
-- Table structure for table `user_todo_tasks`
--

CREATE TABLE `user_todo_tasks` (
  `todo_task_id` int(11) NOT NULL,
  `todo_task_user_id` int(11) NOT NULL,
  `todo_task_name` varchar(255) NOT NULL,
  `todo_task_added` int(11) NOT NULL DEFAULT '0',
  `todo_task_completed` int(11) NOT NULL DEFAULT '0',
  `todo_task_deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_todo_tasks`
--

INSERT INTO `user_todo_tasks` (`todo_task_id`, `todo_task_user_id`, `todo_task_name`, `todo_task_added`, `todo_task_completed`, `todo_task_deleted`) VALUES
(1, 1, 'Banana', 1484680148, 0, 0),
(2, 1, 'Apple', 1484680154, 0, 0),
(3, 1, 'Orange', 1484680164, 1484680173, 0),
(4, 1, 'Grapes', 1484680171, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_uid` (`oauth_uid`) USING BTREE,
  ADD KEY `oauth_info` (`oauth_provider`,`oauth_uid`);

--
-- Indexes for table `user_todo_tasks`
--
ALTER TABLE `user_todo_tasks`
  ADD PRIMARY KEY (`todo_task_id`),
  ADD KEY `user_id` (`todo_task_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_todo_tasks`
--
ALTER TABLE `user_todo_tasks`
  MODIFY `todo_task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
