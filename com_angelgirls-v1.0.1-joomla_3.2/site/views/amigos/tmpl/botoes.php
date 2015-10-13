<?php
// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );

if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&view=home&task=homepage&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}
$user = JFactory::getUser();
JFactory::getDocument()->addScript(JURI::base( true ).'/components/com_angelgirls/assets/js/amigos_action.js?v='.VERSAO_ANGELGIRLS);
$seguindo = JRequest::getVar('seguindo');
$amizade = JRequest::getVar('amizade');
$token = JRequest::getVar('token');
$tipo = JRequest::getVar('tipo');

JFactory::getDocument()->addScriptDeclaration('
Amigos.SeguirURL = "' . JRoute::_ ( 'index.php?option=com_angelgirls&view=amigos&task=seguirUsuario', false ) . '";
Amigos.ParaDeSeguirURL = "' . JRoute::_ ( 'index.php?option=com_angelgirls&view=amigos&task=seguirUsuario', false ) . '";
Amigos.AmigarURL = "' . JRoute::_ ( 'index.php?option=com_angelgirls&view=amigos&task=solicitarAmizade', false ) . '";
Amigos.DesaAmigarURL = "' . JRoute::_ ( 'index.php?option=com_angelgirls&view=amigos&task=cancelarAmizade', false ) . '";
Amigos.AceitarAmizadeURL = "' . JRoute::_ ( 'index.php?option=com_angelgirls&view=amigos&task=solicitarAmizade', false ) . '";
Amigos.RejeitarAmizadeURL = "' . JRoute::_ ( 'index.php?option=com_angelgirls&view=amigos&task=solicitarAmizade', false ) . '";
Amigos.InboxURL = "' . JRoute::_ ( 'index.php?option=com_angelgirls&view=inbox&task=openSendMessageModal', false ) . '";
		
Amigos.Seguindo = '.(isset($seguindo)?'true':'false').';
Amigos.Amigos = '.(isset($amizade) &&  isset($amizade->data_aceita) ?'true':'false').';
Amigos.AmizadeSolicitada = '.(isset($amizade) &&  isset($amizade->data_aceita) && $amizade->id_usuario_solicidante == $user->id ?'true':'false').';
Amigos.AmizadeAprovar = '.(isset($amizade) &&  isset($amizade->data_aceita) && $amizade->id_usuario_solicidante != $user->id ?'true':'false').';
Amigos.IdAmigo = "'.$token.'";
Amigos.TipoAmigo = "'.$tipo.'";
');
?>
<script>
Amigos.TextoAmigos = 'Desfazer Amizade <span class="glyphicon glyphicon-scissors"></span>';
Amigos.TextoNaoAmigos = 'Solicitar Amizade <span class="glyphicon glyphicon-gift"></span>';
Amigos.TextoAguardandoAmigos = 'Cancelar solicita&ccedil;&atilde;o amizade <span class="glyphicon glyphicon-hourglass"></span>';


Amigos.TextoSeguindo = 'Para de seguir <span class="glyphicon glyphicon-thumbs-down"></span>';
Amigos.TextoNaoSeguindo = 'Seguir <span class="glyphicon glyphicon-thumbs-up"></span>';

jQuery(document).ready(function(){
	if(Amigos.Seguindo){
		jQuery('#btnSeguir').html(Amigos.TextoSeguindo);
	}
	else{
		jQuery('#btnSeguir').html(Amigos.TextoNaoSeguindo);
	}
	
	if(Amigos.Amigos){
		jQuery('#btnAmigos').html(Amigos.TextoAmigos);
	}
	else{
		if(Amigos.AmizadeSolicitada){
			jQuery('#btnAmigos').html(Amigos.TextoAguardandoAmigos);
		}
		else{
			jQuery('#btnAmigos').html(Amigos.TextoNaoAmigos);
		}
	}
	jQuery('#btnAmigos').click(function(){
		if(Amigos.Amigos || Amigos.AmizadeSolicitada){// Desafazer amizade
			jQuery.post(Amigos.DesaAmigarURL ,
					{id: Amigos.IdAmigo, tipo: Amigos.TipoAmigo}, function(dado){
				Amigos.Amigos = !Amigos.Amigos;
				jQuery('#btnAmigos').html(Amigos.TextoNaoAmigos);
			});
		}
		else{ //Solicitar amizade
			jQuery.post(Amigos.AmigarURL,
					{token: Amigos.IdAmigo, tipo: Amigos.TipoAmigo}, function(dado){
				Amigos.Amigos = !Amigos.Amigos;
				jQuery('#btnAmigos').html(Amigos.TextoAguardandoAmigos);
			});			
		}
	});

	jQuery('#btnSeguir').click(function(){
		if(Amigos.Seguindo){
			jQuery.post(Amigos.ParaDeSeguirURL ,
					{id: Amigos.IdAmigo, tipo: Amigos.TipoAmigo}, function(dado){
				Amigos.Seguindo = true;
				jQuery('#btnSeguir').html(Amigos.TextoNaoSeguindo);
			});
		}
		else{
			jQuery.post(Amigos.SeguirURL,
					{id: Amigos.IdAmigo, tipo: Amigos.TipoAmigo}, function(dado){
				Amigos.Seguindo = false;
				jQuery('#btnSeguir').html(Amigos.TextoSeguindo);
			});
		}
	});

	jQuery('#btnEnviarMensagem').click(function(){
		var url = Amigos.InboxURL;
		url = url +  (url.indexOf('?')>0?'&token='+Amigos.IdAmigo+'&tipo='+Amigos.TipoAmigo);
		AngelGirls.FrameModal("Enviar mensagem r&aacute;pida", url, "Enviar", "JavaScript: $('#iFrameModal').contents().find('#dadosFormMensage').submit();",270);
	});
	

	jQuery('#btnAprovarAmizade').click(function(){
		jQuery('#groupBtnAProvacao').css('display','none');
		jQuery.post(Amigos.AceitarAmizadeURL,
				{id: Amigos.IdAmigo, tipo: Amigos.TipoAmigo}, function(dado){
			jQuery('#btnSeguir').html(Amigos.TextoSeguindo);
			jQuery('#btnAmigos').html(Amigos.TextoAmigos);
		});
	});

	jQuery('#btnReprovarAmizade').click(function(){
		jQuery('#groupBtnAProvacao').css('display','none');
		jQuery.post(Amigos.RejeitarAmizadeURL,
				{id: Amigos.IdAmigo, tipo: Amigos.TipoAmigo}, function(dado){
			jQuery('#btnSeguir').html(Amigos.TextoNaoSeguindo);
			jQuery('#btnAmigos').html(Amigos.TextoNaoAmigos);
		});
	});
	
});
</script>
<div class="btn-toolbar pull-right" role="toolbar">
	<div class="btn-group" role="group">
		<button class="btn" type="button" id="btnSeguir">
			
		</button>
		<button class="btn" type="button" id="btnAmigos">
			
		</button>
		<button class="btn" type="button" id="btnEnviarMensagem">
			Enviar Mensagem <span class="glyphicon glyphicon-envelope"></span>
		</button>
	</div>
<?php 
if(isset($amizade) &&  isset($amizade->data_aceita) && $amizade->id_usuario_solicidante != $user->id):
?>
	<div class="btn-group" role="group" id="groupBtnAProvacao">
		<button class="btn" type="button" id="btnAprovarAmizade">
			Aceitar Amizade <span class="glyphicon glyphicon-ok"></span>
		</button>
		<button class="btn" type="button" id="btnReprovarAmizade">
			Recusar Amizade <span class="glyphicon glyphicon-remove"></span>
		</button>
	</div>
<?php endif;?>
</div>