<?php
/**
 * Enderecos HTML Default Template
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


?>

<h1><?php echo JText::_('Add Enderecos'); ?></h1>
<form id="new_enderecos" name="new_enderecos" method="post" onsubmit="return document.formvalidator.isValid(this)">
<table border="0" cellspacing="1" cellpadding="1">
            <tr>
                <td width="100" align="right" class="key"><label for="logradouro"> <?php echo JText::_('Logradouro'); ?>:</label></td>
                <td><input class="text_area" type="text" name="logradouro" id="logradouro" size="32" maxlength="250" value="<?php echo $this->item->logradouro;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="endereco"> <?php echo JText::_('Endereco'); ?>:</label></td>
                <td><input class="text_area" type="text" name="endereco" id="endereco" size="32" maxlength="250" value="<?php echo $this->item->endereco;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="numero"> <?php echo JText::_('Numero'); ?>:</label></td>
                <td><input class="text_area" type="text" name="numero" id="numero" size="32" maxlength="250" value="<?php echo $this->item->numero;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="cep"> <?php echo JText::_('Cep'); ?>:</label></td>
                <td><input class="text_area" type="text" name="cep" id="cep" size="32" maxlength="250" value="<?php echo $this->item->cep;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="edited_on"> <?php echo JText::_('Edited On'); ?>:</label></td>
                <td><?php echo JHtml::calendar($this->item->edited_on,'created_on', 'created_on', '%Y-%m-%d');?></td>
            </tr>

</table>
    <?php echo JHTML::_('form.token'); ?>
    <input type="submit" value="<?php echo JText::_('Submit'); ?>" />
    <input type="hidden" name="option" value="com_angelgirls" />
    <input type="hidden" name="task" value="save" />
    <input type="hidden" name="view" value="enderecos" />
    <input type="hidden" name="controller" value="enderecos" />
</form>