<?php

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );

if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=listTema', false ), "" );
	exit ();
}
// Nova Modelo
// Ultima Sessao
// Torne-se modelo, fotografo ou vistor
// Promoções
$modelo = JRequest::getVar ( 'modelo' );
$sessao = JRequest::getVar ( 'sessao' );
$promocao = JRequest::getVar ( 'promocao' );
?>
<div class="page-header">
	<h1>Angel Girls</h1>
</div>
<div class="wells">Bem vindo ao site de com as modelos mais lindas e
	angelicais.</div>
<div class="row">
	<div class="col col-xs-12 col-sm-12 col-md-8 col-lg-10">
		<div id="displayCarrossel" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#displayCarrossel" data-slide-to="0" class="active"></li>
				<li data-target="#displayCarrossel" data-slide-to="1"></li>
				<li data-target="#displayCarrossel" data-slide-to="2"></li>
				<li data-target="#displayCarrossel" data-slide-to="3"></li>
			</ol>
			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<div class="item active" data-id="1">
					<img src="/images/modelos/<?php echo($modelo->foto);?>" alt="<?php echo($modelo->nome);?>">
					<div class="carousel-caption">
						<h3><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$modelo->id.':'.$modelo->nome,false)); ?>"><?php echo($modelo->nome);?></a></h3>
						<p><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$modelo->id.':'.$modelo->nome,false)); ?>"><?php echo($modelo->descricao);?></a></p>
					</div>
				</div>
				<div class="item" data-id="2">
					<img src="/images/sessao/<?php echo($sessao->foto);?>" alt="<?php echo($sessao->nome);?>">
					<div class="carousel-caption">
						<h3><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarSessao&id='.$sessao->id.':'.$sessao->nome,false)); ?>"><?php echo($sessao->nome);?></a></h3>
						<p><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarSessao&id='.$sessao->id.':'.$sessao->nome,false)); ?>"><?php echo($sessao->descricao);?></a></p>
					</div>
				</div>
				<div class="item" data-id="3">
					<img src="/components/com_angelgirls/cadastrese.jpg" alt="Cadastre-se">
					<div class="carousel-caption">
						<h3><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=cadastroModeloid=0:Cadastre-se e seja uma modelo da Angel',false)); ?>">Seja uma Angel </a></h3>
						<p><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=cadastroModeloid=0:Cadastre-se e seja uma modelo da Angel',false)); ?>">Cadastre-se e veja como ser uma modelo da Angel.</a></p>
					</div>
				</div>
				<div class="item" data-id="4">
					<img src="/images/sessao/<?php echo($promocao->foto);?>" alt="<?php echo($promocao->nome);?>">
					<div class="carousel-caption">
						<h3><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarSessao&id='.$promocao->id.':'.$promocao->nome,false)); ?>"><?php echo($promocao->nome);?></a></h3>
						<p><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarSessao&id='.$promocao->id.':'.$promocao->nome,false)); ?>"><?php echo($promocao->descricao);?></a></p>
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
	<div id="itensLateraisCarrossel" class="col col-xs-12 col-sm-12 col-md-4 col-lg-2">
		<div id="itemCarrossel1" class="itemCarroussel">
			<h3><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$modelo->id.':'.$modelo->nome,false)); ?>"><?php echo($modelo->nome);?></a></h3>
			<p><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$modelo->id.':'.$modelo->nome,false)); ?>"><?php echo($modelo->descricao);?></a></p>			
		</div>
		<div id="itemCarrossel2" class="itemCarroussel">
			<h3><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$sessao->id.':'.$sessao->nome,false)); ?>"><?php echo($sessao->nome);?></a></h3>
			<p><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$sessao->id.':'.$sessao->nome,false)); ?>"><?php echo($sessao->descricao);?></a></p>			
		</div>
		<div id="itemCarrossel3" class="itemCarroussel">
			<h3><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=cadastroModeloid=0:Cadastre-se e seja uma modelo da Angel',false)); ?>">Seja uma Angel </a></h3>
			<p><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=cadastroModeloid=0:Cadastre-se e seja uma modelo da Angel',false)); ?>">Cadastre-se e veja como ser uma modelo da Angel.</a></p>			
		</div>
		<div id="itemCarrossel4" class="itemCarroussel">
			<h3><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$promocao->id.':'.$promocao->nome,false)); ?>"><?php echo($promocao->nome);?></a></h3>
			<p><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$promocao->id.':'.$promocao->nome,false)); ?>"><?php echo($promocao->descricao);?></a></p>			
		</div>
	</div>
</div>
<!-- <span class="badge">42</span> -->
<div class="row bloco-conteudo">
	<div class="col col-xs-12 col-sm-12 col-md-8 col-lg-10">
		<div class="list-group">
			<a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=cadastroVisitante&id=:Cadastro de Visitante',false));?>" class="list-group-item active">
				<h4 class="list-group-item-heading">Quer ter acesso a todo conteúdo exclusivo?</h4>
				<p class="list-group-item-text">Cadastre-se para como visitante, e veja todo o conteúdo exclusivo de visitante.</p>
			</a>
		</div>
		<div class="list-group">
			<a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=cadastroFotografo&id=:Cadastro de Fotografos',false));?>" class="list-group-item active">
				<h4 class="list-group-item-heading">Quero ser um fotografo da Angel</h4>
				<p class="list-group-item-text">Cadastre-se para se afiliar, e poder ser um fotografo, o cadatro depende de aprova&ccedil;&atilde;o.</p>
			</a>
		</div>
		<div class="list-group">
			<a href="#" class="list-group-item active">
				<h4 class="list-group-item-heading">Como faço para ser mocelo?</h4>
				<p class="list-group-item-text">Cadastre-se para como visitante, e veja todo o conteúdo exclusivo de visitante.</p>
			</a>
		</div>
	</div>
</div>
<script>
jQuery(document).ready(function(){
	// Activate Carousel
    jQuery("#displayCarrossel").carousel();
    
    // Enable Carousel Indicators
    jQuery(".item1").click(function(){
    	jQuery("#displayCarrossel").carousel(0);
    });
    jQuery(".item2").click(function(){
    	jQuery("#displayCarrossel").carousel(1);
    });
    jQuery(".item3").click(function(){
    	jQuery("#displayCarrossel").carousel(2);
    });
    jQuery(".item4").click(function(){
    	jQuery("#displayCarrossel").carousel(3);
    });
    
    // Enable Carousel Controls
    jQuery(".left").click(function(){
    	jQuery("#displayCarrossel").carousel("prev");
    });
    jQuery(".right").click(function(){
    	jQuery("#displayCarrossel").carousel("next");
    });

    jQuery("#displayCarrossel").on('slide.bs.carousel', function () {
        ('.itemCarroussel').removeClass('ative');
    	jQuery('#itemCarrossel'+ jQuery('div.item.active').attr('data-id')).addClass('ative');
    });
});
</script>