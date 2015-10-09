<?php 

defined ( '_JEXEC' ) or die ( 'Restricted access' );



if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=inboxMensagens&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}

$editor = JFactory::getEditor();
$params = array('images'=> '0','smilies'=> '0', 'html' => '1', 'style'  => '0', 'layer'  => '1', 'table'  => '1', 'clear_entities'=>'0');

$perfil = JRequest::getVar('perfil');
$para = JRequest::getVar('para');
if(isset($para)){
	$var =explode(':',$para);
	
JFactory::getDocument()->addScriptDeclaration('
jQuery(document).ready(function() {
	$("#para").tokenInput(INBOX.pesquisarContatosURL,{
		hintText: "Para quem vai mandar a mensagem?",
		noResultsText: "N&atilde;o encontrado.",
		searchingText: "Buscando...",
		prePopulate: [{id: '.$var[0].', name: "'.$var[1].'"}]
		});
});');
}
else{
	JFactory::getDocument()->addScriptDeclaration('
jQuery(document).ready(function() {
	$("#para").tokenInput(INBOX.pesquisarContatosURL,{
		hintText: "Para quem vai mandar a mensagem?",
		noResultsText: "N&atilde;o encontrado.",
		searchingText: "Buscando..."});
});');
	
}
?>
<form 	
	action="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=sendMessage')); ?>"
	method="post" name="dadosFormMensage" id="dadosFormMensage" class="form-validate"
	role="form" data-toggle="validator" enctype="multipart/form-data">
	<?php echo JHtml::_('form.token'); ?>
	<input type="hidden" value="E" name="ACAO" id="ACAO"/>
	

	<div class="btn-toolbar pull-right" role="group">
		<div class="btn-group" role="group">
			<button  class="btn btn-default disabled" type="button" id="btnNovo">Novo <span class="glyphicon glyphicon-plus" aria-hidden="true" ></span>
			</button>
			<!-- button  class="btn btn-default disabled" type="button" id="btnSalvar">Salvar como rascunho <span class="glyphicon glyphicon-ok" aria-hidden="true" ></span>
			</button-->
			<button  class="btn btn-primary" type="submit">Enviar <span class="glyphicon glyphicon-send" aria-hidden="true"></span>
			</button>
		</div>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="input-group">
			<div class="input-group-addon"><label class="control-label" for="para"><?php echo JText::_('Para'); ?></label></div>
			<input class="form-control"
				style="width: 100%; height: 42px;" type="text" name="para" id="para"
				maxlength="250" value=""
				title="<?php echo JText::_('Para quem deseja mandar a mensagem?'); ?>"
				placeholder="<?php echo JText::_('Para quem deseja mandar a mensagem? Escreva o nome e exibir&aacute; uma lista baseada bo seus amigos.'); ?>" />
			<div class="input-group-addon"><button  class="btn btn-default" type="button" onclick="JavaScript: INBOX.BuscarPerfil('para');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>
			</button></div>
		</div>
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label class="control-label" for="titulo"><?php echo JText::_('Titulo'); ?> *</label>
		<input class="form-control" data-validation="required" required
			style="width: 100%;" type="text" name="titulo" id="titulo"
			maxlength="250" value="<?php echo $titulo;?>"
			title="<?php echo JText::_('Para quem deseja mandar a mensagem?'); ?>"
			placeholder="<?php echo JText::_('Para quem deseja mandar a mensagem? Escreva o nome e exibir&aacute; uma lista baseada bo seus amigos.'); ?>" />
	</div>
	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label for="mensagem" class="control-label">Mensagem</label>
		<?php echo $editor->display('mensagem', '', '50', '50', '10', '5', false, $params); ?>
	</div>
	
	
</form>