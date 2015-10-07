<?php require_once 'ligthbox/header.php' ;
$perfils = JRequest::getVar('perfils');
$ufs = JRequest::getVar('ufs');
$nome = JRequest::getString('nome','');
?>
<form  action="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=perfil&task=buscarPerfilToken')); ?>" method="post" name="dadosFormBuscarPerfil" id="dadosFormBuscarPerfil" class="form-validate" role="form" data-toggle="validator" enctype="multipart/form-data" >
<h3>Localizar fotografos <small>M&aacute;ximo de 100 resultados para busca.</small></h3>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6">
		<label class="control-label"  for="nome"><?php echo JText::_('Nome/Usu&aacute;rio'); ?> * (Obrigat&oacute;rio, minimo 3 caracteres)</label>
		<input class="form-control" data-validation="required" style="width: 90%;" type="text" name="nome" value="<?php echo(JRequest::getVar('nome')); ?>"  id="nome" maxlength="250" title="<?php echo JText::_('Digite um nome para busca a apos clique em buscar'); ?>" placeholder="<?php echo JText::_('Digite um nome para busca a apos clique em buscar Minimo 3 caracteres.'); ?>"/>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-6">
		<label class="control-label"  for="estado_endereco"><?php echo JText::_('Estado'); ?> *</label>
		<select name="estado" id="estado" data-validation="required" class="form-control estado" data-carregar="id_cidade" style="width: 90%;" placeholder="<?php echo JText::_('Selecione um estado'); ?>">
			<option></option>
			<?php
			$estado = JRequest::getVar('estado');
			foreach ($ufs as $f){ 
			?>
			<option value="<?php echo($f->uf) ?>"<?php echo($estado==$f->uf?' selected':'');?>><?php echo($f->nome) ?></option>
			<?php 
			}
			?>
		</select>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6">
		<label class="control-label"  for="id_cidade"> <?php echo JText::_('Cidade'); ?> *</label>
		<select name="id_cidade" id="id_cidade"  class="form-control" style="width: 90%;"  data-value="<?php echo(JRequest::getVar('id_cidade'));?>">
			<option></option>
		</select>
	</div>
	<input type="hidden" name="campo" id="campo" value="<?php echo(JRequest::getVar('campo')); ?>" />
</form>

<?php if(isset($perfils)) : ?>
		<div class="table-responsive">
			<table class="table table-hover" >
				<thead>
					<tr>
						<th></th>
						<th>Nome/Apelido</th>
						<th>Cidade</th>
					</tr>
				</thead>
				<tbody>
<?php 	foreach ($perfils as $perfil):


$urlImg = JRoute::_('index.php?option=com_angelgirls&view='.strtolower($perfil->tipo).'&task=loadImage&id='.$perfil->id.':ico');


?>
					<tr>
						<td style="vertical-align: middle; margin: 0px; padding: 0px;"><a href="JavaScript: SelecionarPerfil('<?php echo($perfil->apelido);?>', <?php echo($perfil->id_usuario);?>);"><img src="<?php echo($urlImg);?>" title="<?php echo($perfil->apelido);?>" alt="<?php echo($perfil->apelido);?>" style="width: 40px; margin: 0px; padding: 0px"/></a></td>
						<td style="vertical-align: middle;"><a href="JavaScript: SelecionarPerfil('<?php echo($perfil->apelido);?>', <?php echo($perfil->id_usuario);?>);"><?php echo(str_ireplace($nome, '<b>' .strtoupper($nome).'</b>', $perfil->apelido));?></a></td>
						<td style="vertical-align: middle;"><a href="JavaScript: SelecionarPerfil('<?php echo($perfil->apelido);?>', <?php echo($perfil->id_usuario);?>);"><?php echo($perfil->estado_mora . ' / ' . $perfil->cidade_mora);?></a></td>
					</tr>
<?php 	endforeach;?>
				</tbody>
			</table>
		</div>
<?php else:?>
	N&atilde;o foram entrados registros.
<?php endif;?>


<?php require_once 'ligthbox/floor.php' ;?>
<script>
jQuery(document).ready(function(){
	setTimeout(function(){
		jQuery('#estado').change();
	}, 1000);
});

function SelecionarPerfil(nome, id){
	var valor = 'parent.'+jQuery('#campo').val()+'("'+nome+'",'+id+');';
	console.log(valor);
	eval(valor);
}
</script>