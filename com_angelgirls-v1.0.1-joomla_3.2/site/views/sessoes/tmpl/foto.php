<?php

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );



if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=carregarSessoes&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}

//http://osvaldas.info/image-lightbox-responsive-touch-friendly
// JFactory::getDocument()->addScript('components/com_angelgirls/assets/js/lightbox.js');
JFactory::getDocument()->addStyleSheet('components/com_angelgirls/assets/css/lightbox.css');


// selector:       'id="imagelightbox"',   // string;
// allowedTypes:   'png|jpg|jpeg|gif',     // string;
// animationSpeed: 250,                    // integer;
// preloadNext:    true,                   // bool;            silently preload the next image
// enableKeyboard: true,                   // bool;            enable keyboard shortcuts (arrows Left/Right and Esc)
// quitOnEnd:      false,                  // bool;            quit after viewing the last image
// quitOnImgClick: false,                  // bool;            quit when the viewed image is clicked
// quitOnDocClick: true,                   // bool;            quit when anything but the viewed image is clicked
// onStart:        false,                  // function/bool;   calls function when the lightbox starts
// onEnd:          false,                  // function/bool;   calls function when the lightbox quits
// onLoadStart:    false,                  // function/bool;   calls function when the image load begins
// onLoadEnd:      false                   // function/bool;   calls function when the image finishes loading
$foto = JRequest::getVar('foto');
$conteudo =$foto;
$fotos = JRequest::getVar('fotos');
$urlFoto = JRoute::_('index.php?option=com_angelgirls&view=fotosessao&task=loadImage&id='.$foto->id.':'.$foto->id_sessao.'-full');


?>
<div class="page-header">
	<h1><?php echo($conteudo->titulo);?>
	<small><?php echo($conteudo->nome_tema);?></small>
	<?php if($conteudo->gostei_sessa=='SIM'):?>
		<span class="badge" title="Gostou"><?php echo($conteudo->audiencia_gostou);?> 
		<span class="glyphicon glyphicon-star" aria-hidden="true" title="Gostou"></span>
		</span>
	<?php else : ?>
		<span class="badge" title=""><?php echo($conteudo->audiencia_gostou);?> 
		<span class="glyphicon glyphicon-heart-empty" aria-hidden="true" title=""></span>
		</span>
	<?php endif?></h1>

</div>

<ul class="nav nav-tabs nav-justified" id="myTabTabs" role="tablist" style="margin-bottom: 0;">
	<li class="active" role="presentation">
		<a href="#general" data-toggle="tab" aria-controls="profile" role="tab">Detalhe sess&atilde;o
		<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
		</a>
	</li>
	<li role="presentation">
		<a href="#modelos" data-toggle="tab" aria-controls="profile" role="tab">Modelo(s)
		<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
		</a>
	</li>
	<li role="presentation">
		<a href="#fotografos" data-toggle="tab" aria-controls="profile" role="tab">Fotografo(s)
		<span class="glyphicon glyphicon-camera" aria-hidden="true"></span>
		</a>
	</li>
</ul>

