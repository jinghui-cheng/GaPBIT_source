USE users;
CREATE TABLE IF NOT EXISTS `UserPatterns` (
  `Username` VARCHAR(15) NOT NULL,
  `PatternID` CHAR(10) NOT NULL,
  PRIMARY KEY (`Username`, `PatternID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
