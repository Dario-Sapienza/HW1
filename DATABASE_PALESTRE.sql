-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 24, 2021 alle 20:17
-- Versione del server: 10.4.14-MariaDB
-- Versione PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `palestre`
--

DELIMITER $$
--
-- Procedure
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `aaa` (IN `palestra` VARCHAR(255))  begin
       select pe.nome as nome , pe.cognome as cognome
       from (((((((palestra p join plesso pl on p.codice = pl.cod_palestra)
             join sala s on s.cod_plesso = pl.codice)
			join sostenuto so on so.cod_sala = s.codice)
            join corso c on c.codice = so.cod_corso)
            join frequenza f on f.corso = c.codice)
            join persona pe on pe.cod_fiscale = f.persona)
            join abbonato a on a.cf = pe.cod_fiscale)
       where (p.nome = palestra and pe.eta > 21 and pe.eta < 30);  
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `operazione1` (IN `nome_corso` VARCHAR(255))  begin

     select cf, nome, cognome, eta, data_nascita
     from visualizza_corsi_singoli
     where corso = nome_corso;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `operazione2` (IN `nome_palestra` VARCHAR(255))  begin
     drop table if exists tmp;
     create temporary table tmp
     (
     id_istruttore integer,
     nome varchar(255),
     cognome varchar(255),
     data_inizio date,
     data_fine date,
     stato_impiego varchar(255),
     numero_impieghi integer
     );
     insert into tmp
     select i.id as id_istruttore, i.nome as nome, i.cognome as cognome, l.data_inizio as data_inizio_impiego,
				l.data_fine as data_fine_impiego, l.tipo as stato_impiego, count(c.codice) as numero_impieghi
     from (((palestra p join lavora l on p.codice = l.cod_palestra) 
                      join istruttore i on l.id_istruttore = i.id)
                      join corso c on c.id_istruttore = i.id)
     where nome_palestra = p.nome
     group by i.id;

select * from tmp; 
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `operazione3` (IN `sala` INTEGER, IN `plesso` INTEGER, IN `nome` VARCHAR(255), IN `marca` VARCHAR(255), IN `tipo_attrezzo` VARCHAR(255))  begin 
if not exists(select* from attrezzo where cod_sala = sala and codice_plesso = plesso and tipo = tipo_attrezzo)  
then
insert into attrezzo values('',sala,plesso,nome,marca,tipo_attrezzo);
else 
signal sqlstate '45000' set message_text ='ATTREZZO DI QUESTO TIPO GIA PRESENTE IN QUESTA SALA';
end if;
		
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `operazione4` (IN `palestra` VARCHAR(255))  begin
	select s.nome as nome_sala
    from (((palestra p join plesso pl on p.codice = pl.cod_palestra)
		join sala s on s.cod_plesso = pl.codice)
        join attrezzo a on a.cod_sala = s.codice and a.codice_plesso = s.cod_plesso)
    where p.nome = palestra and s.codice in (select codice_sala
                                            from conta_attrezzi
											where numero_attrezzi = (select max(numero_attrezzi )
                                            from conta_attrezzi c join palestra p on p.codice = c.codice_palestra
                                            where p.nome = palestra));
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `verifica_corso_singolo` (IN `nome_corso` VARCHAR(255))  begin

     select cf, nome, cognome, eta, data_nascita
     from visualizza_corsi_singoli
     where corso = nome_corso;

end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `abbonato`
--

