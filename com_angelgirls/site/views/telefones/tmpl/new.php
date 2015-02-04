<?php
/**
 * Telefones HTML Default Template
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

<h1><?php echo JText::_('Add Telefones'); ?></h1>
<form id="new_telefones" name="new_telefones" method="post" onsubmit="return document.formvalidator.isValid(this)">
<table border="0" cellspacing="1" cellpadding="1">
            <tr>
                <td width="100" align="right" class="key"><label for="telefone"> <?php echo JText::_('Telefone'); ?>:</label></td>
                <td><input class="text_area" type="text" name="telefone" id="telefone" size="32" maxlength="250" value="<?php echo $this->item->telefone;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="ddd"> <?php echo JText::_('Ddd'); ?>:</label></td>
                <td><input class="text_area" type="text" name="ddd" id="ddd" size="32" maxlength="250" value="<?php echo $this->item->ddd;?>" /></td>
            </tr>

</table>
    <?php echo JHTML::_('form.token'); ?>
    <input type="submit" value="<?php echo JText::_('Submit'); ?>" />
    <input type="hidden" name="option" value="com_angelgirls" />
    <input type="hidden" name="task" value="save" />
    <input type="hidden" name="view" value="telefones" />
    <input type="hidden" name="controller" value="telefones" />
</form>