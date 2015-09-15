<?php

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );



if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=homepage&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
 	//JRequest::setVar('task','homepage');
 	//$controller = JControllerLegacy::getInstance('Angelgirls');
 	//$controller->execute('homepage');
	
	exit ();
}
// Nova Modelo
// Ultima Sessao
// Torne-se modelo, fotografo ou vistor
// Promoções
$modelo = JRequest::getVar('modelo');
$sessao = JRequest::getVar('sessao');
$promocao = JRequest::getVar('promocao');
$conteudos = JRequest::getVar('conteudos');
$makingofs = JRequest::getVar('makingofs');
$sessoes = JRequest::getVar('sessoes');
$fotos = JRequest::getVar('fotos');


//print_r($conteudos);
//exit();
?>
<div class="page-header">
	<h1>Angel Girls</h1>
</div>
<div class="well">Bem vindo ao site de com as modelos mais lindas e
	angelicais.</div>
<div class="row  hidden-phone" style="margin-bottom: 10px;">
	<div class="col col-xs-12 col-sm-12 col-md-8 col-lg-9" style="height: 450px; padding: 0px; margin: 0px;">
		<div id="displayCarrossel" class="carousel slide" data-ride="carousel" style="height: 450px;">
			<!-- Indicators -->
			<ol class="carousel-indicators" style="width: 100px; height: 100px;">
				<li data-target="#displayCarrossel" data-slide-to="0" class="active"></li>
				<li data-target="#displayCarrossel" data-slide-to="1"></li>
				<li data-target="#displayCarrossel" data-slide-to="2"></li>
				<li data-target="#displayCarrossel" data-slide-to="3"></li>
			</ol>
			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<div class="item item-carrossel active" data-id-ver="2">
					<img src="<?php echo(JURI::base( true ));?>/images/modelos/<?php echo($modelo->foto);?>" alt="<?php echo($modelo->nome);?>" style="width:100%">
					<div class="carousel-caption">
						<h3><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$modelo->id.':modelo-'.strtolower(str_replace(" ","-",$modelo->alias)),false)); ?>"><?php echo($modelo->nome);?></a></h3>
						<p><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$modelo->id.':modelo-'.strtolower(str_replace(" ","-",$modelo->alias)),false)); ?>"><?php echo($modelo->descricao);?></a></p>
					</div>
				</div>
				<div class="item item-carrossel" data-id-ver="3">
					<img src="<?php echo(JURI::base( true ));?>/images/sessoes/<?php echo($sessao->foto);?>" alt="<?php echo($sessao->nome);?>" style="width:100%">
					<div class="carousel-caption">
						<h3><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessao&id='.$sessao->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$sessao->alias)),false)); ?>"><?php echo($sessao->nome);?></a></h3>
						<p><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessao&id='.$sessao->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$sessao->alias)),false)); ?>"><?php echo($sessao->descricao);?></a></p>
					</div>
				</div>
				<div class="item item-carrossel" data-id-ver="4">
					<img src="<?php echo(JURI::base( true ));?>/components/com_angelgirls/cadastrese.jpg" alt="Cadastre-se" style="width:100%">
					<div class="carousel-caption">
						<h3><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=cadastro&task=cadastroModelo&id=cadastre-se-modelo-fotografica-sensual-angel-girls',false)); ?>">Seja uma Angel </a></h3>
						<p><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=cadastro&task=cadastroModelo&id=cadastre-se-modelo-fotografica-sensual-angel-girls',false)); ?>">Cadastre-se e veja como ser uma modelo da Angel.</a></p>
					</div>
				</div>
				<div class="item item-carrossel" data-id-ver="1">
					<img src="<?php echo(JURI::base( true ));?>/images/promocoes/<?php echo($promocao->foto);?>" alt="<?php echo($promocao->nome);?>" style="width:100%">
					<div class="carousel-caption">
						<h3><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarPromocao&id='.$promocao->id.':promocao-'.strtolower(str_replace(" ","-",$promocao->alias)),false)); ?>"><?php echo($promocao->nome);?></a></h3>
						<p><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarPromocao&id='.$promocao->id.':promocao-'.strtolower(str_replace(" ","-",$promocao->alias)),false)); ?>"><?php echo($promocao->descricao);?></a></p>
					</div>
				</div>
			</div>

			<!-- Left and right controls -->
			<a class="left carousel-control" href="#displayCarrossel" role="button"
				data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"
				aria-hidden="true"></span> <span class="sr-only">Anterior</span>
			</a> 
			<a class="right carousel-control" href="#displayCarrossel"
				role="button" data-slide="next"> <span
				class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Pr&oacute;ximo</span>
			</a>
		</div>
	</div>
	<div id="itensLateraisCarrossel" class="col col-xs-12 col-sm-12 col-md-4 col-lg-3" style="padding: 5px;">
		<div id="itemCarrossel1" class="itemCarroussel alert alert-info" style="padding: 10px;">
			<h5><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$modelo->id.':modelo-'.strtolower(str_replace(" ","-",$modelo->alias)),false)); ?>"><?php echo($modelo->nome);?></a></h5>
			<p><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$modelo->id.':modelo-'.strtolower(str_replace(" ","-",$modelo->alias)),false)); ?>"><?php echo($modelo->descricao);?></a></p>			
		</div>
		<div id="itemCarrossel2" class="itemCarroussel alert alert-success" style="padding: 10px;">
			<h5><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessao&id='.$sessao->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$sessao->alias)),false)); ?>"><?php echo($sessao->nome);?></a></h5>
			<p><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessao&id='.$sessao->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$sessao->alias)),false)); ?>"><?php echo($sessao->descricao);?></a></p>			
		</div>
		<div id="itemCarrossel3" class="itemCarroussel alert alert-success" style="padding: 10px;">
			<h5><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=cadastro&task=cadastroModelo&id=cadastre-se-modelo-fotografica-sensual-angel-girls',false)); ?>">Seja uma Angel </a></h5>
			<p><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=cadastro&task=cadastroModelo&id=cadastre-se-modelo-fotografica-sensual-angel-girls',false)); ?>"><small>Cadastre-se e veja como ser uma modelo da Angel.</small></a></p>			
		</div>
		<div id="itemCarrossel4" class="itemCarroussel alert alert-success" style="padding: 10px;">
			<h5><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarPromocao&id='.$promocao->id.':promocao-'.strtolower(str_replace(" ","-",$promocao->alias)),false)); ?>"><?php echo($promocao->nome);?></a></h5>
			<p><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarPromocao&id='.$promocao->id.':promocao-'.strtolower(str_replace(" ","-",$promocao->alias)),false)); ?>"><?php echo($promocao->descricao);?></a></p>			
		</div>
	</div>
