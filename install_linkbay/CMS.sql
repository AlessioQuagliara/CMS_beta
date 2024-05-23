-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Creato il: Mag 23, 2024 alle 15:59
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
-- Database: `CMS_2`
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
(1, 'Juan', 'Romero', 'Designer', '3899657115', 'juan.romero@spotexsrl.it', '$2y$10$iqtsvkECdJYkrWl/8wMvwuNcsl9QWeCmIi6HSN49eN8cp1mHSapSW'),
(2, 'Gaia', 'Masia', 'Designer', '3899657115', 'gaia.masia@spotexsrl.it', '$2y$10$icM9YX93YJeHVzkQmvKkcuFqvZNR0nuKfxPCfb7QkwevyGM1iwL0a'),
(3, 'Alessio', 'Quagliara', 'Developer', '3899657115', 'alessio.quagliara@spotexsrl.it', '$2y$10$RLqxrn4t9QDCDCXfjyMabeZ1jtRORL0xEaYvHbaZwe6wMgJezrxGy'),
(4, 'Bruno', 'Postai', 'Developer', '3899657115', 'bruno.postai@spotexsrl.it', '$2y$10$RLqxrn4t9QDCDCXfjyMabeZ1jtRORL0xEaYvHbaZwe6wMgJezrxGy');

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

