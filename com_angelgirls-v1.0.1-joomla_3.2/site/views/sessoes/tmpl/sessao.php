<?php

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );



if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=carregarSessoes&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}


$conteudo = JRequest::getVar('sessao');
$fotos = JRequest::getVar('fotos');


// $query->select('`s`.`id`,`s`.`titulo`,`s`.`nome_foto`,`s`.`executada`,`s`.`descricao`,`s`.`historia`,`s`.`comentario_fotografo`,`s`.`comentario_modelos`,
// 						`s`.`comentario_equipe`,`s`.`meta_descricao`,`s`.`id_agenda`,`s`.`id_tema`,`s`.`id_modelo_principal`,`s`.`id_modelo_secubdaria`,
// 						`s`.`id_locacao`,`s`.`id_fotografo_principal`,`s`.`id_fotografo_secundario`,`s`.`id_figurino_principal`,`s`.`id_figurino_secundario`,
// 						`s`.`audiencia_gostou`,`s`.`audiencia_ngostou`,`s`.`audiencia_view`,`s`.`publicar`,`s`.`status_dado`,`s`.`id_usuario_criador`,
// 						`s`.`id_usuario_alterador`,`s`.`data_criado`,`s`.`data_alterado`,
// 						`tema`.`nome` AS `nome_tema`,`tema`.`descricao` AS `descricao_tema`,`tema`.`nome_foto` AS `foto_tema`,`tema`.`audiencia_gostou` AS `gostou_tema`,
// 						CASE isnull(`vt_sessao`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_tema`,
// 						CASE isnull(`vt_fo1`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_tema`,
// 						CASE isnull(`vt_fo2`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_tema`,
// 						CASE isnull(`mod1`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_tema`,
// 						CASE isnull(`mod2`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_tema`,
// 						`fot1`.`nome_artistico` AS `fotografo1`,`fot1`.`audiencia_gostou` AS `gostou_fot1`,`fot1`.`nome_foto` AS `foto_fot1`,
// 						`fot2`.`nome_artistico` AS `fotografo2`,`fot2`.`audiencia_gostou` AS `gostou_fot2`,`fot2`.`nome_foto` AS `foto_fot2`,
// 						`loc`.`nome` AS `nome_locacao`,`loc`.`nome_foto` AS `foto_locacao`,`loc`.`audiencia_gostou` AS `gostou_locacao`,
// 						`mod1`.`nome_artistico` AS `modelo1`,`mod1`.`foto_perfil` AS `foto_mod1`,`mod1`.`audiencia_gostou` AS `gostou_mo1`,
// 						`mod2`.`nome_artistico` AS `modelo2`,`mod2`.`foto_perfil` AS `foto_mod2`,`mod2`.`audiencia_gostou` AS `gostou_mo2`,
// 						`fig1`.`titulo` AS `figurino1`,`fig1`.`audiencia_gostou` AS `gostou_fig1`,
// 						`fig2`.`titulo` AS `figurino2`,`fig2`.`audiencia_gostou` AS `gostou_fig2`')
?>
<div class="page-header">
	<h1><?php echo($conteudo->titulo);?><?php if($conteudo->gostei_sessa=='SIM'):?>
			<span class="badge" title="Gostou"><?php echo($conteudo->audiencia_gostou);?> 
			<span class="glyphicon glyphicon-star" aria-hidden="true" title="Gostou"></span>
			</span>
		<?php else : ?>
			<span class="badge" title=""><?php echo($conteudo->audiencia_gostou);?> 
			<span class="glyphicon glyphicon-heart-empty" aria-hidden="true" title=""></span>
			</span>
		<?php endif?></h1>

</div>
  

<div class="row">
	<div class="label col col-xs-12 col-sm-3 col-md-3 col-lg-2">
    	Modelo
	</div>
</div>
<div class="row">
	<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-2">
    	<?php echo($conteudo->modelo1)?>
	</div>
</div>    	


<div class="row">
	<div class="label col col-xs-12 col-sm-3 col-md-3 col-lg-2">
    	Fotografo
	</div>
</div>
<div class="row">
	<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-2">
    	<?php echo($conteudo->fotografo1)?>
	</div>
</div>


<div class="row">
	<?php
	$count = 0;
	foreach($fotos as $foto): 
	$url = JRoute::_('index.php?com_angelgirls&view=sessoes&task=carregarFoto&id='.$foto->id.':'.strtolower(str_replace(" ","-",$foto->titulo))); ?>
		<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-2 thumbnail">
    		<a href="<?php echo($url);?>"><img src="<?php echo(JURI::base( true ) . '/images/sessoes/' . $conteudo->id . '/' . $foto->id . '_thumbnail.jpg');?>" /></a>
    	</div>
		<?php
	endforeach; 
	?>
</div>