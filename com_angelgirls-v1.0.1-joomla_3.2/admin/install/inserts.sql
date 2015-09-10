
INSERT INTO `joomla`.`teste_angelgirls_modelo`
(`id_usuario`,`nome_artistico`,`descricao`,`meta_descricao`,`foto_perfil`,`foto_inteira`,`altura`,`peso`,`busto`,`calsa`,`calsado`,`olhos`,
`pele`,`etinia`,`cabelo`,`tamanho_cabelo`,`cor_cabelo`,`outra_cor_cabelo`,`profissao`,`nascionalidade`,`id_cidade_nasceu`,`data_nascimento`,`site`,
`sexo`,`cpf`,`banco`,`agencia`,`conta`,`custo_medio_diaria`,`status_modelo`,`qualificao_equipe`,`audiencia_gostou`,`audiencia_ngostou`,`audiencia_view`,
`id_cidade`,`status_dado`,`id_usuario_criador`,`id_usuario_alterador`,`data_criado`,`data_alterado`)
VALUES
((SELECT id FROM teste_users WHERE username = 'jessie' ),
'Jessie','Modelo fotografica','Modelo fotografica',null,null,1.46,40,25,35,35,'CASTANHOS','CALCASIANA','OUTRO','LIZO','LONGO','RUIVA',null,
'Modelo','Brasileira',1,'1995-12-14',null,'F','01234567890',null,null,null,0,'ATIVA',0,0,0,0,1,'NOVO',
(SELECT id FROM teste_users WHERE username = 'jessie' ),
(SELECT id FROM teste_users WHERE username = 'jessie' ),
NOW(),NOW());

update teste_angelgirls_modelo SET foto_inteira = '1_inteira.jpg', foto_perfil = '1_perfil.jpg' WHERE id = 1;





INSERT INTO `joomla`.`teste_angelgirls_promocao`
(`titulo`,`nome_foto`,`descricao`,`meta_descricao`,`inicio`,`fim`,`publicar`,
`status_dado`,`id_usuario_criador`,`id_usuario_alterador`,`data_criado`,`data_alterado`)
VALUES
(
'Mande a sua foto e concorra a um SET','1.jpg',
'Promoção valida apenas para São Paulo.',
'Mande a sua foto e concorra a um SET. <br/>Promoção valida apenas para São Paulo.',
'2015-01-01','2015-12-01','2015-01-01',
'ATIVO',
(SELECT id FROM teste_users WHERE username = 'jorge' ),
(SELECT id FROM teste_users WHERE username = 'jorge' ),
NOW(),
NOW());



INSERT INTO `joomla`.`teste_angelgirls_sessao`
(`titulo`,`nome_foto`,`executada`,`descricao`,`historia`,`comentario_fotografo`,`comentario_modelos`,`comentario_equipe`,`meta_descricao`,
`id_agenda`,`id_tema`,`id_modelo_principal`,`id_modelo_secubdaria`,`id_locacao`,`id_fotografo_principal`,`id_fotografo_secubdario`,`id_producao_principal`,
`id_producao_secubdario`,`id_figurino_principal`,`id_figurino_secubdario`,`audiencia_gostou`,`audiencia_ngostou`,`audiencia_view`,`publicar`,
`status_dado`,`id_usuario_criador`,`id_usuario_alterador`,`data_criado`,`data_alterado`)
VALUES
('Sessão Inicial Para o Site da Angel','1.jpg','2015-01-31','Sessao experimental','Sessao experimental','Sessao experimental','',
'','Sessao experimental',null,1,1,null,1,1,null,null,null,null,null,0,0,0,'2015-01-01','NOVO',
(SELECT id FROM teste_users WHERE username = 'jorge' ),
(SELECT id FROM teste_users WHERE username = 'jorge' ),
NOW(),
NOW());
