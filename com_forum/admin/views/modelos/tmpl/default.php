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
jimport('joomla.filter.filteroutput');

$lista = JRequest::getVar('lista');
if(JRequest::getVar('task')==null || JRequest::getVar('task')==''){
	$mainframes = JFactory::getApplication();
	$mainframes->redirect(JRoute::_('index.php?option=com_angelgirls&task=listModelo',false),"");
	exit();    
}

JHTML::_('behavior.calendar');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');
JHTML::_('behavior.formvalidator');

$editor =& JFactory::getEditor();
$params = array('smilies'=> '0', 'html' => '1', 'style'  => '1', 'layer'  => '0', 'table'  => '1', 'clear_entities'=>'0');
?>
<form action="<?php echo JRoute::_('index.php?option=com_angelgirls&view=modelo'); ?>" method="post" name="adminForm" id="adminForm">
<?php if(!empty( $this->sidebar)){ ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php } else { ?>
	<div id="j-main-container">
<?php }; ?>
		<div>
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="boxchecked" value="0" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</div>
</form>


<form action="index.php" method="post" name="adminForm" id="adminForm">
    <div id="editcell">
        <table class="adminlist table table-striped" width="90%" align="center">
        <thead>
            <tr>
                <th width="5" class="nowrap center hidden-phone"><?php echo JText::_('ID'); ?></th>
                <th width="20" class="nowrap center hidden-phone"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($lista); ?>);" /></th>
                <th class="nowrap center hidden-phone"></th>
                <th class="nowrap center hidden-phone"><?php echo JText::_('Nome'); ?></th>
                <th class="nowrap center hidden-phone"><?php echo JText::_('Criador'); ?></th>
                <th class="nowrap center hidden-phone"><?php echo JText::_('Editor'); ?></th>

            </tr>
        </thead>
        <?php
            $k = 0;
            $i = 0;
			if($lista!=null){
				foreach($lista as $row){
					JFilterOutput::objectHTMLSafe($row);
					$checked = JHTML::_('grid.id', $i, $row->id);
					$link = JRoute::_('index.php?option=com_angelgirls&view=modelos&task=editModelo&id='. $row->id, false);
					$imagem = JURI::base( true ) . '/../images/modelos/' .( isset($row->nome_foto) && $row->nome_foto!=null && $row->nome_foto!=""  ? $row->nome_foto : 'no_image.png');
			?>
					<tr class="<?php echo "row$k ".($k==1?"odd":"even"); ?>" valign="middle" align="center">
					   <td valign="middle" align="center" class="has-context <?php echo "row$k ".($k==1?"odd":"even"); ?>"><?php echo $row->id; ?></td>
					   <td valign="middle" align="center" class="has-context <?php echo "row$k ".($k==1?"odd":"even"); ?>"><?php echo $checked; ?></td>
   					   <td valign="middle" align="center" class="has-context <?php echo "row$k ".($k==1?"odd":"even"); ?>"><?php echo "<a href='$link'><img src='".$imagem."' style='width: 50px'/></a>"; ?></td>
					   <td valign="middle" align="center" class="has-context <?php echo "row$k ".($k==1?"odd":"even"); ?>"><?php echo "<a href='$link'>".$row->nome."</a>"; ?></td>
					   <td valign="middle" align="center" class="has-context <?php echo "row$k ".($k==1?"odd":"even"); ?>"><?php echo "<a href='$link'>".$row->criador."</a>"; ?></td>
					   <td valign="middle" align="center" class="has-context <?php echo "row$k ".($k==1?"odd":"even"); ?>"><?php echo "<a href='$link'>".$row->editor."</a>"; ?></td>

					</tr>
			<?php
					$k = 1 - $k;
					$i = $i + 1;
				}
			}
        ?>
        </table>
    </div>
    <input type="hidden" name="option" value="com_angelgirls" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="view" value="modelos" />
    <input type="hidden" name="controller" value="modelos" />
</form>

