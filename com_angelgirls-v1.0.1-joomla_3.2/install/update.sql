ALTER TABLE `#__angelgirls_mensagens` ADD COLUMN `enviado` INT NULL DEFAULT 0 AFTER `lido_destinatario`;
update test2_angelgirls_mensagens SET enviado = 1 WHERE id>0;


ALTER TABLE #__angelgirls_post ADD COLUMN token varchar(150);
ALTER TABLE #__angelgirls_promocao ADD COLUMN token varchar(150);
