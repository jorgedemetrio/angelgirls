<?php
/**
 * temas HTML List Template
 *
 * PHP versions 5
 *
 * @category  Template
 * @package   AngelGirls
 * @author    Jorge Demetiro <jorge.demetrio@alldreams.com.br>
 * @copyright All rights reserved.
 * @license   GNU General Public License
 * @link      http://www.alldreams.com.br
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access'); 
$this->item &= JRequest::getVar ( 'tema' );

$sessoes = JRequest::getVar ( 'sessoes' );
$agendas = JRequest::getVar ( 'agendas' );

$imagem = null;
if (isset ( $tema->nome_foto ) && $tema->nome_foto != null && $tema->nome_foto != "") {
	$imagem = JURI::base ( true ) . '/images/temas/' . $tema->nome_foto;
}
?>
<div class="row icones-like-title">
	<div calss="col col-xs-12 col-sm-8 col-md-10 col-lg-10">
		<div class="page-header">
		   <h1><?php echo($this->item->nome);?></h1>
		</div>
	</div>
	<div calss="col col-xs-6 col-sm-2 col-md-1 col-lg-1">
		<div class="fb-like"></div>
	</div>
	<div calss="col col-xs-6 col-sm-2 col-md-1 col-lg-1">
		<!-- Posicione esta tag onde você deseja que o botão +1 apareça. -->
		<div class="g-plusone" data-size="medium" data-annotation="inline" data-width="300"></div>
	</div>
</div>
<div class="row">
<?php if($imagem!=null){?>
	<div class="col col-xs-12 col-sm-12 col-md-12  col-lg-12">
		<img src="<?php echo($imagem); ?>" title="<?php echo($this->item->nome);?>" alt="<?php echo($this->item->nome);?>"/>
	</div>
<?php }?>
	<div class="col col-xs-12 col-sm-12 col-md-12  col-lg-12">
		<?php echo($this->item->descricao);?>
	</div>
</div>

<!-- Sessoes -->
<h2>Sess&otilde;es realizadas (<small>ultimas sess&otilde;es</small>)</h2>
<div class="row">
	<?php
	$contador = 0;
	foreach ( $sessoes as $sessao ) {
		?>
	<div class="col col-xs-12 col-sm-4 col-md-1  col-lg-1">
	<?php
		if (isset ( $sessao->nome_foto ) && $sessao->nome_foto != null && $sessao->nome_foto != "") {
			$imagem = JURI::base ( true ) . '/images/temas/' . $sessao->nome_foto;
			?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo($sessao->titulo);?></h3>
			</div>
			<div class="panel-body">
				<a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarSessao&id='.$sessao->id.':'.$sessao->titulo));?>"
					alt="<?php echo($sessao->titulo);?>" title="<?php echo($sessao->titulo);?>"><img
					alt="<?php echo($sessao->titulo);?>" class="img-thumbnail"
					src="<?php echo($imagem);?>" border="0" /></a>
			</div>
		</div>
		
	<?php
		} else {
			?>
		<a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarSessao&id='.$sessao->id.':'.$sessao->titulo));?>"
			alt="<?php echo($sessao->titulo);?>" title="<?php echo($sessao->titulo);?>"><?php echo($sessao->titulo);?></a>	
	<?php
		}
		?>
	</div>
	<?php
		if ($contador ++ > 12) {
			?>
</div>
<div class="row">		
	<?php
		
		}
	}	?>
</div>



<!-- Agendas -->
<h2>Agendas (<small>pr&oacute;ximas agendas com esse tema.</small>)</h2>
<div class="row">
	<?php
	$contador = 0;
	foreach ( $agendas  as $agenda ) {
		?>
	<div class="col col-xs-12 col-sm-4 col-md-1  col-lg-1">
	<?php
		if (isset ( $agenda->nome_foto ) && $agenda->nome_foto != null && $agenda->nome_foto != "") {
			$imagem = JURI::base ( true ) . '/images/temas/' . $agenda->nome_foto;
			?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo($agenda->titulo);?></h3>
			</div>
			<div class="panel-body">
				<a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarAgenda&id='.$agenda->id.':'.$agenda->titulo));?>"
					alt="<?php echo($agenda->titulo);?>" title="<?php echo($agenda->titulo);?>"><img
					alt="<?php echo($agenda->titulo);?>" class="img-thumbnail"
					src="<?php echo($imagem);?>" border="0" /></a>
			</div>
		</div>
		
	<?php
		} else {
			?>
		<a href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarAgenda&id='.$agenda->id.':'.$agenda->titulo));?>"
			alt="<?php echo($agenda->titulo);?>" title="<?php echo($agenda->titulo);?>"><?php echo($agenda->titulo);?></a>	
	<?php
		}
		?>
	</div>
	<?php
		if ($contador ++ > 12) {
			?>
</div>
<div class="row">		
	<?php
		
		}
	}	?>
</div>
<div class="fb-comments" data-href="http://developers.facebook.com/docs/plugins/comments/" data-width="750px" data-numposts="5"></div>