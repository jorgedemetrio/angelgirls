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



JFactory::getDocument()->addScriptDeclaration('
	Joomla.submitbutton = function(task)
	{
		if (task == "carregar" || document.formvalidator.isValid(document.getElementById("adminForm")))
		{
			Joomla.submitform(task, document.getElementById("adminForm"));
		}
	};
');
?>
<form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate">
    <div class="col100">
        <fieldset class="adminAgenda"><legend><?php echo JText::_('Agenda'); ?></legend>
			<table class="admintable" align="center">
				<tr>
					<th align="center" class="key"><label for="nome"> <?php echo JText::_('Titulo'); ?>:</label></th>
					<th align="center" class="key"><label for="data"> <?php echo JText::_('Data'); ?>:</label></th>
					<th align="center" class="key"><label for="published"> <?php echo JText::_('Published'); ?>:</label></th>
				</tr>
				<tr>
					<td><input class="text_area" style="width: 250px;" type="text" name="titulo"  id="titulo" size="32" maxlength="250" value="<?php echo $this->item->titulo;?>" /></td>
					<td><?php echo JHtml::calendar($this->item->data,'created_on', 'created_on', '%Y-%m-%d');?></td>
					<td>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="right"><label for='published_yes'>Sim</label></td>
								<td  align="left"><input type='radio' name='published' id='published_yes' value='yes' /></td>
								<td>&nbsp;</td>
								<td align="right"><label for='published_no'>Não</label></td>
								<td  align="left"><input type='radio' name='published' id='published_no' value='no' /></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td  align="center" class="key"><label for="publicar"> <?php echo JText::_('Publicar'); ?>:</label></td>
					<td  align="center" class="key"><label for="despublicar"> <?php echo JText::_('Despublicar'); ?>:</label></td>
					<td align="center" class="key"><label for="descricao_google"> <?php echo JText::_('Meta descrição'); ?>:</label></td>
				</tr>
				<tr>
					<td><?php echo JHtml::calendar($this->item->publicar,'publicar', 'publicar', '%d/%m/%Y', 'class="required" ');?></td>
					<td><?php echo JHtml::calendar($this->item->despublicar,'despublicar', 'despublicar', '%d/%m/%Y', 'class="required" ');?></td>
					<td><input class="text_area required" style="width: 250px;" type="text" name="descricao_google" id="descricao_google" size="32" maxlength="250" value="<?php echo $this->item->descricao_google;?>" /></td>
				</tr>
				<tr>

					<td  align="center" class="key"><label for="id_edited_by"><?php echo JText::_('Editado por'); ?>:</label></td>                
					<td  align="center" class="key"><label for="id_created_by"><?php echo JText::_('Criado por'); ?>:</label></td>
					<td  align="center" class="key"><label for="created_on"> <?php echo JText::_('Created On'); ?>:</label></td>
					<td  align="center" class="key"><label for="edited_on"> <?php echo JText::_('Edited On'); ?>:</label></td>					
				</tr>
				<tr>

					<td><?php echo $this->item->id_edited_by;?></td>
					<td><?php echo $this->item->id_created_by;?></td>
					<td><?php echo($this->item->created_on);?></td>
					<td><?php echo($this->item->edited_on);?></td>
				</tr>
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
    <input type="hidden" name="view" value="agendas" />
    <input type="hidden" name="controller" value="agendas" />
    <input type="hidden" name="task" value="save" />
</form>
