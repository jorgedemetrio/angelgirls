<?php

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );



if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=carregarMinhasSessoes&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}

JFactory::getDocument()->addStyleSheet(JURI::base( true ).'/components/com_angelgirls/assets/css/jquery.dataTables.css?v='.VERSAO_ANGELGIRLS);
//JFactory::getDocument()->addStyleSheet(JURI::base( true ).'/components/com_angelgirls/assets/css/dataTables.foundation.css?v='.VERSAO_ANGELGIRLS);
//JFactory::getDocument()->addStyleSheet(JURI::base( true ).'/components/com_angelgirls/assets/css/dataTables.bootstrap.css?v='.VERSAO_ANGELGIRLS);
JFactory::getDocument()->addScript(JURI::base( true ).'/components/com_angelgirls/assets/js/jquery.dataTables.js?v='.VERSAO_ANGELGIRLS);
//JFactory::getDocument()->addScript(JURI::base( true ).'/components/com_angelgirls/assets/js/dataTables.foundation.js?v='.VERSAO_ANGELGIRLS);
//JFactory::getDocument()->addScript(JURI::base( true ).'/components/com_angelgirls/assets/js/dataTables.bootstrap.js?v='.VERSAO_ANGELGIRLS);
JFactory::getDocument()->addScript(JURI::base( true ).'/components/com_angelgirls/assets/js/aprovacao.js?v='.VERSAO_ANGELGIRLS);

$sessoes = JRequest::getVar('sessoes');
$modelos = JRequest::getVar('modelos');
$fotografos = JRequest::getVar('fotografos');

$nome = JRequest::getString('nome','');
$dataInicio = JRequest::getString('data_inicio','');
$dataFim = JRequest::getString('data_fim','');
$idModelo = JRequest::getInt('id_modelo',0);
$idFotografo = JRequest::getString('id_fotografo',0);
$ordem = JRequest::getString('ordem',0);
$perfil = JRequest::getVar('perfil');


if($dataInicio!=''){
	$dataInicio = DateTime::createFromFormat('d/m/Y', $dataInicio )->format('Y-m-d');
}
if($dataFim!=''){
	$dataFim = DateTime::createFromFormat('d/m/Y', $dataFim )->format('Y-m-d');
}