CREATE TABLE `categorie` (
  `id_categoria` int(11) NOT NULL,
  `nome_cat` varchar(255) NOT NULL,
  `associazione` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `codici_sconto`
--

CREATE TABLE `codici_sconto` (
  `id_codicesconto` int(11) NOT NULL,
  `codicesconto` varchar(255) NOT NULL,
  `importo` varchar(255) NOT NULL,
  `stato` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `collezioni`
--

CREATE TABLE `collezioni` (
  `id_collezione` int(11) NOT NULL,
  `nome_c` varchar(255) NOT NULL,
  `descrizione_c` varchar(255) NOT NULL,
  `selected` varchar(255) NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Struttura della tabella `editor_contents`
--

CREATE TABLE `editor_contents` (
  `id` int(11) NOT NULL,
  `name_page` varchar(255) DEFAULT NULL,
  `content` mediumtext NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `leads`
--

CREATE TABLE `leads` (
  `lead` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `messaggio` text NOT NULL,
  `data_rec` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `media`
--

CREATE TABLE `media` (
  `id_media` int(11) NOT NULL,
  `id_prodotto` varchar(255) NOT NULL,
  `immagine` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `tipo_spedizione` varchar(255) NOT NULL,
  `selected` varchar(255) NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(2, 'PayPal', 'Inserisci il client ID', 'Inserisci la Secret Key', 'production', 'active', '2024-03-19 21:06:19', '2024-03-25 17:53:37'),
(3, 'Bonifico', 'Inserisci Intestatario', 'Inserisci Iban', 'production', 'active', '2024-03-19 21:06:32', '2024-03-22 21:45:15'),
(4, 'Pagolight', 'inserisci il client ID', 'Inserisci la secret key', 'production', 'inactive', '2024-03-19 21:06:32', '2024-03-19 22:40:47');

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti`
--

CREATE TABLE `prodotti` (
  `id_prodotto` int(11) NOT NULL,
  `titolo` varchar(255) NOT NULL,
  `titolo_seo` varchar(255) DEFAULT NULL,
  `descrizione` text NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `collezione` varchar(255) NOT NULL,
  `stato` varchar(255) NOT NULL,
  `prezzo` varchar(255) NOT NULL,
  `prezzo_comparato` varchar(255) NOT NULL,
  `quantita` varchar(255) NOT NULL,
  `peso` varchar(255) NOT NULL,
  `varianti` varchar(255) NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `selected` varchar(255) NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `seo`
--

CREATE TABLE `seo` (
  `id` int(11) NOT NULL,
  `editor_page` varchar(255) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `keywords` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `seo`
--

INSERT INTO `seo` (`id`, `editor_page`, `page_name`, `slug`, `title`, `description`, `keywords`) VALUES
(1, 'edit_homepage', 'index', 'home', 'Inserisci il titolo', 'Inserisci una descrizione', 'inserisci, così, le, keywords'),
(2, 'edit_aboutus', 'aboutus', 'aboutus', 'Inserisci il titolo', 'inserisci una descrizione', 'inserisci, così, le, keywords'),
(3, 'edit_contatti', 'contacts', 'contacts', 'Inserisci il titolo', 'inserisci una descrizione', 'inserisci, così, le, keywords'),
(4, 'edit_servizi', 'services', 'services', 'Inserisci il titolo', 'inserisci una descrizione', 'inserisci, così, le, keywords'),
(5, 'edit_landing', 'landing', 'landing', 'Inserisci il titolo', 'inserisci una descrizione', 'inserisci, così, le, keywords'),
(6, 'edit_prodotto', 'prodotto', 'prodotto', 'Inserisci il titolo', 'inserisci una descrizione', 'inserisci, così, le, keywords');

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

-- --------------------------------------------------------

--
-- Struttura della tabella `tracking`
--

CREATE TABLE `tracking` (
  `id_track` int(11) NOT NULL,
  `id_ordine` varchar(255) NOT NULL,
  `corriere` varchar(255) NOT NULL,
  `stato_spedizione` varchar(255) NOT NULL,
  `tracking` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `user_db`
--

CREATE TABLE `user_db` (
  `id_utente` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indici per le tabelle `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indici per le tabelle `codici_sconto`
--
ALTER TABLE `codici_sconto`
  ADD PRIMARY KEY (`id_codicesconto`);

--
-- Indici per le tabelle `collezioni`
--
ALTER TABLE `collezioni`
  ADD PRIMARY KEY (`id_collezione`);

--
-- Indici per le tabelle `dettagli_negozio`
--
ALTER TABLE `dettagli_negozio`
  ADD PRIMARY KEY (`identificatore`);

--
-- Indici per le tabelle `dettagli_ordini`
--
ALTER TABLE `dettagli_ordini`
  ADD PRIMARY KEY (`id_dettaglio`);

--
-- Indici per le tabelle `editor_contents`
--
ALTER TABLE `editor_contents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_page` (`name_page`);

--
-- Indici per le tabelle `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`lead`);

--
-- Indici per le tabelle `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id_media`);

--
-- Indici per le tabelle `ordini`
--
ALTER TABLE `ordini`
  ADD PRIMARY KEY (`id_ordine`);

--
-- Indici per le tabelle `payment_systems`
--
ALTER TABLE `payment_systems`
  ADD PRIMARY KEY (`id_pay`);

--
-- Indici per le tabelle `prodotti`
--
ALTER TABLE `prodotti`
  ADD PRIMARY KEY (`id_prodotto`);

--
-- Indici per le tabelle `seo`
--
ALTER TABLE `seo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indici per le tabelle `spedizioni`
--
ALTER TABLE `spedizioni`
  ADD PRIMARY KEY (`id_spedizione`);

--
-- Indici per le tabelle `tracking`
--
ALTER TABLE `tracking`
  ADD PRIMARY KEY (`id_track`);

--
-- Indici per le tabelle `user_db`
--
ALTER TABLE `user_db`
  ADD PRIMARY KEY (`id_utente`);

--
-- Indici per le tabelle `visitatori`
--
ALTER TABLE `visitatori`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `codici_sconto`
--
ALTER TABLE `codici_sconto`
  MODIFY `id_codicesconto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `collezioni`
--
ALTER TABLE `collezioni`
  MODIFY `id_collezione` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `dettagli_negozio`
--
ALTER TABLE `dettagli_negozio`
  MODIFY `identificatore` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `dettagli_ordini`
--
ALTER TABLE `dettagli_ordini`
  MODIFY `id_dettaglio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `editor_contents`
--
ALTER TABLE `editor_contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `leads`
--
ALTER TABLE `leads`
  MODIFY `lead` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `media`
--
ALTER TABLE `media`
  MODIFY `id_media` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `ordini`
--
ALTER TABLE `ordini`
  MODIFY `id_ordine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `payment_systems`
--
ALTER TABLE `payment_systems`
  MODIFY `id_pay` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `prodotti`
--
ALTER TABLE `prodotti`
  MODIFY `id_prodotto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `seo`
--
ALTER TABLE `seo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `spedizioni`
--
ALTER TABLE `spedizioni`
  MODIFY `id_spedizione` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `tracking`
--
ALTER TABLE `tracking`
  MODIFY `id_track` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `user_db`
--
ALTER TABLE `user_db`
  MODIFY `id_utente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `visitatori`
--
ALTER TABLE `visitatori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
