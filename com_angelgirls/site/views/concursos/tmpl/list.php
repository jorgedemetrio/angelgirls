<?php
/**
 * Concursos HTML List Template
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

<h1><?php echo JText::_('Concursos'); ?></h1>
<?php if(count($this->items) > 0) : ?>
<div id="concursos_list">
    <p><?php echo JText::_('Below is a list of all current Concursos'); ?>.</p>
    <table border="0" cellspacing="1" cellpadding="1">
    <thead>
        <tr>
            <th><?php echo JText::_('Nome'); ?></th>
            <th><?php echo JText::_('Descricao'); ?></th>
            <th><?php echo JText::_('Edited On'); ?></th>
            <th><?php echo JText::_('Published'); ?></th>

        </tr>
    </thead>

    <?php foreach ($this->items as $item) : ?>
    <?php $link = JRoute::_('index.php?option=com_angelgirls&amp;view=concursos&amp;layout=details&amp;id='.$item->id); ?>
        <tr>
            <td><?php echo "<a href='$link'>".$item->nome."</a>"; ?></td>
            <td><?php echo "<a href='$link'>".$item->descricao."</a>"; ?></td>
            <td><?php echo "<a href='$link'>".$item->edited_on."</a>"; ?></td>
            <td><?php echo "<a href='$link'>".$item->published."</a>"; ?></td>

        </tr>
    <?php endforeach; ?>
    </table>
<?php else: ?>
    <p><?php echo JText::_('No Concursos found'); ?>.</p>
<?php endif; ?>
</div>