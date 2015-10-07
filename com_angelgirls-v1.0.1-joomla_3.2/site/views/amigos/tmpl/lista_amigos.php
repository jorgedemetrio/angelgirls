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
$amigos = JRequest::getVar('amigos');


foreach($amigos as $amigo):
	$url = '';
	$urlFoto = '';
	switch ($amigo->tipo):
		case 'FOTOGRAFO':
			$url = JRoute::_('index.php?option=com_angelgirls&view=fotografo&task=carregarFotografo&id='.$amigo->id.':'.strtolower(str_replace(" ","-",$amigo->apelido)));
			$urlFoto = JRoute::_('index.php?option=com_angelgirls&view=fotografo&task=loadImage&id='.$amigo->token.':cube');
		break;
		case 'MODELO':
			$url = JRoute::_('index.php?option=com_angelgirls&view=modelo&task=carregarModelo&id='.$amigo->id.':'.strtolower(str_replace(" ","-",$amigo->apelido)));
			$urlFoto = JRoute::_('index.php?option=com_angelgirls&view=modelo&task=loadImage&id='.$amigo->token.':cube');
		break;
		default:
			$url = JRoute::_('index.php?option=com_angelgirls&view=visitante&task=carregarVisitante&id='.$amigo->id.':'.strtolower(str_replace(" ","-",$amigo->apelido)));
			$urlFoto = JRoute::_('index.php?option=com_angelgirls&view=visitante&task=loadImage&id='.$amigo->token.':cube');
			break;		
	endswitch;
?>
<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-2 thumbnail fade" id="amigo<?php echo($amigo->id);?>">
	<a href="<?php echo($url); ?>" title="<?php echo($urlFoto);?>">
		<img src="<?php echo($urlFoto);?>" />
	</a>
	<div class="caption">
	<h4 class="list-group-item-heading"><a href="<?php echo($url);?>"><?php echo($amigo->apelido);?></a></h4>
	<p><a href="<?php echo($url);?>"><?php echo($amigo->meta_descricao);?></a></p>
	</div>
</div>
<?php 
endforeach;
$contador = sizeof($amigos);
if($contador>0):
echo("<script>lidos+=$contador;\n</script>");
endif;