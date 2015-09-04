<?php
/**
 * Galerias HTML Default Template
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

<h1><?php echo JText::_('Add Galerias'); ?></h1>
<form id="new_galerias" name="new_galerias" method="post" onsubmit="return document.formvalidator.isValid(this)">
<table border="0" cellspacing="1" cellpadding="1">
            <tr>
                <td width="100" align="right" class="key"><label for="nome"> <?php echo JText::_('Nome'); ?>:</label></td>
                <td><input class="text_area" type="text" name="nome" id="nome" size="32" maxlength="250" value="<?php echo $this->item->nome;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="descricao"> <?php echo JText::_('Descricao'); ?>:</label></td>
                <td><?php echo $editor->display('descricao', $this->item->descricao, '400', '400', '20', '20', false, $params); ?></td>
        </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="id_concurso"> <?php echo JText::_('Id Concurso'); ?>:</label></td>
                <td><input class="text_area" type="text" name="id_concurso" id="id_concurso" size="32" maxlength="250" value="<?php echo $this->item->id_concurso;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="id_sessao"> <?php echo JText::_('Id Sessao'); ?>:</label></td>
                <td><input class="text_area" type="text" name="id_sessao" id="id_sessao" size="32" maxlength="250" value="<?php echo $this->item->id_sessao;?>" /></td>
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
                <td width="100" align="right" class="key"><label for="descricao_google"> <?php echo JText::_('Descricao Google'); ?>:</label></td>
                <td><input class="text_area" type="text" name="descricao_google" id="descricao_google" size="32" maxlength="250" value="<?php echo $this->item->descricao_google;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="grande"> <?php echo JText::_('Grande'); ?>:</label></td>
                <td><input class="text_area" type="text" name="grande" id="grande" size="32" maxlength="250" value="<?php echo $this->item->grande;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="thumb"> <?php echo JText::_('Thumb'); ?>:</label></td>
                <td><input class="text_area" type="text" name="thumb" id="thumb" size="32" maxlength="250" value="<?php echo $this->item->thumb;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="icone"> <?php echo JText::_('Icone'); ?>:</label></td>
                <td><input class="text_area" type="text" name="icone" id="icone" size="32" maxlength="250" value="<?php echo $this->item->icone;?>" /></td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="media"> <?php echo JText::_('Media'); ?>:</label></td>
                <td><input class="text_area" type="text" name="media" id="media" size="32" maxlength="250" value="<?php echo $this->item->media;?>" /></td>
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
    <input type="hidden" name="view" value="galerias" />
    <input type="hidden" name="controller" value="galerias" />
</form>