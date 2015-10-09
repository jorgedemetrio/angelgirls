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



$para = JRequest::getVar('para',null);

JFactory::getDocument()->addScriptDeclaration('
INBOX.AtivarConteudoURL = "' . JRoute::_ ( 'index.php?option=com_angelgirls&view=inbox&task=inboxMensagensHTML', false ) . '";
INBOX.MensagemURL = "' . JRoute::_ ( 'index.php?option=com_angelgirls&view=inbox&task=getMessageToReadJson', false ) . '";
INBOX.lixeiraURL = "' . JRoute::_('index.php?option=com_angelgirls&view=inbox&task=moverParaLixeiraMessage', false ) . '";
INBOX.pesquisarContatosURL = "' . JRoute::_('index.php?option=com_angelgirls&view=inbox&task=getContatosJson', false ) . '";
INBOX.BuscarPerfilURL  = "' . JRoute::_('index.php?option=com_angelgirls&view=perfil&task=buscarPerfilToken', false ) . '";
');
?>
<div class="row">
<?php AngelgirlsController::GetMenuLateral(); ?>
	<div id="conteudo" class="col col-xs-12 col-sm-9 col-md-9 col-lg-10">
	
	
		<ul class="nav nav-tabs nav-justified" id="myTabTabs" role="tablist" style="margin-bottom: 0;">
			<li <?php echo(isset($para)?'':'class="active" ')?>role="presentation">
				<a href="#caixaEntrada" data-toggle="tab" aria-controls="profile" role="tab"><span class="glyphicon glyphicon-inbox"></span> Caixas</a>
			</li>
			<li <?php echo(!isset($para)?'':'class="active" ')?>role="presentation">
				<a href="#novaMensagem" data-toggle="tab" aria-controls="profile" role="tab"><span class="glyphicon glyphicon-envelope"></span> Nova mensagem</a>
			</li>
		</ul>
		
		
		<div class="tab-content" style="overflow: auto;">
			<div class="row tab-pane fade in active" id="caixaEntrada">
				<div id="caixasMenu" class="col col-xs-2 col-sm-3 col-md-3 col-lg-2 hidden-phone">
					<ul class="nav nav-pills  nav-stacked">
					  	<li role="presentation" class="tiposCaixas active " id="INBOX-OPTION"><a href="JavaScript: INBOX.AtivarConteudo('INBOX');" title="Caixa de entrada"><span class="glyphicon glyphicon-log-in"></span> Caixa de entrada</a></li>
					  	<!-- li role="presentation" class="tiposCaixas" id="DRAF-OPTION"><a href="JavaScript: INBOX.AtivarConteudo('DRAF');" title="Rascunhos"><span class="glyphicon glyphicon-edit"></span> Rascunhos</a></li-->
					  	<li role="presentation" class="tiposCaixas" id="SENT-OPTION"><a href="JavaScript: INBOX.AtivarConteudo('SENT');" title="Enviados"><span class="glyphicon glyphicon-share"></span> Enviados</a></li>
					  	<li role="presentation" class="tiposCaixas" id="TRASH-OPTION"><a href="JavaScript: INBOX.AtivarConteudo('TRASH');" title="Lixeira"><span class="glyphicon glyphicon-trash"></span><span class="hidden-phone"> Lixeira</span> </a></li>
					</ul>
				</div>
				<div class="col col-xs-12 col-sm-9 col-md-9 col-lg-10">
					<div id="corpoMensagem"  style="display:none; padding: 20px; border: 1 scrollbar #000; margin: 10px; overflow: scroll; transition: height 2s; -webkit-transition: height 2s;">
					</div>
					<div id="caixas">
<?php require_once 'caixa.php'; ?>
					</div>
				</div>
			</div>
			<div class="row fade tab-pane" id="novaMensagem">
<?php require_once 'nova.php'; ?>
			</div>
		</div>
	</div>
</div>