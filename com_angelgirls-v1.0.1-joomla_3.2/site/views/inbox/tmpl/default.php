<?php

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );



if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=carregarSessoes&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
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
$editor = JFactory::getEditor();
$params = array('images'=> '0','smilies'=> '0', 'html' => '1', 'style'  => '0', 'layer'  => '1', 'table'  => '1', 'clear_entities'=>'0');


$para = JRequest::getVar('para');
?>

<div class="row fade in" id="envioMensage">
	<form 	
	action="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=sendMessage')); ?>"
	method="post" name="dadosForm" id="dadosForm" class="form-validate"
	role="form" data-toggle="validator" enctype="multipart/form-data">
		<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
		
			<div class="input-group">
      			<div class="input-group-addon"><label class="control-label" for="para"><?php echo JText::_('Para'); ?></label></div>
				<input class="form-control" data-validation="required" required
					style="width: 90%;" type="text" name="para" id="para"
					maxlength="250" value="<?php echo $para;?>"
					title="<?php echo JText::_('Para quem deseja mandar a mensagem?'); ?>"
					placeholder="<?php echo JText::_('Para quem deseja mandar a mensagem? Escreva o nome e exibir&aacute; uma lista baseada bo seus amigos.'); ?>" />
			</div>

		</div>
	
		<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<label class="control-label" for="titulo"><?php echo JText::_('Titulo'); ?> *</label>
			<input class="form-control" data-validation="required" required
				style="width: 90%;" type="text" name=""titulo"" id=""titulo""
				maxlength="250" value="<?php echo $titulo;?>"
				title="<?php echo JText::_('Para quem deseja mandar a mensagem?'); ?>"
				placeholder="<?php echo JText::_('Para quem deseja mandar a mensagem? Escreva o nome e exibir&aacute; uma lista baseada bo seus amigos.'); ?>" />
		</div>
						

	
		<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<label for="mensagem" class="control-label">Mensagem</label>
			<?php echo $editor->display('mensagem', '', '50', '50', '10', '5', false, $params); ?>
		</div>
		
		
	</form>
</div>

<div class="row fade in" id="LituraEmail">

</div>

<div class="table-responsive">
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
<?php switch ($conteudo->status_dado) :?>
<?php case StatusDado::REMOVIDO : ?>
		
<?php
		break; 
	default:  ?>
				<a href="<?php echo($url);?>" title="Ver"><span class="glyphicon glyphicon-remove" style="color: red;"></span></a>&nbsp;
<?php endswitch;?>
<?php switch ($conteudo->status_mensagem) :?>
<?php case StatusMensagem::NOVO : ?>
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