<?php 
defined ( '_JEXEC' ) or die ( 'Restricted access' );



if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=inboxMensagens&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}

$mensagens = JRequest::getVar('mensagens');
$perfil = JRequest::getVar('perfil');


?>
<div class="table-responsive face active in tab-pane" id="entrada">
			<table class="table table-hover display" id='tabelaInbox' cellspacing="0" width="100%">
				<thead>
					<tr>
						<th style="width: 65px;">&nbsp;</th>
						<th>Titulo</th>
						<th style="width: 250px;">Remetente</th>
						<th style="width: 102px;">Data</th>
					</tr>
				</thead>
				<tbody>
<?php 	foreach($mensagens as $conteudo): ?>
					<tr class="editavel leituraLinnha" data-id="<?php echo($conteudo->id); ?>" <?php if($conteudo->status_mensagem=='NOVO'){ echo('style="font-weight:bold;"');}?>>
		<td class="editavel" style="vertical-align: middle; text-align: center; width: 65px;">
<?php switch ($conteudo->status_dado) :	
		 case StatusDado::REMOVIDO : ?>
		
<?php
		break; 
	default:  ?>
				<a href="<?php echo($url);?>" title="Ver"><span class="glyphicon glyphicon-remove" style="color: red;"></span></a>&nbsp;
<?php endswitch;
		switch ($conteudo->status_mensagem) :	
			case StatusMensagem::NOVO : ?>
				<span class="glyphicon glyphicon-eye-close" title="N&atilde;o lido"></span>&nbsp;
<?php
		break; 
	default:  ?>
		<span class="glyphicon glyphicon-eye-open" title="Lido"></span>&nbsp;
<?php endswitch;
		if($conteudo->respondido=='SIM'){ ?>
			<span class="glyphicon glyphicon-share-alt" title="Respondido" style="color: blue;"></span>&nbsp;
		<?php 
		}
		?>
		</td>
				<td class="editavel" style="vertical-align: middle;"><?php echo($conteudo->titulo); ?></td>
				<td class="editavel" style="vertical-align: middle;width: 250px; overflow: hidden; text-overflow: ellipsis;"><?php echo($conteudo->nome_remetente); ?></td>
				<td class="editavel" style="vertical-align: middle;width: 102px;"><?php echo(isset($conteudo->data_criado) && strlen(trim($conteudo->data_criado))>5 ?JDate::getInstance($conteudo->data_criado)->format('d/m/Y H:i'):'N/D'); ?></td>
			</tr>
<?php
	endforeach;?>
				</tbody>
			</table>
		</div>	