</div>
<!-- <span class="badge">42</span> -->
<div class="row bloco-conteudo">
	<div class="col col-xs-12 col-sm-4 col-md-3 col-lg-3">
		<div class="module">
			<div class="well">
		<?php 
			$module = JModuleHelper::getModule( 'login' );
			echo JModuleHelper::renderModule( $module );
			?>
			</div>
		</div>
	
		<h2>Ultimas Fotos</h2>
		<?php
		foreach($fotos as $conteudo){ ?>
			<div class="thumbnail">
				<?php
					$url = JRoute::_('index.php?option=com_angelgirls&task=carregarFoto&id='.$conteudo->id.':foto-sensual-'.strtolower(str_replace(" ","-",$conteudo->alias)),false);
					$urlFoto = JRoute::_('index.php?option=com_angelgirls&view=fotosessao&task=loadImage&id='.$conteudo->id.':'.$conteudo->id_sessao.'-thumbnail');
					if(isset($conteudo->foto) && isset($conteudo->foto)!=""){?>
						<a href="<?php echo($url );?>"><img src="<?php echo($urlFoto);?>" title="<?php echo($conteudo->nome);?>" alt="<?php echo($conteudo->nome);?>" style="height: 150px;"/></a>
					<?php 
					}?>
					<div class="caption">
					<h4 class="list-group-item-heading"> <a href="<?php echo($url);?>"><?php echo($conteudo->nome);?></a></h4>
					<p><div class="fb-share-button" data-href="<?php echo('http://'.$_SERVER['HTTP_HOST'] . $url);?>" data-layout="button_count"></div>
					<div class="g-plus" data-action="share" data-href="<?php echo('http://'.$_SERVER['HTTP_HOST'] . $url);?>"></div>
					<div class="vkShare" data-action="share" data-href="<?php echo('http://'.$_SERVER['HTTP_HOST'] . $url);?>"></div>
					</p>
					<p><?php echo($conteudo->descricao);?></p>
					<p class="text-center"><a href="<?php echo($url );?>" class="btn btn-primary" role="button">Mais fotos: <?php echo($conteudo->nome);?></a></p>
					</div>
			</div>
		<?php
		} 
		?>
		<h2>Cadastre-se</h2>
		<div class="thumbnail">
			<h4 class="list-group-item-heading"><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=cadastro&task=cadastroVisitante&id=cadastre-se-visitante-vip-angel-girls',false));?>">Quer ter acesso a todo conte&uacute;do exclusivo?</a></h4>
			<p>Cadastre-se para como visitante, e veja todo o conte&uacute;do exclusivo de visitante.</p>
			<p class="text-center"><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=cadastro&task=cadastroVisitante&id=cadastre-se-visitante-vip-angel-girls',false));?>" class="btn btn-primary" role="button">Cadastre-se : Visitante
			<span class="glyphicon glyphicon-sunglasses" aria-hidden="true"></span>
			</a></p>
		</div>
		<div class="thumbnail">
			<h4 class="list-group-item-heading"><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=cadastro&task=cadastroFotografo&id=cadastre-se-fotografo-sensual-angel-girls',false));?>">Quero ser um fotografo da Angel</a></h4>
			<p>Cadastre-se para se afiliar, e poder ser um fotografo, o cadatro depende de aprova&ccedil;&atilde;o.</p>
			<p class="text-center"><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=cadastro&task=cadastroFotografo&id=cadastre-se-fotografo-sensual-angel-girls',false));?>" class="btn btn-primary" role="button">Cadastre-se : Fotografo
			<span class="glyphicon glyphicon-camera" aria-hidden="true"></span>
			</a></p>
		</div>
		<div class="thumbnail">
			<h4 class="list-group-item-heading"><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=cadastro&task=cadastroModelo&id=cadastre-se-modelo-fotografica-sensual-angel-girls',false));?>">Como fa&ccedil;o para ser modelo?</a></h4>
			<p>Veja os beneficios de ser uma modelo <attr>Angel Girls</attr>.</p>
			<p class="text-center"><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=cadastro&task=cadastroModelo&id=cadastre-se-modelo-fotografica-sensual-angel-girls',false));?>" class="btn btn-primary" role="button">Cadastre-se : Modelo
			<span class="glyphicon glyphicon-fire" aria-hidden="true"></span>
			
			</a></p>
		</div>
	</div>
	<div class="col col-xs-12 col-sm-4 col-md-3 col-lg-3">

	<h2>Ultimas Sess&otilde;es</h2>
	<?php
	foreach($sessoes as $conteudo){ ?>
		<div class="thumbnail">
			<?php 
				$url = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessao&id='.$conteudo->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$conteudo->alias)),false); 
				if(isset($conteudo->foto) && isset($conteudo->foto)!=""){?>
					<a href="<?php echo($url);?>"><img src="<?php echo(JURI::base( true ) . '/images/sessoes/' . $conteudo->foto);?>" title="<?php echo($conteudo->nome);?>" alt="<?php echo($conteudo->nome);?>" style="height: 150px;"/></a>
				<?php 
				}?>
				<div class="caption">
				<h4 class="list-group-item-heading"><a href="<?php echo($url);?>"><?php echo($conteudo->nome);?></a></h4>
				<p><div class="fb-share-button" data-href="<?php echo('http://'.$_SERVER['HTTP_HOST'] . $url);?>" data-layout="button_count"></div>
				<div class="g-plus" data-action="share" data-href="<?php echo('http://'.$_SERVER['HTTP_HOST'] . $url);?>"></div>
				<div class="vkShare" data-action="share" data-href="<?php echo('http://'.$_SERVER['HTTP_HOST'] . $url);?>"></div>
				</p>
				<p><?php echo($conteudo->descricao);?></p>
				<p class="text-center"><a href="<?php echo($url);?>" class="btn btn-primary" role="button" style="text-overflow: ellipsis;max-width: 270px;  overflow: hidden;  direction: ltr;"><?php echo($conteudo->nome);?></a></p>
				</div>
		</div>
	<?php
	} 
	?>
		<div class="">
			<?php 
				$url = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessoes&id=sessoes-fotos-sensuais',false); ?>
				
				<p class="text-center"><a href="<?php echo($url);?>" class="btn btn-info" role="button">Ver todas as sess&otilde;es</a></p>
				
		</div>
	</div>
	<div class="col col-xs-12 col-sm-4 col-md-3 col-lg-3">
	<h2>Ultimas N&oacute;ticias</h2>
	<?php
	$couter =0;
	foreach($conteudos as $conteudo){ ?>
		<div class="thumbnail">
			<?php 
				$url = JRoute::_(ContentHelperRoute::getArticleRoute($conteudo->slug, $conteudo->catid, $conteudo->language));
				if(isset($conteudo->foto) && isset($conteudo->foto)!=""){?>
					<a href="<?php echo($url); ?>"><img src="<?php echo(JURI::base( true ) . '/' . $conteudo->foto);?>" title="<?php echo($conteudo->nome);?>" alt="<?php echo($conteudo->nome);?>"/></a>
				<?php 
				}?>
			<div class="caption">
				<h4><a href="<?php echo($url);?>"><?php echo($conteudo->nome);?></a>	</h4>
				<p><?php echo($conteudo->descricao);?></p>
				<p class="text-center"><a href="<?php echo($url); ?>" class="btn btn-primary" role="button">Ler: <?php echo($conteudo->nome);?></a></p>
			</div>
		</div>
	<?php
		//BANNER
		if($couter++==1){
			$module = JModuleHelper::getModule('banner_home_cubo');
			if(isset($module)){
				echo '<div class="thumbnail">'; 
				echo JModuleHelper::renderModule($module);
				echo '</div>';
			}
 		}
	} 
	?>
	</div>
	<div class="col col-xs-12 col-sm-4 col-md-3 col-lg-3">
	<h2>Making Ofs</h2>
	<?php
	foreach($makingofs as $conteudo){ ?>
		<div class="thumbnail">
			<?php 
				$url = JRoute::_(ContentHelperRoute::getArticleRoute($conteudo->slug, $conteudo->catid, $conteudo->language));
				if(isset($conteudo->foto) && isset($conteudo->foto)!=""){?>
					<a href="<?php echo($url); ?>"><img src="<?php echo(JURI::base( true ) . '/' . $conteudo->foto);?>" title="<?php echo($conteudo->nome);?>" alt="<?php echo($conteudo->nome);?>"/></a>
				<?php 
				}?>
			<div class="caption">
				<h4><a href="<?php echo($url);?>"><?php echo($conteudo->nome);?></a>	</h4>
				<p><?php echo($conteudo->descricao);?></p>
				<p class="text-center"><a href="<?php echo($url); ?>" class="btn btn-primary" role="button">Assistir: <?php echo($conteudo->nome);?></a></p>
        			
        			
			</div>
		</div>
	<?php
	} 
	?>
	</div>
</div>
<script>
jQuery(document).ready(function(){
	// Activate Carousel
    jQuery("#displayCarrossel").carousel();
    
    // Enable Carousel Controls
    jQuery(".left").click(function(){
    	jQuery("#displayCarrossel").carousel("prev");
    });
    jQuery(".right").click(function(){
    	jQuery("#displayCarrossel").carousel("next");
    });

    jQuery("#displayCarrossel").on('slide.bs.carousel', function () {
    	$todos = jQuery('.itemCarroussel');
    	$todos.removeClass('alert-success');
    	$todos.removeClass('alert-info');
    	$todos.addClass('alert-success');

    	$objeto = jQuery('#itemCarrossel'+ jQuery('div.item.active').attr('data-id-ver'));
    	$objeto.removeClass('alert-success');
    	$objeto.addClass('alert-info');
    });
});
</script>