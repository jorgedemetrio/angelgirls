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

INBOX.AtivarConteudoURL = '<?php echo(JRoute::_ ( 'index.php?option=com_angelgirls&view=inbox&task=inboxMensagensHTML', false ));?>';
INBOX.MensagemURL = '<?php echo(JRoute::_ ( 'index.php?option=com_angelgirls&view=inbox&task=getMessageToReadJson', false ));?>';
INBOX.lixeiraURL = '<?php echo(JRoute::_('index.php?option=com_angelgirls&view=inbox&task=moverParaLixeiraMessage', false ));?>';
INBOX.pesquisarContatosURL = '<?php echo(JRoute::_('index.php?option=com_angelgirls&view=inbox&task=getContatosJson', false ));?>';

INBOX.Answer = function(id, remetente, mensagem){
	
}

$(document).ready(function() {
    $("#para").tokenInput(INBOX.pesquisarContatosURL,{
        hintText: "Para quem vai mandar a mensagem?",
        noResultsText: "N&aacute;o encontrado.",
        searchingText: "Buscando..."
    });
});


INBOX.moverLixeira = function(id){
	AngelGirls.Processando().show();
	jQuery('#corpoMensagem').fadeOut(500);

	var tipo = null;
	jQuery('.tiposCaixas').each(function(){
	    var $this = jQuery(this);
	    if($this.hasClass('active')){
	    	tipo=$this.attr('id').replace('-OPTION','');
	    }
	})
	
	jQuery.post(INBOX.lixeiraURL , {token:id },function(dado){
		AngelGirls.CarregarDadosInformativos();
		INBOX.AtivarConteudo(tipo);
		AngelGirls.Processando().hide();
	},'json');
}

INBOX.ReadMessage = function(id){
	//AngelGirls.Processando().show();
	jQuery('#corpoMensagem').fadeOut(500);
	var tipo = null;
	jQuery('.tiposCaixas').each(function(){
	    var $this = jQuery(this);
	    if($this.hasClass('active')){
	    	tipo=$this.attr('id').replace('-OPTION','');
	    }
	})
	jQuery.post(INBOX.MensagemURL, {caixa: tipo, token:id },function(dado){
		AngelGirls.CarregarDadosInformativos();
		var dataEnvaido = new Date(dado.data_criado);
		var botataoResponde = '	<div class="btn-toolbar pull-right" role="group"><div class="btn-group" role="group"><button onclick="JavsScript: INBOX.Answer(\''+dado.token+'\', )" class="btn btn-primary" type="buttom">Responder <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span></button></div></div>';
		var mensagem = "";
		mensagem +=  "<div class='bg-info' style='padding:10px; border-radius:10px;'><p class='text-left text-capitalize pull-right text-info'><strong>Enviado: </strong>"+
		dataEnvaido.getDate()+'/'+(dataEnvaido.getMonth()+1)+'/'+dataEnvaido.getFullYear()+' '+dataEnvaido.getHours()+':'+dataEnvaido.getMinutes()+'</p>';
		mensagem += "<p class='text-left text-capitalize text-info'><strong>Remetente:</strong> "+dado.nome_remetente+"</p>";
		mensagem += botataoResponde+"<p class='text-left text-capitalize text-info'><strong>Para:</strong> "+dado.nome_destinatario+"</p>";
		mensagem += "<p class='text-left text-capitalize'><strong>"+dado.titulo+"</strong></p></div><br/><br/>";
		mensagem += "<p class='text-left text-muted'>"+dado.mensagem+"</p>";
		jQuery("tr[data-id='"+id+"']").css('font-weight','normal');
		jQuery('#corpoMensagem').html(mensagem);
		jQuery('#corpoMensagem').fadeIn(1000);
		//AngelGirls.Processando().hide();		
	},'json');
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
			<div class="row tab-pane fade in active" id="caixaEntrada">
				<div id="caixasMenu" class="col col-xs-2 col-sm-3 col-md-3 col-lg-2 hidden-phone">
					<ul class="nav nav-pills  nav-stacked">
					  	<li role="presentation" class="tiposCaixas active " id="INBOX-OPTION"><a href="JavaScript: INBOX.AtivarConteudo('INBOX');" title="Caixa de entrada"><span class="glyphicon glyphicon-log-in"></span> Caixa de entrada</a></li>
					  	<li role="presentation" class="tiposCaixas" id="DRAF-OPTION"><a href="JavaScript: INBOX.AtivarConteudo('DRAF');" title="Rascunhos"><span class="glyphicon glyphicon-edit"></span> Rascunhos</a></li>
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