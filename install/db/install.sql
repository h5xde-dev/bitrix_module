CREATE TABLE IF NOT EXISTS `currencies` ( 
    `id` INT NOT NULL AUTO_INCREMENT ,
    `code` VARCHAR(255) NOT NULL ,
    `value` TEXT NOT NULL ,
    `date_update` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
    PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;