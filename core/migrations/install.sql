CREATE TABLE `gaia`.`%PREFIX%system` ( `system_name` VARCHAR(30) NOT NULL , `system_tmp` VARCHAR(15) NOT NULL , `system_sub_desc` TEXT NOT NULL , `system_close` ENUM('1', '0') NOT NULL DEFAULT '0' , `system_sql` SMALLINT(5) NOT NULL ) ENGINE = InnoDB;