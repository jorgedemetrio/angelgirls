CREATE TABLE `#__angelgirls_vt_visitante` ( 
	`id_visitante` INT NOT NULL, 
	`id_usuario` INT NOT NULL, 
	`data_criado` DATETIME NOT NULL,
	`host_ip` varchar(20) NOT NULL,
	FOREIGN KEY (`id_usuario`) REFERENCES `#__users` (`id`),
	PRIMARY KEY(`id_visitante`,`id_usuario`)
) ENGINE = InnoDB   DEFAULT CHARSET=utf8;