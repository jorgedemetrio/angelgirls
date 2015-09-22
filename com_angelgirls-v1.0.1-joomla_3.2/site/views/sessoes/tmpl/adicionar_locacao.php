<?php require_once 'ligthbox/header.php' ;?>
<?php 
$ufs = JRequest::getVar('ufs');

?>

<form  action="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=perfil&task=salvarLocacao')); ?>" method="post" name="dadosFormLocacao" id="dadosFormLocacao" class="form-validate" role="form" data-toggle="validator" enctype="multipart/form-data" >
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label class="control-label"  for="nome"><?php echo JText::_('Nome'); ?> *</label>
		<input class="form-control" data-validation="required alphanumeric" value="<?php echo(JRequest::getVar('nome')); ?>" style="width: 90%;" type="text" name="nome"  id="nome" maxlength="250" title="<?php echo JText::_('Nome da loca&ccedil;&atilde; da sess&atilde;o. Ex: Model Amor, Av Paulista'); ?>" placeholder="<?php echo JText::_('Nome da loca&ccedil;&atilde; da sess&atilde;o. Ex: Model Amor, Av Paulista'); ?>"/>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label class="control-label"  for="descricao"><?php echo JText::_('Descri&ccedil;&atilde;o'); ?> * <small>(restam <span id="maxlength">250</span> cadacteres)</small></label>
		<textarea class="form-control" data-validation="required alphanumeric" style="width: 90%;" type="text" name="descricao"  id="descricao" maxlength="250" title="<?php echo JText::_('Descri&ccedil;&atilde;o da loca&ccedil&atilde;o da sess&atilde;o'); ?>" placeholder="<?php echo JText::_('Descri&ccedil;&atilde;o da loca&ccedil&atilde;o da sess&atilde;o. Com no m&aacute;ximo 250 caracteres.'); ?>"><?php echo(JRequest::getVar('descricao')); ?></textarea>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-10">
		<label class="control-label"  for="endereco"><?php echo JText::_('Endere&ccedil;o'); ?> *</label>
		<input class="form-control" data-validation="required" style="width: 90%;" type="text" name="endereco"  id="endereco"  value="<?php echo(JRequest::getVar('endereco')); ?>"  maxlength="250" title="<?php echo JText::_('Endere&ccedil;o da loca&ccedil&atilde;o da sess&atilde;o'); ?>" placeholder="<?php echo JText::_('Endere&ccedil;o da loca&ccedil&atilde;o da sess&atilde;o'); ?>"/>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-2">
		<label class="control-label"  for="numero"><?php echo JText::_('N&uacute;mero'); ?></label>
		<input class="form-control" style="width: 90%;" type="text" name="numero"  id="numero" maxlength="10" value="<?php echo(JRequest::getVar('numero')); ?>"  title="<?php echo JText::_('N&uacute;mero da loca&ccedil&atilde;o da sess&atilde;o'); ?>"/>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label class="control-label"  for="bairro"><?php echo JText::_('Bairro'); ?> *</label>
		<input class="form-control" data-validation="required" style="width: 90%;" type="text" name="bairro"  value="<?php echo(JRequest::getVar('bairro')); ?>" id="bairro" maxlength="10" title="<?php echo JText::_('Bairro  da loca&ccedil&atilde;o da sess&atilde;o'); ?>" placeholder="<?php echo JText::_('Bairro da loca&ccedil&atilde;o da sess&atilde;o'); ?>"/>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label class="control-label"  for="complemento"><?php echo JText::_('Complemento'); ?></label>
		<input class="form-control" style="width: 90%;" type="text" name="complemento"  id="complemento" value="<?php echo(JRequest::getVar('complemento')); ?>" maxlength="10" title="<?php echo JText::_('Complemento da loca&ccedil&atilde;o da sess&atilde;o'); ?>" placeholder="<?php echo JText::_('Complemento da loca&ccedil&atilde;o da sess&atilde;o'); ?>"/>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label class="control-label"  for="cep"><?php echo JText::_('CEP'); ?> *</label>
		<input class="form-control validate-cep" data-validation="required"  style="width: 90%;" type="text" name="cep"  id="cep" value="<?php echo(JRequest::getVar('cep')); ?>" maxlength="9" title="<?php echo JText::_('CEP  da loca&ccedil&atilde;o da sess&atilde;o'); ?>" placeholder="<?php echo JText::_('CEP da loca&ccedil&atilde;o da sess&atilde;o'); ?>"/>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-6">
		<label class="control-label"  for="estado_endereco"><?php echo JText::_('Estado'); ?> *</label>
		<select name="estado" id="estado" class="form-control estado" data-carregar="id_cidade" style="width: 90%;" placeholder="<?php echo JText::_('Selecione um estado'); ?>">
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
		<select name="id_cidade" id="id_cidade" class="form-control" style="width: 90%;"  data-value="<?php echo(JRequest::getVar('id_cidade'));?>">
			<option></option>
		</select>
	</div>
	<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-3">
		<label class="control-label"  for="telefone"><?php echo JText::_('Telefone'); ?></label>
		<input class="form-control validate-telefone" style="width: 90%;" type="text" name="telefone"  value="<?php echo(JRequest::getVar('telefone')); ?>"  id="telefone" size="32" maxlength="25" value="<?php echo JRequest::getVar('telefone');?>" title="<?php echo JText::_('Teelfone de contato  da loca&ccedil&atilde;o da sess&atilde;o ex: (11) 99000-0000'); ?>" placeholder="<?php echo JText::_('(11) 99000-0000'); ?>"/>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label class="control-label"  for="site"><?php echo JText::_('Site'); ?></label>
		<div class="input-group">
      		<div class="input-group-addon">http://</div>
			<input class="form-control" style="width: 90%;" type="url" name="site"  id="site" size="32"  value="<?php echo(JRequest::getVar('site')); ?>"  maxlength="250" value="<?php echo $this->item->site;?>" placeholder="<?php echo JText::_('www.site-da-empresa.com.br'); ?>"/>
		</div>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label class="control-label"  for="endereco"><?php echo JText::_('e-mail'); ?></label>
		<input class="form-control validate-email" data-validation="required email"  style="width: 90%;"  value="<?php echo(JRequest::getVar('email')); ?>" type="email" name="email"  id="email" maxlength="250" title="<?php echo JText::_('E-mail  da loca&ccedil&atilde;o da sess&atilde;o'); ?>" placeholder="<?php echo JText::_('E-mail de contato  da loca&ccedil&atilde;o da sess&atilde;o'); ?>"/>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-4">
		<label class="control-label"  for="imagem"><?php echo JText::_('Imagem'); ?></label>
		<input class="form-control" data-validation="required size mime dimension" style="width: 90%;" type="file" name="imagem"  id="imagem" maxlength="250" title="<?php echo JText::_('Imagem que representa o a loca&ccedil&atilde;o da sess&atilde;o'); ?>" placeholder="<?php echo JText::_('Imagem  da loca&ccedil&atilde;o da sess&atilde;o'); ?>" accept="image/*" data-validation-dimension="min300x500"  data-validation="size" data-validation-max-size="3M" data-validation-allowing="jpg, png, gif, JPG, PNG, GIF" />
	</div>
</form>
<?php require_once 'ligthbox/floor.php' ;?>
<script>
jQuery(document).ready(function(){
	setTimeout(function(){
		jQuery('#estado').change();
	}, 1000);
});
</script>