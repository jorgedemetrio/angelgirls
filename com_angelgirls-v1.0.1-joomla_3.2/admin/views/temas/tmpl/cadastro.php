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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');
JHTML::_('behavior.formvalidator');


$editor =& JFactory::getEditor();
$params = array('smilies'=> '0', 'html' => '1', 'style'  => '1', 'layer'  => '0', 'table'  => '1', 'clear_entities'=>'0');



$modelos = JRequest::getVar('modelos');
$fotografos = JRequest::getVar('fotografos');
$temas = JRequest::getVar('temas');
$locacoes = JRequest::getVar('locacoes');




JFactory::getDocument()->addScriptDeclaration('
	Joomla.submitbutton = function(task)
	{
		if (task == "listTema" || document.formvalidator.isValid(document.getElementById("adminForm")))
		{
			Joomla.submitform(task, document.getElementById("adminForm"));
		}
	};
');
?>
<form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data" >
	<?php echo JHtml::_('form.token'); ?>
    <div class="col100">
        <fieldset class="adminAgenda"><legend><?php echo JText::_('Agenda'); ?></legend>
			<table class="admintable" align="center">
				<tr>
					<th align="center" class="key"><label for="nome"> <?php echo JText::_('Nome'); ?>:</label></th>
					<td align="center" class="key"><label for="foto"> <?php echo JText::_('Foto'); ?>:</label></td>
					<td  align="center" class="key"><label for="meta_descricao"> <?php echo JText::_('Meta dado'); ?>:</label></td>
				</tr>
				<tr>
					<td><input class="text_area required" style="width: 300px;" type="text" name="nome"  id="nome" size="32" maxlength="250" value="<?php echo $this->item->nome;?>" /></td>
					<td><input class="text_area " style="width: 250px;" type="file" name="foto" id="foto"/></td>
					<td><input class="text_area required" style="width: 300px;" type="text" name="meta_descricao"  id="meta_descricao" size="32" maxlength="250" value="<?php echo $this->item->meta_descricao;?>" /></td>
				</tr>
				<?php
				if($this->item != null && $this->item->id != null){ 
				?>
				<tr>
					<td  align="center" class="key"><label><?php echo JText::_('Criado por'); ?>:</label></td>
					<td  align="center" class="key"><label><?php echo JText::_('Editado por'); ?>:</label></td>                
					<td  align="center" class="key"><label><?php echo JText::_('Criado'); ?>:</label></td>
					<td  align="center" class="key"><label><?php echo JText::_('Editado'); ?>:</label></td>					
				</tr>
				<tr>
					<td><?php echo $this->item->criador;?></td>
					<td><?php echo $this->item->editor;?></td>
					<td><?php echo(JFactory::getDate($row->data_criado)->toFormat('%d/%m/%Y %H:%M:%S'));?></td>
					<td><?php echo(JFactory::getDate($row->data_alterado)->toFormat('%d/%m/%Y %H:%M:%S'));?></td>
				</tr>
				<tr>
					<td  align="center" class="key"><label for="id_edited_by"><?php echo JText::_('Gostaram'); ?>:</label></td>                
					<td  align="center" class="key"><label for="id_created_by"><?php echo JText::_('N&atilde;o Gostaram'); ?>:</label></td>
					<td  align="center" class="key"><label for="created_on"> <?php echo JText::_('Vizualizaram'); ?>:</label></td>
				
				</tr>
				<tr>
					<td><?php echo $this->item->audiencia_gostou;?></td>
					<td><?php echo $this->item->audiencia_ngostou;?></td>
					<td><?php echo($this->item->audiencia_view);?></td>
				</tr>
				<?php 
				}?>
				<tr>
					<td colspan="4" align="center" class="key"><label for="descricao"> <?php echo JText::_('Descricao'); ?>:</label></td>
				</tr>
				<tr>
					<td colspan="4" ><?php echo $editor->display('descricao', $this->item->descricao, '400', '400', '20', '20', false, $params); ?></td>
				</tr>
				
			</table>
        </fieldset>
    </div>

    <div class="clr"></div>

    <input type="hidden" name="option" value="com_angelgirls" />
    <input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
    <input type="hidden" name="view" value="" />
    <input type="hidden" name="controller" value="" />
    <input type="hidden" name="task" value="saveAngenda" />
</form>
