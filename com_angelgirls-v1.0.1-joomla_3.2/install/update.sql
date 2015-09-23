ALTER TABLE #__angelgirls_foto_sessao DROP COLUMN `token`;
ALTER TABLE #__angelgirls_foto_sessao ADD COLUMN `token` VARCHAR(120) NOT NULL;
ALTER TABLE #__angelgirls_foto_sessao ADD COLUMN `token_imagem` VARCHAR(120) NULL;

ALTER TABLE #__angelgirls_foto_album DROP COLUMN `token`;
ALTER TABLE #__angelgirls_foto_album ADD COLUMN `token` VARCHAR(120) NOT NULL;
ALTER TABLE #__angelgirls_foto_album ADD COLUMN `token_imagem` VARCHAR(120) NULL;