<div id="detalhesSessao" class="tab-content" style="overflow: auto;">
	<div id="general" class="tab-pane fade in active" style="height: 170px;">
		<h2>Detalhe sess&atilde;o</h2>
		<div class="row">
			<div class="label col col-xs-12 col-sm-3 col-md-3 col-lg-3">
		    	Tema
			</div>
			<div class="label col col-xs-12 col-sm-2 col-md-2 col-lg-3">
		    	Figurino
			</div>
			<div class="label col col-xs-12 col-sm-3 col-md-3 col-lg-4">
		    	Local
			</div>
			<div class="label col col-xs-12 col-sm-2 col-md-2 col-lg-1">
		    	Realizado
			</div>		
			<div class="label col col-xs-12 col-sm-2 col-md-2 col-lg-1">
		    	Publicado
			</div>		
		</div>
		<div class="row">
			<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-3 text-center">
		    	<?php echo($conteudo->nome_tema)?>
			</div>
			<div class="col col-xs-12 col-sm-3 col-md-2 col-lg-3 text-center">
		    	<?php echo($conteudo->figurino1 . isset($conteudo->figurino2)?', '.$conteudo->figurino2:'' )?>
			</div>
			<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-4 text-center">
		    	<?php echo($conteudo->nome_locacao )?>
			</div>
			<div class="col col-xs-12 col-sm-3 col-md-2 col-lg-1 text-center">
		    	<?php echo(JFactory::getDate($conteudo->executada)->format('d/m/Y')); ?>
			</div>
			<div class="col col-xs-12 col-sm-3 col-md-2 col-lg-1 text-center">
		    	<?php echo(JFactory::getDate($conteudo->publicar)->format('d/m/Y')); ?>
			</div>
		</div>
		<div class="row">
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 well">
		    	<?php echo($conteudo->descricao )?>
			</div>
		</div>    
	</div>
