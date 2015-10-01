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
$conteudos = JRequest::getVar ( 'conteudos' );
$perfil = JRequest::getVar ( 'perfil' );
?>
<div class="row">
	<div id="menulogado" class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
<!-- 		BUSCAR SESSAO -->
<!-- 		PUBLICAR GALERIA  -->
<!-- 		PUBLICAR SESSAO -->
<!-- 		MEU PERFIL -->

</div>
<div class="row">
	<div id="esquerdo" class="col col-xs-12 col-sm-3 col-md-3 col-lg-2">
		<div>
			<gcse:searchbox-only resultsUrl="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=busca',false));?>" newWindow="false"
			enableHistory="true" autoCompleteMaxCompletions="5" autoCompleteMatchType='any'></gcse:searchbox-only>
		</div>
		<ul class="nav nav-pills  nav-stacked">
		  <li role="presentation" class="active"> <a href="#"><span class="badge"><span class="glyphicon glyphicon-home"></span></span><span class="hidden-phone"> Home <?php echo(strtolower( $perfil->tipo)); ?></span> </a></li>
		  <li role="presentation"><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarPerfil'));?>"><span class="badge"><span class="glyphicon glyphicon-pencil"></span></span><span class="hidden-phone"> Meu perfil</span></a></li>
		  <li role="presentation inbox"><a href="#"><span class="caixaMensagens"></span> <span class="hidden-phone"> Messages</span></a></li>
		  <li role="presentation inbox"><a href="#"><span class="badge"><span class="glyphicon glyphicon-user"></span></span><span class="hidden-phone"> Grupos</span></a></li>
		  <li role="presentation inbox"><a href="#"><span class="badge"><span class="glyphicon glyphicon-globe"></span></span><span class="hidden-phone"> P&aacute;ginas</span></a></li>
		  <li role="presentation inbox"><a href="#"><span class="badge"><span class="glyphicon glyphicon-facetime-video"></span></span><span class="hidden-phone"> V&iacute;deos</span></a></li>
		  <li role="presentation inbox"><a href="#"><span class="badge"><span class="glyphicon glyphicon-sunglasses"></span></span><span class="hidden-phone"> Amigos</span></a></li>
		  <li role="presentation inbox"><a href="#"><span class="badge"><span class="glyphicon glyphicon-comment"></span></span><span class="hidden-phone"> Enviar convites</span></a></li>
		  <li role="presentation inbox"><a href="#"><span class="badge"><span class="glyphicon glyphicon-th-list"></span></span><span class="hidden-phone"> Noticias</span></a></li>
		  <li role="presentation inbox"><a href="#"><span class="badge"><span class="glyphicon glyphicon-calendar"></span></span><span class="hidden-phone"> Calend&aacute;rio</span></a></li>
<?php if($perfil->tipo=='MODELO' || $perfil->tipo=='FOTOGRAFO' ):?>		
		  <li role="presentation inbox"><a href="#"><span class="badge"><span class="glyphicon glyphicon-usd"></span></span><span class="hidden-phone"> Extrato</span></a></li>
  
		  <li role="presentation">
		  	<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="sessoesAprovar"></span><span class="hidden-phone"> Sess&otilde;es</span></a>
		    <ul class="dropdown-menu">
      			<li><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarEditarSessao'));?>"><span class="glyphicon glyphicon-plus"></span> Nova Sess&atilde;o</a></li>
      			<li><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarMinhasSessoes'));?>">Minhas Sess&otilde;es</a></li>
      			<li><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarSessoes'));?>">Todas</a></li>
		    </ul>
		  </li>
<?php endif;?>
		  <li role="presentation">
		  	<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="badge"><span class="glyphicon glyphicon-picture"></span></span><span class="hidden-phone"> Albuns</span></a>
		    <ul class="dropdown-menu">
      			<li><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=novaSessao'));?>"><span class="glyphicon glyphicon-plus"></span> Novo Album</a></li>
      			<li><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarAlbuns&somente_minha=SIM'));?>">Meus Albuns</a></li>
      			<li><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarAlbuns'));?>">Todos</a></li>
		    </ul>
		  </li>
		</ul>
	</div>
	<div id="conteudo" class="col col-xs-12 col-sm-9 col-md-9 col-lg-10">
		<div class="thumbnail">
			Mural
		</div>
		<div class='row'>
<?php	foreach ($conteudos as $conteudo):
		$url ='';
		$urlImg ='';
		$tipoGostar=null;
		$titulo = '';
		$botao = '';
		switch( $conteudo->tipo){
			case 'CONTENT';
				$url = JRoute::_(ContentHelperRoute::getArticleRoute($conteudo->opt1, $conteudo->opt2, $conteudo->opt3));
				$urlImg = $conteudo->op4!=''? JURI::base( true ) . '/' . $conteudo->op4:null;
				$titulo = $conteudo->titulo;
				$botao = '';
				$tipoGostar=null;
				break;
			case 'SESSOES';
				$url = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessao&id='.$conteudo->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$conteudo->titulo)),false);
				$urlImg = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=loadImage&id='.$conteudo->opt1.':thumb');
				$titulo = $conteudo->titulo;
				$botao = '';
				$tipoGostar=null;
				break;
			case 'MODELO';
				$url = JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$conteudo->id.':modelo-'.strtolower(str_replace(" ","-",$conteudo->titulo)),false);
				$urlImg = JRoute::_('index.php?option=com_angelgirls&view=modelo&task=loadImage&id='.$conteudo->id.':thumb');
				$titulo = 'Voc&ecirc; j&aacute; conhece a modelo ' . $conteudo->titulo . '?';
				$botao = '<p class="text-center"><a href="'. $url .'" class="btn">Conhe&ccedil;a os trabalhos dessa musa.</a></p>';
				$tipoGostar=null;
			break;
		}
		?>
		<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-3"  data-id="" data-tipo="" data-data="" >
			<div class="thumbnail ">
				<?php if(isset($urlImg)) : ?>
				<a href="<?php echo($url); ?>">
					<img class="img-responsive" style="width: 90%;  margin: 10px; display:inline-block; "
						src="<?php echo($urlImg);?>" title="<?php echo($conteudo->titulo);?>" alt="<?php echo($conteudo->titulo);?>"/>
				</a>
				<?php endif;?>
				<div class="caption" style="display:inline-block;">
					<h4><a href="<?php echo($url);?>"><?php echo($titulo);?></a>
					<?php if(isset($tipoGostar)){ echo($tipoGostar);}?></h4>
					<p><?php echo($conteudo->descricao);?></p>
					<?php echo($botao);?>
					
				</div>
			</div>
		</div>
<?php 	endforeach;?>
		</div>
	</div>
	<!-- div id="direito" class="hidden-phone col col-xs-1 col-sm-1 col-md-1 col-lg-2"></div-->
</div>