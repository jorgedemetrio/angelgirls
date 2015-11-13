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

$this->item =& JRequest::getVar('agenda');

JFactory::getDocument()->addStyleDeclaration('
		label {
		    display: block;
		    margin-bottom: 5px;
		    color: darkblue;
		    font-weight: bold;
		}
		#foto {
			opacity: 0;
			-moz-opacity: 0;
			filter: alpha(opacity = 0);
			position: absolute;
			z-index: -1; }
');

$modelos = JRequest::getVar('modelos');
$fotografos = JRequest::getVar('fotografos');
$temas = JRequest::getVar('temas');
$locacoes = JRequest::getVar('locacoes');




JFactory::getDocument()->addScriptDeclaration('
	Joomla.submitbutton = function(task)
	{
		if (task == "listAgenda" || document.formvalidator.isValid(document.getElementById("adminForm")))
		{
			Joomla.submitform(task, document.getElementById("adminForm"));
		}
	};
');
?>
<form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
	<?php echo JHtml::_('form.token'); ?>	
    <div class="col100">
        <fieldset class="adminAgenda"><legend><?php echo JText::_('Agenda'); ?></legend>
			<table class="admintable" align="center">
				<tr>
					<th align="center" class="key" colspan="2"><label for="titulo"> <?php echo JText::_('Titulo'); ?>:</label></th>
					<td align="center" class="key" colspan="2"><label for="descricao_google"> <?php echo JText::_('Meta descri&ccedil&atilde;o'); ?>:</label></td>
				</tr>
				<tr>
					<td colspan="2"><input class="text_area required" style="width: 270px;" type="text" name="titulo"  id="titulo" size="32" maxlength="250" value="<?php echo $this->item->titulo;?>" /></td>
					<td colspan="2"><input class="text_area required" style="width: 270px;" type="text" name="descricao_google" id="descricao_google" size="32" maxlength="250" value="<?php echo $this->item->descricao_google;?>" /></td>
				</tr>
				<tr>
					<td  align="center" class="key"><label for="tipo"> <?php echo JText::_('Tipo'); ?>:</label></td>
					<th align="center" class="key"><label for="data"> <?php echo JText::_('Data Evento'); ?>:</label></th>
					<th align="center" class="key"><label for="publicar"> <?php echo JText::_('Data Publica&ccedil;&atilde;o'); ?>:</label></th>
				</tr>
				<tr>
					<td>
						<select name="tipo" id="tipo" class="required">
							<option></option>
							<option value="SESSAO">SESS&ATILDE;O</option>
						</select>
					</td>
					<td><?php echo JHtml::calendar($this->item->data,'data', 'data', '%d/%m/%Y');?></td>
					<td><?php echo JHtml::calendar($this->item->publicar,'publicar', 'publicar', '%d/%m/%Y');?></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td  align="center" class="key"><label for="publicar"> <?php echo JText::_('Fotografo'); ?>:</label></td>
					<td  align="center" class="key"><label for="despublicar"> <?php echo JText::_('Modelo'); ?>:</label></td>
					<td align="center" class="key"><label for="descricao_google"> <?php echo JText::_('Tema'); ?>:</label></td><td>
					<td align="center" class="key"><label for="descricao_google"> <?php echo JText::_('Locacao'); ?>:</label></td>
				</tr>
				<tr>
					<td>
						<select name="id_fotografo" id="id_fotografo">
							<option></option>
							<?php 
							foreach ($fotografos as $fotografo){
							?>
								<option value="<?php echo($fotografo->id); ?>"><?php echo($fotografo->nome); ?></option>
							<?php 
							}?>
						</select>
					</td>
					<td>
						<select name="id_modelo" id="id_modelo">
							<option></option>
							<?php 
							foreach ($modelos as $modelo){
							?>
								<option value="<?php echo($modelo->id); ?>"><?php echo($modelo->nome); ?></option>
							<?php 
							}?>
						</select>
					</td>
					<td>
						<select name="id_tema" id="id_tema">
							<option></option>
							<?php 
							foreach ($temas as $tema){
							?>
								<option value="<?php echo($tema->id); ?>"><?php echo($tema->nome); ?></option>
							<?php 
							}?>
						</select>
					</td>
					<td>
						<select name="id_locacao" id="id_locacao">
							<option></option>
							<?php 
							foreach ($locacoes as $locacoe){
							?>
								<option value="<?php echo($locacoe->id); ?>"><?php echo($locacoe->nome); ?></option>
							<?php 
							}?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<?php
				if($this->item != null && $this->item->id != null){ 
				?>
				<tr>
					<th  align="center" class="key"><label><?php echo JText::_('Criado por'); ?>:</label></th>
					<th  align="center" class="key"><label><?php echo JText::_('Editado por'); ?>:</label></th>                
					<th  align="center" class="key"><label><?php echo JText::_('Criado'); ?>:</label></th>
					<th  align="center" class="key"><label><?php echo JText::_('Editado'); ?>:</label></th>					
				</tr>
				<tr>
					<td align="center"><?php echo $this->item->criador;?></td>
					<td align="center"><?php echo $this->item->editor;?></td>
					<td align="center"><?php echo(JFactory::getDate($this->item->data_criado)->format('d/m/Y'));?></td>
					<td align="center"><?php echo(JFactory::getDate($this->item->data_alterado)->format('d/m/Y'));?></td>
				</tr>
				<tr>
					<th  align="center" class="key"><label for="id_edited_by"><?php echo JText::_('Gostaram'); ?>:</label></th>                
					<th  align="center" class="key"><label for="id_created_by"><?php echo JText::_('N&atilde;o Gostaram'); ?>:</label></th>
					<th  align="center" class="key"><label for="created_on"> <?php echo JText::_('Vizualizaram'); ?>:</label></th>
				
				</tr>
				<tr>
					<td align="center"><?php echo $this->item->audiencia_gostou;?></td>
					<td align="center"><?php echo $this->item->audiencia_ngostou;?></td>
					<td align="center"><?php echo($this->item->audiencia_view);?></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
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
