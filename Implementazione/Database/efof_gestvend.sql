-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: efof.myd.infomaniak.com
-- Creato il: Apr 10, 2019 alle 11:28
-- Versione del server: 5.6.35-log
-- Versione PHP: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `efof_gestvend`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `amministratore`
--

CREATE TABLE `amministratore` (
  `email` varchar(50) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `amministratore`
--

INSERT INTO `amministratore` (`email`, `nome`, `cognome`, `password`, `telefono`) VALUES
('admin@progetto.ch', 'amministratore', 'unico', 'b109f3bbbc244eb82441917ed06d618b9008dd09b3befd1b5e07394c706a8bb980b1d7785e5976ec049b46df5f1326af5a2ea6d103fd07c95385ffab0cacbc86', '1234567890');

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`nome`) VALUES
('cibo'),
('giochi');

-- --------------------------------------------------------

--
-- Struttura della tabella `cliente`
--

CREATE TABLE `cliente` (
  `email` varchar(50) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `cliente`
--

INSERT INTO `cliente` (`email`, `nome`, `cognome`, `password`, `telefono`) VALUES
('a@a.a', 'asd', 'asd', 'e54ee7e285fbb0275279143abc4c554e5314e7b417ecac83a5984a964facbaad68866a2841c3e83ddf125a2985566261c4014f9f960ec60253aebcda9513a9b4', '123'),
('b@b.b', 'asd', 'asd', 'e54ee7e285fbb0275279143abc4c554e5314e7b417ecac83a5984a964facbaad68866a2841c3e83ddf125a2985566261c4014f9f960ec60253aebcda9513a9b4', '123 456 78 90'),
('giairo.mauro@samtrevano.ch', 'Giairo', 'Mauro', '1d9bbc287b32013d699d4f53351af1c670041d78eacb7ee5a9e44fa092b5d1b9a8a7bbe6329a3a4536d512e56c4d73c5286d564a0b983976e1ca6b3f73bf2329', '+411234567890'),
('w@a.a', 'asd', 'asdw2', '1d9bbc287b32013d699d4f53351af1c670041d78eacb7ee5a9e44fa092b5d1b9a8a7bbe6329a3a4536d512e56c4d73c5286d564a0b983976e1ca6b3f73bf2329', '123');

-- --------------------------------------------------------

--
-- Struttura della tabella `compra`
--

CREATE TABLE `compra` (
  `data` datetime NOT NULL,
  `nome_prodotto` varchar(50) NOT NULL DEFAULT '',
  `prezzo_prodotto` float NOT NULL,
  `quantita_prodotto` int(11) NOT NULL,
  `email_cliente` varchar(50) NOT NULL DEFAULT '',
  `id_luogo_ritiro` int(11) DEFAULT NULL,
  `data_entrata_merce` datetime DEFAULT NULL,
  `data_ritiro` datetime DEFAULT NULL,
  `data_ritorno` datetime DEFAULT NULL,
  `acquistato` bit(1) DEFAULT b'0',
  `quantita_richiesta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `compra`
--

INSERT INTO `compra` (`data`, `nome_prodotto`, `prezzo_prodotto`, `quantita_prodotto`, `email_cliente`, `id_luogo_ritiro`, `data_entrata_merce`, `data_ritiro`, `data_ritorno`, `acquistato`, `quantita_richiesta`) VALUES
('2019-04-09 11:11:48', 'cane', 2, 98, 'a@a.a', NULL, NULL, NULL, NULL, b'0', 2),
('2019-04-09 09:48:06', 'cane', 2, 98, 'b@b.b', NULL, NULL, NULL, NULL, b'0', 1),
('2019-04-09 15:46:55', 'cane', 2, 98, 'giairo.mauro@samtrevano.ch', NULL, NULL, NULL, NULL, b'0', 1),
('2019-04-09 11:10:48', 'corda corta', 10, 114, 'a@a.a', NULL, NULL, NULL, NULL, b'0', 1),
('2019-04-09 09:48:04', 'corda corta', 10, 114, 'b@b.b', NULL, NULL, NULL, NULL, b'0', 1),
('2019-04-09 09:48:05', 'Ketchup hunts', 15, 104, 'b@b.b', NULL, NULL, NULL, NULL, b'0', 1),
('2019-04-09 09:48:08', 'Lego classic', 50, 117, 'b@b.b', NULL, NULL, NULL, NULL, b'0', 1),
('2019-04-09 09:48:10', 'Mele verdi da 6', 4, 101, 'b@b.b', NULL, NULL, NULL, NULL, b'0', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `gestore`
--

CREATE TABLE `gestore` (
  `email` varchar(50) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `gestore`
--

INSERT INTO `gestore` (`email`, `nome`, `cognome`, `password`, `telefono`) VALUES
('giairo.mauro@gmail.com', 'Giairo', 'Mauro', 'b109f3bbbc244eb82441917ed06d618b9008dd09b3befd1b5e07394c706a8bb980b1d7785e5976ec049b46df5f1326af5a2ea6d103fd07c95385ffab0cacbc86', '123 456 78 90'),
('gino.scarpa@gmail.com', 'Gino', 'Scarpa', 'b109f3bbbc244eb82441917ed06d618b9008dd09b3befd1b5e07394c706a8bb980b1d7785e5976ec049b46df5f1326af5a2ea6d103fd07c95385ffab0cacbc86', '1234567890'),
('q@q.w', 'qwe', 'qwe', '1d9bbc287b32013d699d4f53351af1c670041d78eacb7ee5a9e44fa092b5d1b9a8a7bbe6329a3a4536d512e56c4d73c5286d564a0b983976e1ca6b3f73bf2329', '123'),
('s.pamo@gmail.com', 'Salvatore', 'Pamino', 'def9ca24ad7484509daf431e3d100a0026fb57b9481b924cc1e25a7366b5ec71318155f42df70e26f296d8fa0f556aceb87502a0ba4aa679485079f9e4659cdf', '+41792380139');

-- --------------------------------------------------------

--
-- Struttura della tabella `luogo_ritiro`
--

CREATE TABLE `luogo_ritiro` (
  `id` int(11) NOT NULL,
  `indirizzo` varchar(50) NOT NULL,
  `citta` varchar(50) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `luogo_ritiro`
--

INSERT INTO `luogo_ritiro` (`id`, `indirizzo`, `citta`, `nome`, `telefono`, `email`) VALUES
(1, 'Via gelsomino 1', 'Lugano', 'Ritira tutto', '0912839482', 'ritutto@gmail.com'),
(3, 'Via cantonale', 'Maroggia', 'cose cosi', '0915555555', 'cosette@cosi.ch');

-- --------------------------------------------------------

--
-- Struttura della tabella `negozio`
--

CREATE TABLE `negozio` (
  `nome` varchar(50) NOT NULL,
  `indirizzo` varchar(50) NOT NULL,
  `citta` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `archiviato` bit(1) DEFAULT b'0',
  `email_gestore` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `negozio`
--

INSERT INTO `negozio` (`nome`, `indirizzo`, `citta`, `telefono`, `archiviato`, `email_gestore`) VALUES
('Moreno dove tutto costa meno', 'Via campana 5', 'Lugano', '+410914567738', b'1', 's.pamo@gmail.com'),
('NegoziettoBello', 'Via ginevra 74', 'Lugano', '+41 91 239 13 43', b'1', 'giairo.mauro@gmail.com'),
('qwe', 'qweq', 'we', '123', b'0', 'q@q.w'),
('Super negozio', 'via gelsomino 2', 'Bellinzona', '1234567890', b'1', 'gino.scarpa@gmail.com'),
('Vestiti e altro', 'Via ginepro 33', 'Zurigo', '0918293812', b'1', 'giairo.mauro@gmail.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotto`
--

CREATE TABLE `prodotto` (
  `nome` varchar(50) NOT NULL,
  `prezzo` float NOT NULL DEFAULT '0',
  `quantita` int(11) NOT NULL,
  `nome_categoria` varchar(50) DEFAULT NULL,
  `img` varchar(100) DEFAULT 'application/img/blankImg.png',
  `percentuale_sito` float DEFAULT '10'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `prodotto`
--

INSERT INTO `prodotto` (`nome`, `prezzo`, `quantita`, `nome_categoria`, `img`, `percentuale_sito`) VALUES
('cane', 2, 98, NULL, 'application/img/blankImg.png', 0),
('corda corta', 10, 114, 'giochi', 'application/img/corda.jpg', 10),
('Ketchup hunts', 15, 104, 'cibo', 'application/img/ketchup_hunt_24oz.png', 10),
('Lasagne surgelate 4 salti in padella', 30, 10, 'cibo', 'application/img/LASAGNE congelate 4 salti in padellapng.png', 10),
('Lego classic', 50, 117, 'giochi', 'application/img/legoClassic.jpg', 0),
('Mele verdi da 6', 4, 101, 'cibo', 'application/img/mele-verdi-6.jpg', 0),
('pollo arrosto', 38, 104, 'cibo', 'application/img/pollo_arrosto_paolopolli.jpg', 10),
('Rugby', 25, 105, 'cibo', 'application/img/rugby.png', 10);

-- --------------------------------------------------------

--
-- Struttura della tabella `vende`
--

CREATE TABLE `vende` (
  `nome_prodotto` varchar(50) NOT NULL DEFAULT '',
  `prezzo_prodotto` float NOT NULL DEFAULT '0',
  `quantita_prodotto` int(11) NOT NULL DEFAULT '0',
  `nome_negozio` varchar(50) NOT NULL DEFAULT '',
  `indirizzo_negozio` varchar(50) NOT NULL DEFAULT '',
  `citta_negozio` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `vende`
--

INSERT INTO `vende` (`nome_prodotto`, `prezzo_prodotto`, `quantita_prodotto`, `nome_negozio`, `indirizzo_negozio`, `citta_negozio`) VALUES
('corda corta', 10, 114, 'NegoziettoBello', 'Via ginevra 74', 'Lugano'),
('Ketchup hunts', 15, 104, 'NegoziettoBello', 'Via ginevra 74', 'Lugano'),
('Lasagne surgelate 4 salti in padella', 30, 10, 'NegoziettoBello', 'Via ginevra 74', 'Lugano'),
('Lego classic', 50, 117, 'NegoziettoBello', 'Via ginevra 74', 'Lugano'),
('Mele verdi da 6', 4, 101, 'NegoziettoBello', 'Via ginevra 74', 'Lugano'),
('pollo arrosto', 38, 104, 'NegoziettoBello', 'Via ginevra 74', 'Lugano'),
('Rugby', 25, 105, 'NegoziettoBello', 'Via ginevra 74', 'Lugano'),
('cane', 2, 98, 'Super negozio', 'Via gelsomino 2', 'Bellinzona'),
('Ketchup hunts', 15, 104, 'Super negozio', 'via gelsomino 2', 'Bellinzona');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `amministratore`
--
ALTER TABLE `amministratore`
  ADD PRIMARY KEY (`email`);

--
-- Indici per le tabelle `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`nome`);

--
-- Indici per le tabelle `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`email`);

--
-- Indici per le tabelle `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`nome_prodotto`,`prezzo_prodotto`,`quantita_prodotto`,`email_cliente`),
  ADD KEY `compra_ibfk_cliente` (`email_cliente`),
  ADD KEY `compra_ibfk_luogo_ritiro` (`id_luogo_ritiro`);

--
-- Indici per le tabelle `gestore`
--
ALTER TABLE `gestore`
  ADD PRIMARY KEY (`email`);

--
-- Indici per le tabelle `luogo_ritiro`
--
ALTER TABLE `luogo_ritiro`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `negozio`
--
ALTER TABLE `negozio`
  ADD PRIMARY KEY (`nome`,`indirizzo`,`citta`),
  ADD KEY `email_gestore` (`email_gestore`);

--
-- Indici per le tabelle `prodotto`
--
ALTER TABLE `prodotto`
  ADD PRIMARY KEY (`nome`,`prezzo`,`quantita`),
  ADD KEY `nome_categoria` (`nome_categoria`);

--
-- Indici per le tabelle `vende`
--
ALTER TABLE `vende`
  ADD PRIMARY KEY (`nome_prodotto`,`prezzo_prodotto`,`quantita_prodotto`,`nome_negozio`,`indirizzo_negozio`,`citta_negozio`),
  ADD KEY `vende_ibfk_negozio` (`nome_negozio`,`indirizzo_negozio`,`citta_negozio`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `luogo_ritiro`
--
ALTER TABLE `luogo_ritiro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_cliente` FOREIGN KEY (`email_cliente`) REFERENCES `cliente` (`email`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_ibfk_luogo_ritiro` FOREIGN KEY (`id_luogo_ritiro`) REFERENCES `luogo_ritiro` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_ibfk_prodotto` FOREIGN KEY (`nome_prodotto`,`prezzo_prodotto`,`quantita_prodotto`) REFERENCES `prodotto` (`nome`, `prezzo`, `quantita`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Limiti per la tabella `negozio`
--
ALTER TABLE `negozio`
  ADD CONSTRAINT `negozio_ibfk_1` FOREIGN KEY (`email_gestore`) REFERENCES `gestore` (`email`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `prodotto`
--
ALTER TABLE `prodotto`
  ADD CONSTRAINT `prodotto_ibfk_1` FOREIGN KEY (`nome_categoria`) REFERENCES `categoria` (`nome`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `vende`
--
ALTER TABLE `vende`
  ADD CONSTRAINT `vende_ibfk_negozio` FOREIGN KEY (`nome_negozio`,`indirizzo_negozio`,`citta_negozio`) REFERENCES `negozio` (`nome`, `indirizzo`, `citta`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `vende_ibfk_prodotto` FOREIGN KEY (`nome_prodotto`,`prezzo_prodotto`,`quantita_prodotto`) REFERENCES `prodotto` (`nome`, `prezzo`, `quantita`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