<?php $urlBusca = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessoes&id=sessoes-fotos-sensuais',false); ?>
	<div id="modelos" class="tab-pane fade in" style="height: 170px;">
		<h2>Modelo(s)</h2>
		<div class="row">
			<div class="col col-xs-12 col-sm-2 col-md-2 col-lg-1 text-center">
			<?php $url = JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$conteudo->id_modelo_principal.':modelo-'.strtolower(str_replace(" ","-",$conteudo->modelo1)),false); ?>
				<a href="<?php echo($url); ?>" href="<?php echo($url); ?>" title="Modelo <?php echo($conteudo->modelo1);?>">
					<img src="<?php echo(JURI::base( true ));?>/images/modelos/<?php echo($conteudo->foto_mod1);?>" title="Modelo <?php echo($conteudo->modelo1);?>" alt="Modelo <?php echo($conteudo->modelo1);?>" class="img-circle">
				</a>
			</div>
			<?php if(isset($conteudo->modelo2)) : ?>
			<div class="col col-xs-12 col-sm-4 col-md-4 col-lg-5">
			<?php else :?>
			<div class="col col-xs-12 col-sm-10 col-md-10 col-lg-11">
			<?php endif; ?>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<h3><a href="<?php echo($url); ?>" title="Modelo <?php echo($conteudo->modelo1);?>">
				    	<?php echo($conteudo->modelo1); ?> 
						</a>			    	
				    	<?php if($conteudo->gostei_mod1=='SIM'):?>
							<span class="badge" title="Gostou"><?php echo($conteudo->gostou_mo1);?> 
							<span class="glyphicon glyphicon-heart" aria-hidden="true" title="Gostou"></span>
							</span>
						<?php else : ?>
							<span class="badge" title=""><?php echo($conteudo->gostou_mo1);?> 
							<span class="glyphicon glyphicon-heart-empty" aria-hidden="true" title=""></span>
							</span>
						<?php endif?></h3>
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
				    	<?php echo($conteudo->desc_mo1); ?> 
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<a href="<?php echo($urlBusca);?>?id_modelo=<?php echo($conteudo->id_modelo_principal);?>" class="btn">Mais sess&otilde;es desta modelo</a>
					</div>
				</div>			
			</div>
			<?php if(isset($conteudo->modelo2)) : ?>
			<div class="col col-xs-12 col-sm-4 col-md-4 col-lg-1 text-center">
			<?php $url = JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$conteudo->id_modelo_secundaria.':modelo-'.strtolower(str_replace(" ","-",$conteudo->modelo2)),false); ?>
				<a href="<?php echo($url); ?>" title="Modelo <?php echo($conteudo->modelo2);?>">
					<img src="<?php echo(JURI::base( true ));?>/images/modelos/<?php echo($conteudo->foto_mod2);?>" title="Modelo <?php echo($conteudo->modelo2);?>" alt="Modelo <?php echo($conteudo->modelo2);?>" class="img-circle">
				</a>
			</div>
			<div class="col col-xs-12 col-sm-5 col-md-5 col-lg-5">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<h3><a href="<?php echo($url); ?>" title="Modelo <?php echo($conteudo->modelo2);?>">
				    	<?php echo($conteudo->modelo2); ?> 
						</a>			    	
				    	<?php if($conteudo->gostei_mod1=='SIM'):?>
							<span class="badge" title="Gostou"><?php echo($conteudo->gostou_mo2);?> 
							<span class="glyphicon glyphicon-heart" aria-hidden="true" title="Gostou"></span>
							</span>
						<?php else : ?>
							<span class="badge" title=""><?php echo($conteudo->gostou_mo2);?> 
							<span class="glyphicon glyphicon-heart-empty" aria-hidden="true" title=""></span>
							</span>
						<?php endif?></h3>
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
				    	<?php echo($conteudo->desc_mo2); ?> 
					</div>
				</div>	
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<a href="<?php echo($urlBusca);?>?id_modelo=<?php echo($conteudo->id_modelo_secundaria);?>" class="btn">Mais sess&otilde;es desta modelo</a>
					</div>
				</div>	
			</div>
			<?php endif; ?>
		</div>
		<div class="row">
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
		    	<?php echo($conteudo->comentario_modelos)?>
			</div>	
		</div>
    </div>
    <div id="fotografos" class="tab-pane fade in" style="height: 170px;">
		<h2>Fotografo(s)</h2>
		<div class="row">
			<div class="col col-xs-12 col-sm-2 col-md-2 col-lg-1 text-center">
			<?php $url = JRoute::_('index.php?option=com_angelgirls&task=carregarFotografo&id='.$conteudo->id_fotografo_principal.':fotografo-'.strtolower(str_replace(" ","-",$conteudo->fotografo1)),false); ?>
				<a href="<?php echo($url); ?>" title="Fotografo(a) <?php echo($conteudo->fotografo1);?>">
					<img src="<?php echo(JURI::base( true ));?>/images/fotografos/<?php echo($conteudo->foto_mod1);?>" title="Fotografo(a) <?php echo($conteudo->fotografo1);?>" alt="Fotografo(a) <?php echo($conteudo->fotografo1);?>" class="img-circle">
				</a>
			</div>
			<?php if(isset($conteudo->fotografo2)) : ?>
			<div class="col col-xs-12 col-sm-4 col-md-4 col-lg-5">
			<?php else :?>
			<div class="col col-xs-12 col-sm-10 col-md-10 col-lg-11">
			<?php endif; ?>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<h3><a href="<?php echo($url); ?>"  title="Fotografo(a) <?php echo($conteudo->fotografo1);?>">
				    	<?php echo($conteudo->fotografo1); ?> 
						</a>			    	
				    	<?php if($conteudo->gostei_fot1=='SIM'):?>
							<span class="badge" title="Gostou"><?php echo($conteudo->gostou_fot1);?> 
							<span class="glyphicon glyphicon-heart" aria-hidden="true" title="Gostou"></span>
							</span>
						<?php else : ?>
							<span class="badge" title=""><?php echo($conteudo->gostou_fot1);?> 
							<span class="glyphicon glyphicon-heart-empty" aria-hidden="true" title=""></span>
							</span>
						<?php endif?></h3>
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
				    	<?php echo($conteudo->desc_fot1); ?> 
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<a href="<?php echo($urlBusca);?>?id_fotografo=<?php echo($conteudo->id_fotografo_principal);?>" class="btn">Mais sess&otilde;es deste(a) fotorgafo(a)</a>
					</div>
				</div>	
			</div>
			<?php if(isset($conteudo->fotografo2)) : ?>
			<div class="col col-xs-12 col-sm-4 col-md-4 col-lg-1 text-center">
			<?php $url = JRoute::_('index.php?option=com_angelgirls&task=carregarFotografo&id='.$conteudo->id_fotografo_secundaria.':fotografo-'.strtolower(str_replace(" ","-",$conteudo->fotografo2)),false); ?>
				<a href="<?php echo($url); ?>"  title="Fotografo(a) <?php echo($conteudo->fotografo2);?>">
					<img src="<?php echo(JURI::base( true ));?>/images/fotografos/<?php echo($conteudo->foto_mod2);?>" title="Fotografo(a) <?php echo($conteudo->fotografo2);?>" alt="Fotografo(a) <?php echo($conteudo->fotografo2);?>" class="img-circle">
				</a>
			</div>
			<div class="col col-xs-12 col-sm-5 col-md-5 col-lg-5">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<h3><a href="<?php echo($url); ?>" title="Fotografo(a) <?php echo($conteudo->fotografo2);?>">
				    	<?php echo($conteudo->fotografo2); ?> 
						</a>			    	
				    	<?php if($conteudo->gostei_fot1=='SIM'):?>
							<span class="badge" title="Gostou"><?php echo($conteudo->gostou_fot2);?> 
							<span class="glyphicon glyphicon-heart" aria-hidden="true" title="Gostou"></span>
							</span>
						<?php else : ?>
							<span class="badge" title=""><?php echo($conteudo->gostou_fot2);?> 
							<span class="glyphicon glyphicon-heart-empty" aria-hidden="true" title=""></span>
							</span>
						<?php endif?></h3>
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
				    	<?php echo($conteudo->desc_mo2); ?> 
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<a href="<?php echo($urlBusca);?>?id_fotografo=<?php echo($conteudo->id_fotografo_secundaria);?>" class="btn">Mais sess&otilde;es deste(a) fotorgafo(a)</a>
					</div>
				</div>	
			</div>
			<?php endif; ?>
		</div>
		<div class="row">
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
		    	<?php echo($conteudo->comentario_fotografo)?>
			</div>	
		</div>
	</div>
