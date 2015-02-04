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
JHTML::_('behavior.calendar');


?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
    <div class="col100">
        <fieldset class="adminform"><legend><?php echo JText::_(''); ?></legend>
        <table class="admintable">
            <tr>
                <td width="100" align="right" class="key"><label for="user_id"> <?php echo JText::_('User Id'); ?>:</label></td>
                <td><input class="text_area" type="text" name="user_id" id="user_id" size="32" maxlength="250" value="<?php echo $this->item->user_id;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="telefone"> <?php echo JText::_('Telefone'); ?>:</label></td>
                <td><input class="text_area" type="text" name="telefone" id="telefone" size="32" maxlength="250" value="<?php echo $this->item->telefone;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="ddd"> <?php echo JText::_('Ddd'); ?>:</label></td>
                <td><input class="text_area" type="text" name="ddd" id="ddd" size="32" maxlength="250" value="<?php echo $this->item->ddd;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="created_on"> <?php echo JText::_('Created On'); ?>:</label></td>
                <td><?php echo JHtml::calendar($this->item->created_on,'created_on', 'created_on', '%Y-%m-%d');?></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="edited_on"> <?php echo JText::_('Edited On'); ?>:</label></td>
                <td><?php echo JHtml::calendar($this->item->edited_on,'created_on', 'created_on', '%Y-%m-%d');?></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="id_created_by"> <?php echo JText::_('Id Created By'); ?>:</label></td>
                <td><input class="text_area" type="text" name="id_created_by" id="id_created_by" size="32" maxlength="250" value="<?php echo $this->item->id_created_by;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="id_edited_by"> <?php echo JText::_('Id Edited By'); ?>:</label></td>
                <td><input class="text_area" type="text" name="id_edited_by" id="id_edited_by" size="32" maxlength="250" value="<?php echo $this->item->id_edited_by;?>" /></td>
            </tr>

            <tr></tr>
        </table>
        </fieldset>
    </div>

    <div class="clr"></div>

    <input type="hidden" name="option" value="com_angelgirls" />
    <input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
    <input type="hidden" name="view" value="telefones" />
    <input type="hidden" name="controller" value="telefones" />
    <input type="hidden" name="task" value="save" />
</form>
