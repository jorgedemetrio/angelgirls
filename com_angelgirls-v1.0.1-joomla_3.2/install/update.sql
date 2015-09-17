DROP TABLE `#__angelgirls_galeria`;
DROP TABLE `#__angelgirls_foto_galeria`;
DROP TABLE `#__angelgirls_vt_foto_galeria`;





CREATE TABLE `#__angelgirls_album` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`titulo` VARCHAR(250) NOT NULL UNIQUE, 
		
		`id_foto_capa` varchar(100)  NULL,
		
		`executada` DATE NOT NULL, 
		`descricao` TEXT NULL , 
		`meta_descricao` VARCHAR(250) NOT NULL , 
		
		`audiencia_gostou` INT DEFAULT 0,
		`audiencia_ngostou` INT DEFAULT 0,
		`audiencia_view` INT DEFAULT 0,
		
		`publicar` DATE NOT NULL,
		`status_dado` VARCHAR(25) DEFAULT 'NOVO',
		`id_usuario_criador` INT NOT NULL , 
		`id_usuario_alterador` INT NOT NULL , 
		`data_criado` DATETIME NOT NULL  , 
		`data_alterado` DATETIME NOT NULL ,
		FOREIGN KEY (`id_usuario_criador`) REFERENCES `#__users` (`id`),
		FOREIGN KEY (`id_usuario_alterador`) REFERENCES `#__users` (`id`)
) ENGINE = InnoDB   DEFAULT CHARSET=utf8;

CREATE  INDEX album_usuario_criador_idx ON `#__angelgirls_album`(`id_usuario_criador`);

CREATE TABLE `#__angelgirls_foto_album` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`titulo` VARCHAR(250) NOT NULL, 
		`token` VARCHAR(250) NOT NULL,
		`nome_arquivo` VARCHAR(250) NOT NULL,
		`descricao` TEXT NULL , 
		`meta_descricao` VARCHAR(250) NOT NULL, 
		`id_album` INT NOT NULL,
		`ordem` INT,
		`audiencia_gostou` INT DEFAULT 0,
		`audiencia_ngostou` INT DEFAULT 0,
		`audiencia_view` INT DEFAULT 0,
		`status_dado` VARCHAR(25) DEFAULT 'NOVO',
		`id_usuario_criador` INT NOT NULL , 
		`id_usuario_alterador` INT NOT NULL , 
		`data_criado` DATETIME NOT NULL  , 
		`data_alterado` DATETIME NOT NULL,
		FOREIGN KEY (`id_usuario_criador`) REFERENCES `#__users` (`id`),
		FOREIGN KEY (`id_usuario_alterador`) REFERENCES `#__users` (`id`),
		FOREIGN KEY (`id_album`) REFERENCES `#__angelgirls_album` (`id`)
) ENGINE = InnoDB   DEFAULT CHARSET=utf8;

CREATE  INDEX album_foto_usuario_criador_idx ON `#__angelgirls_foto_album`(`id_usuario_criador`,`id_album` );
ALTER TABLE  `#__angelgirls_album` ADD CONSTRAINT FOREIGN KEY (`id_foto_capa`) REFERENCES `#__angelgirls_foto_album` (`id`);


CREATE TABLE `#__angelgirls_vt_foto_album` ( 
	`id_foto` INT NOT NULL, 
	`id_usuario` INT NOT NULL, 
	`data_criado` DATETIME NOT NULL,
	FOREIGN KEY (`id_usuario`) REFERENCES `#__users` (`id`),
	FOREIGN KEY (`id_foto`) REFERENCES `#__angelgirls_foto_album` (`id`),
	PRIMARY KEY(`id_foto`,`id_usuario`)
) ENGINE = InnoDB   DEFAULT CHARSET=utf8;


CREATE TABLE `#__angelgirls_vt_album` ( 
	`id_album` INT NOT NULL, 
	`id_usuario` INT NOT NULL, 
	`data_criado` DATETIME NOT NULL,
	FOREIGN KEY (`id_usuario`) REFERENCES `#__users` (`id`),
	FOREIGN KEY (`id_album`) REFERENCES `#__angelgirls_album` (`id`),
	PRIMARY KEY(`id_album`,`id_usuario`)
) ENGINE = InnoDB   DEFAULT CHARSET=utf8;


