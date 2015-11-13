<?php
defined('_JEXEC') or die('Restricted access'); 
$enderecos = JRequest::getVar('enderecos');
?>
<table class="table table-hover">
	<thead>
		<tr>
			<th><span class="hidden-tablet hidden-phone">Principal</span></th>
			<th><span class="hidden-tablet hidden-phone">Remover</span></th>
			<th>Tipo</th>
			<th>CEP</th>
			<th>Endereco</th>
			<th>Numero</th>
			<th>Cidade</th>
			<th>Estado</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($enderecos as $endereco):?>
								<tr>
	<?php 	if($endereco->principal=='S'):?>
			<td class="padrao" title="Est&aacute; como principal por isso n&atilde;o pode ser editado." style="text-align: center;"><span class="glyphicon glyphicon-check"></span></td>
			<td class="padrao" title="Est&aacute; como principal por isso n&atilde;o pode ser editado." style="text-align: center;"><span class="glyphicon glyphicon-ban-circle"></span></td>
			<td class="padrao" title="Est&aacute; como principal por isso n&atilde;o pode ser editado."><?php echo( strtolower($endereco->tipo));?></td>
			<td class="padrao" title="Est&aacute; como principal por isso n&atilde;o pode ser editado."><?php echo( strtolower($endereco->cep));?></td>
			<td class="padrao" title="Est&aacute; como principal por isso n&atilde;o pode ser editado."><?php echo( strtolower($endereco->endereco));?></td>
			<td class="padrao" title="Est&aacute; como principal por isso n&atilde;o pode ser editado."><?php echo( strtolower($endereco->numero));?></td>
			<td class="padrao" title="Est&aacute; como principal por isso n&atilde;o pode ser editado."><?php echo( strtolower($endereco->cidade));?></td>
			<td class="padrao" title="Est&aacute; como principal por isso n&atilde;o pode ser editado."><?php echo( strtolower($endereco->estado));?></td>
	<?php 	else :?>
			<td title="Definir como endere&ccedil;o principal." style="text-align: center;"><a	href="JavaScript: FormEnderecoActions.padrao(
										<?php echo( $endereco->id);?>);"><span class="glyphicon glyphicon-unchecked"></span></a></td>
			<td title="Remover endere&ccedil;o." style="text-align: center;"><a	href="JavaScript: FormEnderecoActions.remover(
										<?php echo( $endereco->id);?>);"><span class="glyphicon glyphicon-remove"></span></a></td>
			<td class="editavel" onclick="JavaScript: FormEnderecoActions.editar(
										<?php echo( $endereco->id);?>,
										'<?php echo( $endereco->tipo);?>',
										'<?php echo( $endereco->endereco);?>',
										'<?php echo( $endereco->numero);?>',
										'<?php echo( $endereco->complemento);?>',
										'<?php echo( $endereco->bairro);?>',
										'<?php echo( $endereco->cep);?>',
										<?php echo( $endereco->id_cidade);?>,
										'<?php echo( $endereco->uf);?>');"><?php echo( strtolower($endereco->tipo));?></td>
			<td class="editavel" onclick="JavaScript: FormEnderecoActions.editar(
										<?php echo( $endereco->id);?>,
										'<?php echo( $endereco->tipo);?>',
										'<?php echo( $endereco->endereco);?>',
										'<?php echo( $endereco->numero);?>',
										'<?php echo( $endereco->complemento);?>',
										'<?php echo( $endereco->bairro);?>',
										'<?php echo( $endereco->cep);?>',
										<?php echo( $endereco->id_cidade);?>,
										'<?php echo( $endereco->uf);?>');"><?php echo( strtolower($endereco->cep));?></td>
			<td class="editavel" onclick="JavaScript: FormEnderecoActions.editar(
										<?php echo( $endereco->id);?>,
										'<?php echo( $endereco->tipo);?>',
										'<?php echo( $endereco->endereco);?>',
										'<?php echo( $endereco->numero);?>',
										'<?php echo( $endereco->complemento);?>',
										'<?php echo( $endereco->bairro);?>',
										'<?php echo( $endereco->cep);?>',
										<?php echo( $endereco->id_cidade);?>,
										'<?php echo( $endereco->uf);?>');"><?php echo( strtolower($endereco->endereco));?></td>
			<td class="editavel" onclick="JavaScript: FormEnderecoActions.editar(
										<?php echo( $endereco->id);?>,
										'<?php echo( $endereco->tipo);?>',
										'<?php echo( $endereco->endereco);?>',
										'<?php echo( $endereco->numero);?>',
										'<?php echo( $endereco->complemento);?>',
										'<?php echo( $endereco->bairro);?>',
										'<?php echo( $endereco->cep);?>',
										<?php echo( $endereco->id_cidade);?>,
										'<?php echo( $endereco->uf);?>');"><?php echo( strtolower($endereco->numero));?></td>
			<td class="editavel" onclick="JavaScript: FormEnderecoActions.editar(
										<?php echo( $endereco->id);?>,
										'<?php echo( $endereco->tipo);?>',
										'<?php echo( $endereco->endereco);?>',
										'<?php echo( $endereco->numero);?>',
										'<?php echo( $endereco->complemento);?>',
										'<?php echo( $endereco->bairro);?>',
										'<?php echo( $endereco->cep);?>',
										<?php echo( $endereco->id_cidade);?>,
										'<?php echo( $endereco->uf);?>');"><?php echo( strtolower($endereco->cidade));?></td>
			<td class="editavel" onclick="JavaScript: FormEnderecoActions.editar(
										<?php echo( $endereco->id);?>,
										'<?php echo( $endereco->tipo);?>',
										'<?php echo( $endereco->endereco);?>',
										'<?php echo( $endereco->numero);?>',
										'<?php echo( $endereco->complemento);?>',
										'<?php echo( $endereco->bairro);?>',
										'<?php echo( $endereco->cep);?>',
										<?php echo( $endereco->id_cidade);?>,
										'<?php echo( $endereco->uf);?>');"><?php echo( strtolower($endereco->estado));?></td>
	<?php 	endif;?>
		</tr>
	<?php endforeach;?>
							</tbody>
</table>