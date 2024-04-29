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
-- Struttura della tabella `spedizioni`
--

CREATE TABLE `spedizioni` (
  `id_spedizione` int(11) NOT NULL,
  `tipo_spedizione` varchar(255) NOT NULL,
  `prezzo_spedizione` varchar(255) NOT NULL,
  `peso_spedizione` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `spedizioni`
--

INSERT INTO `spedizioni` (`id_spedizione`, `tipo_spedizione`, `prezzo_spedizione`, `peso_spedizione`) VALUES
(1, 'Scegli Modalità', '45', '1');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `spedizioni`
--
ALTER TABLE `spedizioni`
  ADD PRIMARY KEY (`id_spedizione`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `spedizioni`
--
ALTER TABLE `spedizioni`
  MODIFY `id_spedizione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