/** CORRECAOO DE FORENS DA AREA DE SESSAO **/
UPDATE `#__angelgirls_sessao` SET id_locacao = null, id_tema = null WHERE ID >0;
ALTER TABLE  `#__angelgirls_sessao` ADD CONSTRAINT FOREIGN KEY (`id_usuario_criador`) REFERENCES `#__users` (`id`);
ALTER TABLE  `#__angelgirls_sessao` ADD CONSTRAINT FOREIGN KEY (`id_usuario_alterador`) REFERENCES `#__users` (`id`);
ALTER TABLE  `#__angelgirls_sessao` ADD CONSTRAINT FOREIGN KEY (`id_agenda`) REFERENCES `#__angelgirls_agenda` (`id`);
ALTER TABLE  `#__angelgirls_sessao` ADD CONSTRAINT FOREIGN KEY (`id_tema`) REFERENCES `#__angelgirls_tema` (`id`);
ALTER TABLE  `#__angelgirls_sessao` ADD CONSTRAINT FOREIGN KEY (`id_modelo_principal`) REFERENCES `#__angelgirls_modelo` (`id`);
ALTER TABLE  `#__angelgirls_sessao` ADD CONSTRAINT FOREIGN KEY (`id_modelo_secundaria`) REFERENCES `#__angelgirls_modelo` (`id`);
ALTER TABLE  `#__angelgirls_sessao` ADD CONSTRAINT FOREIGN KEY (`id_locacao`) REFERENCES `#__angelgirls_locacao` (`id`);
ALTER TABLE  `#__angelgirls_sessao` ADD CONSTRAINT FOREIGN KEY (`id_fotografo_principal`) REFERENCES `#__angelgirls_fotografo` (`id`);
ALTER TABLE  `#__angelgirls_sessao` ADD CONSTRAINT FOREIGN KEY (`id_fotografo_secundario`) REFERENCES `#__angelgirls_fotografo` (`id`);
ALTER TABLE  `#__angelgirls_sessao` ADD CONSTRAINT FOREIGN KEY (`id_figurino_principal`) REFERENCES `#__angelgirls_figurino` (`id`);
ALTER TABLE  `#__angelgirls_sessao` ADD CONSTRAINT FOREIGN KEY (`id_figurino_secundario`) REFERENCES `#__angelgirls_figurino` (`id`);
ALTER TABLE  `#__angelgirls_foto_sessao` ADD CONSTRAINT FOREIGN KEY (`id_usuario_criador`) REFERENCES `#__users` (`id`);
ALTER TABLE  `#__angelgirls_foto_sessao` ADD CONSTRAINT FOREIGN KEY (`id_usuario_alterador`) REFERENCES `#__users` (`id`);
ALTER TABLE  `#__angelgirls_foto_sessao` ADD CONSTRAINT FOREIGN KEY (`id_sessao`) REFERENCES `#__angelgirls_sessao` (`id`);

/** CORRECAOO DE FORENS DE USUARIO **/
ALTER TABLE  `#__angelgirls_fotografo` ADD CONSTRAINT FOREIGN KEY (`id_usuario_criador`) REFERENCES `#__users` (`id`);
ALTER TABLE  `#__angelgirls_fotografo` ADD CONSTRAINT FOREIGN KEY (`id_usuario_alterador`) REFERENCES `#__users` (`id`);
ALTER TABLE  `#__angelgirls_fotografo` ADD CONSTRAINT FOREIGN KEY (`id_usuario`) REFERENCES `#__users` (`id`);

ALTER TABLE  `#__angelgirls_visitante` ADD CONSTRAINT FOREIGN KEY (`id_usuario_criador`) REFERENCES `#__users` (`id`);
ALTER TABLE  `#__angelgirls_visitante` ADD CONSTRAINT FOREIGN KEY (`id_usuario_alterador`) REFERENCES `#__users` (`id`);
ALTER TABLE  `#__angelgirls_visitante` ADD CONSTRAINT FOREIGN KEY (`id_usuario`) REFERENCES `#__users` (`id`);

ALTER TABLE  `#__angelgirls_modelo` ADD CONSTRAINT FOREIGN KEY (`id_usuario_criador`) REFERENCES `#__users` (`id`);
ALTER TABLE  `#__angelgirls_modelo` ADD CONSTRAINT FOREIGN KEY (`id_usuario_alterador`) REFERENCES `#__users` (`id`);
ALTER TABLE  `#__angelgirls_modelo` ADD CONSTRAINT FOREIGN KEY (`id_usuario`) REFERENCES `#__users` (`id`);



