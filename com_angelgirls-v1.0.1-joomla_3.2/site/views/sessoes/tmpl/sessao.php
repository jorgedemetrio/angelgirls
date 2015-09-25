<?php

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );


if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=carregarSessoes&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}

JFactory::getDocument()->addScriptDeclaration('var lidos = 0;');

$conteudo = JRequest::getVar('sessao');
$fotos = JRequest::getVar('fotos');
$id = JRequest::getInt('id');

$perfil = JRequest::getVar('perfil');



?>
<div class="page-header">
	<h1><?php echo($conteudo->titulo);?> 
	<small><?php echo($conteudo->nome_tema);?></small>
	<div class="gostar" data-gostei='<?php echo($conteudo->gostei_sessao);?>' data-id='<?php echo($conteudo->id);?>' data-area='sessao' data-gostaram='<?php echo($conteudo->audiencia_gostou);?>'></div>
</h1>

</div>

<script>



</script>
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
	<li role="presentation">
		<a href="#comentarios" data-toggle="tab" aria-controls="profile" role="tab">Coment&aacute;rios
		<span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
		</a>
	</li>
</ul>

<div id="detalhesSessao" class="tab-content" style="overflow: auto;">
	<div id="general" class="tab-pane fade in active" style="height: 210px;">
		<h2>Detalhe sess&atilde;o</h2>
		<div class="row">
			<div class="label col col-xs-12 col-sm-3 col-md-3 col-lg-3">
		    	Tema
			</div>
			<div class="label col col-xs-12 col-sm-2 col-md-2 col-lg-3">
		    	Figurino
			</div>
			<div class="label col col-xs-12 col-sm-3 col-md-3 col-lg-3">
		    	Local
			</div>
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
			<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-3 text-center">
		    	<?php echo($conteudo->nome_tema)?>
			</div>
			<div class="col col-xs-12 col-sm-3 col-md-2 col-lg-3 text-center">
		    	<?php echo($conteudo->figurino1 . isset($conteudo->figurino2)?', '.$conteudo->figurino2:'' )?>
			</div>
			<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-3 text-center">
		    	<?php echo($conteudo->nome_locacao )?>
			</div>
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
				<h4>Descri&ccedil;&atilde;o da sess&atilde;o</h4>
		    	<?php echo($conteudo->descricao )?>
			</div>
		</div>    
	</div>
