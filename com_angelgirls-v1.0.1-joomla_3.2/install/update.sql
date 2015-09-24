CREATE TABLE `#__angelgirls_video_sessao` (
	`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`titulo` VARCHAR(250) NOT NULL ,
	`id_sessao` INT NOT NULL, 
	`url_youtube` VARCHAR(250),
	`id_youtube` VARCHAR(250),
	`id_vimeo` VARCHAR(250),
	`url_vimeo` VARCHAR(250),
	`makingof` ENUM('S','N') DEFAUL 'S',
	`status_dado` VARCHAR(25) DEFAULT 'NOVO',
	`id_usuario_criador` INT NOT NULL , 
	`id_usuario_alterador` INT NOT NULL , 
	`data_criado` DATETIME NOT NULL, 
	`data_alterado` DATETIME NOT NULL,
	`host_ip_criador` varchar(20) NOT NULL,
	`host_ip_alterador` varchar(20) NULL,
	FOREIGN KEY (`id_usuario_criador`) REFERENCES `#__users` (`id`),
	FOREIGN KEY (`id_usuario_alterador`) REFERENCES `#__users` (`id`),
	FOREIGN KEY (`id_sessao`) REFERENCES `#__angelgirls_sessao` (`id`)
) ENGINE = InnoDB   DEFAULT CHARSET=utf8;



ALTER TABLE `#__angelgirls_fotografo` ADD COLUMN `foto_documento` VARCHAR(100);
ALTER TABLE `#__angelgirls_fotografo` ADD COLUMN `foto_comp_residencia` VARCHAR(100);
ALTER TABLE `#__angelgirls_fotografo` ADD COLUMN `status_documento` VARCHAR(20);
ALTER TABLE `#__angelgirls_fotografo` ADD COLUMN `status_comp_residencia` VARCHAR(20);

ALTER TABLE `#__angelgirls_modelo` ADD COLUMN `foto_documento` VARCHAR(100);
ALTER TABLE `#__angelgirls_modelo` ADD COLUMN `foto_comp_residencia` VARCHAR(100);
ALTER TABLE `#__angelgirls_modelo` ADD COLUMN `status_documento` VARCHAR(20);
ALTER TABLE `#__angelgirls_modelo` ADD COLUMN `status_comp_residencia` VARCHAR(20);]

ALTER TABLE `#__angelgirls_modelo` ADD COLUMN `pontos` bigint DEFAULT 0;
ALTER TABLE `#__angelgirls_fotografo` ADD COLUMN `pontos` bigint DEFAULT 0;
ALTER TABLE `#__angelgirls_visitante` ADD COLUMN `pontos` bigint DEFAULT 0;


ALTER TABLE `#__angelgirls_sessao` ADD COLUMN  `tipo` enum('VENDA','PONTOS','PATROCINIO','LEILAO')  DEFAULT 'VENDA';