</div>

<div class="labelTitulo">
	<a class="example-image-link" href="<?php echo($urlFoto);?>" data-lightbox="example-set" data-title="<?php echo($foto->titulo); ?>">
		<img src="<?php echo($urlFoto);?>" class="img-responsive"/>
	</a>
	<h2><?php echo($foto->titulo); ?></h2>
</div>

<div style="overflow: hidden; margin-top:10px; top: 0px; transition: 0ms linear; text-align: center;left: -50px" class="hidden-phone row carousel slide" id="componente">
	<div class="col col-xs-1 col-sm-1 col-md-1 col-lg-1 text-center" style="vertical-align: middle;"><a href="JavaScript: componente.left();" class="setaEsquerda setas left carousel-control" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left" ></span>
	<span class="sr-only">Voltar</span></a></div>
	<div class=" col col-xs-10 col-sm-10 col-md-10 col-lg-10 text-center">
		<div class="hidden-phone controle text-center" id="navegador" style="display: none;height: 225px;" >
			<?php
			$count = 0;
			foreach($fotos as $conteudo): 
				$url = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarFoto&id='.$conteudo->id.':'.strtolower(str_replace(" ","-",$conteudo->titulo))); 
				$urlFoto = JRoute::_('index.php?option=com_angelgirls&view=fotosessao&task=loadImage&id='.$conteudo->id.':'.$conteudo->sessao.'-ico'); ?>
				<div class="item <?php echo($conteudo->id==$foto->id?' ativo':''); ?>">
		    		<a href="<?php echo($url);?>"><img src="<?php echo($urlFoto);?>" class="img-rounded"/>
		    		<div class="label"><?php echo($conteudo->titulo);?></div></a>
		    	</div>
			<?php
			endforeach; 
			?>
		</div>
	</div>
	<div class="col col-xs-1 col-sm-1 col-md-1 col-lg-1 text-center" style="vertical-align: middle;height: 225px;"><a href="JavaScript: componente.right();"  class="setaDireita setas right carousel-control" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span>
	<span class="sr-only">Próximo</span></a></div>
