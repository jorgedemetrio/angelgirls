
ALTER TABLE `ag_angelgirls_amizade` DROP FOREIGN KEY `ag_angelgirls_amizade_ibfk_1`;
ALTER TABLE `ag_angelgirls_amizade` CHANGE COLUMN `id_usuario_solicidante` `id_usuario_solicitante` INT(11) NOT NULL ;
ALTER TABLE `ag_angelgirls_amizade` ADD CONSTRAINT `ag_angelgirls_amizade_ibfk_1`  FOREIGN KEY (`id_usuario_solicitante`)  REFERENCES `ag_users` (`id`);
