ALTER TABLE `ag_angelgirls_mensagens` ADD COLUMN `token` varchar(250) NULL;
ALTER TABLE `ag_angelgirls_mensagens` ADD COLUMN `tipo` INT;


CREATE TABLE `ag_angelgirls_extrato_pontos` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		
		`chave` VARCHAR(25) DEFAULT 'SESSAO.CRIADA',
		`pontos` bigint,
		`motivo` text,
		
		`id_usuario` INT NOT NULL , 
		`data` DATETIME NOT NULL, 
		`host_ip` varchar(20) NOT NULL,

		FOREIGN KEY (`id_usuario`) REFERENCES `ag_users` (`id`)
) ENGINE = InnoDB   DEFAULT CHARSET=utf8;