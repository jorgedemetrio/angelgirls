<?php

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );



if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=carregarSessoes&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}

$sessoes = JRequest::getVar('sessoes');
$modelos = JRequest::getVar('modelos');
$fotografos = JRequest::getVar('fotografos');

$nome = JRequest::getString('nome','','POST');
$dataInicio = JRequest::getString('data_inicio','','POST');
$dataFim = JRequest::getString('data_fim','','POST');
$idModelo = JRequest::getInt('id_modelo',0,'POST');
$idFotografo = JRequest::getString('id_fotografo',0,'POST');

if($dataInicio!=''){
	$dataInicio = DateTime::createFromFormat('d/m/Y', $dataInicio )->format('Y-m-d');
}
if($dataFim!=''){
	$dataFim = DateTime::createFromFormat('d/m/Y', $dataFim )->format('Y-m-d');
}
?>
<div class="page-header">
	<h1>Sess&otilde;es de fotos sensuais <small>com as modelos mais bonitas, gatas e gostosas</small></h1>
</div>
<form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data" >
	<?php echo JHtml::_('form.token'); ?>
	<input type="hidden" name="task" id="task" value="carregarSessoes"/>
	<input type="hidden" name="option" id="option" value="com_angelgirls"/>
	<input type="hidden" name="controller" id="controller" value="Angelgirls"/>
	
	<div class="btn-group pull-right" role="group">
		<div class="btn-group" role="group">
			<button  class="btn btn-success" type="submit"><?php echo JText::_('Filtrar'); ?>
				<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
			</button>
		</div>
	</div>
	<h2>Filtro</h2>
<div>
	<div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
		<label class="control-label"  for="nome"><?php echo JText::_('Titulo'); ?></label>
		<input class="form-control" style="width: 90%;" type="text" name="nome"  id="nome" value="<?php echo($nome);?>" size="32" maxlength="150" placeholder="<?php echo JText::_('Buscar por titulo da sess&atilde;o'); ?>"/>
	</div>
	<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-4">
		<label class="control-label"  for="data_inicio"><?php echo JText::_('Apartir da data'); ?></label>
		<?php echo JHtml::calendar($dataInicio, 'data_inicio', 'data_inicio', '%d/%m/%Y', 'class="form-control validate-data validate-apartir"');?>
	</div>
	<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-4">
		<label class="control-label"  for="data_fim"><?php echo JText::_('At&eacute; a data'); ?></label>
		<?php echo JHtml::calendar($dataFim, 'data_fim', 'data_fim', '%d/%m/%Y', 'class="form-control validate-data validate-ate"');?>
	</div>
	<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-6">
		<label class="control-label"  for="id_modelo"><?php echo JText::_('Com a modelo'); ?></label>
		<select name="id_modelo" id="id_modelo" class="form-control"/>
			<option></option>
			<?php foreach($modelos as $conteudo){ 
			$img =  JURI::base( true ) . '/images/modelos/' . $conteudo->foto;
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
				$img =  JURI::base( true ) . '/images/fotografos/' . $conteudo->foto;
			?>
			<option value="<?php echo($conteudo->id);?>" data-foto="<?php echo($img); ?>" title="<?php echo($conteudo->nome);?>"<?php echo($idFotografo==$conteudo->id?" selected":"") ?>><?php echo($conteudo->nome);?></option>
		    <?php 
			}?>
		</select>
	</div>
</div>
<div class="row">
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
<div class="row" id="linha">
<?php
	foreach($sessoes as $conteudo){ ?>
	<div class="col col-xs-12 col-sm-4 col-md-3 col-lg-3">
		<div class="thumbnail">
<?php  $url = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessao&id='.$conteudo->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$conteudo->alias))); ?>
					<h5 class="list-group-item-heading" style="width: 100%; text-align: center; background-color: grey; color: white;  padding: 10px;"><a href="<?php echo($url);?>" style="color: white;"><?php echo($conteudo->nome);?></a>
    			<?php if($conteudo->eu=='SIM'):?>
					<span class="badge" title="Gostou"><?php echo($conteudo->gostou);?> 
					<span class="glyphicon glyphicon-star" aria-hidden="true" title="Gostou"></span>
					</span>
				<?php else : ?>
					<span class="badge" title=""><?php echo($conteudo->gostou);?> 
					<span class="glyphicon glyphicon-heart-empty" aria-hidden="true" title=""></span>
					</span>
				<?php endif?></h5>
<?php 			if(isset($conteudo->foto) && isset($conteudo->foto)!=""){?>
					<a href="<?php echo($url);?>"><img src="<?php echo(JURI::base( true ) . '/images/sessoes/' . $conteudo->foto);?>" title="<?php echo($conteudo->nome);?>" alt="<?php echo($conteudo->nome);?>"/></a>
				<?php 
				}?>
				<div class="caption">

				<p class="text-center"><?php echo($conteudo->descricao);?></p>
				<p class="text-center"><a href="<?php echo($url);?>" class="btn btn-primary" role="button"><?php echo($conteudo->nome);?>

				</a></p>
				</div>
		</div>
	</div>
	<?php
	} 
?>
</div>
<div class="row" id="carregando" style="display: none">
	<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="height: 300px; vertical-align: middle; text-align: center;" class="text-center">
		<img src="<?php echo(JURI::base( true ))?>/components/com_angelgirls/loading.gif" alt="carregando" title="Carregando" style="width: 200px"/>
	</div>
</div>
<script>
var lidos = <?php echo(sizeof($sessoes));?>;

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
	
	
	if(lidos>30){
		jQuery('#carregando').css('display','');
	}
	
	jQuery('body').scroll(function() {
		 if (jQuery(this).scrollTop() + jQuery(this).height() == jQuery(this).get(0).scrollHeight) {
			 //carregar
			 // jQuery('#linha').append(data);
		 }
	});

	jQuery('#id_modelo').change();
	jQuery('#id_fotografo').change();
});
</script>