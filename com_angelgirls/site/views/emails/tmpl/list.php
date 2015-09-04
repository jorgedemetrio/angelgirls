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

 * Emails HTML Default Template
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

<h2><?php echo JText::_('Add Emails'); ?></h2>
<form id="new_emails" name="new_emails" method="post" onsubmit="return document.formvalidator.isValid(this)">
	<table border="0" cellspacing="1" cellpadding="1" 
			summary="<?php echo JText::_('Add Emails'); ?>"
			title="<?php echo JText::_('Add Emails'); ?>">
		<tr>
			<td width="100" align="right" class="key"><label for="emails"> <?php echo JText::_('Email'); ?>:</label></td>
			<td><input class="text_area" type="text" name="emails" id="emails" size="32" maxlength="250" value="<?php echo $this->item->emails;?>" /></td>
		</tr>
	</table>
    <?php echo JHTML::_('form.token'); ?>
    <input type="submit" value="<?php echo JText::_('Submit'); ?>" />
    <input type="hidden" name="option" value="com_angelgirls" />
    <input type="hidden" name="task" value="save" />
    <input type="hidden" name="view" value="emails" />
    <input type="hidden" name="controller" value="emails" />
</form>


<h2><?php echo JText::_('Emails'); ?></h2>
<?php if(count($this->items) > 0) : ?>
<div id="emails_list">
    <p><?php echo JText::_('Below is a list of all current Emails'); ?>.</p>
    <table border="0" cellspacing="1" cellpadding="1" 
    	summary="<?php echo JText::_('Below is a list of all current Emails'); ?>" 
    	title="<?php echo JText::_('Below is a list of all current Emails'); ?>"
    	class="tabelaDados">
	    <thead>
	        <tr>
	            <th><?php echo JText::_('Emails'); ?></th>
	            <th><?php echo JText::_('Edited On'); ?></th>
	        </tr>
	    </thead>
	    <tbody>
	    <?php foreach ($this->items as $item) : ?>
	    <?php $link = JRoute::_('index.php?option=com_angelgirls&amp;view=emails&amp;layout=details&amp;id='.$item->id); ?>
	        <tr>
	            <td><?php echo "<a href='$link'>".$item->emails."</a>"; ?></td>
	            <td><?php echo "<a href='$link'>".$item->edited_on."</a>"; ?></td>
	        </tr>
	    <?php endforeach; ?>
	    </tbody>
    </table>
<?php else: ?>
    <p><?php echo JText::_('No Emails found'); ?>.</p>
<?php endif; ?>
</div>