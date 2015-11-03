<?php

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );



if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=carregarSessoes&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}
JFactory::getDocument()->addScriptDeclaration('var lidos = 0;');
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
$somenteMinha = JRequest::getString('somente_minha');


if($dataInicio!=''){
	$dataInicio = DateTime::createFromFormat('d/m/Y', $dataInicio )->format('Y-m-d');
}
if($dataFim!=''){
	$dataFim = DateTime::createFromFormat('d/m/Y', $dataFim )->format('Y-m-d');
}
?>
<div class="row">
<?php AngelgirlsController::GetMenuLateral(); ?>
	<div id="conteudo" class="col col-xs-12 col-sm-9 col-md-9 col-lg-10">
		<div class="page-header">
			<h1>Albuns de fotos</h1>
		</div>
		<form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data" >
			<?php echo JHtml::_('form.token');?>
			<input type="hidden" name="task" id="task" value="carregarSessoes"/>
			<input type="hidden" name="option" id="option" value="com_angelgirls"/>
			<input type="hidden" name="view" id="option" value="sessoes"/>
			<input type="hidden" name="somente_minha" id="somente_minha" value="<?php echo($somenteMinha);?>"/>
			<input type="hidden" name="Itemid" id="Itemid" value="<?php echo(JRequest::getVar ( 'Itemid' ));?>"/>
			<div class="btn-toolbar pull-right" role="toolbar">
				<?php if(isset($perfil)) : ?>
				<div class="btn-group" role="group"  aria-label="Funções">
					<a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarEditarAlbum&Itemid='.JRequest::getVar ( 'Itemid' )));?>" class="btn btn-success" type="button" id="novo"><?php echo JText::_('Nova'); ?>
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
			<div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-3">
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
			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<label class="control-label"  for="ordem"><?php echo JText::_('Ordem'); ?></label>
				<select name="ordem" id="ordem" class="form-control">
					<option value="1"<?php echo($ordem==1?' SELECTED':'')?>>Ultimas->Primeiras sess&otilde;es</option>
					<option value="2"<?php echo($ordem==2?' SELECTED':'')?>>Primeiras->Ultimas sess&otilde;es</option>
					<option value="3"<?php echo($ordem==3?' SELECTED':'')?>>Titulos de A->Z</option>
					<option value="4"<?php echo($ordem==4?' SELECTED':'')?>>Titulos de Z->A</option>
				</select>
			</div>
			<?php if(isset($perfil)) : ?>
			<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: right;">
				<div style="text-align: right; margin-top: 0px;" title='Deve clicar em "Filtrar" para ter efeito.' class="checkbox-iten" data-hidden-value="SIM" data-hidden-label="<?php echo JText::_('Somente as Minhas'); ?>" data-hidden-id='somente_minha' id="somente_minha_bt"  name="somente_minha_bt"
					onchange='if(jQuery("#somente_minha").val()!="<?php echo($somenteMinha);?>"){info("Deve clicar em \"Filtrar\" para ter efeito.");}'></div>
			</div>
			<?php endif;?>
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
		<h2>Albuns</h2>
		<div class="row" id="linha">
		<?php
		require_once 'album_html.php';
		?>
		</div>
		<div class="row" id="carregando" style="display: none">
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="height: 300px; vertical-align: middle; text-align: center;" class="text-center">
				<img src="<?php echo(JURI::base( true ))?>/components/com_angelgirls/loading_img.gif" alt="carregando" title="Carregando" style="width: 450px"/>
			</div>
		</div>
	</div>
</div>
<script>
var carregando = false;
var temMais=false;
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
	
	
	if(lidos>=<?php echo(AngelgirlsController::LIMIT_DEFAULT)?>){
		jQuery('#carregando').css('display','');
		temMais=true;
	}
	else{
		jQuery('#carregando').css('display','none');
		temMais=false;
	}

	jQuery('#limpar').click(function(){
		window.location='<?php echo( JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessoes&id=sessoes-fotos-sensuais&Itemid='.JRequest::getVar ( 'Itemid' ),false));?>';
	});
	
	
	jQuery(document).scroll(function(){
		 if( (jQuery(window).height()+jQuery(this).scrollTop()+200) >= jQuery(document).height() && !carregando && temMais) {
			carregando = true;
			jQuery.post('<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessoesContinuaJson',false)); ?>',{
				nome:'<?php echo($nome); ?>',
				data_inicio:'<?php echo(JRequest::getString('data_inicio','')); ?>',
				data_fim:'<?php echo(JRequest::getString('data_fim','')); ?>',
				id_modelo:'<?php echo($idModelo); ?>',
				id_fotografo:'<?php echo($idFotografo); ?>',
				ordem:'<?php echo($ordem); ?>',
				somente_minha:'<?php echo($somenteMinha); ?>',	
				posicao: lidos}, function(dado){
				jQuery('#linha').append(dado);		
				carregando=false;
				setTimeout(function(){ AngelGirls.ResetConfig();}, 500);
			},'html');
		 }
	});

	jQuery('#id_modelo').change();
	jQuery('#id_fotografo').change();
});
</script>