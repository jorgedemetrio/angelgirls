<?php
/**
 * Emails HTML List Template
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

<h1><?php echo JText::_('Emails'); ?></h1>
<?php if(count($this->items) > 0) : ?>
<div id="emails_list">
    <p><?php echo JText::_('Below is a list of all current Emails'); ?>.</p>
    <table border="0" cellspacing="1" cellpadding="1">
    <thead>
        <tr>
            <th><?php echo JText::_('Emails'); ?></th>
            <th><?php echo JText::_('Edited On'); ?></th>

        </tr>
    </thead>

    <?php foreach ($this->items as $item) : ?>
    <?php $link = JRoute::_('index.php?option=com_angelgirls&amp;view=emails&amp;layout=details&amp;id='.$item->id); ?>
        <tr>
            <td><?php echo "<a href='$link'>".$item->emails."</a>"; ?></td>
            <td><?php echo "<a href='$link'>".$item->edited_on."</a>"; ?></td>

        </tr>
    <?php endforeach; ?>
    </table>
<?php else: ?>
    <p><?php echo JText::_('No Emails found'); ?>.</p>
<?php endif; ?>
</div>