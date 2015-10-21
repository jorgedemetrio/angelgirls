<?php

/**
 * Agendas HTML Default Template
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
JHTML::_('behavior.calendar');
//JHtml::_('dropdown.init');
//JHtml::_('behavior.keepalive');

if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&view=perfil&task=amigos&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}
$amigos = JRequest::getVar('soliticacoes_recebidas');


foreach($amigos as $amigo):
	$url = '';
	$urlFoto = '';
	switch ($amigo->tipo):
		case 'FOTOGRAFO':
			$url = JRoute::_('index.php?option=com_angelgirls&view=fotografo&task=fotografo&id='.$amigo->token.':'.strtolower(str_replace(" ","-",$amigo->apelido)));
			$urlFoto = JRoute::_('index.php?option=com_angelgirls&view=fotografo&task=loadImage&id='.$amigo->token.':cube');
		break;
		case 'MODELO':
			$url = JRoute::_('index.php?option=com_angelgirls&view=modelo&task=modelo&id='.$amigo->token.':'.strtolower(str_replace(" ","-",$amigo->apelido)));
			$urlFoto = JRoute::_('index.php?option=com_angelgirls&view=modelo&task=loadImage&id='.$amigo->token.':cube');
		break;
		default:
			$url = JRoute::_('index.php?option=com_angelgirls&view=visitante&task=perfil&id='.$amigo->token.':'.strtolower(str_replace(" ","-",$amigo->apelido)));
			$urlFoto = JRoute::_('index.php?option=com_angelgirls&view=visitante&task=loadImage&id='.$amigo->token.':cube');
			break;		
	endswitch;
?>
<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-2 thumbnail fade" id="amigo<?php echo($amigo->token);?>">
	<a href="<?php echo($url); ?>" title="<?php echo($urlFoto);?>">
		<img src="<?php echo($urlFoto);?>" />
	</a>
	<div class="caption">
	<h4 class="list-group-item-heading"><a href="<?php echo($url);?>"><?php echo($amigo->apelido);?></a></h4>
	<p><a href="<?php echo($url);?>"><?php echo($amigo->meta_descricao);?></a></p>
	
		<div class="btn-toolbar pull-right" role="toolbar">
			<div class="btn-group" role="group" id="groupBtnAProvacao">
				<button class="btn btn-success aceitar" type="button" id="btnAprovarAmizade" title="Aceitar Amizade" data-id="<?php echo($amigo->token);?>"
				data-tipo="<?php echo($amigo->tipo);?>" onclick="JavaScript: Amigos.Aceitar(this);">
					<span class="glyphicon glyphicon-ok"></span>
				</button>
				<button class="btn  btn-danger recusar" type="button" id="btnReprovarAmizade"  title="Recusar Amizade" data-id="<?php echo($amigo->token);?>"
				data-tipo="<?php echo($amigo->tipo);?>" onclick="JavaScript: Amigos.Recusar(this);">
					<span class="glyphicon glyphicon-remove"></span>
				</button>
			</div>
		</div>
	
	</div>
</div>
<?php 
endforeach;
$contador = sizeof($amigos);
if($contador>0):
echo("<script>lidos+=$contador;\n</script>");
endif;