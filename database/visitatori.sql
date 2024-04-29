-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Creato il: Apr 29, 2024 alle 22:07
-- Versione del server: 5.7.39
-- Versione PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `CMS`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `visitatori`
--

CREATE TABLE `visitatori` (
  `id` int(11) NOT NULL,
  `id_visitatore` varchar(255) NOT NULL,
  `data_visita` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `visitatori`
--

INSERT INTO `visitatori` (`id`, `id_visitatore`, `data_visita`) VALUES
(1, 'visitatore_660fd7fdc93d0', '2024-04-05 11:19:12'),
(2, 'visitatore_660ff5dc52a30', '2024-04-05 13:01:40'),
(3, 'visitatore_66101af061abf', '2024-04-05 15:42:07'),
(4, 'visitatore_66125b876a1fc', '2024-04-07 09:35:20'),
(5, 'visitatore_661ba21b1204b', '2024-04-14 09:47:53'),
(6, 'visitatore_661d0df06e890', '2024-04-15 11:23:05'),
(7, 'visitatore_662162c74b5b0', '2024-04-18 18:13:27'),
(8, 'visitatore_66216e2eab252', '2024-04-18 19:25:46'),
(9, 'visitatore_6627e67092af1', '2024-04-23 17:05:06');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `visitatori`
--
ALTER TABLE `visitatori`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `visitatori`
--
ALTER TABLE `visitatori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
