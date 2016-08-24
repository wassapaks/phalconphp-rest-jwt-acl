CREATE TABLE `dbhcare`.`patientphysician` (
  `idpatientphysician` INT NOT NULL AUTO_INCREMENT,
  `idpatient` VARCHAR(250) NULL,
  `idphysician` VARCHAR(250) NULL,
  PRIMARY KEY (`idpatientphysician`));

