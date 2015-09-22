ALTER TABLE `#__angelgirls_tema` CHANGE COLUMN `nome_foto` `nome_foto` VARCHAR(150) NULL DEFAULT NULL ;
ALTER TABLE `#__angelgirls_agenda` CHANGE COLUMN `nome_foto` `nome_foto` VARCHAR(150) NULL DEFAULT NULL ;
ALTER TABLE `#__angelgirls_fotografo` CHANGE COLUMN `nome_foto` `nome_foto` VARCHAR(150) NULL DEFAULT NULL ;
ALTER TABLE `#__angelgirls_visitante` CHANGE COLUMN `nome_foto` `nome_foto` VARCHAR(150) NULL DEFAULT NULL ;
ALTER TABLE `#__angelgirls_locacao` CHANGE COLUMN `nome_foto` `nome_foto` VARCHAR(150) NULL DEFAULT NULL ;
ALTER TABLE `#__angelgirls_figurino` CHANGE COLUMN `nome_foto` `nome_foto` VARCHAR(150) NULL DEFAULT NULL ;
ALTER TABLE `#__angelgirls_sessao` CHANGE COLUMN `nome_foto` `nome_foto` VARCHAR(150) NULL DEFAULT NULL ;
ALTER TABLE `#__angelgirls_promocao` CHANGE COLUMN `nome_foto` `nome_foto` VARCHAR(150) NULL DEFAULT NULL ;

ALTER TABLE `#__angelgirls_figurino` DROP COLUMN titulo;  
ALTER TABLE `#__angelgirls_figurino` ADD COLUMN `nome` VARCHAR(250) NOT NULL;
ALTER TABLE `#__angelgirls_figurino` ADD COLUMN `meta_descricao` VARCHAR(250) NOT NULL;