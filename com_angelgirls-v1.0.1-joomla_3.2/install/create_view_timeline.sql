
CREATE OR REPLACE VIEW #__timeline (id,  tipo,  titulo, descricao, prioridade, data_publicado, 
	audiencia, acessos, rnd, opt1, opt2, opt3, opt4) AS
(SELECT 
	s.id, 
    'SESSOES' as tipo, 
    s.titulo,
    s.descricao, 
    0.9 as prioridade, 
    s.publicar as data_publicado, 
	s.audiencia_gostou as audiencia,
    s.audiencia_view as acessos,
    RAND() as rnd,
    '' AS opt1,
    '' AS opt2,
    '' AS opt3,
    '' AS opt4
FROM 
	#__angelgirls_sessao as s
WHERE
	s.status_dado =  'PUBLICADO' AND
    s.publicar <= NOW() 
ORDER BY 
	s.publicar DESC)
UNION 
(SELECT 
	s.id, 
    'CONTENT' as tipo, 
    s.title as titulo, 
    s.introtext as descricao,
    0.5 as prioridade, 
    s.publish_up as data_publicado, 
	0 as audiencia,
    s.access as acessos,
	RAND() as rnd,
    concat(id , ':' , alias) AS opt1,
    catid AS opt2,
    language AS opt3,
	MID(`images`,LOCATE(':',`images`)+2, LOCATE(',',`images`)-LOCATE(':',`images`)-2) AS opt4
FROM 
	#__content as s
WHERE
	s.state =  1 AND
    s.publish_up <= NOW()   AND 
    s.images IS NOT NULL AND
    LENGTH(s.images) > 5
ORDER BY 
	s.s.publish_up DESC)
UNION
(SELECT 
	s.id, 
    'MODELO' as tipo, 
    s.nome_artistico as titulo, 
    s.meta_descricao as descricao,
    0.4 as prioridade, 
    s.data_criado as data_publicado, 
	s.audiencia_gostou as audiencia,
    s.audiencia_view as acessos,
	RAND() as rnd,
    '' AS opt1,
    '' AS opt2,
    '' AS opt3,
    '' AS opt4
FROM 
	#__angelgirls_modelo as s
WHERE
	s.status_dado NOT IN  ('REMOVIDO','REPROVADO') AND
    s.status_modelo NOT IN  ('REMOVIDO','REPROVADO') AND
    s.foto_perfil <> '' AND
    s.foto_perfil is not null AND 
    s.id IN (SELECT id_modelo_principal as id FROM #__angelgirls_sessao)
ORDER BY 
	s.s.data_alterado DESC)
UNION 
 (SELECT 
	s.id, 
    'POST' as tipo, 
    '' as titulo, 
    s.texto as descricao,
    0.5 as prioridade, 
    s.data_criado as data_publicado, 
	s.audiencia_gostou as audiencia,
    s.audiencia_view as acessos,
	RAND() as rnd,
    u.id AS opt1,
    u.name AS opt2,
    '' AS opt3,
    MID(`images`,LOCATE(':',`images`)+2, LOCATE(',',`images`)-LOCATE(':',`images`)-2) AS opt4
FROM 
	#__angelgirls_post as s INNER JOIN 
    #__users as u ON s.id_usuario = u.id
WHERE
	s.status_dado NOT IN  ('REMOVIDO','REPROVADO') AND
    u.block <> 1
ORDER BY 
	s.s.data_alterado DESC)   
UNION 
 (SELECT 
	s.id, 
    'GALERIA' as tipo, 
    s.titulo as titulo, 
    s.meta_descricao as descricao,
    0.7 as prioridade, 
    s.data_criado as data_publicado, 
	s.audiencia_gostou as audiencia,
    s.audiencia_view as acessos,
	RAND() as rnd,
    '' AS opt1,
    '' AS opt2,
    '' AS opt3,
    '' AS opt4
FROM 
	#__angelgirls_galeria as s 
WHERE
	s.status_dado NOT IN  ('REMOVIDO','REPROVADO') 
ORDER BY 
	s.s.data_alterado DESC)  
UNION 
 (SELECT 
	s.id, 
    'PROMOCAO' as tipo, 
    s.titulo as titulo, 
    s.meta_descricao as descricao,
    0.9 as prioridade, 
    s.inicio as data_publicado, 
	0 as audiencia,
    0 as acessos,
	RAND() as rnd,
    '' AS opt1,
    '' AS opt2,
    '' AS opt3,
    '' AS opt4
FROM 
	#__angelgirls_promocao as s 
WHERE
	s.status_dado = 'PUBLICADO' AND
    s.inicio <= NOW() AND
    s.fim >= NOW() 
ORDER BY 
	s.s.data_alterado DESC) 
UNION
(SELECT 
	s.id, 
    'BANNER' as tipo, 
    s.custombannercode as titulo, 
    s.description as descricao,
    0.7 as prioridade, 
    IF( FLOOR((RAND() * 5)) >3, NOW(), s.publish_up) as data_publicado, 
	s.clicks as audiencia,
    s.track_impressions as acessos,
	RAND() as rnd,
    s.clickurl AS opt1,
    s.alias AS opt2,
    language AS opt3,
   	s.custombannercode AS opt4
FROM 
	#__banners as s
WHERE
	s.state =  1 AND
    s.publish_up <= NOW()  AND 
    s.publish_down >= NOW() AND
    s.catid = 5
ORDER BY 
	s.publish_up DESC, s.clicks)
ORDER BY data_publicado DESC, prioridade DESC;