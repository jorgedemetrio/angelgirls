<?php 
defined('_JEXEC') or die('Restricted access');

$redesSociais =& JRequest::getVar('redesSociais');
?>
<div id="table-responsive">
	<table class="admintable table table-striped" align="center">
		<tr>
			<th></th>
			<th></th>
			<th><?php echo JText::_('Rede'); ?></th>
			<th><?php echo JText::_('Contato'); ?></th>
			<th><?php echo JText::_('Principal'); ?></th>
		</tr>
		<?php
		$k="odd";
		foreach ($redesSociais as $redesSocial){ 
		?>
		<tr class="<?php echo($k);?>">
			<td class="<?php echo($k);?>"></td>
			<td class="<?php echo($k);?>"></td>
			<td class="<?php echo($k);?>"><?php echo($redesSocial->rede_social); ?></td>
			<td class="<?php echo($k);?>"><?php echo($redesSocial->url_usuario); ?></td>
		</tr>
		<?php
			if($k=="odd"){
				$k="even";
			}
			else{
				$k="odd";
			}
		} 
		?>
	</table>
</div>