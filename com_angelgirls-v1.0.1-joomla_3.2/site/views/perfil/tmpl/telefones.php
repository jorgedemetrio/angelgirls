<?php
defined('_JEXEC') or die('Restricted access'); 
$telefones = JRequest::getVar('telefones');
?>
<table class="table table-hover">
	<thead>
		<tr>
			<th><span class="hidden-tablet hidden-phone">Principal</span></th>
			<th><span class="hidden-tablet hidden-phone">Remover</span></th>
			<th>Tipo</th>
			<th>Operadora</th>
			<th>DDD</th>
			<th>Telefone</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($telefones as $telefone):?>
								<tr>
	<?php 	if($telefone->principal=='S'):?>
			<td class="padrao" title="Est&aacute; como principal por isso n&atilde;o pode ser editado." style="text-align: center;"><span class="glyphicon glyphicon-check"></span></td>
			<td class="padrao" title="Est&aacute; como principal por isso n&atilde;o pode ser editado." style="text-align: center;"><span class="glyphicon glyphicon-ban-circle"></span></td>
			<td class="padrao" title="Est&aacute; como principal por isso n&atilde;o pode ser editado."><?php echo( strtolower($telefone->tipo));?></td>
			<td class="padrao" title="Est&aacute; como principal por isso n&atilde;o pode ser editado."><?php echo( strtolower(str_replace('_', ' ', $telefone->operadora)));?></td>
			<td class="padrao" title="Est&aacute; como principal por isso n&atilde;o pode ser editado."><?php echo( strtolower($telefone->ddd));?></td>
			<td class="padrao" title="Est&aacute; como principal por isso n&atilde;o pode ser editado."><?php echo( strtolower($telefone->telefone));?></td>
	<?php 	else :?>
			<td title="Definir como telefone principal." style="text-align: center;"><a	href="JavaScript: FormTelefoneActions.padrao(
										<?php echo( $telefone->id);?>);"><span class="glyphicon glyphicon-unchecked"></span></a></td>
			<td title="Remover telefone." style="text-align: center;"><a	href="JavaScript: FormTelefoneActions.remover(
										<?php echo( $telefone->id);?>);"><span class="glyphicon glyphicon-remove"></span></a></td>
			<td class="editavel" onclick="JavaScript: FormTelefoneActions.editar(
										<?php echo( $telefone->id);?>,
										'<?php echo( $telefone->tipo);?>',
										'<?php echo( $telefone->ddd);?>',
										'<?php echo( $telefone->telefone);?>',
										'<?php echo( $telefone->operadora);?>');"><?php echo( strtolower($telefone->tipo));?></td>
			<td class="editavel" onclick="JavaScript: FormTelefoneActions.editar(
										<?php echo( $telefone->id);?>,
										'<?php echo( $telefone->tipo);?>',
										'<?php echo( $telefone->ddd);?>',
										'<?php echo( $telefone->telefone);?>',
										'<?php echo( $telefone->operadora);?>');"><?php echo( strtolower(str_replace('_', ' ',  $telefone->operadora)));?></td>
			<td class="editavel" onclick="JavaScript: FormTelefoneActions.editar(
										<?php echo( $telefone->id);?>,
										'<?php echo( $telefone->tipo);?>',
										'<?php echo( $telefone->ddd);?>',
										'<?php echo( $telefone->telefone);?>',
										'<?php echo( $telefone->operadora);?>');"><?php echo( strtolower($telefone->ddd));?></td>
			<td class="editavel" onclick="JavaScript: FormTelefoneActions.editar(
										<?php echo( $telefone->id);?>,
										'<?php echo( $telefone->tipo);?>',
										'<?php echo( $telefone->ddd);?>',
										'<?php echo( $telefone->telefone);?>',
										'<?php echo( $telefone->operadora);?>');"><?php echo( strtolower($telefone->telefone));?></td>
	<?php 	endif;?>
		</tr>
	<?php endforeach;?>
							</tbody>
</table>