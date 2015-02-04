<?php
/**
 * Perfils HTML Default Template
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
JHTML::_('behavior.formvalidation');
JHTML::_('behavior.keepalive');
JHTML::_('behavior.calendar');

$editor =& JFactory::getEditor();
$params = array('smilies'=> '0', 'html' => '1', 'style'  => '1', 'layer'  => '0', 'table'  => '1', 'clear_entities'=>'0');
?>

<h1><?php echo JText::_('Add Perfils'); ?></h1>
<form id="new_perfils" name="new_perfils" method="post" onsubmit="return document.formvalidator.isValid(this)">
<table border="0" cellspacing="1" cellpadding="1">
            <tr>
                <td width="100" align="right" class="key"><label for="descricao"> <?php echo JText::_('Descricao'); ?>:</label></td>
                <td><?php echo $editor->display('descricao', $this->item->descricao, '400', '400', '20', '20', false, $params); ?></td>
        </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="documento"> <?php echo JText::_('Documento'); ?>:</label></td>
                <td><input class="text_area" type="text" name="documento" id="documento" size="32" maxlength="250" value="<?php echo $this->item->documento;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="foto_perfil"> <?php echo JText::_('Foto Perfil'); ?>:</label></td>
                <td><input class="text_area" type="text" name="foto_perfil" id="foto_perfil" size="32" maxlength="250" value="<?php echo $this->item->foto_perfil;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="apelido"> <?php echo JText::_('Apelido'); ?>:</label></td>
                <td><input class="text_area" type="text" name="apelido" id="apelido" size="32" maxlength="250" value="<?php echo $this->item->apelido;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="tipo_perfil"> <?php echo JText::_('Tipo Perfil'); ?>:</label></td>
                <td><input class="text_area" type="text" name="tipo_perfil" id="tipo_perfil" size="32" maxlength="250" value="<?php echo $this->item->tipo_perfil;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="published"> <?php echo JText::_('Published'); ?>:</label></td>
                <td>
                  <?php
                  foreach (array(JText::_("No"), JText::_("Yes")) as $key => $value) {
                      $c = '';
                      if($this->item->published == $key) $c = " checked='checked' ";
                      echo "<input type='radio' name='published' id='published_$key' $c value='$key' /> <label for='published_$key'>$value</label><br />";
                  }
                  ?>
                </td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="status"> <?php echo JText::_('Status'); ?>:</label></td>
                <td><input class="text_area" type="text" name="status" id="status" size="32" maxlength="250" value="<?php echo $this->item->status;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="publicar"> <?php echo JText::_('Publicar'); ?>:</label></td>
                <td><?php echo JHtml::calendar($this->item->publicar,'created_on', 'created_on', '%Y-%m-%d');?></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="despublicar"> <?php echo JText::_('Despublicar'); ?>:</label></td>
                <td><?php echo JHtml::calendar($this->item->despublicar,'created_on', 'created_on', '%Y-%m-%d');?></td>
            </tr>

</table>
    <?php echo JHTML::_('form.token'); ?>
    <input type="submit" value="<?php echo JText::_('Submit'); ?>" />
    <input type="hidden" name="option" value="com_angelgirls" />
    <input type="hidden" name="task" value="save" />
    <input type="hidden" name="view" value="perfils" />
    <input type="hidden" name="controller" value="perfils" />
</form>