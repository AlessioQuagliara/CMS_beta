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
-- Struttura della tabella `dettagli_negozio`
--

CREATE TABLE `dettagli_negozio` (
  `identificatore` int(11) NOT NULL,
  `imprenditore` varchar(255) NOT NULL,
  `impresa` varchar(255) NOT NULL,
  `CF_fiscale` varchar(255) NOT NULL,
  `IVA` varchar(255) NOT NULL,
  `REA` varchar(255) NOT NULL,
  `via` varchar(255) NOT NULL,
  `paese` varchar(255) NOT NULL,
  `cap` varchar(255) NOT NULL,
  `email_impresa` varchar(255) NOT NULL,
  `pec` varchar(255) NOT NULL,
  `telefono_impresa` varchar(255) NOT NULL,
  `capitale_sociale` varchar(255) NOT NULL,
  `sitoweb` varchar(255) NOT NULL,
  `nome_negozio` varchar(255) NOT NULL,
  `cosa_vuoi_vendere` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `dettagli_negozio`
--

INSERT INTO `dettagli_negozio` (`identificatore`, `imprenditore`, `impresa`, `CF_fiscale`, `IVA`, `REA`, `via`, `paese`, `cap`, `email_impresa`, `pec`, `telefono_impresa`, `capitale_sociale`, `sitoweb`, `nome_negozio`, `cosa_vuoi_vendere`) VALUES
(1, 'Alessio Ciao', 'Alessio Quagliara', '', '', '', 'Via dei gelsi, 3', '', '22020', 'quagliara.alessio@gmail.com', '', '3408213326', '', '', '', '');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `dettagli_negozio`
--
ALTER TABLE `dettagli_negozio`
  ADD PRIMARY KEY (`identificatore`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `dettagli_negozio`
--
ALTER TABLE `dettagli_negozio`
  MODIFY `identificatore` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
