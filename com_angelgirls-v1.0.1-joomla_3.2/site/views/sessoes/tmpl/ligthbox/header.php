<html>
	<head>
		  <link href="<?php echo(JUri::root()); ?>/templates/protostar/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
		  <link rel="stylesheet" href="<?php echo(JUri::root()); ?>/components/com_angelgirls/assets/css/angelgirls.css?v=1.0" type="text/css" />
		  <link rel="stylesheet" href="<?php echo(JUri::root()); ?>/components/com_angelgirls/assets/css/bootstrap-theme.css?v=1.0" type="text/css" />
		  <link rel="stylesheet" href="<?php echo(JUri::root()); ?>/components/com_angelgirls/assets/css/bootstrap.css?v=1.0" type="text/css" />
		  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/theme-default.min.css" type="text/css" />
		  <link rel="stylesheet" href="<?php echo(JUri::root()); ?>/media/system/css/calendar-jos.css" type="text/css"  title="Verde"  media="all" />
		  <link rel="stylesheet" href="<?php echo(JUri::root()); ?>/templates/protostar/css/template.css?v=1.0" type="text/css" />
		  <script src="<?php echo(JUri::root()); ?>/media/jui/js/jquery.min.js" type="text/javascript"></script>
		  <script src="<?php echo(JUri::root()); ?>/media/jui/js/jquery-migrate.min.js" type="text/javascript"></script>
		  <script src="<?php echo(JUri::root()); ?>/media/jui/js/jquery.ui.core.min.js" type="text/javascript"></script>
		  <script src="<?php echo(JUri::root()); ?>/components/com_angelgirls/assets/js/jquery.mask.min.js?v=1.0" type="text/javascript"></script>
		  <script src="<?php echo(JUri::root()); ?>/components/com_angelgirls/assets/js/angelgirls.js?v=1.0" type="text/javascript"></script>
		  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js" type="text/javascript"></script>
		  <script src="<?php echo(JUri::root()); ?>/components/com_angelgirls/assets/js/editar_sessao.js?v=1.0" type="text/javascript"></script>
		  <script src="<?php echo(JUri::root()); ?>/media/jui/js/bootstrap.min.js" type="text/javascript"></script>
		  <script src="<?php echo(JUri::root()); ?>/media/system/js/calendar.js" type="text/javascript"></script>
		  <script src="<?php echo(JUri::root()); ?>/media/system/js/calendar-setup.js" type="text/javascript"></script>
		  <script src="<?php echo(JUri::root()); ?>/templates/protostar/js/template.js?v=1.0" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.hasTooltip').tooltip({"html": true,"container": "body"});
});
Calendar._DN = ["Domingo","Segunda","Ter\u00e7a","Quarta","Quinta","Sexta","S\u00e1bado","Domingo"]; Calendar._SDN = ["Dom","Seg","Ter","Qua","Qui","Sex","S\u00e1b","Dom"]; Calendar._FD = 0; Calendar._MN = ["Janeiro","Fevereiro","Mar\u00e7o","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"]; Calendar._SMN = ["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"]; Calendar._TT = {"INFO":"Sobre o calend\u00e1rio","ABOUT":"DHTML Date\/Time Selector\n(c) dynarch.com 2002-2005 \/ Author: Mihai Bazon\nFor latest version visit: http:\/\/www.dynarch.com\/projects\/calendar\/\nDistributed under GNU LGPL.  See http:\/\/gnu.org\/licenses\/lgpl.html for details.\n\nData da sele\u00e7\u00e3o:\n- Use os bot\u00f5es seta \u00ab e \u00bb para selecionar um ano\n- Use os bot\u00f5es < e > para selecionar o m\u00eas\n- Segure o bot\u00e3o do mouse sobre qualquer um dos bot\u00f5es acima para sele\u00e7\u00e3o mais r\u00e1pida.","ABOUT_TIME":"\n\nTime selection:\n- Click on any of the time parts to increase it\n- or Shift-click to decrease it\n- or click and drag for faster selection.","PREV_YEAR":"Selecione para ir para o ano anterior. Selecione e segure para ver uma lista de anos.","PREV_MONTH":"Selecione para ir para o m\u00eas anterior. Selecione e segure para obter uma lista dos meses.","GO_TODAY":"Ir para hoje","NEXT_MONTH":"Selecione para ir para o pr\u00f3ximo m\u00eas. Selecione e segure para ver uma lista dos meses.","SEL_DATE":"Selecionar data.","DRAG_TO_MOVE":"Arraste para mover","PART_TODAY":" Hoje ","DAY_FIRST":"Exibir %s primeiro","WEEKEND":"0,6","CLOSE":"Fechar","TODAY":"Hoje","TIME_PART":"(Shift-) Selecione ou Arraste para alterar o valor.","DEF_DATE_FORMAT":"%Y-%m-%d","TT_DATE_FORMAT":"%a, %b %e","WK":"Semana","TIME":"Hora:"};
jQuery(document).ready(function($) {Calendar.setup({
			// Id of the input field
			inputField: "data_nascimento",
			// Format of the input field
			ifFormat: "%d/%m/%Y",
			// Trigger for the calendar (button ID)
			button: "data_nascimento_img",
			// Alignment (defaults to "Bl")
			align: "Tl",
			singleClick: true,
			firstDay: 0
			});});


		document.PathBaseComponent="<?php echo(JUri::root()); ?>/components/com_angelgirls/";
		document.PathBase="<?php JUri::root() ?>/";
		document.UrlLogin ="/angelgirls/index.php?option=com_users&view=login";
  </script>
		<script>
		jQuery(document).ready(function(){
			jQuery('#descricao').restrictLength($('#maxlength'));
			
			jQuery.validate({
			    modules : 'security, date, file, html5',
			    language : ptBRValidation,
			    decimalSeparator : ','
			}); 
		}); 		
		</script>
		<link href='//fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	</head>
	<body>
		<div class="container-fluid">
<?php 
		$mensagens = JRequest::setVar('mensagem'); 
		if(isset($mensagens)) :?>
<div class="alert alert-warning alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
<?php if(is_array($mensagens)) : ?>
		<ul>
<?php 		foreach ($mensagens as $mensagen):?>
			<li><?php echo($mensagen.'<br/>');?></li>

<?php 		endforeach;?>
		</ul>
<?php else:
		echo($mensagens);
endif;?>			
</div>
<?php endif;
?>