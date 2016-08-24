
ALTER TABLE `dbhcare`.`members`
ADD COLUMN `permission` INT NULL AFTER `dateedited`,
ADD COLUMN `userLevel` CHAR(10) NULL AFTER `permission`;