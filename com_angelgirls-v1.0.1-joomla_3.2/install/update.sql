ALTER TABLE `#__angelgirls_mensagens` ADD COLUMN `enviado` INT NULL DEFAULT 0 AFTER `lido_destinatario`;
update test2_angelgirls_mensagens SET enviado = 1 WHERE id>0;


