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
defined ( '_JEXEC' ) or die ( 'Restricted access' );
$lista = JRequest::getVar ( 'lista' );
if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=listTema', false ), "" );
	exit ();
}
?>
<!-- LAYOUT TEM QUE TER  -->
<!-- <div id="fb-root"></div> -->

<div class="row icones-like">
	<div calss="col col-xs-12 col-sm-8 col-md-10 col-lg-10">
		<div class="page-header">
		   <h1>Temas das sess&atilde;oes fotograficas</h1>
		</div>
	</div>
	<div calss="col col-xs-6 col-sm-2 col-md-1 col-lg-1">
		<div class="fb-like"></div>
	</div>
	<div calss="col col-xs-6 col-sm-2 col-md-1 col-lg-1">
		<div class="g-plusone" data-size="medium" ></div>
	</div>
</div>

<div class="wells">
   Aqui voc&ecirc; ir&aacute; encontrar os temas fotograficos j&aacute; usados em nossas sessões fotograficas e em sessões agendadas. 
</div>

<div class="row">
	<?php
	$contador = 0;
	foreach ( $lista as $tema ) {
		?>
	<div class="col col-xs-12 col-sm-4 col-md-1  col-lg-1">
	<?php
		if (isset ( $tema->nome_foto ) && $tema->nome_foto != null && $tema->nome_foto != "") {
			$imagem = JURI::base ( true ) . '/images/temas/' . $tema->nome_foto;
		?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title" <?php echo($tema->nome);?></h3>
			</div>
			<div class="panel-body">
				<a
					href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarTema&id='.$tema->id.':'.$tema->nome));?>"
					alt="<?php echo($tema->nome);?>" title="<?php echo($tema->nome);?>"><img
					alt="<?php echo($tema->nome);?>" class="img-thumbnail"
					src="<?php echo($imagem);?>" border="0" /></a>
			</div>
		</div>
	<?php
		} else {
			?>
		<a
			href="<?php echo(JRoute::_('index.php?option=com_angelgirls&task=carregarTema&id='.$tema->id.':'.$tema->nome));?>"
			alt="<?php echo($tema->nome);?>" title="<?php echo($tema->nome);?>"><?php echo($tema->nome);?></a>	
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
