-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 08, 2026 alle 23:01
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mobilita_sostenibile`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `classi`
--

CREATE TABLE `classi` (
  `id` int(11) NOT NULL,
  `id_sezione` int(11) NOT NULL,
  `id_indirizzo` int(11) NOT NULL,
  `id_scuola` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `indirizzi`
--

CREATE TABLE `indirizzi` (
  `id` int(11) NOT NULL,
  `nome` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `mezzi`
--

CREATE TABLE `mezzi` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `tipo` enum('benzina','diesel','ibrida','elettrica') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `scuole`
--

CREATE TABLE `scuole` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `citta` varchar(50) NOT NULL,
  `indirizzo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `scuole_indirizzi`
--

CREATE TABLE `scuole_indirizzi` (
  `id_scuola` int(11) NOT NULL,
  `id_indirizzo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `sezioni`
--

CREATE TABLE `sezioni` (
  `id` int(11) NOT NULL,
  `nome` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `studenti`
--

CREATE TABLE `studenti` (
  `id` int(11) NOT NULL,
  `id_classe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `studenti_viaggi`
--

CREATE TABLE `studenti_viaggi` (
  `id_studente` int(11) NOT NULL,
  `id_viaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `ruolo` enum('s','d','a') DEFAULT NULL,
  `account_activation_hash` varchar(64) NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `username`, `email`, `password`, `ruolo`, `account_activation_hash`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, 'paolo', 'paolo.cataldo0722@gmail.com', 'd4a9c286b2e4d57fccef6090191652a1', 'a', '', NULL, NULL),
(5, 'PROVA', 'ucataldo2007@gmail.com', 'e7226222d28a9b09aef035be74890a7d', NULL, '8cd9105edd3625725030a9fad8f7c80b6c551bce90fc26e809d2e7dd5a37b296', '18338c5585c8101079e345e1477869953b5e0fb53ca0ce3bfa81767d910c685c', '2026-04-08 22:21:26'),
(8, 'gabriele', 'gabrielevalentino294@studenti.itisavogadro.it', '489cb7fc2813cc180bba70f297cafc15', NULL, 'd65f48f7870e6e17ffbded0ad20342dcc69082040aacece5dd6e81440f091081', NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `viaggi`
--

CREATE TABLE `viaggi` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `distanza_km` int(11) NOT NULL,
  `passeggeri` int(11) NOT NULL,
  `co2` float NOT NULL,
  `id_mezzo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `classi`
--
ALTER TABLE `classi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_indirizzo` (`id_indirizzo`),
  ADD KEY `id_sezione` (`id_sezione`),
  ADD KEY `id_scuola` (`id_scuola`);

--
-- Indici per le tabelle `indirizzi`
--
ALTER TABLE `indirizzi`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `mezzi`
--
ALTER TABLE `mezzi`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `scuole`
--
ALTER TABLE `scuole`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `scuole_indirizzi`
--
ALTER TABLE `scuole_indirizzi`
  ADD PRIMARY KEY (`id_scuola`,`id_indirizzo`),
  ADD KEY `id_indirizzo` (`id_indirizzo`);

--
-- Indici per le tabelle `sezioni`
--
ALTER TABLE `sezioni`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `studenti`
--
ALTER TABLE `studenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_classe` (`id_classe`);

--
-- Indici per le tabelle `studenti_viaggi`
--
ALTER TABLE `studenti_viaggi`
  ADD PRIMARY KEY (`id_studente`,`id_viaggio`),
  ADD KEY `id_viaggio` (`id_viaggio`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `account_activation_hash` (`account_activation_hash`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`);

--
-- Indici per le tabelle `viaggi`
--
ALTER TABLE `viaggi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mezzo` (`id_mezzo`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `classi`
--
ALTER TABLE `classi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `indirizzi`
--
ALTER TABLE `indirizzi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `mezzi`
--
ALTER TABLE `mezzi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `scuole`
--
ALTER TABLE `scuole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `sezioni`
--
ALTER TABLE `sezioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `studenti`
--
ALTER TABLE `studenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `viaggi`
--
ALTER TABLE `viaggi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `classi`
--
ALTER TABLE `classi`
  ADD CONSTRAINT `classi_ibfk_1` FOREIGN KEY (`id_indirizzo`) REFERENCES `indirizzi` (`id`),
  ADD CONSTRAINT `classi_ibfk_2` FOREIGN KEY (`id_sezione`) REFERENCES `sezioni` (`id`),
  ADD CONSTRAINT `classi_ibfk_3` FOREIGN KEY (`id_scuola`) REFERENCES `scuole` (`id`);

--
-- Limiti per la tabella `scuole_indirizzi`
--
ALTER TABLE `scuole_indirizzi`
  ADD CONSTRAINT `scuole_indirizzi_ibfk_1` FOREIGN KEY (`id_indirizzo`) REFERENCES `indirizzi` (`id`),
  ADD CONSTRAINT `scuole_indirizzi_ibfk_2` FOREIGN KEY (`id_scuola`) REFERENCES `scuole` (`id`);

--
-- Limiti per la tabella `studenti`
--
ALTER TABLE `studenti`
  ADD CONSTRAINT `studenti_ibfk_1` FOREIGN KEY (`id`) REFERENCES `utenti` (`id`),
  ADD CONSTRAINT `studenti_ibfk_2` FOREIGN KEY (`id_classe`) REFERENCES `classi` (`id`);

--
-- Limiti per la tabella `studenti_viaggi`
--
ALTER TABLE `studenti_viaggi`
  ADD CONSTRAINT `studenti_viaggi_ibfk_1` FOREIGN KEY (`id_studente`) REFERENCES `studenti` (`id`),
  ADD CONSTRAINT `studenti_viaggi_ibfk_2` FOREIGN KEY (`id_viaggio`) REFERENCES `viaggi` (`id`);

--
-- Limiti per la tabella `viaggi`
--
ALTER TABLE `viaggi`
  ADD CONSTRAINT `viaggi_ibfk_1` FOREIGN KEY (`id_mezzo`) REFERENCES `mezzi` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
