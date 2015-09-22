<?php require_once 'ligthbox/header.php' ;?>
<form  action="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=perfil&task=salvarFigurino')); ?>" method="post" name="dadosFormFigurino" id="dadosFormFigurino" class="form-validate" role="form" data-toggle="validator" enctype="multipart/form-data" >
	<input type="hidden" name="campo" id="campo" value="<?php echo(JRequest::getVar('campo')); ?>"/> 
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label class="control-label"  for="nome"><?php echo JText::_('Nome'); ?> *</label>
		<input class="form-control" data-validation="required alphanumeric" style="width: 90%;" type="text" name="nome" value="<?php echo(JRequest::getVar('nome')); ?>"  id="nome" maxlength="250" title="<?php echo JText::_('Nome do figurino'); ?>" placeholder="<?php echo JText::_('Nome do figurino'); ?>"/>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label class="control-label"  for="descricao"><?php echo JText::_('Descri&ccedil;&atilde;o'); ?> * <small>(restam <span id="maxlength">250</span> cadacteres)</small></label>
		<textarea class="form-control" data-validation="required alphanumeric" style="width: 90%;" type="text" name="descricao"  id="descricao" maxlength="250" title="<?php echo JText::_('Descri&ccedil;&atilde;o do figurino'); ?>" placeholder="<?php echo JText::_('Descri&ccedil;&atilde;o do figurino'); ?>"><?php echo(JRequest::getVar('descricao')); ?></textarea>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label class="control-label"  for="imagem"><?php echo JText::_('Imagem'); ?> *</label>
		<input class="form-control" data-validation="required size mime dimension" style="width: 90%;" type="file" name="imagem"  id="imagem" maxlength="250" title="<?php echo JText::_('Imagem que representa o figurino'); ?>" placeholder="<?php echo JText::_('Imagem que representa o figurino'); ?>" accept="image/*" data-validation-dimension="min300x500"  data-validation="size" data-validation-max-size="3M" data-validation-allowing="jpg, png, gif, JPG, PNG, GIF" />
	</div>
</form>
<?php require_once 'ligthbox/floor.php' ;?>
