CREATE TABLE `#__cidade` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`nome` VARCHAR(150) NOT NULL , 
		`uf` CHAR(2) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `#__uf` (
  `ds_uf_sigla` char(2) NOT NULL,
  `ds_uf_nome` varchar(255) NOT NULL,
  PRIMARY KEY (`ds_uf_sigla`)
) ENGINE=InnoDB;

ALTER TABLE `#__cidade` ADD INDEX `FK_CIDADE_UF_idx` (`uf` ASC);
ALTER TABLE `#__cidade` ADD CONSTRAINT `FK_CIDADE_UF`  FOREIGN KEY (`uf`) REFERENCES `#__uf` (`ds_uf_sigla`);


CREATE TABLE `#__angelgirls_agenda` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`titulo` VARCHAR(100) NOT NULL, 
		
		`tipo` VARCHAR(20) DEFAULT 'SESSAO', 
		`nome_foto` varchar(100)  NULL,
		`descricao` TEXT NULL , 
		`meta_descricao` VARCHAR(250) NOT NULL ,

		`audiencia_gostou` INT DEFAULT 0,
		`audiencia_ngostou` INT DEFAULT 0,
		`audiencia_view` INT DEFAULT 0,
		
		`data` DATE NOT NULL, 
		
		`id_tema` INT,
		`id_modelo` INT,
		`id_locacao` INT,
		`id_fotografo` INT,
		
		
		`publicar` DATE, 
		`status_dado` VARCHAR(25) DEFAULT 'NOVO',
		`id_usuario_criador` INT NOT NULL , 
		`id_usuario_alterador` INT NOT NULL , 
		`data_criado` DATETIME NOT NULL  , 
		`data_alterado` DATETIME NOT NULL 
		
) ENGINE = InnoDB;

CREATE TABLE `#__angelgirls_email` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`principal` ENUM('S','N') NOT NULL, 
		`email` VARCHAR(150) NOT NULL , 
		`id_usuario` INT NOT NULL,
		`ordem` int,
		
		`status_dado` VARCHAR(25) DEFAULT 'NOVO',
		`id_usuario_criador` INT NOT NULL , 
		`id_usuario_alterador` INT NOT NULL , 
		`data_criado` DATETIME NOT NULL  , 
		`data_alterado` DATETIME NOT NULL  
) ENGINE = InnoDB;


CREATE TABLE `#__angelgirls_redesocial` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`principal` ENUM('S','N') NOT NULL, 
		`publico` ENUM('S','N','A','E') NOT NULL,
		`rede_social` VARCHAR(150) NOT NULL , 
		`url_usuario` VARCHAR(150) NOT NULL , 
		`id_usuario` INT NOT NULL ,
		`ordem` int,
		
		`status_dado` VARCHAR(25) DEFAULT 'NOVO',
		`id_usuario_criador` INT NOT NULL , 
		`id_usuario_alterador` INT NOT NULL , 
		`data_criado` DATETIME NOT NULL  , 
		`data_alterado` DATETIME NOT NULL  
) ENGINE = InnoDB;

CREATE TABLE `#__angelgirls_telefone` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`tipo` ENUM('CELULAR','RESIDENCIAL','ESCRITORIO','RECADO','OUTRO'), 
		`principal` ENUM('S','N') NOT NULL, 
		`operadora` VARCHAR(15), 
		`ddi` VARCHAR(4) DEFAULT '+55', 
		`ddd` VARCHAR(3) NOT NULL , 
		`telefone` VARCHAR(15) NOT NULL , 
		`id_usuario` INT NOT NULL ,
		`ordem` int,
		
		`status_dado` VARCHAR(25) DEFAULT 'NOVO',
		`id_usuario_criador` INT NOT NULL , 
		`id_usuario_alterador` INT NOT NULL , 
		`data_criado` DATETIME NOT NULL  , 
		`data_alterado` DATETIME NOT NULL  
) ENGINE = InnoDB;

