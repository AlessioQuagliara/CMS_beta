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
-- Struttura della tabella `ordini`
--

CREATE TABLE `ordini` (
  `id_ordine` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `data_ordine` varchar(255) NOT NULL,
  `stato_ordine` varchar(255) NOT NULL,
  `totale_ordine` varchar(255) NOT NULL,
  `indirizzo_spedizione` varchar(255) NOT NULL,
  `paese` varchar(255) NOT NULL,
  `cap` varchar(255) NOT NULL,
  `citta` varchar(255) NOT NULL,
  `provincia` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `tipo_spedizione` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `ordini`
--

INSERT INTO `ordini` (`id_ordine`, `email`, `data_ordine`, `stato_ordine`, `totale_ordine`, `indirizzo_spedizione`, `paese`, `cap`, `citta`, `provincia`, `telefono`, `nome`, `cognome`, `tipo_spedizione`) VALUES
(1, 'scrivi@laemail.it', 'inserisci la data', 'Completo', '0', 'Inserisci la via', 'Inserisci il paese', 'inserisci il cap', 'Inserisci la città', 'Inserisci la provincia', 'Inserisci il telefono', 'Inserisci il nome', 'inserisci il cognome', 'Inserisci la spedizione'),
(2, 'scrivi@laemail.it', 'inserisci la data', 'Abbandonato', '0', 'Inserisci la via', 'Inserisci il paese', 'inserisci il cap', 'Inserisci la città', 'Inserisci la provincia', 'Inserisci il telefono', 'Inserisci il nome', 'inserisci il cognome', 'Inserisci la spedizione'),
(3, 'scrivi@laemail.it', 'inserisci la data', 'Abbandonato', '0', 'Inserisci la via', 'Inserisci il paese', 'inserisci il cap', 'Inserisci la città', 'Inserisci la provincia', 'Inserisci il telefono', 'Inserisci il nome', 'inserisci il cognome', 'Inserisci la spedizione'),
(4, 'scrivi@laemail.it', 'inserisci la data', 'Abbandonato', '0', 'Inserisci la via', 'Inserisci il paese', 'inserisci il cap', 'Inserisci la città', 'Inserisci la provincia', 'Inserisci il telefono', 'Inserisci il nome', 'inserisci il cognome', 'Inserisci la spedizione'),
(5, 'quagliara.alessio@gmail.com', '2024-04-23 19:05:13', 'Abbandonato', '12', 'Via dei gelsi, 3', 'Italia', '22020', 'Faloppio', 'CO', '3408213326', 'Alessio', 'Quagliara', 'Scegli Modalità'),
(6, 'scrivi@laemail.it', 'inserisci la data', 'inevaso', '0', 'Inserisci la via', 'Inserisci il paese', 'inserisci il cap', 'Inserisci la città', 'Inserisci la provincia', 'Inserisci il telefono', 'Inserisci il nome', 'inserisci il cognome', 'Inserisci la spedizione');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `ordini`
--
ALTER TABLE `ordini`
  ADD PRIMARY KEY (`id_ordine`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `ordini`
--
ALTER TABLE `ordini`
  MODIFY `id_ordine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
