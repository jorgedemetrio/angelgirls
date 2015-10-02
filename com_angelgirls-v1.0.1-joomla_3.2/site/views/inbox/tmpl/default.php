<?php

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );



if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=inboxMensagens&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}
JFactory::getDocument()->addStyleSheet(JURI::base( true ).'/components/com_angelgirls/assets/css/jquery.dataTables.css?v='.VERSAO_ANGELGIRLS);
JFactory::getDocument()->addStyleSheet(JURI::base( true ).'/components/com_angelgirls/assets/css/token-input.css?v='.VERSAO_ANGELGIRLS);
JFactory::getDocument()->addStyleSheet(JURI::base( true ).'/components/com_angelgirls/assets/css/token-input-facebook.css?v='.VERSAO_ANGELGIRLS);


JFactory::getDocument()->addScript(JURI::base( true ).'/components/com_angelgirls/assets/js/jquery.tokeninput.js?v='.VERSAO_ANGELGIRLS);
JFactory::getDocument()->addScript(JURI::base( true ).'/components/com_angelgirls/assets/js/jquery.dataTables.js?v='.VERSAO_ANGELGIRLS);
JFactory::getDocument()->addScript(JURI::base( true ).'/components/com_angelgirls/assets/js/inbox.js?v='.VERSAO_ANGELGIRLS);
JFactory::getDocument()->addStyleSheet('//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/theme-default.min.css?v='.VERSAO_ANGELGIRLS);
JFactory::getDocument()->addScript('//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js?v='.VERSAO_ANGELGIRLS);


$mensagens = JRequest::getVar('mensagens');
$perfil = JRequest::getVar('perfil');



$para = JRequest::getVar('para');
?>
<script>
function ativarConteudo(id){
	//if()
	
}
</script>
<div class="row">
<?php AngelgirlsController::GetMenuLateral(); ?>
	<div id="conteudo" class="col col-xs-12 col-sm-9 col-md-9 col-lg-10">
	
	
		<ul class="nav nav-tabs nav-justified" id="myTabTabs" role="tablist" style="margin-bottom: 0;">
			<li class="active" role="presentation">
				<a href="#caixaEntrada" data-toggle="tab" aria-controls="profile" role="tab"><span class="glyphicon glyphicon-inbox"></span> Caixas</a>
			</li>
			<li role="presentation">
				<a href="#novaMensagem" data-toggle="tab" aria-controls="profile" role="tab"><span class="glyphicon glyphicon-envelope"></span> Nova mensagem</a>
			</li>
		</ul>
		
		
		<div class="tab-content" style="overflow: auto;">
			<div id="corpoMensagem" class="fade">
			</div>		
			<div class="row tab-pane fade in active" id="caixaEntrada">
				<div id="caixas" class="col col-xs-2 col-sm-3 col-md-3 col-lg-2 hidden-phone">
					<ul class="nav nav-pills  nav-stacked">
					  	<li role="presentation" class="active"><a href="#"><span class="glyphicon glyphicon-inbox"></span> Caixa de entrada</a></li>
					  	<li role="presentation"><a href="#"><span class="glyphicon glyphicon-log-in"></span> Rascunhos</a></li>
					  	<li role="presentation"><a href="#"><span class="glyphicon glyphicon-share"></span> Enviados</a></li>
					  	<li role="presentation"><a href="#"><span class="glyphicon glyphicon-trash"></span><span class="hidden-phone"> Lixeira</span> </a></li>
					</ul>
				</div>
				<div id="caixas" class="col col-xs-12 col-sm-9 col-md-9 col-lg-10">
<?php require_once 'caixa.php'; ?>
				</div>
			</div>
			<div class="row fade tab-pane" id="novaMensagem">
<?php require_once 'nova.php'; ?>
			</div>
		</div>
	</div>
</div>