</div>
<style>
.setas{
    top: 110px;
}
#navegador {
	display: block;
	box-sizing: border-box;
	display: inline-block;
	height: 225px;
	position: relative;
	overflow: hidden;
}
		
#navegador .item {
	padding: 0;
	margin: 0;
	width: 150px;
	display: inline-block;
	outline: none;
	position: relative;
	outline: none;
	vertical-align: baseline;
	vertical-align: middle;
	opacity: 0.7;
}
#navegador 	img {
	max-height: 225px;
}
#navegador .ativo {
	opacity: 1;
}

#navegador .ativo img {
	border: red 2px solid;
	opacity: 1;
}

#navegador .item .label {
    position: absolute;
    bottom: 1.5em;
    left: 0;
    z-index: 50;
    padding: 4px;
    color: #FFFFFF;
    background: rgba(255,255,255,0.4);
    font-family: 'Oranienbaum',Georgia,serif;
    line-height: 2.8em;
    font-weight: bold;
    border-radius: 0.5em;
    -webkit-border-radius: 0 0.5em 0.5em 0;
    -moz-border-radius: 0 0.5em 0.5em 0;
    text-shadow: none;
}

.labelTitulo h2 {
    position: relative;
    z-index: 50;
    top: -150px;
    width: auto;
    padding: 4px;
    float: left;
    color: #FFFFFF;
    background: rgba(255,255,255,0.4);
    font-family: 'Oranienbaum',Georgia,serif;
    line-height: 2.8em;
    font-weight: bold;
    border-radius: 0.5em;
    -webkit-border-radius: 0 0.5em 0.5em 0;
    -moz-border-radius: 0 0.5em 0.5em 0;
    text-shadow: none;
}

.labelTitulo{
	height: 500px;
	width: 100%;
	text-align: center;
	background: #424141;
	border: #828282 2px solid ;
	
}
.labelTitulo img {
   vertical-align: middle;
   margin: 0 auto;
   padding: 0px;
	height: 495px;
}

</style>
<script>
function ComponenteNavegacao(id,maxItensPorTela){
	this.id = id;
	var itens = new Array();
	var maxItensPorTela = 8;
	var position = 0 ;
	var $objeto;

	
	this.init = function (){
		$objeto = jQuery('#'+id);

		$objeto.find('div.controle').css('width','780px');
// 		var itemContador=0;
// 		$objeto.find('div.item').each(function(){
// 		     var $item  = jQuery(this);
// 		     $item.css('display',(itemContador++>=6? '':'none'));
// 		});

		itens = $objeto.find('div.item');
		var ativoIndex = -1;
		for(var index=0;index<itens.length;index++){
			if(jQuery( itens[index]).hasClass('ativo')){
				ativoIndex=index;
			}
		}

// 		$objeto.find('div.setaEsquerda').click(this.left);
// 		$objeto.find('div.setaDireita').click(this.right);
		
		var inciar = ativoIndex-2;
		while(inciar<0){inciar++;}
		while(inciar>(itens.length-5)){inciar=(itens.length-5);}

		this.position=inciar;

		this.reload();

		


		

		
		$objeto.find('div.controle').css('display','');
	}

	this.reload = function(){
		for(var index=0;index<itens.length;index++){
			jQuery( itens[index]).css('display','none');
		}
		for(var index=this.position; (index-this.position) < 6 && index < itens.length ;index++){
			jQuery( itens[index]).css('display','inline-block');
		}
	}
	
	this.right = function(){
		this.position++;
		if(this.position>(itens.length-5)) 
			this.position=itens.length-5;
		this.reload();
	}


	this.left = function(){
		this.position--;
		if(this.position<0) 
			this.position=0;
		this.reload();
	}

	this.init();
}
var componente = null;
jQuery(document).ready(function (){
	componente = new ComponenteNavegacao('componente');
});

</script>
<script src="components/com_angelgirls/assets/js/lightbox.js" type="text/javascript" ></script>
