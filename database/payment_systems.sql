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
-- Struttura della tabella `payment_systems`
--

CREATE TABLE `payment_systems` (
  `id_pay` int(11) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `secret_key` varchar(255) NOT NULL,
  `environment` enum('sandbox','production') NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `payment_systems`
--

INSERT INTO `payment_systems` (`id_pay`, `provider`, `client_id`, `secret_key`, `environment`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Stripe', 'inserisci il client ID', 'Secret key', 'production', 'inactive', '2024-03-19 20:51:10', '2024-03-22 21:42:29'),
(2, 'PayPal', 'Abo5G5DRkD7KFaElbymGulNpmTptnaFiBTTDri5R8RD1fmGIY3LFCv-jJS1G_ywCJXpa6HgFvFi3cm3r', 'ENChtxqVncwphEj3tTcqIAiEXiKN7al-qS2_1F-Amorqp52ATitZ985d6Vx0f8l7kod526jjL21CnmQd', 'production', 'active', '2024-03-19 21:06:19', '2024-03-25 17:53:37'),
(3, 'Bonifico', 'SPINAUDIO DI LIOTTA STEFANIA', 'IT45G0760110900001065369744', 'production', 'active', '2024-03-19 21:06:32', '2024-03-22 21:45:15'),
(4, 'Pagolight', 'inserisci il client ID', 'Inserisci la secret key', 'production', 'inactive', '2024-03-19 21:06:32', '2024-03-19 22:40:47');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `payment_systems`
--
ALTER TABLE `payment_systems`
  ADD PRIMARY KEY (`id_pay`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `payment_systems`
--
ALTER TABLE `payment_systems`
  MODIFY `id_pay` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
