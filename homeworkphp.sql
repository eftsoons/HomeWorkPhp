-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-8.2
-- Время создания: Июн 13 2025 г., 20:10
-- Версия сервера: 8.2.0
-- Версия PHP: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `homeworkphp`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bank`
--

CREATE TABLE `bank` (
  `idbank` int NOT NULL,
  `namebank` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `adressbank` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `bank`
--

INSERT INTO `bank` (`idbank`, `namebank`, `adressbank`) VALUES
(1, 'Сбербанк', 'ул. Брамса'),
(2, 'Тбанк', 'ул. Тинькофф'),
(3, 'ВТБ', 'ул. Мухосранск'),
(4, 'Альфа-банк', 'Пусто123');

-- --------------------------------------------------------

--
-- Структура таблицы `bankomat`
--

CREATE TABLE `bankomat` (
  `idbankomat` int NOT NULL,
  `codebank` int NOT NULL,
  `adressbankomat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `bankomat`
--

INSERT INTO `bankomat` (`idbankomat`, `codebank`, `adressbankomat`) VALUES
(2, 2, 'ул. Какая'),
(3, 1, 'Москва123123'),
(4, 3, 'Кремль'),
(5, 1, 'ул. Садовая'),
(6, 1, 'ул. Машиностроительная'),
(7, 2, 'ул. Площадь революции'),
(8, 2, 'ул. Театральная'),
(9, 3, 'ул. Путина'),
(10, 3, 'ул. Ворам123'),
(19, 4, 'Пусто'),
(20, 4, 'Пусто2123123');

-- --------------------------------------------------------

--
-- Структура таблицы `client`
--

CREATE TABLE `client` (
  `id` int NOT NULL,
  `fullname` text NOT NULL,
  `adress` text NOT NULL,
  `codebank` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `client`
--

INSERT INTO `client` (`id`, `fullname`, `adress`, `codebank`) VALUES
(1, 'Федорович А.А.', 'ул. Какая?', 1),
(2, 'Беспрозванных А.', 'Москва', 2),
(3, 'Путин В.В.', 'Кремль', 3),
(8, 'Тест Тестович Тестовичей', 'Пусто', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `operation`
--

CREATE TABLE `operation` (
  `clientid` int NOT NULL,
  `bankomatid` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comission` tinyint(1) NOT NULL DEFAULT '0',
  `sum` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `operation`
--

INSERT INTO `operation` (`clientid`, `bankomatid`, `date`, `comission`, `sum`) VALUES
(3, 9, '2025-06-12 01:26:08', 0, 2147483647),
(3, 4, '2025-06-12 01:28:22', 0, 345),
(1, 2, '2025-06-12 01:28:50', 0, 34345),
(2, 7, '2025-06-12 01:28:54', 0, 123123),
(1, 2, '2025-06-12 01:30:33', 1, 3434),
(3, 10, '2025-06-12 01:31:28', 0, 123123123),
(3, 9, '2025-06-12 01:31:47', 0, 1231231231),
(3, 10, '2025-06-12 01:31:56', 1, 123123123),
(3, 9, '2025-06-12 01:34:43', 0, 2147483647),
(3, 10, '2025-06-12 01:34:57', 1, 2147483647),
(1, 2, '2025-06-13 12:25:56', 1, 123),
(1, 2, '2025-06-13 12:26:03', 0, 321),
(1, 2, '2025-06-13 12:30:13', 0, 123123),
(1, 3, '2025-06-13 17:01:55', 0, 123),
(1, 3, '2025-06-13 17:03:06', 0, 123),
(8, 20, '2025-06-13 17:09:18', 0, 123);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` text NOT NULL,
  `password` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`) VALUES
(6, 'root', 'asd'),
(7, 'root2', 'root');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`idbank`),
  ADD UNIQUE KEY `id` (`idbank`),
  ADD KEY `id_2` (`idbank`);

--
-- Индексы таблицы `bankomat`
--
ALTER TABLE `bankomat`
  ADD PRIMARY KEY (`idbankomat`),
  ADD UNIQUE KEY `id` (`idbankomat`),
  ADD KEY `codebank` (`codebank`);

--
-- Индексы таблицы `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codebank_client` (`codebank`);

--
-- Индексы таблицы `operation`
--
ALTER TABLE `operation`
  ADD KEY `clientid` (`clientid`),
  ADD KEY `bankomatid` (`bankomatid`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bank`
--
ALTER TABLE `bank`
  MODIFY `idbank` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `bankomat`
--
ALTER TABLE `bankomat`
  MODIFY `idbankomat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `client`
--
ALTER TABLE `client`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bankomat`
--
ALTER TABLE `bankomat`
  ADD CONSTRAINT `codebank_bankomat` FOREIGN KEY (`codebank`) REFERENCES `bank` (`idbank`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `codebank_client` FOREIGN KEY (`codebank`) REFERENCES `bank` (`idbank`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `operation`
--
ALTER TABLE `operation`
  ADD CONSTRAINT `bankomatid` FOREIGN KEY (`bankomatid`) REFERENCES `bankomat` (`idbankomat`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `clientid` FOREIGN KEY (`clientid`) REFERENCES `client` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
