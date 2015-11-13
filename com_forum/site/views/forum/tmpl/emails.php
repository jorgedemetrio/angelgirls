<?php
defined('_JEXEC') or die('Restricted access'); 
$emails = JRequest::getVar('emails');
?>
<table class="table table-hover">
	<thead>
		<tr>
			<th><span class="hidden-tablet hidden-phone">Principal</span></th>
			<th><span class="hidden-tablet hidden-phone">Remover</span></th>
			<th>E-mail</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($emails as $email):?>
	<tr>
	<?php 	if($email->principal=='S'):?>
			<td class="padrao" title="Est&aacute; como principal por isso n&atilde;o pode ser editado." style="text-align: center;"><span class="glyphicon glyphicon-check"></span></td>
			<td class="padrao" title="Est&aacute; como principal por isso n&atilde;o pode ser editado." style="text-align: center;"><span class="glyphicon glyphicon-ban-circle"></span></td>
			<td class="padrao" style="text-transform: lowercase;" title="Est&aacute; como principal por isso n&atilde;o pode ser editado."><?php echo( strtolower($email->email));?></td>
	<?php 	else :?>
		<tr>
			<td title="Definir como e-mail principal."  style="text-align: center;"><a href="JavaScript: FormEmailActions.padrao(
										<?php echo( $email->id);?>);"><span class="glyphicon glyphicon-unchecked"></span></a></td>
			<td title="Remover e-mail."  style="text-align: center;"><a href="JavaScript: FormEmailActions.remover(
										<?php echo( $email->id);?>);"><span class="glyphicon glyphicon-remove"></span></a></td>
			<td class="editavel" style="text-transform: lowercase;" onclick="JavaScript: FormEmailActions.editar(
										<?php echo( $email->id);?>,
										'<?php echo( $email->email);?>');"><?php echo( strtolower($email->email));?></td>

	<?php 	endif;?>
	</tr>
	<?php endforeach;?>
							</tbody>
</table>