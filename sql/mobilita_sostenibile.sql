-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 11, 2026 alle 13:18
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

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
  `id_scuola` int(11) NOT NULL,
  `anno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `classi`
--

INSERT INTO `classi` (`id`, `id_sezione`, `id_indirizzo`, `id_scuola`, `anno`) VALUES
(22, 4, 4, 3, 1),
(23, 5, 4, 3, 1),
(24, 6, 4, 3, 1),
(25, 7, 4, 3, 1),
(26, 4, 4, 3, 2),
(27, 5, 4, 3, 2),
(28, 6, 4, 3, 2),
(29, 7, 4, 3, 2),
(30, 4, 4, 3, 3),
(31, 5, 4, 3, 3),
(32, 6, 4, 3, 3),
(33, 7, 4, 3, 3),
(34, 4, 4, 3, 4),
(35, 5, 4, 3, 4),
(36, 6, 4, 3, 4),
(37, 7, 4, 3, 4),
(38, 4, 4, 3, 5),
(39, 5, 4, 3, 5),
(40, 6, 4, 3, 5),
(41, 7, 4, 3, 5),
(42, 4, 5, 3, 1),
(43, 5, 5, 3, 1),
(44, 6, 5, 3, 1),
(45, 7, 5, 3, 1),
(46, 4, 5, 3, 2),
(47, 5, 5, 3, 2),
(48, 6, 5, 3, 2),
(49, 7, 5, 3, 2),
(50, 4, 5, 3, 3),
(51, 5, 5, 3, 3),
(52, 6, 5, 3, 3),
(53, 7, 5, 3, 3),
(54, 4, 5, 3, 4),
(55, 5, 5, 3, 4),
(56, 6, 5, 3, 4),
(57, 7, 5, 3, 4),
(58, 4, 5, 3, 5),
(59, 5, 5, 3, 5),
(60, 6, 5, 3, 5),
(61, 7, 5, 3, 5),
(62, 4, 6, 3, 1),
(63, 5, 6, 3, 1),
(64, 6, 6, 3, 1),
(65, 7, 6, 3, 1),
(66, 4, 6, 3, 2),
(67, 5, 6, 3, 2),
(68, 6, 6, 3, 2),
(69, 7, 6, 3, 2),
(70, 4, 6, 3, 3),
(71, 5, 6, 3, 3),
(72, 6, 6, 3, 3),
(73, 7, 6, 3, 3),
(74, 4, 6, 3, 4),
(75, 5, 6, 3, 4),
(76, 6, 6, 3, 4),
(77, 7, 6, 3, 4),
(78, 4, 6, 3, 5),
(79, 5, 6, 3, 5),
(80, 6, 6, 3, 5),
(81, 7, 6, 3, 5),
(82, 4, 7, 3, 1),
(83, 5, 7, 3, 1),
(84, 6, 7, 3, 1),
(85, 7, 7, 3, 1),
(86, 4, 7, 3, 2),
(87, 5, 7, 3, 2),
(88, 6, 7, 3, 2),
(89, 7, 7, 3, 2),
(90, 4, 7, 3, 3),
(91, 5, 7, 3, 3),
(92, 6, 7, 3, 3),
(93, 7, 7, 3, 3),
(94, 4, 7, 3, 4),
(95, 5, 7, 3, 4),
(96, 6, 7, 3, 4),
(97, 7, 7, 3, 4),
(98, 4, 7, 3, 5),
(99, 5, 7, 3, 5),
(100, 6, 7, 3, 5),
(101, 7, 7, 3, 5);

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
(4, 'Meccanica'),
(5, 'Informatica'),
(6, 'Elettronica'),
(7, 'Liceo');

-- --------------------------------------------------------

--
-- Struttura della tabella `mezzi`
--

CREATE TABLE `mezzi` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `co2_per_km` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `mezzi`
--

INSERT INTO `mezzi` (`id`, `nome`, `co2_per_km`) VALUES
(10, 'Auto benzina', 120),
(11, 'Auto diesel', 110),
(12, 'Auto ibrida', 80),
(13, 'Auto elettrica', 0),
(14, 'Scooter', 90),
(15, 'Autobus', 70),
(16, 'Treno', 40),
(17, 'Bici', 0),
(18, 'A piedi', 0),
(19, 'moto', 100);

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
(3, 'ITIS Avogadro', 'Torino', 'Corso San Maurizio 8');

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
(4, 'A'),
(5, 'B'),
(6, 'C'),
(7, 'D');

-- --------------------------------------------------------

--
-- Struttura della tabella `studenti_viaggi`
--

CREATE TABLE `studenti_viaggi` (
  `id_studente` int(11) NOT NULL,
  `id_viaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `studenti_viaggi`
--

INSERT INTO `studenti_viaggi` (`id_studente`, `id_viaggio`) VALUES
(29, 1),
(29, 2),
(29, 3),
(29, 4),
(29, 7),
(29, 8);

-- --------------------------------------------------------

--
-- Struttura della tabella `tratte`
--

