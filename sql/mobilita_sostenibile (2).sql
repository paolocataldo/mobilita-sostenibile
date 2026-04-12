-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 12, 2026 alle 20:37
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

--
-- Dump dei dati per la tabella `classi`
--

INSERT INTO `classi` (`id`, `id_sezione`, `id_indirizzo`, `id_scuola`) VALUES
(4, 1, 3, 2),
(5, 2, 3, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `indirizzi`
--

CREATE TABLE `indirizzi` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `indirizzi`
--

INSERT INTO `indirizzi` (`id`, `nome`) VALUES
(1, 'Informatica'),
(2, 'Meccanica'),
(3, 'Scientifico');

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

--
-- Dump dei dati per la tabella `scuole`
--

INSERT INTO `scuole` (`id`, `nome`, `citta`, `indirizzo`) VALUES
(1, 'ITIS Avogadro', 'Torino', 'Via Rossini 18'),
(2, 'Liceo Scientifico Galileo', 'Torino', 'Via Verdi 10');

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
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `sezioni`
--

INSERT INTO `sezioni` (`id`, `nome`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C');

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
  `id_classe` int(11) DEFAULT NULL,
  `account_activation_hash` varchar(255) DEFAULT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `username`, `email`, `password`, `ruolo`, `id_classe`, `account_activation_hash`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, 'paolo', 'paolo.cataldo0722@gmail.com', 'e7226222d28a9b09aef035be74890a7d', 'a', 0, '', NULL, NULL),
(12, 'paolo5', 'gabrielevalentino294@gmail.com', 'e7226222d28a9b09aef035be74890a7d', NULL, 0, '6a9e40de9450015cfd3362bd44d63faeefc735e28c61dc3b0f8bb967e855d9a2', NULL, NULL),
(20, 'prova', 's9503358v@studenti.itisavogadro.it', 'e94f14b2f1a94a57e9d55385bbeb9691', 's', 0, NULL, NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `indirizzi`
--
ALTER TABLE `indirizzi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `mezzi`
--
ALTER TABLE `mezzi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `scuole`
--
ALTER TABLE `scuole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `sezioni`
--
ALTER TABLE `sezioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
