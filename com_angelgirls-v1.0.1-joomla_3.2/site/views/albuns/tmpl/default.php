<?php

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );



if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=carregarAlbuns&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}

$albuns = JRequest::getVar('albuns');

$nome = JRequest::getString('nome','');
$dataInicio = JRequest::getString('data_inicio','');
$dataFim = JRequest::getString('data_fim','');
$idModelo = JRequest::getInt('id_modelo',0);
$idFotografo = JRequest::getString('id_fotografo',0);
$ordem = JRequest::getString('ordem',0);


if($dataInicio!=''){
	$dataInicio = DateTime::createFromFormat('d/m/Y', $dataInicio )->format('Y-m-d');
}
if($dataFim!=''){
	$dataFim = DateTime::createFromFormat('d/m/Y', $dataFim )->format('Y-m-d');
}
?>
<div class="page-header">
	<h1>Albuns/Galerias de fotos <small>ache as fotos com as modelos mais bonitas da internet!</small></h1>
</div>
<form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data" >
	<?php echo JHtml::_('form.token');?>
	<input type="hidden" name="task" id="task" value="carregarAlbuns"/>
	<input type="hidden" name="option" id="option" value="com_angelgirls"/>
	<input type="hidden" name="controller" id="controller" value="Angelgirls"/>
	
	<div class="btn-group pull-right" role="group">
		<div class="btn-group" role="group">
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
		<input class="form-control" style="width: 90%;" type="text" name="nome"  id="nome" value="<?php echo($nome);?>" size="32" maxlength="150" placeholder="<?php echo JText::_('Buscar por titulo'); ?>"/>
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
		<label class="control-label"  for="data_fim"><?php echo JText::_('Ordem'); ?></label>
		<select name="ordem" id="ordem" class="form-control">
			<option value="1"<?php echo($ordem==1?' SELECTED':'')?>>Data Ultimas->Primeiras</option>
			<option value="2"<?php echo($ordem==2?' SELECTED':'')?>>Data Primeiras->Ultimas</option>
			<option value="3"<?php echo($ordem==3?' SELECTED':'')?>>Titulos de A->Z</option>
			<option value="4"<?php echo($ordem==4?' SELECTED':'')?>>Titulos de Z->A</option>
		</select>
	</div>
	</div>
</div>

</form>
<h2>Albuns</h2>
<div class="row" id="linha">
<?php
	foreach($albuns as $conteudo){ ?>
	<div class="col col-xs-12 col-sm-4 col-md-3 col-lg-2">
		<div class="thumbnail">
<?php  
$url = JRoute::_('index.php?option=com_angelgirls&view=albuns&task=carregarAlbum&id='.$conteudo->id.':album-'.strtolower(str_replace(" ","-",$conteudo->alias)));
$urlImg = JRoute::_('index.php?option=com_angelgirls&view=albuns&task=loadImage&id='.$conteudo->id.':ico'); 
?>
				<h5 class="list-group-item-heading" style="width: 100%; text-align: center; background-color: grey; color: white;  padding: 10px;overflow: hidden; text-overflow: ellipsis; "><a href="<?php echo($url);?>" style="color: white;"><?php echo($conteudo->nome);?></a>
				<div class="gostar" data-gostei='<?php echo($conteudo->eu);?>' data-id='<?php echo($conteudo->id);?>' data-area='album' data-gostaram='<?php echo($conteudo->gostou);?>'></div>
				</h5>
<?php 			if(isset($conteudo->foto) && isset($conteudo->foto)!=""){?>
					<a href="<?php echo($url);?>"><img src="<?php echo($urlImg);?>" title="<?php echo($conteudo->nome);?>" alt="<?php echo($conteudo->nome);?>"/></a>
				<?php 
				}?>
				<div class="caption">

				<p class="text-center"><?php echo($conteudo->descricao);?></p>
				<p class="text-center"><a href="<?php echo($url);?>" class="btn btn-primary" role="button" style="text-overflow: ellipsis;max-width: 150px;  overflow: hidden;  direction: ltr;"><?php echo($conteudo->nome);?>

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
		<img src="<?php echo(JURI::base( true ))?>/components/com_angelgirls/loading_img.gif" alt="carregando" title="Carregando" style="width: 450px"/>
	</div>
</div>
<script>
var lidos = <?php echo(sizeof($albuns));?>;
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
	
	
	if(lidos>=24){
		jQuery('#carregando').css('display','');
		temMais=true;
	}
	else{
		jQuery('#carregando').css('display','none');
		temMais=false;
	}

	jQuery('#limpar').click(function(){
		window.location='<?php echo( JRoute::_('index.php?option=com_angelgirls&view=albuns&task=carregarAlbuns&id=album',false));?>';
		});
	
	
	jQuery(document).scroll(function(){
		 if( (jQuery(window).height()+jQuery(this).scrollTop()+200) >= jQuery(document).height() && !carregando && temMais) {
			carregando = true;
			jQuery.post('<?php echo(JRoute::_('index.php?option=com_angelgirls&view=albuns&task=carregarAlbunsContinuaJson',false)); ?>',{
				nome:'<?php echo($nome); ?>',
				data_inicio:'<?php echo(JRequest::getString('data_inicio','')); ?>',
				data_fim:'<?php echo(JRequest::getString('data_fim','')); ?>',
				id_modelo:'<?php echo($idModelo); ?>',
				id_fotografo:'<?php echo($idFotografo); ?>',
				ordem:'<?php echo($ordem); ?>',	posicao: lidos
				}, function(dado){
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