CREATE TABLE `abbonato` (
  `cf` varchar(255) NOT NULL,
  `cod_tessera` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `abbonato`
--

INSERT INTO `abbonato` (`cf`, `cod_tessera`) VALUES
('MSNFDR', 111),
('SPNDRA', 333);

-- --------------------------------------------------------

--
-- Struttura della tabella `attrezzo`
--

CREATE TABLE `attrezzo` (
  `codice` int(11) NOT NULL,
  `cod_sala` int(11) DEFAULT NULL,
  `codice_plesso` int(11) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `attrezzo`
--

INSERT INTO `attrezzo` (`codice`, `cod_sala`, `codice_plesso`, `nome`, `marca`, `tipo`) VALUES
(1, 1, 1, 'tapis roulan', 'TecnoGym', 'CARDIO'),
(2, 1, 1, 'manubri', 'Wellness', 'BODY-BUILDING'),
(3, 3, 2, 'cyclette', 'TecnoGym', 'CARDIO'),
(4, 2, 4, 'panca piana', 'OmniaGym', 'BODY-BUILDING'),
(5, 5, 3, 'sbarra per trazioni', 'OmniaGym', 'BODY-BUILDING'),
(6, 1, 1, 'Elastico', 'Wellness', 'BODY-BUILDING');

-- --------------------------------------------------------

--
-- Struttura della tabella `azioni_news`
--

CREATE TABLE `azioni_news` (
  `utente` varchar(255) DEFAULT NULL,
  `titolo` varchar(255) DEFAULT NULL,
  `indirizzo` varchar(1023) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `conta_attrezzi`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `conta_attrezzi` (
`codice_palestra` int(11)
,`codice_sala` int(11)
,`numero_attrezzi` bigint(21)
);

-- --------------------------------------------------------

--
-- Struttura della tabella `corso_singolo`
--

CREATE TABLE `corso_singolo` (
  `cf` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `corso_singolo`
--

INSERT INTO `corso_singolo` (`cf`) VALUES
('SCNVNI'),
('SPTENC'),
('VNCLEI');

-- --------------------------------------------------------

--
-- Struttura della tabella `istruttore`
--

CREATE TABLE `istruttore` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `cognome` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `istruttore`
--

INSERT INTO `istruttore` (`id`, `nome`, `cognome`) VALUES
(1, 'Pippo', 'Franco'),
(2, 'Dusan', 'Mandic'),
(3, 'Oriana', 'Aprile'),
(4, 'Lino', 'Banfi'),
(5, 'Pino', 'Daniele'),
(6, 'Pi', 'Fco');

-- --------------------------------------------------------

--
-- Struttura della tabella `nuove_affiliazioni`
--

CREATE TABLE `nuove_affiliazioni` (
  `indirizzo` varchar(1023) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `nuove_affiliazioni`
--

INSERT INTO `nuove_affiliazioni` (`indirizzo`, `nome`) VALUES
('fit-active.jpg', 'FIT-ACTIVE'),
('fitness-club.jpg', 'FITNESS CLUB'),
('primo-round.jpg', 'PRIMO ROUND'),
('neo-fit.jpg', 'NEO-FIT'),
('world-of-fitness.jpg', 'WORLD OF FITNESS'),
('next-fit.jpg', 'NEXT-FIT');

-- --------------------------------------------------------

--
-- Struttura della tabella `palestra`
--

CREATE TABLE `palestra` (
  `codice` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `immagine` varchar(1023) DEFAULT NULL,
  `descrizione` varchar(1023) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `palestra`
--

INSERT INTO `palestra` (`codice`, `nome`, `immagine`, `descrizione`) VALUES
(1, 'CUS CATANIA', 'CUS.jpg', 'SALA PESI, SALA CARDIO, SALA BOXE, PISTA DI ATLETICA, CAMPO DA CALCIO/RUGBY, CAMPI DA BEACH VOLLEY, CAMPO DA TENNIS, CAMPO DA BASKET'),
(2, 'ALTAIR CLUB', 'altair.jpg', 'PISCINA, SALA CALISTHENICS'),
(3, 'MC-FIT', 'mc-fit.jpg', 'SALA PESI, SALA CARDIO, SALA CYCLING, SALA BOXE'),
(4, 'ONE-FIT', 'one-fit.jpg', 'SALA PESI, SALA YOGA'),
(5, 'TORRE DEL GRIFO VILLAGE', 'tdg.jpg', 'SALA PESI, SALA CARDIO, PISCINA, SPA, CAMPI DA CALCIO'),
(6, 'ATHLETIC CLUB', 'atl-club.jpg', 'SALA PESI, SALA CARDIO, CAMPO DA BASKET'),
(7, 'VIRGIN ACTIVE', 'virgin.jpg', 'SALA PESI, SALA FIT-BOXE, SALA CYCLING, SPA'),
(8, 'SPORTING CENTER', 'sporting-center.jpg', 'SALA PESI, PISCINA, CAMPO DA PALLAVOLO/BASKET, CAMPO DA TENNIS'),
(9, 'STONE PERSONAL', 'stone-personal.jpg', 'SALA PESI');

-- --------------------------------------------------------

--
-- Struttura della tabella `persona`
--

CREATE TABLE `persona` (
  `cod_fiscale` varchar(255) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `cognome` varchar(255) DEFAULT NULL,
  `eta` int(11) DEFAULT NULL,
  `data_nascita` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `persona`
--

INSERT INTO `persona` (`cod_fiscale`, `nome`, `cognome`, `eta`, `data_nascita`) VALUES
('MSNFDR', 'Federica', 'Messina', 22, '1998-08-17'),
('SCNVNI', 'Ivan', 'Scandura', 23, '1997-09-08'),
('SPNDRA', 'Dario', 'Sapienza', 23, '1998-05-23'),
('SPTENC', 'Enrica', 'Spataro', 21, '1999-06-29'),
('VNCLEI', 'Elio', 'Vinciguerra', 21, '2000-01-13');

--
-- Trigger `persona`
--
DELIMITER $$
CREATE TRIGGER `calcola_eta_persona` BEFORE INSERT ON `persona` FOR EACH ROW begin
set new.eta = (datediff(current_date(),new.data_nascita)/365);

end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `plesso`
--

CREATE TABLE `plesso` (
  `codice` int(11) NOT NULL,
  `cod_palestra` int(11) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `indirizzo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `plesso`
--

INSERT INTO `plesso` (`codice`, `cod_palestra`, `nome`, `indirizzo`) VALUES
(1, 1, 'Cittadella', 'Via Santa Sofia'),
(2, 1, 'Porto', 'Via Dusmet'),
(3, 2, 'Bellini', 'Via Etnea'),
(4, 5, 'Mascara', 'Via Marconi'),
(5, 3, 'Bryant', 'Via Umberto');

-- --------------------------------------------------------

--
-- Struttura della tabella `preferiti`
--

CREATE TABLE `preferiti` (
  `utente` varchar(255) DEFAULT NULL,
  `codice_palestra` int(11) DEFAULT NULL,
  `nome_palestra` varchar(255) DEFAULT NULL,
  `immagine` varchar(1023) DEFAULT NULL,
  `descrizione` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `preferiti`
--

INSERT INTO `preferiti` (`utente`, `codice_palestra`, `nome_palestra`, `immagine`, `descrizione`) VALUES
('pippomale', 2, 'ALTAIR CLUB', ' altair.jpg', 'PISCINA, SALA CALISTHENICS'),
('pippomale', 5, 'TORRE DEL GRIGO VILLAGE', ' tdg.jpg', 'SALA PESI, SALA CARDIO, PISCINA, SPA, CAMPI DA CALCIO'),
('pippomale', 7, 'VIRGIN ACTIVE', ' virgin.jpg', 'SALA PESI, SALA FIT-BOXE, SALA CYCLING, SPA');

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazione_corso`
--

CREATE TABLE `prenotazione_corso` (
  `codice` int(11) NOT NULL,
  `palestra` int(11) NOT NULL,
  `corso` varchar(255) DEFAULT NULL,
  `cognome` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `prenotazione_corso`
--

INSERT INTO `prenotazione_corso` (`codice`, `palestra`, `corso`, `cognome`, `username`) VALUES
(4, 7, 'ZUMBA', 'Capecchi', 'Kosky'),
(12, 7, 'CROSSFIT', 'Aprile', 'oria97'),
(13, 6, 'PILATES', 'Aprile', 'oria97'),
(16, 4, 'AERO-TONE', 'Aprile', 'ivAno'),
(17, 4, 'PILATES', 'smith', 'willsmith'),
(18, 7, 'AERO-TONE', 'Aprile', 'oria97');

-- --------------------------------------------------------

--
-- Struttura della tabella `sala`
--

CREATE TABLE `sala` (
  `codice` int(11) NOT NULL,
  `cod_plesso` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `sala`
--

INSERT INTO `sala` (`codice`, `cod_plesso`, `nome`) VALUES
(1, 1, 'SALA1'),
(2, 4, 'SALA2'),
(3, 2, 'SALA3'),
(4, 5, 'SALA4'),
(5, 3, 'SALA5');

-- --------------------------------------------------------

--
-- Struttura della tabella `turno`
--

CREATE TABLE `turno` (
  `codice` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `ora` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `turno`
--

INSERT INTO `turno` (`codice`, `data`, `ora`) VALUES
(1, '2020-12-21', '15:00:00'),
(2, '2020-12-21', '17:00:00'),
(3, '2020-12-25', '09:00:00'),
(4, '2020-12-28', '19:00:00'),
(5, '2020-12-28', '13:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `username` varchar(255) NOT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `cognome` varchar(255) DEFAULT NULL,
  `eta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`username`, `mail`, `password`, `nome`, `cognome`, `eta`) VALUES
('Eleonoraspataro', 'spataroeleonora29@gmail.com', '$2y$10$dKcU1HYbMt57aynvsuUaDu1iB31.9ORhi/EnLT7qRb7DOfXlbXHvO', 'Eleonora', 'Spataro', 19),
('giu99', 'giulia.v@gmail.com', '$2y$10$.fRA7cydwexVS2K6C72M0uwL97WcWmmZg3l93QK9VXL2FrnR15AeC', 'Giulia', 'Vitaliti', 23),
('ivAno', 'ivanoo@gmail.com', '$2y$10$bB1rZ/oRq0i9PFFq8nWntO4nj6WrTar0pMLL4bKhhECTQrj5Vy2Xe', 'Ivan', 'Aprile', 67),
('Kosky', 'koskyobeso@gmail.com', '$2y$10$TBMptPInhB.3Dx0AGV5teu2Cj4odozMs75wVXGGehgMn87sZnQB/q', 'Enrico', 'Capecchi', 90),
('marros', 'mar@gmail.com', '$2y$10$GHvfmJioLYmNezTYygkUIePIVk3S8KoqzElkBTH0ElUxtWvKMDZfW', 'Mario', 'Rossi', 53),
('oria97', 'ori@outlook.it', '$2y$10$C0TPOMZai7GV67jrXccP1OzniMDE01hGLGMQ5gwj4ekVNQ5QAqpN6', 'Oriana', 'Aprile', 23),
('willsmith', 'ws@gmail.com', '$2y$10$SEZ4fj2in1twjkwptWikdOvfZAsQkpQfqe3ULsRKAJdAiohfbCeBm', 'willian', 'smith', 33);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `visualizza_corsi_singoli`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `visualizza_corsi_singoli` (
);

-- --------------------------------------------------------

--
-- Struttura per vista `conta_attrezzi`
--
DROP TABLE IF EXISTS `conta_attrezzi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `conta_attrezzi`  AS SELECT `pa`.`codice` AS `codice_palestra`, `a`.`cod_sala` AS `codice_sala`, count(0) AS `numero_attrezzi` FROM (((`attrezzo` `a` join `sala` `s` on(`a`.`codice_plesso` = `s`.`cod_plesso` and `a`.`cod_sala` = `s`.`codice`)) join `plesso` `p` on(`s`.`cod_plesso` = `p`.`codice`)) join `palestra` `pa` on(`p`.`cod_palestra` = `pa`.`codice`)) GROUP BY `a`.`cod_sala` ;

-- --------------------------------------------------------

--
-- Struttura per vista `visualizza_corsi_singoli`
--
DROP TABLE IF EXISTS `visualizza_corsi_singoli`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `visualizza_corsi_singoli`  AS SELECT `p`.`cod_fiscale` AS `cf`, `p`.`nome` AS `nome`, `p`.`cognome` AS `cognome`, `p`.`eta` AS `eta`, `p`.`data_nascita` AS `data_nascita`, `c`.`tipologia` AS `corso` FROM (((`frequenza` `f` join `corso` `c` on(`f`.`corso` = `c`.`codice` and `f`.`istruttore` = `c`.`id_istruttore`)) join `persona` `p` on(`f`.`persona` = `p`.`cod_fiscale`)) join `corso_singolo` `cs` on(`p`.`cod_fiscale` = `cs`.`cf`)) ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `abbonato`
--
ALTER TABLE `abbonato`
  ADD PRIMARY KEY (`cf`),
  ADD KEY `idx_cf` (`cf`);

--
-- Indici per le tabelle `attrezzo`
--
ALTER TABLE `attrezzo`
  ADD PRIMARY KEY (`codice`),
  ADD KEY `idx1_sala` (`cod_sala`),
  ADD KEY `idx2_plesso` (`codice_plesso`),
  ADD KEY `cod_sala` (`cod_sala`,`codice_plesso`);

--
-- Indici per le tabelle `corso_singolo`
--
ALTER TABLE `corso_singolo`
  ADD PRIMARY KEY (`cf`),
  ADD KEY `idx1_cf` (`cf`);

--
-- Indici per le tabelle `istruttore`
--
ALTER TABLE `istruttore`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `palestra`
--
ALTER TABLE `palestra`
  ADD PRIMARY KEY (`codice`);

--
-- Indici per le tabelle `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`cod_fiscale`);

--
-- Indici per le tabelle `plesso`
--
ALTER TABLE `plesso`
  ADD PRIMARY KEY (`codice`),
  ADD KEY `idx_palestra` (`cod_palestra`);

--
-- Indici per le tabelle `prenotazione_corso`
--
ALTER TABLE `prenotazione_corso`
  ADD PRIMARY KEY (`codice`) USING BTREE,
  ADD KEY `idx_pal` (`palestra`);

--
-- Indici per le tabelle `sala`
--
ALTER TABLE `sala`
  ADD PRIMARY KEY (`codice`,`cod_plesso`),
  ADD KEY `idx_plesso` (`cod_plesso`);

--
-- Indici per le tabelle `turno`
--
ALTER TABLE `turno`
  ADD PRIMARY KEY (`codice`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `attrezzo`
--
ALTER TABLE `attrezzo`
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `istruttore`
--
ALTER TABLE `istruttore`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `palestra`
--
ALTER TABLE `palestra`
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `plesso`
--
ALTER TABLE `plesso`
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `prenotazione_corso`
--
ALTER TABLE `prenotazione_corso`
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT per la tabella `sala`
--
ALTER TABLE `sala`
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `turno`
--
ALTER TABLE `turno`
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `abbonato`
--
ALTER TABLE `abbonato`
  ADD CONSTRAINT `abbonato_ibfk_1` FOREIGN KEY (`cf`) REFERENCES `persona` (`cod_fiscale`);

--
-- Limiti per la tabella `attrezzo`
--
ALTER TABLE `attrezzo`
  ADD CONSTRAINT `attrezzo_ibfk_1` FOREIGN KEY (`cod_sala`,`codice_plesso`) REFERENCES `sala` (`codice`, `cod_plesso`);

--
-- Limiti per la tabella `corso_singolo`
--
ALTER TABLE `corso_singolo`
  ADD CONSTRAINT `corso_singolo_ibfk_1` FOREIGN KEY (`cf`) REFERENCES `persona` (`cod_fiscale`);

--
-- Limiti per la tabella `plesso`
--
ALTER TABLE `plesso`
  ADD CONSTRAINT `plesso_ibfk_1` FOREIGN KEY (`cod_palestra`) REFERENCES `palestra` (`codice`);

--
-- Limiti per la tabella `prenotazione_corso`
--
ALTER TABLE `prenotazione_corso`
  ADD CONSTRAINT `prenotazione_corso_ibfk_1` FOREIGN KEY (`palestra`) REFERENCES `palestra` (`codice`);

--
-- Limiti per la tabella `sala`
--
ALTER TABLE `sala`
  ADD CONSTRAINT `sala_ibfk_1` FOREIGN KEY (`cod_plesso`) REFERENCES `plesso` (`codice`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
