-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 14 mrt 2022 om 13:13
-- Serverversie: 10.4.22-MariaDB
-- PHP-versie: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `verrukkulluk`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `artikelen`
--

CREATE TABLE `artikelen` (
  `ID` int(8) UNSIGNED NOT NULL,
  `naam` varchar(100) NOT NULL,
  `omschrijving` text NOT NULL,
  `standaard_hoeveelheid` decimal(6,2) NOT NULL,
  `eenheid` varchar(100) NOT NULL,
  `prijs` decimal(6,2) NOT NULL,
  `caloriën` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `artikelen`
--

INSERT INTO `artikelen` (`ID`, `naam`, `omschrijving`, `standaard_hoeveelheid`, `eenheid`, `prijs`, `caloriën`) VALUES
(1, 'Pizzadeeg', 'Pizzadeeg omschrijving', '1.00', 'st', '2.13', 200),
(2, 'Tomatensaus', 'Tomatensaus omschrijving', '500.00', 'mL', '2.44', 190),
(3, 'Mozarella', 'Mozarella omschrijving', '130.00', 'g', '0.69', 322),
(4, 'Basilicum vers', 'Basilicum vers omschrijving', '1.00', 'st', '1.19', 5),
(5, 'Mie', 'Mie omschrijving', '500.00', 'g', '0.97', 1765),
(6, 'Bami groenten', 'Bami groenten omschrijving', '500.00', 'g', '1.99', 20),
(7, 'Bami kruidenmix', 'Bami kruidenmix omschrijving', '30.00', 'g', '1.09', 36),
(8, 'Varkensvlees stukjes', 'Varkensvlees stukjes omshrijving', '250.00', 'g', '2.85', 100),
(9, 'Ei', 'Ei omschrijving', '6.00', 'st', '2.35', 100),
(10, 'Schnitzel', 'Schnitzel omschrijving', '200.00', 'g', '1.79', 100),
(11, 'Paneermeel gekruid', 'Paneermeel gekruid omschrijving', '150.00', 'g', '0.49', 150);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `boodschappen`
--

CREATE TABLE `boodschappen` (
  `ID` int(8) UNSIGNED NOT NULL,
  `gebruiker_ID` int(11) NOT NULL,
  `artikel_ID` int(11) NOT NULL,
  `aantal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE `gebruikers` (
  `ID` int(8) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `voornaam` varchar(100) NOT NULL,
  `achternaam` varchar(100) NOT NULL,
  `afbeelding` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`ID`, `email`, `voornaam`, `achternaam`, `afbeelding`) VALUES
(1, 'arie@domein.nl', 'Arie', 'Ariesen', ''),
(2, 'bob@domein.nl', 'Bob', 'Bobben', ''),
(3, 'chris@dmein.nl', 'Chris', 'Chrissen', ''),
(4, 'dirk@domein.nl', 'Dirk', 'Dirksen', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ingrediënten`
--

CREATE TABLE `ingrediënten` (
  `ID` int(8) UNSIGNED NOT NULL,
  `recept_ID` int(11) NOT NULL,
  `artikel_ID` int(11) NOT NULL,
  `hoeveelheid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `ingrediënten`
--

INSERT INTO `ingrediënten` (`ID`, `recept_ID`, `artikel_ID`, `hoeveelheid`) VALUES
(1, 1, 1, 4),
(2, 1, 2, 500),
(3, 1, 4, 1),
(4, 1, 3, 260),
(5, 2, 5, 400),
(6, 2, 6, 800),
(7, 2, 7, 30),
(8, 2, 8, 500),
(9, 3, 5, 400),
(10, 3, 6, 1000),
(11, 3, 7, 30),
(12, 3, 9, 4),
(13, 4, 10, 500),
(14, 4, 11, 100),
(15, 4, 9, 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `keuken_type`
--

CREATE TABLE `keuken_type` (
  `ID` int(8) UNSIGNED NOT NULL,
  `record_type` varchar(1) NOT NULL,
  `omschrijving` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `keuken_type`
--

INSERT INTO `keuken_type` (`ID`, `record_type`, `omschrijving`) VALUES
(1, 'K', 'Italiaans'),
(2, 'K', 'Duits'),
(3, 'K', 'Chinees'),
(4, 'T', 'Veganistisch'),
(5, 'T', 'Vegetarisch'),
(6, 'T', 'Vlees'),
(7, 'T', 'Vis');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `recepten`
--

CREATE TABLE `recepten` (
  `ID` int(8) UNSIGNED NOT NULL,
  `naam` varchar(100) NOT NULL,
  `korte_omschrijving` text NOT NULL,
  `lange_omschrijving` text NOT NULL,
  `keuken_ID` int(11) NOT NULL,
  `type_ID` int(11) NOT NULL,
  `afbeelding` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `recepten`
--

INSERT INTO `recepten` (`ID`, `naam`, `korte_omschrijving`, `lange_omschrijving`, `keuken_ID`, `type_ID`, `afbeelding`) VALUES
(1, 'Pizza Margherita', 'Pizza Margherita kort', 'Pizza Margherita lang', 1, 5, ''),
(2, 'Bami', 'Bami kort', 'Bami lang', 3, 6, ''),
(3, 'Bami', 'Bami kort', 'Bami lang', 3, 5, ''),
(4, 'Schnitzel', 'Schnitzel kort', 'Schnitzel lang', 2, 6, '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `recept_info`
--

CREATE TABLE `recept_info` (
  `ID` int(8) UNSIGNED NOT NULL,
  `record_type` varchar(1) NOT NULL,
  `recept_ID` int(11) NOT NULL,
  `gebruiker_ID` int(11) DEFAULT NULL,
  `tekstveld` text DEFAULT NULL,
  `numeriekveld` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `recept_info`
--

INSERT INTO `recept_info` (`ID`, `record_type`, `recept_ID`, `gebruiker_ID`, `tekstveld`, `numeriekveld`) VALUES
(1, 'B', 1, 0, 'Omschrijving Stap 1 Pizza', 1),
(2, 'B', 1, 0, 'Omschrijving Stap 2 pizza', 2),
(3, 'O', 1, 3, 'Lekker!', 0),
(4, 'W', 2, 0, '', 4),
(5, 'F', 4, 3, '', 0),
(6, 'O', 3, 4, 'Niet te vreten.', 0),
(7, 'F', 1, 2, NULL, NULL),
(22, 'W', 1, 0, NULL, 5),
(23, 'W', 3, 0, NULL, 1),
(24, 'W', 1, 0, NULL, 5),
(25, 'W', 3, 0, NULL, 1),
(26, 'W', 4, 0, NULL, 3),
(27, 'W', 4, 0, NULL, 3),
(28, 'W', 1, NULL, NULL, 1),
(29, 'W', 1, NULL, NULL, 3),
(30, 'W', 1, NULL, NULL, 3),
(31, 'W', 1, NULL, NULL, 4),
(32, 'W', 1, NULL, NULL, 2),
(33, 'W', 1, NULL, NULL, 5),
(34, 'W', 1, NULL, NULL, 3),
(35, 'W', 1, NULL, NULL, 3),
(36, 'W', 1, NULL, NULL, 3),
(37, 'W', 1, NULL, NULL, 4),
(38, 'W', 1, NULL, NULL, 2),
(39, 'W', 2, NULL, NULL, 2),
(40, 'W', 2, NULL, NULL, 4),
(41, 'W', 2, NULL, NULL, 2),
(42, 'W', 2, NULL, NULL, 5),
(43, 'W', 2, NULL, NULL, 3),
(44, 'W', 2, NULL, NULL, 1),
(45, 'W', 1, NULL, NULL, 4),
(46, 'W', 1, NULL, NULL, 2),
(47, 'W', 1, NULL, NULL, 2),
(48, 'W', 1, NULL, NULL, 3),
(49, 'W', 1, NULL, NULL, 2),
(50, 'W', 1, NULL, NULL, 4),
(51, 'W', 1, NULL, NULL, 2),
(52, 'W', 1, NULL, NULL, 3),
(53, 'W', 1, NULL, NULL, 3),
(54, 'W', 1, NULL, NULL, 3),
(55, 'W', 1, NULL, NULL, 3),
(56, 'W', 1, NULL, NULL, 2),
(57, 'W', 1, NULL, NULL, 2),
(58, 'W', 1, NULL, NULL, 2),
(59, 'W', 1, NULL, NULL, 2),
(60, 'W', 1, NULL, NULL, 3),
(61, 'W', 1, NULL, NULL, 1),
(62, 'W', 1, NULL, NULL, 4),
(63, 'W', 1, NULL, NULL, 3),
(64, 'W', 1, NULL, NULL, 2),
(65, 'W', 1, NULL, NULL, 1),
(66, 'W', 1, NULL, NULL, 3),
(67, 'W', 1, NULL, NULL, 5),
(68, 'W', 1, NULL, NULL, 1),
(69, 'W', 1, NULL, NULL, 3),
(70, 'W', 1, NULL, NULL, 3),
(71, 'W', 1, NULL, NULL, 5),
(72, 'W', 1, NULL, NULL, 1),
(73, 'W', 1, NULL, NULL, 3),
(74, 'W', 1, NULL, NULL, 3),
(75, 'W', 1, NULL, NULL, 3),
(76, 'W', 1, NULL, NULL, 3),
(77, 'W', 1, NULL, NULL, 3),
(78, 'W', 1, NULL, NULL, 5),
(79, 'W', 1, NULL, NULL, 3),
(80, 'W', 1, NULL, NULL, 2),
(81, 'W', 1, NULL, NULL, 1),
(82, 'W', 1, NULL, NULL, 5),
(83, 'W', 1, NULL, NULL, 3),
(84, 'W', 1, NULL, NULL, 3),
(85, 'W', 1, NULL, NULL, 2),
(86, 'W', 1, NULL, NULL, 2),
(87, 'W', 1, NULL, NULL, 1),
(88, 'W', 1, NULL, NULL, 5),
(89, 'W', 1, NULL, NULL, 4),
(90, 'W', 1, NULL, NULL, 3),
(91, 'W', 1, NULL, NULL, 2),
(92, 'W', 1, NULL, NULL, 2),
(93, 'W', 1, NULL, NULL, 2),
(94, 'W', 1, NULL, NULL, 4),
(95, 'W', 1, NULL, NULL, 3),
(96, 'W', 1, NULL, NULL, 3),
(97, 'W', 2, NULL, NULL, 2),
(98, 'W', 2, NULL, NULL, 1),
(99, 'W', 2, NULL, NULL, 4),
(100, 'W', 3, NULL, NULL, 4),
(101, 'W', 3, NULL, NULL, 2),
(102, 'W', 3, NULL, NULL, 3),
(140, 'W', 3, NULL, NULL, 3),
(169, 'F', 4, 1, NULL, NULL),
(170, 'W', 1, NULL, NULL, 3),
(173, 'F', 2, 1, NULL, NULL);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `artikelen`
--
ALTER TABLE `artikelen`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `boodschappen`
--
ALTER TABLE `boodschappen`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `gebruiker_ID` (`gebruiker_ID`),
  ADD KEY `artikel_ID` (`artikel_ID`);

--
-- Indexen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `ingrediënten`
--
ALTER TABLE `ingrediënten`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `recept_ID` (`recept_ID`),
  ADD KEY `artikel_ID` (`artikel_ID`);

--
-- Indexen voor tabel `keuken_type`
--
ALTER TABLE `keuken_type`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `recepten`
--
ALTER TABLE `recepten`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `keuken_ID` (`keuken_ID`),
  ADD KEY `type_ID` (`type_ID`);

--
-- Indexen voor tabel `recept_info`
--
ALTER TABLE `recept_info`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `recept_ID` (`recept_ID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `artikelen`
--
ALTER TABLE `artikelen`
  MODIFY `ID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT voor een tabel `boodschappen`
--
ALTER TABLE `boodschappen`
  MODIFY `ID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `ID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `ingrediënten`
--
ALTER TABLE `ingrediënten`
  MODIFY `ID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT voor een tabel `keuken_type`
--
ALTER TABLE `keuken_type`
  MODIFY `ID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `recepten`
--
ALTER TABLE `recepten`
  MODIFY `ID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `recept_info`
--
ALTER TABLE `recept_info`
  MODIFY `ID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
