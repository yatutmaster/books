-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Май 09 2017 г., 14:14
-- Версия сервера: 10.1.13-MariaDB
-- Версия PHP: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mts`
--

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `access` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`id`, `id_user`, `access`) VALUES
(21, 1, 1),
(22, 1, 1),
(23, 1, 1),
(24, 1, 0),
(25, 1, 1),
(26, 1, 0),
(27, 20, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `id_owner` int(11) NOT NULL,
  `active_ver` int(11) DEFAULT '1',
  `year` int(11) NOT NULL,
  `book_name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `history`
--

INSERT INTO `history` (`id`, `id_book`, `id_owner`, `active_ver`, `year`, `book_name`, `image`, `author`, `date`) VALUES
(10, 21, 1, 1, 9879, 'mlkm', '1_590febe6afec2.jpg', 'wefwef', '2017-05-08 03:54:14'),
(11, 22, 1, 1, 3222, 'dlfvkm', '1_590ff83890f70.jpeg', 'wmoo', '2017-05-08 04:46:48'),
(12, 23, 1, 1, 3222, 'dlfvkm', '1_590ff856a7e94.jpeg', 'wmoo', '2017-05-08 04:47:18'),
(13, 24, 1, 0, 1212, 'dlfvkm', '1_590ff8c0c35fb.jpeg', 'wmoo', '2017-05-08 04:49:04'),
(14, 24, 1, 0, 3222, 'dlfvkm', '1_590ff8c0c35fb.jpeg', 'wmoo', '2017-05-08 04:49:04'),
(17, 24, 1, 0, 1111, 'dlfvkm', '1_5911322cda3ae.png', 'wmoo', '2017-05-09 03:06:20'),
(18, 24, 1, 1, 1111, 'Война и мир', '1_5911322cda3ae.png', 'wmoo', '2017-05-09 03:28:33'),
(19, 25, 1, 0, 2312, 'Книга', '1_591142acb4884.jpg', 'Нет автора', '2017-05-09 04:16:44'),
(20, 25, 1, 0, 2312, 'Книга', '1_591142cb20467.jpg', 'Нет автора', '2017-05-09 04:17:15'),
(21, 25, 1, 0, 2312, 'Книга', '1_591149ee62519.jpg', 'Нет автора', '2017-05-09 04:47:42'),
(22, 25, 1, 1, 2312, 'Книгаddd', '1_59119af929261.jpg', 'Нет автора', '2017-05-09 10:33:29'),
(23, 26, 1, 1, 1920, 'Сказки', '1_59119bbf0805e.jpg', 'А.С.Пушкин', '2017-05-09 10:36:47'),
(24, 27, 20, 0, 3333, 'Book1', '20_5911a4d4c3879.jpg', 'author no name', '2017-05-09 11:15:32'),
(25, 27, 20, 1, 3333, 'Book2', '20_5911a4d4c3879.jpg', 'author no name', '2017-05-09 11:15:48'),
(26, 27, 1, 0, 3333, 'Book4545', '1_5911a52ce4029.jpg', 'author no name', '2017-05-09 11:17:00');

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1494196543),
('m170507_114128_create_users_table', 1494198911),
('m170507_114156_create_books_table', 1494198911),
('m170507_114325_create_history_table', 1494198912);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fio` varchar(255) DEFAULT NULL,
  `accessToken` tinytext NOT NULL,
  `authKey` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fio`, `accessToken`, `authKey`) VALUES
(1, 'admin', '6feb38dee84537fc916817babc843967', 'Vasya Pupkin', '', ''),
(13, 'ebkmlekm', '44cfa38ec467227c0df8667d80b42751', 'амвам', '3a8e3d52429889c76e5422c767db7689', 'IJysDz6we7RMqAChC-1-VUPkiCqEphMf'),
(14, 'лдм', '9d292fdf6e2c7311efc0c11144e35adf', 'вам', '', 'zdPhB0XyLTc4cDAWilnYvmKgcqqDC2JH'),
(15, 'лдмукп', '378d6a4e0d99b7ee381739cff5e2d076', 'вам', '', 'I4nhnWlM16k_VYjUDY-Wx1Ri7FY2Hmuc'),
(16, 'мукму', 'ae0dfe5395832849abb1461f95051396', 'ывмывм', '', 'H14a2KwfbEq80odrDDjo0Uk2EXyEKofr'),
(17, 'мукмуwefw', '245e868b9329b5ff3a01256c32e35eb3', 'wef', '', '7M6tLFIdGiYkXzq_VpGj652hpcmSdhxD'),
(18, 'epro', '64ae8da64acc905c505bd50866790413', 'wefwef', '', 'HwrThoEvAtTEj2k8-FJ-_M5r9kY6xBRo'),
(20, 'user', '4fadce46b9101bf39a06e3fe82012976', 'user', '', 'rzQhM7QwcefxTOtSaIDzJatVRgvSll7Y');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-books-id_user` (`id_user`);

--
-- Индексы таблицы `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-history-id_owner` (`id_owner`),
  ADD KEY `idx-history-id_book` (`id_book`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT для таблицы `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk-books-id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `fk-history-id_book` FOREIGN KEY (`id_book`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-history-id_owner` FOREIGN KEY (`id_owner`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
