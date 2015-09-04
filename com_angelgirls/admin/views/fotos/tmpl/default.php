<?php
/**
 * Fotos HTML Default Template
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

$editor =& JFactory::getEditor();
$params = array('smilies'=> '0', 'html' => '1', 'style'  => '1', 'layer'  => '0', 'table'  => '1', 'clear_entities'=>'0');
?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
    <div class="col100">
        <fieldset class="adminform"><legend><?php echo JText::_(''); ?></legend>
        <table class="admintable">
            <tr>
                <td width="100" align="right" class="key"><label for="title"> <?php echo JText::_('Title'); ?>:</label></td>
                <td><input class="text_area" type="text" name="title" id="title" size="32" maxlength="250" value="<?php echo $this->item->title;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="descricao"> <?php echo JText::_('Descricao'); ?>:</label></td>
                <td><?php echo $editor->display('descricao', $this->item->descricao, '400', '400', '20', '20', false, $params); ?></td>
			</tr>
            <tr>
                <td width="100" align="right" class="key"><label for="descricao_google"> <?php echo JText::_('Descricao Google'); ?>:</label></td>
                <td><input class="text_area" type="text" name="descricao_google" id="descricao_google" size="32" maxlength="250" value="<?php echo $this->item->descricao_google;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="apelido"> <?php echo JText::_('Apelido'); ?>:</label></td>
                <td><input class="text_area" type="text" name="apelido" id="apelido" size="32" maxlength="250" value="<?php echo $this->item->apelido;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="autor"> <?php echo JText::_('Autor'); ?>:</label></td>
                <td><input class="text_area" type="text" name="autor" id="autor" size="32" maxlength="250" value="<?php echo $this->item->autor;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="modelos"> <?php echo JText::_('Modelos'); ?>:</label></td>
                <td><input class="text_area" type="text" name="modelos" id="modelos" size="32" maxlength="250" value="<?php echo $this->item->modelos;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="data_foto"> <?php echo JText::_('Data Foto'); ?>:</label></td>
                <td><?php echo JHtml::calendar($this->item->data_foto,'created_on', 'created_on', '%Y-%m-%d');?></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="total_gostei"> <?php echo JText::_('Total Gostei'); ?>:</label></td>
                <td><input class="text_area" type="text" name="total_gostei" id="total_gostei" size="32" maxlength="250" value="<?php echo $this->item->total_gostei;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="total_ngostei"> <?php echo JText::_('Total Ngostei'); ?>:</label></td>
                <td><input class="text_area" type="text" name="total_ngostei" id="total_ngostei" size="32" maxlength="250" value="<?php echo $this->item->total_ngostei;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="autor_name"> <?php echo JText::_('Autor'); ?>:</label></td>
                <td><input class="text_area" type="text" name="autor_name" id="autor_name" size="32" maxlength="250" value="<?php echo $this->item->autor_name;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="created_on"> <?php echo JText::_('Created On'); ?>:</label></td>
                <td><?php echo JHtml::calendar($this->item->created_on,'created_on', 'created_on', '%Y-%m-%d');?></td>
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
                <td width="100" align="right" class="key"><label for="edited_on"> <?php echo JText::_('Edited On'); ?>:</label></td>
                <td><?php echo JHtml::calendar($this->item->edited_on,'created_on', 'created_on', '%Y-%m-%d');?></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="publicar"> <?php echo JText::_('Publicar'); ?>:</label></td>
                <td><?php echo JHtml::calendar($this->item->publicar,'created_on', 'created_on', '%Y-%m-%d');?></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="despublicar"> <?php echo JText::_('Despublicar'); ?>:</label></td>
                <td><?php echo JHtml::calendar($this->item->despublicar,'created_on', 'created_on', '%Y-%m-%d');?></td>
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
    <input type="hidden" name="view" value="fotos" />
    <input type="hidden" name="controller" value="fotos" />
    <input type="hidden" name="task" value="save" />
</form>
