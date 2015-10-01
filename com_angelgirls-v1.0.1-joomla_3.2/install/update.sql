ALTER TABLE #__angelgirls_mensagens ADD COLUMN status_mensagem VARCHAR(25) DEFAULT 'NOVO' ;


CREATE TABLE `#__angelgirls_amizade` ( 
	`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
	`id_usuario_solicidante` INT NOT NULL , 
	`id_usuario_solicitado` INT NOT NULL , 
	`data_solicitada` DATETIME NOT NULL, 
	`data_aceita` DATETIME NULL,
	`host_ip_solicitante` varchar(20) NOT NULL,
	`host_ip_aceitou` varchar(20) NULL,
	FOREIGN KEY (`id_usuario_solicidante`) REFERENCES `#__users` (`id`),
	FOREIGN KEY (`id_usuario_solicitado`) REFERENCES `#__users` (`id`)
) ENGINE = InnoDB   DEFAULT CHARSET=utf8;


CREATE TABLE `#__angelgirls_amizade_lista` ( 
	`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
    `nome` varchar(255) NOT NULL DEFAULT 'AMIGOS', 
	`status_dado` VARCHAR(25) DEFAULT 'NOVO',
	`id_usuario_criador` INT NOT NULL , 
	 `sistema` enum('S','N') DEFAULT 'N',
	`id_usuario_alterador` INT NOT NULL , 
	`data_criado` DATETIME NOT NULL, 
	`data_alterado` DATETIME NOT NULL,
	`host_ip_criador` varchar(20) NOT NULL,
	`host_ip_alterador` varchar(20) NULL,
	FOREIGN KEY (`id_usuario_criador`) REFERENCES `#__users` (`id`),
	FOREIGN KEY (`id_usuario_alterador`) REFERENCES `#__users` (`id`)
) ENGINE = InnoDB   DEFAULT CHARSET=utf8;

CREATE TABLE `#__angelgirls_amizade_lista_contato` (
	`id_lista` INT NOT NULL,
	`id_usuario` INT NOT NULL,
	`data_alterado` DATETIME NOT NULL,
	`host_ip_criador` varchar(20) NOT NULL,
	PRIMARY KEY(id_lista, id_usuario),
	FOREIGN KEY (`id_usuario`) REFERENCES `#__users` (`id`),
	FOREIGN KEY (`id_lista`) REFERENCES `#__angelgirls_amizade_lista` (`id`)
)


CREATE TABLE `#__angelgirls_seguindo` ( 
	`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
	`id_usuario_seguidor` INT NOT NULL , 
	`id_usuario_seguido` INT NOT NULL , 
	`data` DATETIME NOT NULL, 
	`host_ip` varchar(20) NULL,
	FOREIGN KEY (`id_usuario_seguidor`) REFERENCES `#__users` (`id`),
	FOREIGN KEY (`id_usuario_seguido`) REFERENCES `#__users` (`id`)
) ENGINE = InnoDB   DEFAULT CHARSET=utf8;

ALTER TABLE `#__angelgirls_modelo` DROP COLUMN `token`;
ALTER TABLE `#__angelgirls_fotografo` DROP COLUMN `token`;
ALTER TABLE `#__angelgirls_visitante` DROP COLUMN `token`;

ALTER TABLE `#__angelgirls_modelo` ADD COLUMN `token` VARCHAR(250) UNIQUE NOT NULL;
ALTER TABLE `#__angelgirls_fotografo` ADD COLUMN `token` VARCHAR(250) UNIQUE  NOT NULL;
ALTER TABLE `#__angelgirls_visitante` ADD COLUMN `token` VARCHAR(250) UNIQUE   NOT NULL;


UPDATE #__angelgirls_modelo SET token = UUID() WHERE token IS NULL; 
UPDATE #__angelgirls_fotografo SET token = UUID() WHERE token IS NULL; 
UPDATE #__angelgirls_visitante SET token = UUID() WHERE token IS NULL; 


ALTER TABLE `joomla`.`test2_angelgirls_sessao` 
CHANGE COLUMN `token` `token` VARCHAR(250) NOT NULL ,
ADD UNIQUE INDEX `token_UNIQUE` (`token` ASC);
