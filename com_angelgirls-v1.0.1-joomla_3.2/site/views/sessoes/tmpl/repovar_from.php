<?php require_once 'ligthbox/header.php' ;?>
<form  action="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=perfil&task=reprovarSessao')); ?>" method="post" name="reprovarForm" id="reprovarForm" class="form-validate" role="form" data-toggle="validator" enctype="multipart/form-data" >
	<input type="hidden" name="id" id="id" value="<?php echo(JRequest::getVar('id')); ?>"/> 
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label class="control-label"  for="descricao"><?php echo JText::_('Motivo de reprovar ou rejeitar a sess&atilde;o'); ?> * <small>(restam <span id="maxlength">250</span> cadacteres)</small></label>
		<textarea class="form-control" data-validation="required alphanumeric" required style="width: 90%;" type="text" name="descricao"  id="descricao" maxlength="250" title="<?php echo JText::_('Qual o motivo de rejei&ccedil;&atilde;o?'); ?>" placeholder="<?php echo JText::_('Qual o motivo de rejei&ccedil;&atilde;o?'); ?>"><?php echo(JRequest::getVar('descricao')); ?></textarea>
	</div>
</form>
<?php require_once 'ligthbox/floor.php' ;?>