CREATE TABLE `#__angelgirls_endereco` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`tipo` ENUM('RESIDO','TRABALHO','OUTRO'), 
		`principal` ENUM('S','N') NOT NULL,
		`endereco` VARCHAR(250), 
		`numero` VARCHAR(10),
		`bairro` VARCHAR(100),
		`complemento` VARCHAR(100),
		`cep` VARCHAR(15),
		`id_cidade` INT NOT NULL, 
		`id_usuario` INT NOT NULL ,
		`ordem` int,
		
		`status_dado` VARCHAR(25) DEFAULT 'NOVO',
		`id_usuario_criador` INT NOT NULL , 
		`id_usuario_alterador` INT NOT NULL , 
		`data_criado` DATETIME NOT NULL  , 
		`data_alterado` DATETIME NOT NULL  
) ENGINE = InnoDB;





CREATE TABLE `#__angelgirls_modelo` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`id_usuario` INT UNIQUE NOT NULL , 
		`nome_artistico` VARCHAR(150) NOT NULL, 
		`descricao` TEXT NULL, 
		`meta_descricao` VARCHAR(250) NOT NULL , 
		`foto_perfil` VARCHAR(100), 
		`foto_inteira` VARCHAR(100),
		`foto_inteira_horizontal` VARCHAR(100), 
		`altura` NUMERIC(5,2) , 
		`peso` NUMERIC(3) , 
		`busto` NUMERIC(3) , 
		`calsa` NUMERIC(3) , 
		`calsado` NUMERIC(3) , 
		`olhos` ENUM('NEGROS','AZUIS','VERDES','CASTANHOS','MEL','OUTRO') , 
		`pele` ENUM('CALCASIANA','BRANCA','PARDA','MORENA','NEGRA','AMARELA','OUTRO') , 
		`etinia` ENUM('AZIATICA','AFRO','EURPEIA','ORIENTAL','LATINA','OUTRO'), 
		`cabelo` ENUM('LIZO','ENCARACOLADO','CACHIADO','ONDULADOS','CRESPO','OUTRO','SEM'), 
		`tamanho_cabelo` ENUM('SEM','MUITO CURTO','CURTO','MEDIO','LONGO','MUITO LONGO','OUTRO'), 
		`cor_cabelo` ENUM('BRANCO','LOIRA CLARA','LOIRA','LOIRO ESCURO','COLORIDO','RUIVA','SEM','CASTANHO','NEGRO','OUTRO'), 
		`outra_cor_cabelo` VARCHAR(25),
		`profissao` VARCHAR(25),
		`nascionalidade` VARCHAR(25),
		`id_cidade_nasceu` INT,
		`data_nascimento` DATE,
		`site` VARCHAR(250),
		`sexo` ENUM('M','F') DEFAULT 'F',
		
		`cpf` VARCHAR(14) NOT NULL UNIQUE,
		`banco` VARCHAR(14),
		`agencia` VARCHAR(14),
		`conta` VARCHAR(14),
		
		`custo_medio_diaria` NUMERIC(12,2) DEFAULT 0,
		
		`status_modelo` VARCHAR(14) DEFAULT 'NOVA',
		`qualificao_equipe` INT DEFAULT 0,
		`audiencia_gostou` INT DEFAULT 0,
		`audiencia_ngostou` INT DEFAULT 0,
		`audiencia_view` INT DEFAULT 0,
		`id_cidade` INT NOT NULL ,
		
		`status_dado` VARCHAR(25) DEFAULT 'NOVO',
		`id_usuario_criador` INT NOT NULL , 
		`id_usuario_alterador` INT NOT NULL , 
		`data_criado` DATETIME NOT NULL  , 
		`data_alterado` DATETIME NOT NULL  
) ENGINE = InnoDB;


CREATE TABLE `#__angelgirls_fotografo` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`id_usuario` INT UNIQUE NOT NULL , 
		`nome_artistico` VARCHAR(150) NOT NULL, 
		`descricao` TEXT NULL , 
		`meta_descricao` VARCHAR(250) NOT NULL ,
		
		`nome_foto` varchar(100)  NULL,
		
		`data_nascimento` DATE,
		`sexo` ENUM('M','F') NOT NULL,
		`nascionalidade` VARCHAR(25),
		`id_cidade_nasceu` INT,
		`site` VARCHAR(250),
		`profissao` VARCHAR(25),
		`id_cidade` INT NOT NULL,
		
		

		`status_fotografo` VARCHAR(14),
		`qualificao_equipe` INT DEFAULT 0,
		`audiencia_gostou` INT DEFAULT 0,
		`audiencia_ngostou` INT DEFAULT 0,
		`audiencia_view` INT DEFAULT 0,
		
		`custo_medio_diaria` NUMERIC(12,2) DEFAULT 0,
		
		`cpf` VARCHAR(14) NOT NULL UNIQUE,
		`banco` VARCHAR(14),
		`agencia` VARCHAR(14),
		`conta` VARCHAR(14),
		
		`status_dado` VARCHAR(25) DEFAULT 'NOVO',
		`id_usuario_criador` INT NOT NULL , 
		`id_usuario_alterador` INT NOT NULL , 
		`data_criado` DATETIME NOT NULL  , 
		`data_alterado` DATETIME NOT NULL  
) ENGINE = InnoDB;