<?php $urlBusca = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessoes&id=sessoes-fotos-sensuais',false); ?>
	<div id="modelos" class="tab-pane fade in" style="height: 210px;">
		<h2>Modelo(s)</h2>
		<div class="row">
			<div class="col col-xs-12 col-sm-2 col-md-2 col-lg-1 text-center">
			<?php 
			$url = JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$conteudo->id_modelo_principal.':modelo-'.strtolower(str_replace(" ","-",$conteudo->modelo1)),false);
			$urlImg = JRoute::_('index.php?option=com_angelgirls&view=modelo&task=loadImage&id='.$conteudo->id_modelo_principal.':ico');
			 ?>
				<a href="<?php echo($url); ?>" href="<?php echo($url); ?>" title="Modelo <?php echo($conteudo->modelo1);?>">
					<img src="<?php echo($urlImg);?>" title="Modelo <?php echo($conteudo->modelo1);?>" alt="Modelo <?php echo($conteudo->modelo1);?>" class="img-circle">
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
						<div class="gostar" data-gostei='<?php echo($conteudo->gostei_mod1);?>' 
							data-id='<?php echo($conteudo->id_modelo_principal);?>' data-area='modelo' data-gostaram='<?php echo($conteudo->gostou_mo1);?>'></div></h3>
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
				    	<?php echo($conteudo->desc_mo1); ?> 
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-bottom: 10px">
						<a href="<?php echo($url);?>" class="btn btn-info">Mais detalhes sobre a modelo</a>
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
			<?php 
				$url = JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$conteudo->id_modelo_secundaria.':modelo-'.strtolower(str_replace(" ","-",$conteudo->modelo2)),false);
				$urlImg = JRoute::_('index.php?option=com_angelgirls&view=modelo&task=loadImage&id='.$conteudo->id_modelo_secundaria.':ico');
				?>
				<a href="<?php echo($url); ?>" title="Modelo <?php echo($conteudo->modelo2);?>">
					<img src="<?php echo($urlImg);?>" title="Modelo <?php echo($conteudo->modelo2);?>" alt="Modelo <?php echo($conteudo->modelo2);?>" class="img-circle">
				</a>
			</div>
			<div class="col col-xs-12 col-sm-5 col-md-5 col-lg-5">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<h3><a href="<?php echo($url); ?>" title="Modelo <?php echo($conteudo->modelo2);?>">
				    	<?php echo($conteudo->modelo2); ?> 
						</a>			    	
						<div class="gostar" data-gostei='<?php echo($conteudo->gostei_mod2);?>' 
							data-id='<?php echo($conteudo->id_modelo_secundaria);?>' data-area='modelo' data-gostaram='<?php echo($conteudo->gostou_mo2);?>'></div></h3>
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
				    	<?php echo($conteudo->desc_mo2); ?> 
					</div>
				</div>	
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-bottom: 10px">
						<a href="<?php echo($url);?>" class="btn btn-info">Mais detalhes sobre a modelo</a>
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
    <div id="fotografos" class="tab-pane fade in" style="height: 210px;">
		<h2>Fotografo(s)</h2>
		<div class="row">
			<div class="col col-xs-12 col-sm-2 col-md-2 col-lg-1 text-center">
			<?php 
			$url = JRoute::_('index.php?option=com_angelgirls&task=carregarFotografo&id='.$conteudo->id_fotografo_principal.':fotografo-'.strtolower(str_replace(" ","-",$conteudo->fotografo1)),false);
			$urlImg = JRoute::_('index.php?option=com_angelgirls&view=fotografo&task=loadImage&id='.$conteudo->id_fotografo_principal.':ico');
			?>
				<a href="<?php echo($url); ?>" title="Fotografo(a) <?php echo($conteudo->fotografo1);?>">
					<img src="<?php echo($urlImg);?>" title="Fotografo(a) <?php echo($conteudo->fotografo1);?>" alt="Fotografo(a) <?php echo($conteudo->fotografo1);?>" class="img-circle">
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
						<div class="gostar" data-gostei='<?php echo($conteudo->gostei_fot1);?>' 
							data-id='<?php echo($conteudo->id_fotografo_principal);?>' data-area='fotografo' data-gostaram='<?php echo($conteudo->gostou_fot1);?>'></div>
						</h3>
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
				    	<?php echo($conteudo->desc_fot1); ?> 
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-bottom: 10px">
						<a href="<?php echo($url);?>" class="btn btn-info">Mais detalhes sobre o(a) fotografo(a)</a>
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
			<?php 
			$url = JRoute::_('index.php?option=com_angelgirls&task=carregarFotografo&id='.$conteudo->id_fotografo_secundaria.':fotografo-'.strtolower(str_replace(" ","-",$conteudo->fotografo2)),false); 
			$urlImg = JRoute::_('index.php?option=com_angelgirls&view=fotografo&task=loadImage&id='.$conteudo->id_fotografo_secundaria.':ico');
			?>
				<a href="<?php echo($url); ?>"  title="Fotografo(a) <?php echo($conteudo->fotografo2);?>">
					<img src="<?php echo($urlImg);?>" title="Fotografo(a) <?php echo($conteudo->fotografo2);?>" alt="Fotografo(a) <?php echo($conteudo->fotografo2);?>" class="img-circle">
				</a>
			</div>
			<div class="col col-xs-12 col-sm-5 col-md-5 col-lg-5">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<h3><a href="<?php echo($url); ?>" title="Fotografo(a) <?php echo($conteudo->fotografo2);?>">
				    	<?php echo($conteudo->fotografo2); ?> 
						</a>			    	
				    	<div class="gostar" data-gostei='<?php echo($conteudo->gostei_fot2);?>' 
							data-id='<?php echo($conteudo->id_fotografo_secundaria);?>' data-area='fotografo' data-gostaram='<?php echo($conteudo->gostou_fot2);?>'></div></h3>
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
				    	<?php echo($conteudo->desc_mo2); ?> 
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-bottom: 10px">
						<a href="<?php echo($url);?>" class="btn btn-info">Mais detalhes sobre o(a) fotografo(a)</a>
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
	<div id="comentarios" class="tab-pane fade" style="height: 210px;">
		<div class="fb-comments" data-href="http://<?php echo($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']); ?>" data-width="100%" style="margin: 0 auto;"></div>
	</div>
</div>
<h2>Fotos</h2>
<div class="row"  id="linha">
<?php require_once 'fotos.php'; ?>
</div>
<div class="row" id="carregando" style="display: none">
	<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="height: 300px; vertical-align: middle; text-align: center;" class="text-center">
		<img src="<?php echo(JURI::base( true ))?>/components/com_angelgirls/loading_img.gif" alt="carregando" title="Carregando" style="width: 450px"/>
	</div>
</div>

<script>
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
			jQuery.post('<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarFotosContinuaHtml&id='.$conteudo->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$conteudo->titulo)),false)); ?>',
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