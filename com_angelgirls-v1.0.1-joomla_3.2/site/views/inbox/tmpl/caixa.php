<?php 
defined ( '_JEXEC' ) or die ( 'Restricted access' );



if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=inboxMensagens&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}

$mensagens = JRequest::getVar('mensagens');
$perfil = JRequest::getVar('perfil');
$caixa = JRequest::getString('caixa','INBOX');
$user = JFactory::getUser();
?>
<div class="table-responsive face active in tab-pane" id="entrada">
			<table class="table table-hover display" id='tabelaInbox' cellspacing="0" width="100%" >
				<thead>
					<tr>
						<th style="width: 65px;" data-sort="no">&nbsp;</th>
						<th>Titulo</th>
						<th style="width: 250px;">Remetente</th>
						<th style="width: 102px;" data-class-name="priority">Data</th>
					</tr>
				</thead>
				<tbody>
<?php 	foreach($mensagens as $conteudo): 
$lido =null;
if(($conteudo->lido_remetente ==0 &&  $conteudo->id_usuario_remetente == $user->id) ||
		($conteudo->lido_destinatario ==0 &&  $conteudo->id_usuario_destino == $user->id)) :
	$lido = false;
else :
	$lido = true;
endif;

?>
					<tr class="editavel leituraLinnha"  data-id="<?php echo($conteudo->token); ?>"  <?php if(!$lido){ echo('style="font-weight:bold;"');}?>>
						<td class="editavel" style="vertical-align: middle; text-align: center; width: 65px;" data-sort="no">
<?php switch ($caixa) :	
		 case 'TRASH' : ?>
		
<?php
		break; 
	default:  ?>
				<a href="JavaScript: INBOX.moverLixeira('<?php echo($conteudo->token); ?>');" title="Mover para lixeira"><span class="glyphicon glyphicon-remove" style="color: red;"></span></a>&nbsp;
<?php 
	endswitch;
	if(!$lido) : ?>	
			<a href="JavaScript: INBOX.ReadMessage('<?php echo($conteudo->token); ?>');"></a><span class="glyphicon glyphicon-eye-close" title="N&atilde;o lido"></span>&nbsp;</a>
<?php
	else: ?>
		<span class="glyphicon glyphicon-eye-open" title="Lido"></span>&nbsp;
<?php endif;
if($conteudo->respondido=='SIM'): ?>
			<span class="glyphicon glyphicon-share-alt" title="Respondido" style="color: blue;"></span>&nbsp;
<?php 
endif;
?></td>
				<td onclick="JavaScript: INBOX.ReadMessage('<?php echo($conteudo->token); ?>');" class="editavel" style="vertical-align: middle;"><?php echo($conteudo->titulo); ?></td>
				<td onclick="JavaScript: INBOX.ReadMessage('<?php echo($conteudo->token); ?>');" class="editavel" style="vertical-align: middle;width: 250px; overflow: hidden; text-overflow: ellipsis;"><?php echo($conteudo->nome_remetente); ?></td>
				<td onclick="JavaScript: INBOX.ReadMessage('<?php echo($conteudo->token); ?>');" class="editavel" style="vertical-align: middle;width: 102px;" data-order="<?php echo(JDate::getInstance($conteudo->data_criado)->format('YmdHis')); ?>"><?php echo(isset($conteudo->data_criado) && strlen(trim($conteudo->data_criado))>5 ?JDate::getInstance($conteudo->data_criado)->format('d/m/Y H:i'):'N/D'); ?></td>
			</tr>
<?php
	endforeach;?>
				</tbody>
			</table>
		</div>	