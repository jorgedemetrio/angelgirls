CREATE TABLE IF NOT EXISTS `#__angelgirls_fotos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `descricao` TEXT DEFAULT NULL,
  `descricao_google` VARCHAR(255) NOT NULL,
  `apelido` VARCHAR(255) DEFAULT NULL,
  `autor` VARCHAR(255) DEFAULT NULL,
  `modelos` VARCHAR(255) DEFAULT NULL,
  `data_foto` DATE NOT NULL,
  `views`  NOT NULL,
  `total_gostei` INT(11) NOT NULL,
  `total_ngostei` INT(11) NOT NULL,
  `autor_name` VARCHAR(255) NOT NULL,
  `created_on` DATETIME NOT NULL,
  `published` INT(1) NOT NULL,
  `edited_on` DATETIME NOT NULL,
  `publicar` DATETIME NOT NULL,
  `despublicar` DATETIME NOT NULL,
  `id_created_by` INT(11) NOT NULL,
  `id_edited_by` INT(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__angelgirls_perfils` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `descricao` TEXT DEFAULT NULL,
  `documento` VARCHAR(255) DEFAULT NULL,
  `foto_perfil` VARCHAR(255) NOT NULL,
  `apelido` VARCHAR(255) DEFAULT NULL,
  `tipo_perfil` VARCHAR(255) NOT NULL,
  `published` INT(1) NOT NULL,
  `status` VARCHAR(255) NOT NULL,
  `created_on` DATETIME NOT NULL,
  `edited_on` DATETIME NOT NULL,
  `publicar` DATETIME NOT NULL,
  `despublicar` DATETIME NOT NULL,
  `id_created_by` INT(11) NOT NULL,
  `id_edited_by` INT(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__angelgirls_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `emails` VARCHAR(255) NOT NULL,
  `created_on` DATETIME NOT NULL,
  `edited_on` DATETIME NOT NULL,
  `id_created_by` INT(11) NOT NULL,
  `id_edited_by` INT(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__angelgirls_telefones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `telefone` VARCHAR(255) NOT NULL,
  `ddd` VARCHAR(255) NOT NULL,
  `created_on` DATETIME NOT NULL,
  `edited_on` DATETIME NOT NULL,
  `id_created_by` INT(11) NOT NULL,
  `id_edited_by` INT(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__angelgirls_enderecos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `logradouro` VARCHAR(255) NOT NULL,
  `endereco` VARCHAR(255) NOT NULL,
  `numero` VARCHAR(255) NOT NULL,
  `complemento` VARCHAR(255) NOT NULL,
  `bairro` VARCHAR(255) NOT NULL,
  `cidade` VARCHAR(255) NOT NULL,
  `estado` VARCHAR(255) NOT NULL,
  `pais` VARCHAR(255) NOT NULL,
  `cep` VARCHAR(255) NOT NULL,
  `created_on` DATETIME NOT NULL,
  `edited_on` DATETIME NOT NULL,
  `id_created_by` INT(11) NOT NULL,
  `id_edited_by` INT(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__angelgirls_galerias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `apelido` VARCHAR(255) DEFAULT NULL,
  `descricao` TEXT DEFAULT NULL,
  `id_concurso` INT(11) DEFAULT NULL,
  `id_sessao` INT(11) DEFAULT NULL,
  `autor` VARCHAR(255) DEFAULT NULL,
  `modelos` VARCHAR(255) DEFAULT NULL,
  `descricao_google` VARCHAR(255) NOT NULL,
  `grande` VARCHAR(255) NOT NULL,
  `thumb` VARCHAR(255) NOT NULL,
  `icone` VARCHAR(255) NOT NULL,
  `media` VARCHAR(255) NOT NULL,
  `published` INT(1) NOT NULL,
  `created_on` DATETIME NOT NULL,
  `edited_on` DATETIME NOT NULL,
  `publicar` DATETIME NOT NULL,
  `despublicar` DATETIME NOT NULL,
  `id_created_by` INT(11) NOT NULL,
  `id_edited_by` INT(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__angelgirls_sessoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `apelido` VARCHAR(255) DEFAULT NULL,
  `descricao` TEXT DEFAULT NULL,
  `published` INT(1) NOT NULL,
  `descricao_google` VARCHAR(255) NOT NULL,
  `created_on` DATETIME NOT NULL,
  `edited_on` DATETIME NOT NULL,
  `publicar` DATETIME NOT NULL,
  `despublicar` DATETIME NOT NULL,
  `id_created_by` INT(11) NOT NULL,
  `id_edited_by` INT(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__angelgirls_concursos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `apelido` VARCHAR(255) DEFAULT NULL,
  `descricao` TEXT NOT NULL,
  `premio` TEXT NOT NULL,
  `cadastro_valido` DATE NOT NULL,
  `votos_validos` INT(11) NOT NULL,
  `created_on` DATETIME NOT NULL,
  `edited_on` DATETIME NOT NULL,
  `published` INT(1) NOT NULL,
  `publicar` DATETIME NOT NULL,
  `despublicar` DATETIME NOT NULL,
  `id_created_by` INT(11) NOT NULL,
  `id_edited_by` INT(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__angelgirls_agendas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `apelido` VARCHAR(255) DEFAULT NULL,
  `descricao` TEXT DEFAULT NULL,
  `descricao_google` VARCHAR(255) NOT NULL,
  `data` DATETIME NOT NULL,
  `published` INT(1) NOT NULL,
  `created_on` DATETIME NOT NULL,
  `edited_on` DATETIME NOT NULL,
  `publicar` DATETIME NOT NULL,
  `despublicar` DATETIME NOT NULL,
  `id_created_by` INT(11) NOT NULL,
  `id_edited_by` INT(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__angelgirls_conteudos_associados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(255) NOT NULL,
  `origem_tipo` VARCHAR(255) DEFAULT NULL,
  `origem_id` INT(11) DEFAULT NULL,
  `origem_url` VARCHAR(255) DEFAULT NULL,
  `destino_tipo` VARCHAR(255) DEFAULT NULL,
  `destino_id` INT(11) DEFAULT NULL,
  `destino_url` VARCHAR(255) DEFAULT NULL,
  `published` INT(1) NOT NULL,
  `created_on` DATETIME NOT NULL,
  `edited_on` DATETIME NOT NULL,
  `id_created_by` INT(11) NOT NULL,
  `id_edited_by` INT(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__angelgirls_votos_concursos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `concurso_id` INT(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__angelgirls_tags_galeria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` INT(11) NOT NULL,
  `galeria_id` INT(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__angelgirls_tags_foto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` INT(11) NOT NULL,
  `foto_id` INT(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__angelgirls_tags_sessao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` INT(11) NOT NULL,
  `sessao_id` INT(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__angelgirls_tags_fotografo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__angelgirls_fotos_galerias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foto_id` INT(11) NOT NULL,
  `galeria_id` INT(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__angelgirls_fotos_agenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foto_id` INT(11) NOT NULL,
  `agenda_id` INT(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