JFactory::getDocument()->addScriptDeclaration('

jQuery(document).ready(function() {
		setTimeout(function(){
		    jQuery("#tabelaComSessoes").DataTable({
				"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
				"language": {
		            "lengthMenu": "Exibir _MENU_ itens por p&aacute;gina",
		            "zeroRecords": "N&atilde;o encontrado - sorry",
		            "info": "Exibir pag. _PAGE_ de _PAGES_",
		            "infoEmpty": "Sem registros",
		            "infoFiltered": "(filtrado de _MAX_ total)",
					"search": "Busca"
		        },
				"aoColumns": [
		            null,
					null,
		            { "orderSequence": [ "desc", "asc" ] },
		            null,
		            { "orderSequence": [ "desc", "asc" ] },
		            null,
		            { "orderSequence": [ "desc", "asc" ] },
					{ "orderSequence": [ "desc", "asc" ] }
		        ]
			});
		
		},1000);
});
');

?>
<div class="row">
<?php AngelgirlsController::GetMenuLateral(); ?>
	<div id="conteudo" class="col col-xs-12 col-sm-9 col-md-9 col-lg-10">
		<div class="page-header">
			<h1>Suas sess&otilde;es <small>permite editar e alterar</small></h1>
		</div>
		<form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data" >
			<?php echo JHtml::_('form.token');?>
			<input type="hidden" name="task" id="task" value="carregarMinhasSessoes"/>
			<input type="hidden" name="view" id="option" value="sessoes"/>
			<input type="hidden" name="option" id="option" value="com_angelgirls"/>
		
			<input type="hidden" name="Itemid" id="Itemid" value="<?php echo(JRequest::getVar ( 'Itemid' ));?>"/>
			<div class="btn-toolbar pull-right" role="toolbar">
				<?php if(isset($perfil)) : ?>
				<div class="btn-group" role="group"  aria-label="Funções">
					<a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarEditarSessao'));?>" class="btn btn-success" type="button" id="novo"><?php echo JText::_('Nova'); ?>
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
					</a>
				</div>
				<?php endif;?>
				<div class="btn-group" role="group" aria-label="Busca">
					<button  class="btn btn-" type="button" id="limpar"><?php echo JText::_('Limpar Busca'); ?>
						<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
					</button>
					<button  class="btn btn-success" type="submit"><?php echo JText::_('Filtrar'); ?>
						<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
					</button>
				</div>
			</div>
			<h2>Filtro</h2>
		<div>
			<div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-6">
				<label class="control-label"  for="nome"><?php echo JText::_('Titulo'); ?></label>
				<input class="form-control" style="width: 90%;" type="text" name="nome"  id="nome" value="<?php echo($nome);?>" size="32" maxlength="150" placeholder="<?php echo JText::_('Buscar por titulo da sess&atilde;o'); ?>"/>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<label class="control-label"  for="data_inicio"><?php echo JText::_('Apartir da data'); ?></label>
				<?php echo JHtml::calendar($dataInicio, 'data_inicio', 'data_inicio', '%d/%m/%Y', 'class="form-control validate-data validate-apartir"');?>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<label class="control-label"  for="data_fim"><?php echo JText::_('At&eacute; a data'); ?></label>
				<?php echo JHtml::calendar($dataFim, 'data_fim', 'data_fim', '%d/%m/%Y', 'class="form-control validate-data validate-ate"');?>
			</div>
		
			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-6">
				<label class="control-label"  for="id_modelo"><?php echo JText::_('Com a modelo'); ?></label>
				<select name="id_modelo" id="id_modelo" class="form-control"/>
					<option></option>
					<?php foreach($modelos as $conteudo){ 
					$img =  JRoute::_('index.php?option=com_angelgirls&view=modelo&task=loadImage&id='.$conteudo->id.':ico');
					?>
					<option value="<?php echo($conteudo->id);?>" data-foto="<?php echo($img); ?>" title="<?php echo($conteudo->nome);?>"<?php echo($idModelo==$conteudo->id?" selected":"") ?>>
					<?php echo($conteudo->nome);?></option>
				    <?php 
					}?>
				</select>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-6">
				<label class="control-label"  for="id_modelo"><?php echo JText::_('Com a modelo'); ?></label>
				<select name="id_fotografo" id="id_fotografo" class="form-control"/>
					<option></option>
					<?php foreach($fotografos as $conteudo){
						$img =  JRoute::_('index.php?option=com_angelgirls&view=fotografo&task=loadImage&id='.$conteudo->id.':ico');
					?>
					<option value="<?php echo($conteudo->id);?>" data-foto="<?php echo($img); ?>" title="<?php echo($conteudo->nome);?>"<?php echo($idFotografo==$conteudo->id?" selected":"") ?>><?php echo($conteudo->nome);?></option>
				    <?php 
					}?>
				</select>
			</div>
		</div>
		<div class="row hidden-phone">
			<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-6 thumbnail" id="fotoModelo" style="display:none;  text-align: center;">
				<h4>Modelo selecionada</h4>
				<img src="" id="fotoModeloImg" alt="" title="" style="width: 150px"/>
			</div>
			<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-6 thumbnail" id="fotoFotografo" style="display:none; text-align: center;" >
				<h4>Fotografo selecionada</h4>
				<img src="" id="fotoFotografoImg" alt="" title="" style="width: 150px"/>
			</div>
		</div>
		</form>
		<h2>Sess&otilde;es</h2>
<?php
		require_once 'meu_album_html.php';
?>
	</div>
</div>
<script>
jQuery(document).ready(function() {


	jQuery('#id_modelo').change(function(){
		jQuery('#fotoModelo').fadeOut();
		$iten = jQuery('#id_modelo option:selected');
		if($iten && $iten.length>0 && $iten.val()!=""){
			jQuery('#fotoModeloImg').attr('src',$iten.attr('data-foto'));
			jQuery('#fotoModeloImg').attr('alt',$iten.attr('title'));
			jQuery('#fotoModeloImg').attr('title',$iten.attr('title'));
			jQuery('#fotoModelo').fadeIn();
		}
	});

	jQuery('#id_fotografo').change(function(){
		jQuery('#fotoFotografo').fadeOut();
		$iten = jQuery('#id_fotografo option:selected');
		if($iten && $iten.length>0 && $iten.val()!=""){
			jQuery('#fotoFotografoImg').attr('src',$iten.attr('data-foto'));
			jQuery('#fotoFotografoImg').attr('alt',$iten.attr('title'));
			jQuery('#fotoFotografoImg').attr('title',$iten.attr('title'));
			jQuery('#fotoFotografo').fadeIn();
		}
	});
	


	jQuery('#id_modelo').change();
	jQuery('#id_fotografo').change();
});
</script>