-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 20 Sty 2023, 14:50
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `reservation_system`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reservations`
--

CREATE TABLE `reservations` (
  `id` int(10) UNSIGNED NOT NULL,
  `teacher` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `duration` smallint(5) UNSIGNED NOT NULL,
  `user` int(255) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `reservations`
--

INSERT INTO `reservations` (`id`, `teacher`, `date`, `time`, `duration`, `user`, `description`, `location`) VALUES
(11, 1, '2023-01-18', '10:30:00', 1800, NULL, ' askdhkashdkaskd', 'lok01'),
(12, 1, '2023-01-18', '12:35:00', 900, NULL, ' sdhakdsaksd', 'lok01'),
(13, 1, '2023-01-17', '14:53:00', 1800, 5, ' aaf', 'lok02'),
(14, 2, '2023-01-16', '15:15:00', 1800, 4, ' cdxd', 'lok03'),
(15, 2, '2023-01-18', '13:15:00', 1800, NULL, ' fhcth', 'lok01'),
(16, 2, '2023-01-10', '15:10:00', 900, NULL, NULL, 'lok03'),
(19, 1, '2023-01-19', '12:00:00', 900, NULL, NULL, 'dhf'),
(20, 1, '2023-01-17', '17:03:00', 1800, 4, ' ', 'dsgdgrs'),
(21, 1, '2023-01-09', '15:06:00', 900, NULL, ' c', 'ds'),
(24, 1, '2023-01-20', '15:17:00', 900, NULL, NULL, 'dgs'),
(25, 1, '2023-01-18', '15:21:00', 900, NULL, ' fftuy', 'gdgg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `teachers_list`
--

CREATE TABLE `teachers_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(256) NOT NULL,
  `prefix` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `teachers_list`
--

INSERT INTO `teachers_list` (`id`, `name`, `email`, `prefix`) VALUES
(1, 'teacher1', 't1@mail.com', 't1'),
(2, 'teacher2', 't2@mail.com', 't2'),
(3, 'teacher3', 't3@mail.com', 't3');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `teacherID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `teacherID`) VALUES
(4, 'tUser@gmail.com', '$2y$10$h90JRdlUo3Qyz2RTTDBwIuB9G81OqsKfF2A/aPCYN9wt2Y0fMrWEC', 'testUser', NULL),
(5, 'teacher1@gmail.com', '$2y$10$nEsoh7GcxiJnJzEvyw.xXOpecBCEiBMAv6AZPlD.ijUbO2Vaduy8K', 'teacher1', 1),
(6, 'teacher2@gmail.com', '$2y$10$nyqd0FkSwxxSdHFx7kYkP.hdtXFwrX3CNTkDNchLxLCJKOD3r.Go.', 'teacher2', 2);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher` (`teacher`);

--
-- Indeksy dla tabeli `teachers_list`
--
ALTER TABLE `teachers_list`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT dla tabeli `teachers_list`
--
ALTER TABLE `teachers_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`teacher`) REFERENCES `teachers_list` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
