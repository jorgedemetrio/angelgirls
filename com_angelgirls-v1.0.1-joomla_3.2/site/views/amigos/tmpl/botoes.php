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
Amigos.AceitarAmizadeURL = "' . JRoute::_ ( 'index.php?option=com_angelgirls&view=amigos&task=aceitarAmizade', false ) . '";
Amigos.RejeitarAmizadeURL = "' . JRoute::_ ( 'index.php?option=com_angelgirls&view=amigos&task=rejeitarSolicitacaoAmizade', false ) . '";
Amigos.InboxURL = "' . JRoute::_ ( 'index.php?option=com_angelgirls&view=inbox&task=openSendMessageModal', false ) . '";
		
Amigos.Seguindo = '.(isset($seguindo)?'true':'false').';
Amigos.Amigos = '.(isset($amizade) &&  isset($amizade->data_aceita) ?'true':'false').';
Amigos.AmizadeSolicitada = '.(isset($amizade) &&  !isset($amizade->data_aceita) && $amizade->id_usuario_solicidante == $user->id ?'true':'false').';
Amigos.AmizadeAprovar = '.(isset($amizade) &&  !isset($amizade->data_aceita) && $amizade->id_usuario_solicidante != $user->id ?'true':'false').';
Amigos.IdAmigo = "'.$token.'";
Amigos.TipoAmigo = "'.$tipo.'";
');

?>
<script>

</script>
<div class="btn-toolbar pull-right" role="toolbar">
	<div class="btn-group" role="group">
		<button class="btn" type="button" id="btnSeguir">
			
		</button>
		<button class="btn" type="button" id="btnAmigos"<?php 
if(isset($amizade) &&  !isset($amizade->data_aceita) && $amizade->id_usuario_solicidante != $user->id):
?> style="display:none"<?php endif;?>>
			
		</button>
		<button class="btn" type="button" id="btnEnviarMensagem">
			Enviar Mensagem <span class="glyphicon glyphicon-envelope"></span>
		</button>
	</div>
<?php 
if(isset($amizade) &&  !isset($amizade->data_aceita) && $amizade->id_usuario_solicidante != $user->id):
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