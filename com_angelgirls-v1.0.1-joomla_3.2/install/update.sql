ALTER TABLE `#__angelgirls_mensagens` ADD COLUMN `token` varchar(250) NULL;


CREATE TABLE `#__angelgirls_extrato_pontos` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		
		`chave` VARCHAR(25) DEFAULT 'SESSAO.CRIADA',
		`pontos` bigint,
		`motivo` text,
		
		`id_usuario` INT NOT NULL , 
		`data` DATETIME NOT NULL, 
		`host_ip` varchar(20) NOT NULL,

		FOREIGN KEY (`id_usuario`) REFERENCES `test2_users` (`id`)
) ENGINE = InnoDB   DEFAULT CHARSET=utf8;