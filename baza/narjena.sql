-- MySQL Script generated by MySQL Workbench
-- čet 05 jan 2017 18:52:30 CET
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `eptrgovinatk` ;

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `eptrgovinatk` DEFAULT CHARACTER SET utf8 ;
USE `eptrgovinatk` ;

-- -----------------------------------------------------
-- Table `mydb`.`Uporabnik`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eptrgovinatk`.`Uporabnik` ;

CREATE TABLE IF NOT EXISTS `eptrgovinatk`.`Uporabnik` (
  `idUporabnik` INT NOT NULL AUTO_INCREMENT,
  `ime` VARCHAR(45) NULL,
  `priimek` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `geslo` VARCHAR(1024) NULL,
  `telefon` VARCHAR(45) NULL,
  `naslov` VARCHAR(45) NULL,
  `posta` VARCHAR(45) NULL,
  `vloga_id` INT NULL,
  `aktiven` TINYINT(1) NULL,
  `aktivacija_hash` VARCHAR(1024) NULL,
  `certifikat_id` VARCHAR(1024) NULL,
  PRIMARY KEY (`idUporabnik`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Narocilo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eptrgovinatk`.`Narocilo` ;

CREATE TABLE IF NOT EXISTS `eptrgovinatk`.`Narocilo` (
  `idNarocilo` INT NOT NULL AUTO_INCREMENT,
  `znesek` DOUBLE NULL,
  `status_id` INT NULL,
  `datum_oddaje` DATETIME NULL,
  `datum_potrditve` DATETIME NULL,
  `stranka_id` INT NULL,
  `prodajalec_id` INT NULL,
  PRIMARY KEY (`idNarocilo`),
  INDEX `fk_Narocilo_1_idx` (`stranka_id` ASC),
  INDEX `fk_Narocilo_2_idx` (`prodajalec_id` ASC),
  CONSTRAINT `fk_Narocilo_1`
    FOREIGN KEY (`stranka_id`)
    REFERENCES `eptrgovinatk`.`Uporabnik` (`idUporabnik`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Narocilo_2`
    FOREIGN KEY (`prodajalec_id`)
    REFERENCES `eptrgovinatk`.`Uporabnik` (`idUporabnik`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Log`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eptrgovinatk`.`Log` ;

CREATE TABLE IF NOT EXISTS `eptrgovinatk`.`Log` (
  `idLog` INT NOT NULL AUTO_INCREMENT,
  `uporabnik_id` INT NULL,
  `cas` DATETIME NULL,
  PRIMARY KEY (`idLog`),
  INDEX `fk_Log_1_idx` (`uporabnik_id` ASC),
  CONSTRAINT `fk_Log_1`
    FOREIGN KEY (`uporabnik_id`)
    REFERENCES `eptrgovinatk`.`Uporabnik` (`idUporabnik`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Izdelek`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eptrgovinatk`.`Izdelek` ;

CREATE TABLE IF NOT EXISTS `eptrgovinatk`.`Izdelek` (
  `idIzdelek` INT NOT NULL AUTO_INCREMENT,
  `ime` VARCHAR(45) NULL,
  `opis` VARCHAR(1024) NULL,
  `cena` DOUBLE NULL,
  `aktiven` TINYINT(1) NULL,
  PRIMARY KEY (`idIzdelek`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Postavka`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eptrgovinatk`.`Postavka` ;

CREATE TABLE IF NOT EXISTS `eptrgovinatk`.`Postavka` (
  `narocilo_id` INT NOT NULL,
  `izdelek_id` INT NOT NULL,
  `kolicina` INT NULL,
  PRIMARY KEY (`narocilo_id`, `izdelek_id`),
  INDEX `fk_Postavka_2_idx` (`izdelek_id` ASC),
  CONSTRAINT `fk_Postavka_1`
    FOREIGN KEY (`narocilo_id`)
    REFERENCES `eptrgovinatk`.`Narocilo` (`idNarocilo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Postavka_2`
    FOREIGN KEY (`izdelek_id`)
    REFERENCES `eptrgovinatk`.`Izdelek` (`idIzdelek`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Ocena`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eptrgovinatk`.`Ocena` ;

CREATE TABLE IF NOT EXISTS `eptrgovinatk`.`Ocena` (
  `uporabnik_id` INT NOT NULL,
  `izdelek_id` INT NOT NULL,
  `ocena` INT NULL,
  INDEX `fk_Ocena_1_idx` (`uporabnik_id` ASC),
  INDEX `fk_Ocena_2_idx` (`izdelek_id` ASC),
  PRIMARY KEY (`uporabnik_id`, `izdelek_id`),
  CONSTRAINT `fk_Ocena_1`
    FOREIGN KEY (`uporabnik_id`)
    REFERENCES `eptrgovinatk`.`Uporabnik` (`idUporabnik`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Ocena_2`
    FOREIGN KEY (`izdelek_id`)
    REFERENCES `eptrgovinatk`.`Izdelek` (`idIzdelek`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Slika`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eptrgovinatk`.`Slika` ;

CREATE TABLE IF NOT EXISTS `eptrgovinatk`.`Slika` (
  `idSlika` INT NOT NULL AUTO_INCREMENT,
  `izdelek_id` INT NOT NULL,
  `slika` VARCHAR(1024) NULL,
  PRIMARY KEY (`idSlika`),
  INDEX `fk_Slika_1_idx` (`izdelek_id` ASC),
  CONSTRAINT `fk_Slika_1`
    FOREIGN KEY (`izdelek_id`)
    REFERENCES `eptrgovinatk`.`Izdelek` (`idIzdelek`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;