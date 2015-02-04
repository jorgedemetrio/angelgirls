<?php
/**
 * Conteudos_associados HTML Default Template
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


?>

<h1><?php echo JText::_('Add Conteudos Associados'); ?></h1>
<form id="new_conteudos_associados" name="new_conteudos_associados" method="post" onsubmit="return document.formvalidator.isValid(this)">
<table border="0" cellspacing="1" cellpadding="1">
            <tr>
                <td width="100" align="right" class="key"><label for="titulo"> <?php echo JText::_('Titulo'); ?>:</label></td>
                <td><input class="text_area" type="text" name="titulo" id="titulo" size="32" maxlength="250" value="<?php echo $this->item->titulo;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="origem_tipo"> <?php echo JText::_('Origem Tipo'); ?>:</label></td>
                <td><input class="text_area" type="text" name="origem_tipo" id="origem_tipo" size="32" maxlength="250" value="<?php echo $this->item->origem_tipo;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="origem_id"> <?php echo JText::_('Origem Id'); ?>:</label></td>
                <td><input class="text_area" type="text" name="origem_id" id="origem_id" size="32" maxlength="250" value="<?php echo $this->item->origem_id;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="origem_url"> <?php echo JText::_('Origem Url'); ?>:</label></td>
                <td><input class="text_area" type="text" name="origem_url" id="origem_url" size="32" maxlength="250" value="<?php echo $this->item->origem_url;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="destino_tipo"> <?php echo JText::_('Destino Tipo'); ?>:</label></td>
                <td><input class="text_area" type="text" name="destino_tipo" id="destino_tipo" size="32" maxlength="250" value="<?php echo $this->item->destino_tipo;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="destino_id"> <?php echo JText::_('Destino Id'); ?>:</label></td>
                <td><input class="text_area" type="text" name="destino_id" id="destino_id" size="32" maxlength="250" value="<?php echo $this->item->destino_id;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="destino_url"> <?php echo JText::_('Destino Url'); ?>:</label></td>
                <td><input class="text_area" type="text" name="destino_url" id="destino_url" size="32" maxlength="250" value="<?php echo $this->item->destino_url;?>" /></td>
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

</table>
    <?php echo JHTML::_('form.token'); ?>
    <input type="submit" value="<?php echo JText::_('Submit'); ?>" />
    <input type="hidden" name="option" value="com_angelgirls" />
    <input type="hidden" name="task" value="save" />
    <input type="hidden" name="view" value="conteudos_associados" />
    <input type="hidden" name="controller" value="conteudos_associados" />
</form>