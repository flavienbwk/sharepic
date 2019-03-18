-- MySQL Script generated by MySQL Workbench
-- Mon Mar 18 18:52:49 2019
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`User` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ids` VARCHAR(45) NOT NULL,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `first_name` VARCHAR(45) NULL,
  `last_name` VARCHAR(45) NULL,
  `registered_at` DATETIME NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Avatar`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Avatar` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `local_uri` VARCHAR(255) NOT NULL,
  `added_at` DATETIME NOT NULL,
  `User_id` INT NOT NULL,
  PRIMARY KEY (`id`, `User_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Publication`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Publication` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ids` VARCHAR(45) NOT NULL,
  `description` TEXT NULL,
  `created_at` DATETIME NOT NULL,
  `geolocation` VARCHAR(45) NULL,
  `User_id` INT NOT NULL,
  PRIMARY KEY (`id`, `User_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Photo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Photo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `local_uri` VARCHAR(45) NOT NULL,
  `order` INT NOT NULL DEFAULT 0,
  `fingerprint` VARCHAR(255) NOT NULL,
  `Publication_id` INT NOT NULL,
  PRIMARY KEY (`id`, `Publication_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Comment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Comment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `text` TEXT NOT NULL,
  `added_at` DATETIME NOT NULL,
  `Publication_id` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Reaction`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Reaction` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `image_uri` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Publication_Reaction`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Publication_Reaction` (
  `Publication_id` INT NOT NULL,
  `User_id` INT NOT NULL,
  `reacted_at` DATETIME NOT NULL,
  `Reaction_id` INT NOT NULL,
  PRIMARY KEY (`Publication_id`, `User_id`, `Reaction_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Subscription`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Subscription` (
  `Subscribed_User_id` INT NOT NULL,
  `Subscriber_User_id` INT NOT NULL,
  `subscribed_at` DATETIME NOT NULL,
  PRIMARY KEY (`Subscribed_User_id`, `Subscriber_User_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Conversation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Conversation` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Conversation_has_User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Conversation_has_User` (
  `User_id` INT NOT NULL,
  `Conversation_id` INT NOT NULL,
  `added_at` DATETIME NOT NULL,
  PRIMARY KEY (`User_id`, `Conversation_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Message`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Message` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `value` VARCHAR(45) NULL,
  `Conversation_id` INT NOT NULL,
  `User_id` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Connection`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Connection` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `expires_at` DATETIME NOT NULL,
  `ip` VARCHAR(45) NULL,
  `User_id` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Notification`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Notification` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `message` VARCHAR(255) NOT NULL,
  `Publication_id` INT NULL,
  `Target_User_id` INT NULL,
  `seen` TINYINT NOT NULL DEFAULT 0,
  `User_id` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
