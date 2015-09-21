ALTER TABLE `#__angelgirls_sessao` ADD COLUMN `token` VARCHAR(120) NULL;
ALTER TABLE `#__angelgirls_foto_sessao` ADD COLUMN `token` VARCHAR(120) NULL;
ALTER TABLE `#__angelgirls_foto_sessao` ADD COLUMN `possui_nudes` CHAR(1) DEFAULT 'S';
ALTER TABLE `#__angelgirls_foto_sessao` ADD COLUMN `area_vip` CHAR(1) DEFAULT 'S';

ALTER TABLE `#__angelgirls_album` ADD COLUMN `token` VARCHAR(120) NULL;

ALTER TABLE `#__angelgirls_foto_album` DROP COLUMN `token`;
ALTER TABLE `#__angelgirls_foto_album` ADD COLUMN `token` VARCHAR(120) NULL;
ALTER TABLE `#__angelgirls_foto_album` ADD COLUMN `possui_nudes` CHAR(1) DEFAULT 'S';
ALTER TABLE `#__angelgirls_foto_album` ADD COLUMN `area_vip` CHAR(1) DEFAULT 'S';
ALTER TABLE `#__angelgirls_figurino` ADD COLUMN `nome_foto` varchar(100)  NULL;


DROP TABLE `#__angelgirls_galeria`;
DROP TABLE `#__angelgirls_foto_galeria`;
DROP TABLE `#__angelgirls_vt_foto_galeria`;

CREATE TABLE `#__angelgirls_mensagens` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`id_resposta` INT, 
		`titulo` VARCHAR(250) NOT NULL, 
		`id_usuario_destino` INT NOT NULL ,
		`mensagem` TEXT  NOT NULL , 
		`status_dado` VARCHAR(25) DEFAULT 'NOVO',
		`id_usuario_remetente` INT NOT NULL , 
 		`data_criado` DATETIME NOT NULL,
 		FOREIGN KEY (`id_usuario_remetente`) REFERENCES `#__users` (`id`),
		FOREIGN KEY (`id_usuario_destino`) REFERENCES `#__users` (`id`),
		FOREIGN KEY (`id_resposta`) REFERENCES `#__angelgirls_mensagens` (`id`)
) ENGINE = InnoDB   DEFAULT CHARSET=utf8;