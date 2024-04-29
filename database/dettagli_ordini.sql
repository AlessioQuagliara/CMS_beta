-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Creato il: Apr 29, 2024 alle 22:06
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
-- Struttura della tabella `dettagli_ordini`
--

CREATE TABLE `dettagli_ordini` (
  `id_dettaglio` int(11) NOT NULL,
  `id_ordine` varchar(255) NOT NULL,
  `id_prodotto` varchar(255) NOT NULL,
  `quantita` varchar(255) NOT NULL,
  `prezzo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `dettagli_ordini`
--

INSERT INTO `dettagli_ordini` (`id_dettaglio`, `id_ordine`, `id_prodotto`, `quantita`, `prezzo`) VALUES
(1, '5', '1', '1', '12');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `dettagli_ordini`
--
ALTER TABLE `dettagli_ordini`
  ADD PRIMARY KEY (`id_dettaglio`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `dettagli_ordini`
--
ALTER TABLE `dettagli_ordini`
  MODIFY `id_dettaglio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
