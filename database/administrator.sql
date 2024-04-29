-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Creato il: Apr 29, 2024 alle 22:03
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
-- Struttura della tabella `administrator`
--

CREATE TABLE `administrator` (
  `id_admin` int(11) NOT NULL,
  `nome` varchar(255) COLLATE utf8_bin NOT NULL,
  `cognome` varchar(255) COLLATE utf8_bin NOT NULL,
  `ruolo` varchar(255) COLLATE utf8_bin NOT NULL,
  `telefono` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(250) COLLATE utf8_bin NOT NULL,
  `password` varchar(250) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `administrator`
--

INSERT INTO `administrator` (`id_admin`, `nome`, `cognome`, `ruolo`, `telefono`, `email`, `password`) VALUES
(7, 'Juan', 'Romero', 'Amministratore', '3899657115', 'juan.romero@spotexsrl.it', '$2y$10$iqtsvkECdJYkrWl/8wMvwuNcsl9QWeCmIi6HSN49eN8cp1mHSapSW'),
(8, 'Gaia', 'Masia', 'Designer', '3899657115', 'gaia.masia@spotexsrl.it', '$2y$10$icM9YX93YJeHVzkQmvKkcuFqvZNR0nuKfxPCfb7QkwevyGM1iwL0a'),
(11, 'Alessio', 'Quagliara', 'Developer', '3899657115', 'alessio.quagliara@spotexsrl.it', '$2y$10$RLqxrn4t9QDCDCXfjyMabeZ1jtRORL0xEaYvHbaZwe6wMgJezrxGy');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id_admin`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