CREATE TABLE `tratte` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `distanza_km` int(11) NOT NULL,
  `passeggeri` int(11) NOT NULL,
  `co2` float NOT NULL,
  `id_mezzo` int(11) NOT NULL,
  `riempimento_bus` enum('vuoto','poco','medio','tanto') DEFAULT NULL,
  `riempimento_treno` enum('vuoto','medio','pieno') DEFAULT NULL,
  `id_viaggio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tratte`
--

INSERT INTO `tratte` (`id`, `data`, `distanza_km`, `passeggeri`, `co2`, `id_mezzo`, `riempimento_bus`, `riempimento_treno`, `id_viaggio`) VALUES
(20, '2026-06-07', 3, 4, 82.5, 11, NULL, NULL, 1),
(21, '2026-06-07', 1, 1, 0, 18, NULL, NULL, 1),
(22, '2026-06-06', 3, 1, 240, 12, NULL, NULL, 2),
(23, '2026-06-06', 3, 1, 336, 10, NULL, NULL, 2),
(24, '2026-06-07', 3, 4, 82.5, 11, NULL, NULL, 3),
(25, '2026-06-07', 1, 1, 0, 18, NULL, NULL, 3),
(26, '2026-06-07', 2, 50, 140, 15, NULL, NULL, 4),
(30, '2026-06-08', 10, 1, 0, 17, NULL, NULL, 7),
(31, '2026-06-08', 1, 1, 0, 18, NULL, NULL, 7);

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
  `account_activation_hash` varchar(64) DEFAULT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `username`, `email`, `password`, `ruolo`, `id_classe`, `account_activation_hash`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, 'paolo', 'paolo.cataldo0722@gmail.com', 'e7226222d28a9b09aef035be74890a7d', 'd', NULL, '', NULL, NULL),
(12, 'paolo5', 'gabrielevalentino294@gmail.com', 'e7226222d28a9b09aef035be74890a7d', NULL, NULL, '6a9e40de9450015cfd3362bd44d63faeefc735e28c61dc3b0f8bb967e855d9a2', NULL, NULL),
(28, 'gabri', 's9503347v@studenti.itisavogadro.it', 'e7226222d28a9b09aef035be74890a7d', 's', 66, '64278f1ccdf2aa50c6f849505be2a72adfbea5e8f972ea13121cbe16da727bdd', NULL, NULL),
(29, 'prova', 's9503358v@studenti.itisavogadro.it', 'e7226222d28a9b09aef035be74890a7d', 's', 60, NULL, 'c8480390b693d4a38307cc510e054ecb86bb0924bb3f1eb8cc60d3ef29104cb3', '2026-05-21 20:41:35'),
(30, 'paolo2', 'paolocataldo520@gmail.com', 'e7226222d28a9b09aef035be74890a7d', 'a', 60, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `viaggi`
--

CREATE TABLE `viaggi` (
  `id` int(11) NOT NULL,
  `data` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `viaggi`
--

INSERT INTO `viaggi` (`id`, `data`) VALUES
(1, '2026-06-07'),
(2, '2026-06-06'),
(3, '2026-06-07'),
(4, '2026-06-07'),
(7, '2026-06-08'),
(8, '2026-06-11');

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
-- Indici per le tabelle `sezioni`
--
ALTER TABLE `sezioni`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `studenti_viaggi`
--
ALTER TABLE `studenti_viaggi`
  ADD PRIMARY KEY (`id_studente`,`id_viaggio`),
  ADD KEY `fk_studenti_viaggi` (`id_viaggio`);

--
-- Indici per le tabelle `tratte`
--
ALTER TABLE `tratte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mezzo` (`id_mezzo`),
  ADD KEY `fk_tratte_viaggi` (`id_viaggio`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `account_activation_hash` (`account_activation_hash`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  ADD KEY `fk_utenti_classi` (`id_classe`);

--
-- Indici per le tabelle `viaggi`
--
ALTER TABLE `viaggi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `classi`
--
ALTER TABLE `classi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT per la tabella `indirizzi`
--
ALTER TABLE `indirizzi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `mezzi`
--
ALTER TABLE `mezzi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT per la tabella `scuole`
--
ALTER TABLE `scuole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `sezioni`
--
ALTER TABLE `sezioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `tratte`
--
ALTER TABLE `tratte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT per la tabella `viaggi`
--
ALTER TABLE `viaggi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- Limiti per la tabella `studenti_viaggi`
--
ALTER TABLE `studenti_viaggi`
  ADD CONSTRAINT `fk_studenti_viaggi` FOREIGN KEY (`id_viaggio`) REFERENCES `viaggi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_studenti_viaggi_utenti` FOREIGN KEY (`id_studente`) REFERENCES `utenti` (`id`);

--
-- Limiti per la tabella `tratte`
--
ALTER TABLE `tratte`
  ADD CONSTRAINT `fk_tratte_viaggi` FOREIGN KEY (`id_viaggio`) REFERENCES `viaggi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tratte_ibfk_1` FOREIGN KEY (`id_mezzo`) REFERENCES `mezzi` (`id`);

--
-- Limiti per la tabella `utenti`
--
ALTER TABLE `utenti`
  ADD CONSTRAINT `fk_utenti_classi` FOREIGN KEY (`id_classe`) REFERENCES `classi` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
