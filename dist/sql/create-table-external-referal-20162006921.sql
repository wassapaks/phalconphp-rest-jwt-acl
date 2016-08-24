CREATE TABLE `dbhcare`.`externalreferal` (
  `idexternalreferal` VARCHAR(250) NOT NULL,
  `name` VARCHAR(250) NULL,
  `address` VARCHAR(250) NULL,
  `addressTwo` VARCHAR(250) NULL,
  `city` VARCHAR(45) NULL,
  `fax` VARCHAR(45) NULL,
  `internalReferral` VARCHAR(45) NULL,
  `datecreated` DATE NULL,
  `dateupdated` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idexternalreferal`));