CREATE TABLE `#__angelgirls_visitante` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`id_usuario` INT UNIQUE NOT NULL, 
		`sobre` TEXT NULL , 
		
		`possui_foto_perfil` ENUM('S','N') NOT NULL , 
		`data_nascimento` DATE NOT NULL,
		`sexo` ENUM('M','F') NOT NULL,

		`site` VARCHAR(250),
		`profissao` VARCHAR(25),
		`nascionalidade` VARCHAR(25),
		`id_cidade_nasceu` INT,
		
		


		`qualificao_equipe` INT DEFAULT 0,
		`audiencia_gostou` INT DEFAULT 0,
		`audiencia_ngostou` INT DEFAULT 0,
		`audiencia_view` INT DEFAULT 0,
		
		`custo_medio_diaria` NUMERIC(12,2) DEFAULT 0,
		
		`cpf` VARCHAR(14) NOT NULL UNIQUE,
		`banco` VARCHAR(14),
		`agencia` VARCHAR(14),
		`conta` VARCHAR(14),
		
		`status_dado` VARCHAR(25) DEFAULT 'NOVO',
		`id_usuario_criador` INT NOT NULL , 
		`id_usuario_alterador` INT NOT NULL , 
		`data_criado` DATETIME NOT NULL  , 
		`data_alterado` DATETIME NOT NULL  
) ENGINE = InnoDB;


CREATE TABLE `#__angelgirls_equipe` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`id_usuario` INT NOT NULL , 
		`nome_artistico` VARCHAR(150) NOT NULL, 
		`descricao` TEXT NULL , 
		`meta_descricao` VARCHAR(250) NOT NULL , 
		`possui_foto_perfil` ENUM('S','N') NOT NULL , 
		`data_nascimento` DATE,
		`sexo` ENUM('M','F') NOT NULL,

		`site` VARCHAR(250),
		`profissao` VARCHAR(25),
		`id_cidade` INT NOT NULL,
		

		`status_fotografo` VARCHAR(14),
		`qualificao_equipe` INT DEFAULT 0,
		`audiencia_gostou` INT DEFAULT 0,
		`audiencia_ngostou` INT DEFAULT 0,
		`audiencia_view` INT DEFAULT 0,
		
		`custo_medio_diaria` NUMERIC(12,2) DEFAULT 0,
		
		`cpf` VARCHAR(14) NOT NULL UNIQUE,
		`banco` VARCHAR(14),
		`agencia` VARCHAR(14),
		`conta` VARCHAR(14),
		
		`status_dado` VARCHAR(25) DEFAULT 'NOVO',
		`id_usuario_criador` INT NOT NULL , 
		`id_usuario_alterador` INT NOT NULL , 
		`data_criado` DATETIME NOT NULL  , 
		`data_alterado` DATETIME NOT NULL  
) ENGINE = InnoDB;


CREATE TABLE `#__angelgirls_locacao` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`nome` VARCHAR(250) NOT NULL UNIQUE, 
		`endereco` VARCHAR(250), 
		`numero` VARCHAR(10),
		`bairro` VARCHAR(100),
		`complemento` VARCHAR(100),
		`cep` VARCHAR(15),
		`id_cidade` INT NOT NULL, 
		
		`descricao` TEXT NULL , 
		`meta_descricao` VARCHAR(250) NOT NULL , 
		
		`nome_foto` varchar(100)  NULL, 
		
		`site` VARCHAR(250),
		`ddd_telefone` VARCHAR(3),
		`telefone` VARCHAR(15),
		`email` VARCHAR(100),
		
		`custo_medio_diaria` NUMERIC(12,2) DEFAULT 0,
		
		`audiencia_gostou` INT DEFAULT 0,
		`audiencia_ngostou` INT DEFAULT 0,
		`audiencia_view` INT DEFAULT 0,
		
		`status_dado` VARCHAR(25) DEFAULT 'NOVO',
		`id_usuario_criador` INT NOT NULL , 
		`id_usuario_alterador` INT NOT NULL , 
		`data_criado` DATETIME NOT NULL  , 
		`data_alterado` DATETIME NOT NULL  
) ENGINE = InnoDB;


