--
-- Struttura della tabella `%PREFIX%restorePassword`
--

CREATE TABLE `%PREFIX%restorePassword` (
  `resID` int(11) NOT NULL,
  `resEmail` varchar(80) NOT NULL,
  `resIP` varchar(15) NOT NULL,
  `resData` datetime NOT NULL,
  `resPubID` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `%PREFIX%Users`
--

CREATE TABLE `%PREFIX%Users` (
  `userID` int(11) NOT NULL,
  `userName` varchar(250) NOT NULL,
  `userPassword` text NOT NULL,
  `userEmail` varchar(80) NOT NULL,
  `oauth_uid` varchar(200) DEFAULT NULL,
  `oauth_provider` varchar(200) DEFAULT NULL,
  `userIP` varchar(15) NOT NULL,
  `userDataReg` datetime NOT NULL,
  `userDataLastLogin` datetime DEFAULT NULL,
  `userStat` enum('0','1') NOT NULL DEFAULT '0',
  `userNewsLetter` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indici per le tabelle `%PREFIX%restorePassword`
--
ALTER TABLE `%PREFIX%restorePassword`
  ADD PRIMARY KEY (`resID`);

--
-- Indici per le tabelle `%PREFIX%Users`
--
ALTER TABLE `%PREFIX%Users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT per la tabella `%PREFIX%restorePassword`
--
ALTER TABLE `%PREFIX%restorePassword`
  MODIFY `resID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT per la tabella `%PREFIX%Users`
--
ALTER TABLE `%PREFIX%Users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

UPDATE `%PREFIX%system` SET `system_sql`= 2 WHERE `system_sql`= 1;