<?php
// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );
$perfil = JRequest::getVar ( 'perfil' );
$view = JRequest::getVar ( 'view' );
if(!isset($perfil)){
	$perfil = AngelgirlsController::getPerfilLogado();
}

?>
<?php
// if(JDEBUG):
//echo($view); 
//endif;?>
<div id="esquerdo" class="col col-xs-2 col-sm-3 col-md-3 col-lg-2 hidden-phone">
	<div class="hidden-phone">
		<gcse:searchbox-only resultsUrl="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=busca',false));?>" newWindow="false"
		enableHistory="true" autoCompleteMaxCompletions="5" autoCompleteMatchType='any'></gcse:searchbox-only>
	</div>
	<ul class="nav nav-pills  nav-stacked">
	  <li role="presentation"<?php echo($view=='home' || !isset($view) ?'  class="active"':'');?>> <a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=home&task=homepage',false));?>"><span class="badge"><span class="glyphicon glyphicon-home"></span></span><span class="hidden-phone"> Home <?php echo(strtolower( $perfil->tipo)); ?></span> </a></li>
<?php if(isset($perfil)) : ?>
	  <li role="presentation"<?php echo($view=='perfil'?'  class="active"':'');?>><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarPerfil',false));?>"><span class="badge"><span class="glyphicon glyphicon-pencil"></span></span><span class="hidden-phone"> Meu perfil</span></a></li>
	  <li role="presentation inbox"<?php echo($view=='inbox'?'  class="active"':'');?>><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=inbox&task=inboxMensagens',false));?>"><span class="caixaMensagens"></span> <span class="hidden-phone"> Messages</span></a></li>
	  <li role="presentation inbox"<?php echo($view=='amigos'?'  class="active"':'');?>><a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=amigos',false));?>"><span class="badge"><span class="glyphicon glyphicon-sunglasses"></span></span><span class="hidden-phone"> Amigos</span></a></li>
<?php if(JDEBUG): ?><li role="presentation inbox"><a href="#"><span class="badge"><span class="glyphicon glyphicon-user"></span></span><span class="hidden-phone"> Grupos</span></a></li>
	  <li role="presentation inbox"><a href="#"><span class="badge"><span class="glyphicon glyphicon-globe"></span></span><span class="hidden-phone"> P&aacute;ginas</span></a></li>
	  <li role="presentation inbox"><a href="#"><span class="badge"><span class="glyphicon glyphicon-facetime-video"></span></span><span class="hidden-phone"> V&iacute;deos</span></a></li>
	  <li role="presentation inbox"><a href="#"><span class="badge"><span class="glyphicon glyphicon-comment"></span></span><span class="hidden-phone"> Enviar convites</span></a></li>
	  <li role="presentation inbox"><a href="#"><span class="badge"><span class="glyphicon glyphicon-th-list"></span></span><span class="hidden-phone"> Noticias</span></a></li>
	  <li role="presentation inbox"><a href="#"><span class="badge"><span class="glyphicon glyphicon-calendar"></span></span><span class="hidden-phone"> Calend&aacute;rio</span></a></li>
<?php endif;?>
<?php if($perfil->tipo=='MODELO' || $perfil->tipo=='FOTOGRAFO' ):?>		
		  <li role="presentation inbox"><a href="#"><span class="badge"><span class="glyphicon glyphicon-piggy-bank"></span></span><span class="hidden-phone"> Extrato</span></a></li>
  
		  <li role="presentation"<?php echo($view=='sessoes'?'  class="active"':'');?>>
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
<?php endif;?>
</div>