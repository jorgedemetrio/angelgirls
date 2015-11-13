CREATE TABLE `#__angelgirls_vt_visitante` ( 
	`id_visitante` INT NOT NULL, 
	`id_usuario` INT NOT NULL, 
	`data_criado` DATETIME NOT NULL,
	`host_ip` varchar(20) NOT NULL,
	FOREIGN KEY (`id_usuario`) REFERENCES `#__users` (`id`),
	PRIMARY KEY(`id_visitante`,`id_usuario`)
) ENGINE = InnoDB   DEFAULT CHARSET=utf8;












ALTER TABLE `#__angelgirls_post` 
CHANGE COLUMN `token` `token` VARCHAR(150) NOT NULL ,
ADD UNIQUE INDEX `token_UNIQUE` (`token` ASC);

ALTER TABLE `#__angelgirls_promocao` 
CHANGE COLUMN `token` `token` VARCHAR(150) NOT NULL ,
ADD UNIQUE INDEX `token_UNIQUE` (`token` ASC);

ALTER TABLE `#__angelgirls_sessao` 
ADD UNIQUE INDEX `token_UNIQUE` (`token` ASC);

ALTER TABLE `#__angelgirls_foto_sessao`  
ADD UNIQUE INDEX `token_UNIQUE` (`token` ASC);

ALTER TABLE `#__angelgirls_foto_album` 
ADD UNIQUE INDEX `token_UNIQUE` (`token` ASC);


ALTER TABLE `#__angelgirls_modelo` 
ADD COLUMN `nivel` INT NULL DEFAULT 0 AFTER `token`;

ALTER TABLE `#__angelgirls_fotografo` 
ADD COLUMN `nivel` INT NULL DEFAULT 0 AFTER `token`;

ALTER TABLE `#__angelgirls_visitante` 
ADD COLUMN `nivel` INT NULL DEFAULT 0 AFTER `token`;




