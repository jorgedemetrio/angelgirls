<?php

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );



if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=carregarAlbuns&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}


$conteudo = JRequest::getVar('album');
$fotos = JRequest::getVar('fotos');
$id = JRequest::getInt('id');


?>
<div class="page-header">
	<h1><?php echo($conteudo->titulo);?>
	<small><?php echo($conteudo->nome_tema);?></small>
	<div class="gostar" data-gostei='<?php echo($conteudo->gostei_sessao);?>' data-id='<?php echo($conteudo->id);?>' data-area='album' data-gostaram='<?php echo($conteudo->audiencia_gostou);?>'></div>
</h1>

</div>

<script>



</script>
<ul class="nav nav-tabs nav-justified" id="myTabTabs" role="tablist" style="margin-bottom: 0;">
	<li class="active" role="presentation">
		<a href="#general" data-toggle="tab" aria-controls="profile" role="tab">Detalhes
		<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
		</a>
	</li>
	<li role="presentation">
		<a href="#comentarios" data-toggle="tab" aria-controls="profile" role="tab">Coment&aacute;rios
		<span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
		</a>
	</li>
</ul>

<div id="detalhesAlbum" class="tab-content" style="overflow: auto;">
	<div id="general" class="tab-pane fade in active" style="height: 210px;">
		<h2>Detalhes</h2>
		<div class="row">
			<div class="label col col-xs-12 col-sm-2 col-md-2 col-lg-1">
		    	Acessos
			</div>		
			<div class="label col col-xs-12 col-sm-2 col-md-2 col-lg-1">
		    	Realizado
			</div>		
			<div class="label col col-xs-12 col-sm-2 col-md-2 col-lg-1">
		    	Publicado
			</div>		
		</div>
		<div class="row">
			<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-1 text-center">
		    	<?php echo($conteudo->audiencia_view )?>
			</div>
			<div class="col col-xs-12 col-sm-3 col-md-2 col-lg-1 text-center">
		    	<?php echo(JFactory::getDate($conteudo->executada)->format('d/m/Y')); ?>
			</div>
			<div class="col col-xs-12 col-sm-3 col-md-2 col-lg-1 text-center">
		    	<?php echo(JFactory::getDate($conteudo->publicar)->format('d/m/Y')); ?>
			</div>
		</div>
		<div class="row">
			<div class="col col-xs-12 col-sm-4 col-md-2 col-lg-2 text-center" style="vertical-align: middle; height: 100%">
				<div class="dropdown">
				  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Compartilhar <span class="glyphicon glyphicon-share"></span>
				    <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				    <li><div class="fb-share-button" data-layout="button_count"></div></li>
				    <li role="separator" class="divider"></li>
				    <li><div class="vkShare" data-action="share"></div></li>
				    <li role="separator" class="divider"></li>
				    <li><div class="g-plus" data-action="share"></div></li>
				  </ul>
				</div>
			</div>
			<div class="col col-xs-12 col-sm-8 col-md-10 col-lg-10 well">
				<h4>Descri&ccedil;&atilde;o </h4>
		    	<?php echo($conteudo->descricao )?>
			</div>
		</div>    
	</div>
	<div id="comentarios" class="tab-pane fade" style="height: 210px;">
		<div class="fb-comments" data-href="http://<?php echo($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']); ?>" data-width="100%" style="margin: 0 auto;"></div>
	</div>
</div>
<h2>Fotos</h2>
<div class="row"  id="linha">
	<?php
	$count = 0;
	foreach($fotos as $foto): 
		$url = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarFoto&id='.$foto->id.':foto-sensual-'.strtolower(str_replace(" ","-",$foto->titulo))); 
		$urlFoto = JRoute::_('index.php?option=com_angelgirls&view=fotoalbum&task=loadImage&id='.$foto->id.':'.$conteudo->id.'-thumbnail'); ?>

		<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-2 thumbnail">
    		<a href="<?php echo($url);?>"><img src="<?php echo($urlFoto);?>" /></a>
    	</div>
	<?php
	endforeach; 
	?>
</div>
<div class="row" id="carregando" style="display: none">
	<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="height: 300px; vertical-align: middle; text-align: center;" class="text-center">
		<img src="<?php echo(JURI::base( true ))?>/components/com_angelgirls/loading_img.gif" alt="carregando" title="Carregando" style="width: 450px"/>
	</div>
</div>

<script>
var lidos = <?php echo(sizeof($fotos));?>;
var carregando = false;
var temMais=false;
jQuery(document).ready(function() {

	if(lidos>=24){
		jQuery('#carregando').css('display','');
		temMais=true;
	}
	else{
		jQuery('#carregando').css('display','none');
		temMais=false;
	}
	
	
	jQuery(document).scroll(function(){
		 if( (jQuery(window).height()+jQuery(this).scrollTop()+300) >= jQuery(document).height() && !carregando && temMais) {
			carregando = true;
			jQuery.post('<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarFotosContinuaHtml&id='.$conteudo->id.':album-'.strtolower(str_replace(" ","-",$conteudo->titulo)),false)); ?>',
					{posicao: lidos}, function(dado){
				jQuery("#carregando").css("display","none");
				if(dado.length<=0){
					jQuery("#carregando").css("display","none");
					temMais=false;
				}
				else{
					//lidos = lidos+24;
					jQuery('#carregando').css('display','');
					jQuery('#linha').append(dado);
				}		
				carregando=false;					
			},'html');
		 }
	});
});
</script>