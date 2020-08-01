-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Авг 01 2020 г., 21:27
-- Версия сервера: 5.6.47
-- Версия PHP: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `vk_monitor`
--

-- --------------------------------------------------------

--
-- Структура таблицы `curent_states`
--

CREATE TABLE `curent_states` (
  `id` int(11) NOT NULL,
  `post_url` varchar(64) NOT NULL,
  `update_interval` int(11) NOT NULL DEFAULT '30',
  `datetime_url_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `datetime_mon_last_update` datetime DEFAULT NULL,
  `memory_used` varchar(32) DEFAULT NULL COMMENT 'Сколько памяти съел скрипт',
  `current_iteration` varchar(32) NOT NULL DEFAULT '0' COMMENT 'Сколько раз уже сканировал'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `curent_states`
--

INSERT INTO `curent_states` (`id`, `post_url`, `update_interval`, `datetime_url_add`, `datetime_mon_last_update`, `memory_used`, `current_iteration`) VALUES
(17, 'https://vk.com/wall-193812347_92', 30, '2020-08-01 20:17:27', NULL, NULL, '0'),
(19, 'https://vk.com/wall-193812347_9282', 30, '2020-08-01 20:35:32', '2020-08-01 21:26:20', '1.08Mb', '12');

-- --------------------------------------------------------

--
-- Структура таблицы `mon_results`
--

CREATE TABLE `mon_results` (
  `id` int(32) NOT NULL,
  `post_url` varchar(64) NOT NULL,
  `iteration` int(32) DEFAULT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `count_likes` int(32) NOT NULL,
  `count_views` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mon_results`
--

INSERT INTO `mon_results` (`id`, `post_url`, `iteration`, `datetime`, `count_likes`, `count_views`) VALUES
(21, 'https://vk.com/wall-193812347_9282', 11, '2020-08-01 21:26:20', 40, 212);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `curent_states`
--
ALTER TABLE `curent_states`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_url` (`post_url`);

--
-- Индексы таблицы `mon_results`
--
ALTER TABLE `mon_results`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `curent_states`
--
ALTER TABLE `curent_states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `mon_results`
--
ALTER TABLE `mon_results`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
