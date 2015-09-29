ALTER TABLE `#__angelgirls_video_sessao` ADD COLUMN  `arquivo` VARCHAR(25);
ALTER TABLE `#__angelgirls_video_sessao` ADD COLUMN  `token` VARCHAR(25);
ALTER TABLE `#__angelgirls_video_sessao` ADD COLUMN  `descricao` TEXT NULL;
ALTER TABLE `#__angelgirls_video_sessao` ADD COLUMN  `meta_descricao` VARCHAR(250) NOT NULL;
ALTER TABLE `#__angelgirls_video_sessao` ADD COLUMN  `ordem` INT;
ALTER TABLE `#__angelgirls_video_sessao` ADD COLUMN  `tipo` ENUM('MAKINGOF','AUTORIZACAOMODELO','OUTRO') DEFAULT 'MAKINGOF';
ALTER TABLE `#__angelgirls_video_sessao` DROP COLUMN makingof;  


CREATE TABLE `#__angelgirls_vt_video_sessao` ( 
	`id_video` INT NOT NULL, 
	`id_usuario` INT NOT NULL, 
	`data_criado` DATETIME NOT NULL,
	`host_ip` varchar(20) NOT NULL,
	FOREIGN KEY (`id_usuario`) REFERENCES `#__users` (`id`),
	PRIMARY KEY(`id_video`,`id_usuario`)
) ENGINE = InnoDB   DEFAULT CHARSET=utf8;