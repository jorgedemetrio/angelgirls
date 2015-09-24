ALTER TABLE `#__angelgirls_agenda`  ADD COLUMN `host_ip_criador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_agenda`  ADD COLUMN `host_ip_alterador` varchar(20) NULL;
ALTER TABLE `#__angelgirls_email`  ADD COLUMN  `host_ip_criador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_email`  ADD COLUMN  `host_ip_alterador` varchar(20) NULL;
ALTER TABLE `#__angelgirls_redesocial`  ADD COLUMN `host_ip_criador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_redesocial`  ADD COLUMN `host_ip_alterador` varchar(20) NULL;
ALTER TABLE `#__angelgirls_telefone`  ADD COLUMN  `host_ip_criador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_telefone`  ADD COLUMN `host_ip_alterador` varchar(20) NULL;
ALTER TABLE `#__angelgirls_endereco`  ADD COLUMN `host_ip_criador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_endereco`  ADD COLUMN `host_ip_alterador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_modelo`  ADD COLUMN `host_ip_criador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_modelo`  ADD COLUMN `host_ip_alterador` varchar(20) NULL;
ALTER TABLE `#__angelgirls_fotografo`  ADD COLUMN `host_ip_criador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_fotografo`  ADD COLUMN `host_ip_alterador` varchar(20) NULL;
ALTER TABLE `#__angelgirls_visitante`  ADD COLUMN  `host_ip_criador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_visitante`  ADD COLUMN  `host_ip_alterador` varchar(20) NULL;
ALTER TABLE `#__angelgirls_equipe`  ADD COLUMN `host_ip_criador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_equipe`  ADD COLUMN `host_ip_alterador` varchar(20) NULL;
ALTER TABLE `#__angelgirls_locacao`  ADD COLUMN `host_ip_criador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_locacao`  ADD COLUMN `host_ip_alterador` varchar(20) NULL;
ALTER TABLE `#__angelgirls_tema`  ADD COLUMN `host_ip_criador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_tema`  ADD COLUMN `host_ip_alterador` varchar(20) NULL;
ALTER TABLE `#__angelgirls_figurino`  ADD COLUMN `host_ip_criador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_figurino`  ADD COLUMN `host_ip_alterador` varchar(20) NULL;
ALTER TABLE `#__angelgirls_sessao`  ADD COLUMN `host_ip_criador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_sessao`  ADD COLUMN `host_ip_alterador` varchar(20) NULL;
ALTER TABLE `#__angelgirls_mensagens`  ADD COLUMN `host_ip_criador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_mensagens`  ADD COLUMN `host_ip_alterador` varchar(20) NULL;
ALTER TABLE `#__angelgirls_foto_sessao`  ADD COLUMN `host_ip_criador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_foto_sessao`  ADD COLUMN `host_ip_alterador` varchar(20) NULL;
ALTER TABLE `#__angelgirls_post`  ADD COLUMN `host_ip_criador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_post`  ADD COLUMN `host_ip_alterador` varchar(20) NULL;
ALTER TABLE `#__angelgirls_comentario_post`  ADD COLUMN `host_ip_criador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_comentario_post`  ADD COLUMN `host_ip_alterador` varchar(20) NULL;
ALTER TABLE `#__angelgirls_promocao`  ADD COLUMN `host_ip_criador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_promocao`  ADD COLUMN `host_ip_alterador` varchar(20) NULL;
ALTER TABLE `#__angelgirls_album`  ADD COLUMN `host_ip_criador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_album`  ADD COLUMN `host_ip_alterador` varchar(20) NULL;
ALTER TABLE `#__angelgirls_foto_album`  ADD COLUMN `host_ip_criador` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_foto_album`  ADD COLUMN `host_ip_alterador` varchar(20) NULL;
ALTER TABLE `#__angelgirls_vt_foto_album`  ADD COLUMN `host_ip` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_vt_album`  ADD COLUMN `host_ip` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_vt_fotografo` ADD COLUMN `host_ip` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_vt_sessao` ADD COLUMN `host_ip` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_vt_modelo` ADD COLUMN `host_ip` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_vt_foto_sessao`  ADD COLUMN `host_ip` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_vt_equipe`  ADD COLUMN `host_ip` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_vt_post`  ADD COLUMN `host_ip` varchar(20) NOT NULL;
ALTER TABLE `#__angelgirls_vt_comentario_post` ADD COLUMN `host_ip` varchar(20) NOT NULL;





CREATE TABLE `#__query_logs` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`query` text NOT NULL,
		`host_ip` varchar(20) NOT NULL,
		`id_usuario` INT NOT NULL , 
		`data` DATETIME NOT NULL  
) ENGINE = InnoDB   DEFAULT CHARSET=utf8;


ALTER TABLE #__angelgirls_figurino ADD FOREIGN KEY (`id_usuario_criador`) REFERENCES `#__users` (`id`);
ALTER TABLE #__angelgirls_figurino ADD FOREIGN KEY (`id_usuario_alterador`) REFERENCES `#__users` (`id`);

CREATE TABLE `#__angelgirls_tema` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`nome` VARCHAR(250) NOT NULL UNIQUE, 
		`descricao` TEXT NULL , 
		`meta_descricao` VARCHAR(250) NOT NULL , 
		
		`nome_foto` varchar(150)  NULL,
		
		`audiencia_gostou` INT DEFAULT 0,
		`audiencia_ngostou` INT DEFAULT 0,
		`audiencia_view` INT DEFAULT 0,
		
		`status_dado` VARCHAR(25) DEFAULT 'NOVO',
		`id_usuario_criador` INT NOT NULL , 
		`id_usuario_alterador` INT NOT NULL , 
		`data_criado` DATETIME NOT NULL  , 
		`data_alterado` DATETIME NOT NULL,
		`host_ip_criador` varchar(20) NOT NULL,
		`host_ip_alterador` varchar(20) NULL
) ENGINE = InnoDB   DEFAULT CHARSET=utf8;
