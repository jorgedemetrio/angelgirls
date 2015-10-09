<?php 

defined ( '_JEXEC' ) or die ( 'Restricted access' );



if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=inboxMensagens&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}

$editor = JFactory::getEditor();
$params = array('images'=> '0','smilies'=> '0', 'html' => '1', 'style'  => '0', 'layer'  => '1', 'table'  => '1', 'clear_entities'=>'0');




$token = JRequest::getVar('para');
$tipo = JRequest::getVar('tipo');
$mensagem = JRequest::getVar('mensagem');
$titulo = JRequest::getVar('titulo');

$mensagens = JRequest::getVar('mensagens');


	



?>
<form 	
	action="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=sendMessageModal')); ?>"
	method="post" name="dadosFormMensage" id="dadosFormMensage" class="form-validate"
	role="form" data-toggle="validator" enctype="multipart/form-data">
	<?php echo JHtml::_('form.token'); ?>
	<input type="hidden" value="<?php echo($token); ?>" name="token" id="token"/>
	<input type="hidden" value="<?php echo($tipo); ?>" name="tipo" id="tipo"/>

	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label class="control-label" for="titulo"><?php echo JText::_('Titulo'); ?> *</label>
		<input class="form-control" data-validation="required" required
			style="width: 100%;" type="text" name="titulo" id="titulo"
			maxlength="250" value="<?php echo $titulo;?>"
			title="<?php echo JText::_('Qual o titulo da mensagem? Minimo de 5 caracteres.'); ?>"
			placeholder="<?php echo JText::_('Qual o titulo da mensagem? Minimo de 5 caracteres.'); ?>" />
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label for="mensagem" class="control-label">Mensagem</label>
		<textarea rows="5" data-validation="required" required style="width: 100%" name="mensagem" id="mensagem" 
		placeholder="<?php echo JText::_('Qual o texto da mensagem?'); ?>"><?php echo $mensagem;?></textarea>
	</div>
</form>