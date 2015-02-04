<?php
/**
 * Galerias HTML Details Template
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
?>

<?php if($this->item->id > 0) : ?>
<table border="0" cellspacing="1" cellpadding="1">
<tr>
    <th><?php echo JText::_('Nome'); ?></th>
    <td><?php echo $this->item->nome; ?></td></tr>
<tr>
    <th><?php echo JText::_('Descricao'); ?></th>
    <td><?php echo $this->item->descricao; ?></td></tr>
<tr>
    <th><?php echo JText::_('Id Concurso'); ?></th>
    <td><?php echo $this->item->id_concurso; ?></td></tr>
<tr>
    <th><?php echo JText::_('Id Sessao'); ?></th>
    <td><?php echo $this->item->id_sessao; ?></td></tr>
<tr>
    <th><?php echo JText::_('Autor'); ?></th>
    <td><?php echo $this->item->autor; ?></td></tr>
<tr>
    <th><?php echo JText::_('Modelos'); ?></th>
    <td><?php echo $this->item->modelos; ?></td></tr>
<tr>
    <th><?php echo JText::_('Descricao Google'); ?></th>
    <td><?php echo $this->item->descricao_google; ?></td></tr>
<tr>
    <th><?php echo JText::_('Grande'); ?></th>
    <td><?php echo $this->item->grande; ?></td></tr>
<tr>
    <th><?php echo JText::_('Thumb'); ?></th>
    <td><?php echo $this->item->thumb; ?></td></tr>
<tr>
    <th><?php echo JText::_('Icone'); ?></th>
    <td><?php echo $this->item->icone; ?></td></tr>
<tr>
    <th><?php echo JText::_('Media'); ?></th>
    <td><?php echo $this->item->media; ?></td></tr>
<tr>
    <th><?php echo JText::_('Published'); ?></th>
    <td><?php echo $this->item->published; ?></td></tr>
<tr>
    <th><?php echo JText::_('Created On'); ?></th>
    <td><?php echo $this->item->created_on; ?></td></tr>
<tr>
    <th><?php echo JText::_('Edited On'); ?></th>
    <td><?php echo $this->item->edited_on; ?></td></tr>
<tr>
    <th><?php echo JText::_('Publicar'); ?></th>
    <td><?php echo $this->item->publicar; ?></td></tr>
<tr>
    <th><?php echo JText::_('Despublicar'); ?></th>
    <td><?php echo $this->item->despublicar; ?></td></tr>
<tr>
    <th><?php echo JText::_('Id Created By'); ?></th>
    <td><?php echo $this->item->id_created_by; ?></td></tr>
<tr>
    <th><?php echo JText::_('Id Edited By'); ?></th>
    <td><?php echo $this->item->id_edited_by; ?></td></tr>

</table>
<?php else : ?>
    <p><?php echo JText::_('Galerias not found'); ?>.</p>
<?php endif; ?>