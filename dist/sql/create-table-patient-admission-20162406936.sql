CREATE TABLE `dbhcare`.`patientadmission` (
  `idpatientadmission` INT NOT NULL AUTO_INCREMENT,
  `idpatient` VARCHAR(250) NULL,
  `socDate` DATE NULL,
  `epType` VARCHAR(10) NULL,
  `episodeStartDate` DATE NULL,
  `episodeEndDate` DATE NULL,
  `dateCreated` DATE NULL,
  `dateUpdated` TIMESTAMP NOT NULL,
  PRIMARY KEY (`idpatientadmission`));

