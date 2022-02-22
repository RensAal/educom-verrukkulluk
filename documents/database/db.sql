-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2022 at 12:41 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

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
-- Table structure for table `artikelen`
--

CREATE TABLE `artikelen` (
  `ID` int(11) NOT NULL,
  `naam` text NOT NULL,
  `omschrijving` text NOT NULL,
  `standaard_hoeveelheid` decimal(6,2) NOT NULL,
  `eenheid` text NOT NULL,
  `prijs` decimal(6,2) NOT NULL,
  `caloriën` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `artikelen`
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
-- Table structure for table `gebruikers`
--

CREATE TABLE `gebruikers` (
  `ID` int(11) NOT NULL,
  `email` text NOT NULL,
  `voornaam` text NOT NULL,
  `achternaam` text NOT NULL,
  `afbeelding` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gebruikers`
--

INSERT INTO `gebruikers` (`ID`, `email`, `voornaam`, `achternaam`, `afbeelding`) VALUES
(1, 'arie@domein.nl', 'Arie', 'Ariesen', ''),
(2, 'bob@domein.nl', 'Bob', 'Bobben', ''),
(3, 'chris@dmein.nl', 'Chris', 'Chrissen', ''),
(4, 'dirk@domein.nl', 'Dirk', 'Dirksen', '');

-- --------------------------------------------------------

--
-- Table structure for table `ingrediënten`
--

CREATE TABLE `ingrediënten` (
  `ID` int(11) NOT NULL,
  `naam` text NOT NULL,
  `recept_ID` int(11) NOT NULL,
  `artikel_ID` int(11) NOT NULL,
  `hoeveelheid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ingrediënten`
--

INSERT INTO `ingrediënten` (`ID`, `naam`, `recept_ID`, `artikel_ID`, `hoeveelheid`) VALUES
(1, 'Pizzadeeg', 1, 1, 4),
(2, 'Tomatensaus', 1, 2, 500),
(3, 'Basilicum', 1, 4, 1),
(4, 'Mozarella', 1, 3, 260),
(5, 'Mie', 2, 5, 400),
(6, 'Bami groenten', 2, 6, 800),
(7, 'Bami kruiden', 2, 7, 30),
(8, 'Varkensvlees', 2, 8, 500),
(9, 'Mie', 3, 5, 400),
(10, 'Bami groenten', 3, 6, 1000),
(11, 'Bami kruiden', 3, 7, 30),
(12, 'Ei', 3, 9, 4),
(13, 'Schnitzel', 4, 10, 500),
(14, 'Paneermeel ', 4, 11, 100),
(15, 'Ei (losgeklopt)', 4, 9, 2);

-- --------------------------------------------------------

--
-- Table structure for table `keuken_type`
--

CREATE TABLE `keuken_type` (
  `ID` int(11) NOT NULL,
  `record_type` varchar(1) NOT NULL,
  `omschrijving` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `keuken_type`
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
-- Table structure for table `recepten`
--

CREATE TABLE `recepten` (
  `ID` int(11) NOT NULL,
  `naam` text NOT NULL,
  `korte_omschrijving` text NOT NULL,
  `lange_omschrijving` text NOT NULL,
  `keuken_ID` int(11) NOT NULL,
  `type_ID` int(11) NOT NULL,
  `afbeelding` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recepten`
--

INSERT INTO `recepten` (`ID`, `naam`, `korte_omschrijving`, `lange_omschrijving`, `keuken_ID`, `type_ID`, `afbeelding`) VALUES
(1, 'Pizza Margherita', 'Pizza Margherita kort', 'Pizza Margherita lang', 1, 5, ''),
(2, 'Bami', 'Bami kort', 'Bami lang', 3, 6, ''),
(3, 'Bami', 'Bami kort', 'Bami lang', 3, 5, ''),
(4, 'Schnitzel', 'Schnitzel kort', 'Schnitzel lang', 2, 6, '');

-- --------------------------------------------------------

--
-- Table structure for table `recept_info`
--

CREATE TABLE `recept_info` (
  `ID` int(11) NOT NULL,
  `record_type` varchar(1) NOT NULL,
  `recept_ID` int(11) NOT NULL,
  `gebruiker_ID` int(11) NOT NULL,
  `tekstveld` text NOT NULL,
  `numeriekveld` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recept_info`
--

INSERT INTO `recept_info` (`ID`, `record_type`, `recept_ID`, `gebruiker_ID`, `tekstveld`, `numeriekveld`) VALUES
(1, 'B', 1, 0, 'Omschrijving Stap 1 Pizza', 1),
(2, 'B', 1, 0, 'Omschrijving Stap 2 pizza', 2),
(3, 'O', 1, 3, 'Lekker!', 0),
(4, 'W', 2, 0, '', 4),
(5, 'F', 4, 3, '', 0),
(6, 'O', 3, 4, 'Niet te vreten.', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikelen`
--
ALTER TABLE `artikelen`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ingrediënten`
--
ALTER TABLE `ingrediënten`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `recept_ID` (`recept_ID`),
  ADD KEY `artikel_ID` (`artikel_ID`);

--
-- Indexes for table `keuken_type`
--
ALTER TABLE `keuken_type`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `recepten`
--
ALTER TABLE `recepten`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `keuken_ID` (`keuken_ID`),
  ADD KEY `type_ID` (`type_ID`);

--
-- Indexes for table `recept_info`
--
ALTER TABLE `recept_info`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `recept_ID` (`recept_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ingrediënten`
--
ALTER TABLE `ingrediënten`
  ADD CONSTRAINT `ingrediënten_ibfk_1` FOREIGN KEY (`recept_ID`) REFERENCES `recepten` (`ID`),
  ADD CONSTRAINT `ingrediënten_ibfk_2` FOREIGN KEY (`artikel_ID`) REFERENCES `artikelen` (`ID`);

--
-- Constraints for table `recepten`
--
ALTER TABLE `recepten`
  ADD CONSTRAINT `recepten_ibfk_1` FOREIGN KEY (`keuken_ID`) REFERENCES `keuken_type` (`ID`),
  ADD CONSTRAINT `recepten_ibfk_2` FOREIGN KEY (`type_ID`) REFERENCES `keuken_type` (`ID`);

--
-- Constraints for table `recept_info`
--
ALTER TABLE `recept_info`
  ADD CONSTRAINT `recept_info_ibfk_1` FOREIGN KEY (`recept_ID`) REFERENCES `recepten` (`ID`),
  ADD CONSTRAINT `recept_info_ibfk_2` FOREIGN KEY (`gebruiker_ID`) REFERENCES `gebruikers` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