CREATE TABLE `#__angelgirls_tema` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`nome` VARCHAR(250) NOT NULL UNIQUE, 
		`descricao` TEXT NULL , 
		`meta_descricao` VARCHAR(250) NOT NULL , 
		
		`nome_foto` varchar(100)  NULL,
		
		`audiencia_gostou` INT DEFAULT 0,
		`audiencia_ngostou` INT DEFAULT 0,
		`audiencia_view` INT DEFAULT 0,
		
		`status_dado` VARCHAR(25) DEFAULT 'NOVO',
		`id_usuario_criador` INT NOT NULL , 
		`id_usuario_alterador` INT NOT NULL , 
		`data_criado` DATETIME NOT NULL  , 
		`data_alterado` DATETIME NOT NULL  
) ENGINE = InnoDB;


CREATE TABLE `#__angelgirls_sessao` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`titulo` VARCHAR(250) NOT NULL UNIQUE, 
		
		`nome_foto` varchar(100)  NULL,
		
		`executada` DATE NOT NULL, 
		`descricao` TEXT NULL , 
		`historia` TEXT NULL , 
		`comentario_fotografo` TEXT NULL , 
		`comentario_modelos` TEXT NULL , 
		`comentario_equipe` TEXT NULL , 
		`meta_descricao` VARCHAR(250) NOT NULL , 
		
		
		`id_agenda` INT,
		`id_tema` INT NULL,
		`id_modelo_principal` INT  NOT NULL,
		`id_modelo_secubdaria` INT,
		`id_locacao` INT NULL,
		`id_fotografo_principal` INT  NOT NULL,
		`id_fotografo_secundario` INT,
		
		`id_figurino_principal` INT,
		`id_figurino_secundario` INT,
		
		`audiencia_gostou` INT DEFAULT 0,
		`audiencia_ngostou` INT DEFAULT 0,
		`audiencia_view` INT DEFAULT 0,
		
		`publicar` DATE NOT NULL,
		`status_dado` VARCHAR(25) DEFAULT 'NOVO',
		`id_usuario_criador` INT NOT NULL , 
		`id_usuario_alterador` INT NOT NULL , 
		`data_criado` DATETIME NOT NULL  , 
		`data_alterado` DATETIME NOT NULL  
) ENGINE = InnoDB;

CREATE TABLE `#__angelgirls_figurino` ( 
	`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
	`titulo` VARCHAR(250) NOT NULL,
	`descricao` TEXT NULL , 
	
	`audiencia_gostou` INT DEFAULT 0,
	`audiencia_ngostou` INT DEFAULT 0,
	`audiencia_view` INT DEFAULT 0,
	
	`status_dado` VARCHAR(25) DEFAULT 'NOVO',
	`id_usuario_criador` INT NOT NULL , 
	`id_usuario_alterador` INT NOT NULL , 
	`data_criado` DATETIME NOT NULL  , 
	`data_alterado` DATETIME NOT NULL  
) ENGINE = InnoDB;

CREATE TABLE `#__angelgirls_foto_sessao` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`titulo` VARCHAR(250) NOT NULL, 
		
		`descricao` TEXT NULL , 
		`meta_descricao` VARCHAR(250) NOT NULL, 
		
		`id_sessao` INT NOT NULL,
		`ordem` INT,
		
		`audiencia_gostou` INT DEFAULT 0,
		`audiencia_ngostou` INT DEFAULT 0,
		`audiencia_view` INT DEFAULT 0,
		
		`status_dado` VARCHAR(25) DEFAULT 'NOVO',
		`id_usuario_criador` INT NOT NULL , 
		`id_usuario_alterador` INT NOT NULL , 
		`data_criado` DATETIME NOT NULL  , 
		`data_alterado` DATETIME NOT NULL  
) ENGINE = InnoDB;



