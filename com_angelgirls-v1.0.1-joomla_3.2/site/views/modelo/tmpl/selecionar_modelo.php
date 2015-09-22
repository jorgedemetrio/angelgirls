<?php require_once 'ligthbox/header.php' ;?>
<form  action="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=perfil&task=salvarTema')); ?>" method="post" name="dadosFormTema" id="dadosFormTema" class="form-validate" role="form" data-toggle="validator" enctype="multipart/form-data" >
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group" role="group" aria-label="Busca">
			<button  class="btn btn-success" type="submit"><?php echo JText::_('Buscar'); ?>
				<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
			</button>
		</div>
	</div>
<h3>Localizar modelos</h3>

	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label class="control-label"  for="nome"><?php echo JText::_('Nome'); ?> *</label>
		<input class="form-control" data-validation="required alphanumeric" style="width: 90%;" type="text" name="nome" value="<?php echo(JRequest::getVar('nome')); ?>"  id="nome" maxlength="250" title="<?php echo JText::_('Nome do tema'); ?>" placeholder="<?php echo JText::_('Nome do tema'); ?>"/>
	</div>

</form>
<?php require_once 'ligthbox/floor.php' ;?>