CREATE TABLE `#__angelgirls_galeria` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`titulo` VARCHAR(250) NOT NULL UNIQUE, 
		`id_usuario` INT NOT NULL , 
		
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
		`data_alterado` DATETIME NOT NULL  
) ENGINE = InnoDB;


CREATE TABLE `#__angelgirls_foto_galeria` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`titulo` VARCHAR(250) NOT NULL, 
		`id_usuario` INT NOT NULL , 
		
		`descricao` TEXT NULL , 
		`meta_descricao` VARCHAR(250) NOT NULL, 
		
		`id_galeria` INT NOT NULL,
		
		`audiencia_gostou` INT DEFAULT 0,
		`audiencia_ngostou` INT DEFAULT 0,
		`audiencia_view` INT DEFAULT 0,
		
		`status_dado` VARCHAR(25) DEFAULT 'NOVO',
		`id_usuario_criador` INT NOT NULL , 
		`id_usuario_alterador` INT NOT NULL , 
		`data_criado` DATETIME NOT NULL  , 
		`data_alterado` DATETIME NOT NULL  
) ENGINE = InnoDB;




CREATE TABLE `#__angelgirls_promocao` ( 
		`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		`titulo` VARCHAR(250) NOT NULL UNIQUE, 
		
		`nome_foto` varchar(100)  NULL,
		
		`descricao` TEXT NULL , 
		`meta_descricao` VARCHAR(250) NOT NULL , 
		
		`inicio` DATE NOT NULL,
		`fim` DATE NOT NULL,
		
		
		`publicar` DATE NOT NULL,
		`status_dado` VARCHAR(25) DEFAULT 'NOVO',
		`id_usuario_criador` INT NOT NULL , 
		`id_usuario_alterador` INT NOT NULL , 
		`data_criado` DATETIME NOT NULL  , 
		`data_alterado` DATETIME NOT NULL  
) ENGINE = InnoDB;

CREATE TABLE `#__angelgirls_vt_fotografo` ( 
	`id_fotografo` INT NOT NULL, 
	`id_usuario` INT NOT NULL, 
	`data_criado` DATETIME NOT NULL,
	PRIMARY KEY(`id_fotografo`,`id_usuario`)
) ENGINE = InnoDB;


CREATE TABLE `#__angelgirls_vt_sessao` ( 
	`id_sessao` INT NOT NULL, 
	`id_usuario` INT NOT NULL, 
	`data_criado` DATETIME NOT NULL,
	PRIMARY KEY(`id_sessao`,`id_usuario`)
) ENGINE = InnoDB;

CREATE TABLE `#__angelgirls_vt_modelo` ( 
	`id_modelo` INT NOT NULL, 
	`id_usuario` INT NOT NULL, 
	`data_criado` DATETIME NOT NULL,
	PRIMARY KEY(`id_modelo`,`id_usuario`)
) ENGINE = InnoDB;

CREATE TABLE `#__angelgirls_vt_foto_sessao` ( 
	`id_foto` INT NOT NULL, 
	`id_usuario` INT NOT NULL, 
	`data_criado` DATETIME NOT NULL,
	PRIMARY KEY(`id_foto`,`id_usuario`)
) ENGINE = InnoDB;

CREATE TABLE `#__angelgirls_vt_foto_galeria` ( 
	`id_foto` INT NOT NULL, 
	`id_usuario` INT NOT NULL, 
	`data_criado` DATETIME NOT NULL,
	PRIMARY KEY(`id_foto`,`id_usuario`)
) ENGINE = InnoDB;

CREATE TABLE `#__angelgirls_vt_equipe` ( 
	`id_equipe` INT NOT NULL, 
	`id_usuario` INT NOT NULL, 
	`data_criado` DATETIME NOT NULL,
	PRIMARY KEY(`id_equipe`,`id_usuario`)
) ENGINE = InnoDB;

CREATE TABLE `#__angelgirls_vt_galeria` ( 
	`id_galeria` INT NOT NULL, 
	`id_usuario` INT NOT NULL, 
	`data_criado` DATETIME NOT NULL,
	PRIMARY KEY(`id_galeria`,`id_usuario`)
) ENGINE = InnoDB;