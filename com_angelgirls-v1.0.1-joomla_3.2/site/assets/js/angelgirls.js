/**
 * Processando
 */


//BUSCA

  (function() {
    var cx = '003094212550420491412:esufx1ar20m';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
        '//cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();



function TestaCPF(strCPF) {
	var Soma; 
	var Resto; 
	Soma = 0; 
	if (strCPF == "00000000000") return false; 
	for (i=1; i<=9; i++) 
			Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i); 
	Resto = (Soma * 10) % 11; 
	if ((Resto == 10) || (Resto == 11)) 
		Resto = 0; 
	if (Resto != parseInt(strCPF.substring(9, 10)) ) 
		return false; 
	Soma = 0; 
	for (i = 1; i <= 10; i++) 
		Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i); 
	Resto = (Soma * 10) % 11; 
	if ((Resto == 10) || (Resto == 11)) 
		Resto = 0; 
	if (Resto != parseInt(strCPF.substring(10, 11) ) ) 
		return false;
	return true; 
}
var AngelGirls = new Object();

alert = function(msg){
	jQuery('#modalWindowtitle').html(window.document.title);
	jQuery('#modalWindowbody').html(msg);
	jQuery('#modalWindowok').css('display','none');
	jQuery('#modalWindow').modal('show');
	jQuery('#modalWindowbody').removeClass('alert');
	jQuery('#modalWindowbody').removeClass('alert-warning');
	jQuery('#modalWindowbody').removeClass('alert-danger');
	jQuery('#modalWindowbody').addClass('alert alert-danger');
} 

info = function(msg){
	jQuery('#modalWindowtitle').html(window.document.title);
	jQuery('#modalWindowbody').html(msg);
	jQuery('#modalWindowok').css('display','none');
	jQuery('#modalWindow').modal('show');
	jQuery('#modalWindowbody').removeClass('alert');
	jQuery('#modalWindowbody').removeClass('alert-warning');
	jQuery('#modalWindowbody').removeClass('alert-danger');
	jQuery('#modalWindowbody').addClass('alert alert-warning');
} 



AngelGirls.AbrirModalAlerta = function(titulo, texto, legandaBotaoOk, destino){
	jQuery('#modalWindowtitle').html(titulo);
	jQuery('#modalWindowbody').html(texto);
	jQuery('#modalWindowok').attr('href',destino);
	jQuery('#modalWindowok').html(legandaBotaoOk);
	jQuery('#modalWindowok').css('display','');
	jQuery('#modalWindow').modal('show');
	jQuery('#modalWindowbody').removeClass('alert');
	jQuery('#modalWindowbody').removeClass('alert-warning');
	jQuery('#modalWindowbody').removeClass('alert-danger');
	jQuery('#modalWindowbody').addClass('alert alert-warning');
}

AngelGirls.FrameModal = function(titulo, url, legandaBotaoOk, destino, tamanho){
	jQuery('#modalWindowtitle').html(titulo);
	jQuery('#modalWindowbody').html('<iframe src="'+url+'" style="width:100%; max-height:350px;height: '+(tamanho>350?'100%':tamanho+'px')+'" id="iFrameModal"></iframe>');
	jQuery('#modalWindowok').attr('href',destino);
	jQuery('#modalWindowok').html(legandaBotaoOk);
	jQuery('#modalWindowok').css('display','');
	jQuery('#modalWindow').modal('show');
	jQuery('#modalWindowbody').removeClass('alert-warning');
	jQuery('#modalWindowbody').removeClass('alert-danger');
	jQuery('#modalWindowbody').removeClass('alert');
}

AngelGirls.PostItEffects = function(){
	$(".content-post").css('background','#FFFFBC');
	$(".content-post").css('background','#FFFFBC');	
	$(".content-post").css('-webkit-box-shadow','0 15px 10px rgba(0, 0, 0, 0.7)');
	$(".content-post").css('-moz-box-shadow','0 15px 10px rgba(0, 0, 0, 0.7)');
	$(".content-post").css('box-shadow','0 15px 10px rgba(0, 0, 0, 0.7)');
	$(".content-post").css('-webkit-box-shadow','0 1px 4px rgba(0, 0, 0, 0.3), 0 0 60px rgba(0, 0, 0, 0.1) inset');
	$(".content-post").css('-moz-box-shadow','0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset');
	$(".content-post").css('box-shadow','0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset');
	setTimeout(function() {
		$(".content-post").each(function(){
			$this = $(this);
			if($this.attr('data-ajustado')!='FEITO'){
				var P =  Math.floor((Math.random() * 7) *(Math.random()*5>2?-1:1) +1);
				$this.css('transition','2s');
				$this.css('-webkit-box-shadow','0 1px 4px rgba(0, 0, 0, 0.3), 0 0 60px rgba(0, 0, 0, 0.1) inset');
				$this.css('-moz-box-shadow','0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset');
				$this.css('box-shadow','0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset');
				$this.css('background','#FFFFBC');
				$this.css('-ms-transform','rotate('+P+'deg)');
			    $this.css('-webkit-transform','rotate('+P+'deg)');
			    $this.css('transform','rotate('+P+'deg)');
			    $this.attr('data-ajustado','FEITO');
			}
		});
	}, 2000);
}

AngelGirls.FrameModalHide = function(){
	jQuery('#modalWindow').modal('hide');
}


AngelGirls.Processando = function () {
    return {
        show: function() {
        	jQuery('#pleaseWaitDialog').modal('show');
        	jQuery('#pleaseWaitDialog').css('display','');
        },
        hide: function () {
        	jQuery('#pleaseWaitDialog').modal('hide');
        	jQuery('#pleaseWaitDialog').css('display','none');
        },
    };
};

document.AngelGirls = AngelGirls;


AngelGirls.ResetGostar = function(){
	jQuery('.gostar').each(function(){
		$objetoRef = jQuery(this);
		if(!$objetoRef.attr('data-checado') && $objetoRef.attr('data-checado')!='SIM'){
			if($objetoRef.attr('data-gostei')=='SIM'){
				$objetoRef.html('<span class="badge" title="Gostou">'+$objetoRef.attr('data-gostaram')+' <span class="glyphicon glyphicon-heart" aria-hidden="true" title="Gostou" style="color:red;"></span></span>');
			}
			else{
				$objetoRef.html('<span class="badge" title="Gostou">'+$objetoRef.attr('data-gostaram')+' <span class="glyphicon glyphicon-heart-empty" aria-hidden="true" title="Gostar"></span></span>');
			}
			$objetoRef.attr('data-checado','SIM');
			$objetoRef.click(function(){
				$objeto = jQuery(this);
				jQuery.post(document.PathBase+"index.php?option=com_angelgirls&view="+$objeto.attr('data-area')+"&task=gostarJson&id="+$objeto.attr('data-id')+":voto", {},function(dado){
					if(dado.status=="ok"){
						if($objeto.attr('data-gostei')=='SIM'){
							$objeto.attr('data-gostaram',parseInt($objeto.attr('data-gostaram'))-1);
							$objeto.html('<span class="badge" title="Gostou">'+$objeto.attr('data-gostaram')+' <span class="glyphicon glyphicon-heart-empty" aria-hidden="true" title="Gostar"></span></span>');
							$objeto.attr('data-gostei','NAO');
	
						}
						else{
							$objeto.attr('data-gostei','SIM');
							$objeto.attr('data-gostaram',parseInt($objeto.attr('data-gostaram'))+1);
							$objeto.html('<span class="badge" title="Gostou">'+$objeto.attr('data-gostaram')+' <span class="glyphicon glyphicon-heart" aria-hidden="true" title="Gostou"></span></span>');
						}					
					}
					else if(dado.codigo=="401"){
						AngelGirls.AbrirModalAlerta('Não está logando', '<p>Voc&ecirc; n&otilde;o est&aacute; logado.<br/>Para executar essa a&ccedil;&atilde;o deve estar logado.<br/>Deseja Realizar login?<br/><br/></p>', 'Entrar/Login', document.UrlLogin);
					}
					else{
						alert(dado.mesage);
					}
				},"json");
			});
		}
	});	
};

AngelGirls.ResetConfig = function(){
	AngelGirls.ResetGostar();
	jQuery('.checkbox-iten').each(function(){
		$objetoRef = jQuery(this);
		$hiddenRef = jQuery('#'+$objetoRef.attr('data-hidden-id'))
		if($hiddenRef.val()==$objetoRef.attr('data-hidden-value')){
			$objetoRef.html($objetoRef.attr('data-hidden-label')+' <span class="glyphicon glyphicon-check"></span>');
		}
		else{
			$objetoRef.html($objetoRef.attr('data-hidden-label')+' <span class="glyphicon glyphicon-unchecked"></span>');
		}
		$objetoRef.click(function(){
			$objeto = jQuery(this);
			$hidden = jQuery('#'+$objeto.attr('data-hidden-id'));
			if($hidden.val()==$objeto.attr('data-hidden-value')){
				$hidden.val('');
				$objeto.html($objeto.attr('data-hidden-label')+' <span class="glyphicon glyphicon-unchecked"></span>');
				
			}
			else{
				$objeto.html($objeto.attr('data-hidden-label')+' <span class="glyphicon glyphicon-check"></span>');
				$hidden.val($objeto.attr('data-hidden-value'));					
			}
			if($objeto.attr('onchange') && $objeto.attr('onchange')!=""){
				eval($objeto.attr('onchange'));
			}
		});
	});
}; 


AngelGirls.ProcessandoMensagens = false;
AngelGirls.ProcessandoMensagensInterval = null;

AngelGirls.QuantidadeMensagens = null;
AngelGirls.QuantidadeSets =null;

AngelGirls.Notificar = function (titulo, mensagem, url){
	Notification.requestPermission(function(dado){
		if(dado=='granted'){
			var notification = new Notification("Angel Girls: "+titulo, {
			    icon: 'http://www.angelgirls.com.br/components/com_angelgirls/angelgirls.png',
			    body: mensagem
			});
	        notification.onclick = function() {
	            window.location=url;
	            window.focus();
	        }
		}
	});
}

AngelGirls.CarregarDadosInformativos = function(){
	if(!AngelGirls.ProcessandoMensagens){
		AngelGirls.ProcessandoMensagens=true;
		jQuery.post(document.PathBase+'index.php?option=com_angelgirls&view=sessoes&task=checarDados',{}, function(dado){
			if(dado.logado=='SIM'){
				if(jQuery('#MenuAprovacaoTopo').length<=0){
					var menuLat =  '<li class="sessoesAprovar" style="float: right;" id="MenuAprovacaoTopo"></li>';
					jQuery('.menu').append(menuLat);
				}
				if(jQuery('#MenuCaixaMensagensTopo').length<=0){
					var menuLat =  '<li class="caixaMensagens" style="float: right;" id="MenuCaixaMensagensTopo"></li>';
					jQuery('.menu').append(menuLat);
				}


				var inboxURL =document.PathBase+"index.php?option=com_angelgirls&view=inbox&task=inboxMensagens";
				var sessoesURL = document.PathBase+"index.php?option=com_angelgirls&task=carregarMinhasSessoes";
				if(dado.mensagens>0)
					jQuery('.caixaMensagens').html('<a href="'+inboxURL+'"><span class="badge" title="Mensagens"><span class="glyphicon glyphicon-inbox" aria-hidden="true" title="Mensagens"></span></span><span class="valorInformacao">'+(dado.mensagens>99?'+99':dado.mensagens)+'</span></a>');	
				else
					jQuery('.caixaMensagens').html('<a href="'+inboxURL+'"><span class="badge" title="Mensagens" style="color: #CACACA;"><span class="glyphicon glyphicon-inbox" aria-hidden="true" title="Mensagens"></span></span></a>');
				
				if(dado.aprovar>0)
					jQuery('.sessoesAprovar').html('<a href="'+sessoesURL+'"><span class="badge" title="Sess&otilde;es"><span class="glyphicon glyphicon-camera" aria-hidden="true" title="Mensagens"></span></span><span class="valorInformacao">'+(dado.aprovar>99?'+99':dado.aprovar)+'</span></a>');	
				else
					jQuery('.sessoesAprovar').html('<a href="'+sessoesURL+'"><span class="badge" title="Sess&otilde;es" style="color: #CACACA;"><span class="glyphicon glyphicon-camera" aria-hidden="true" title="Mensagens"></span></span></a>');
				
				if(AngelGirls.QuantidadeMensagens != null && AngelGirls.QuantidadeMensagens<dado.mensagens && dado.mensagens > 0){
					AngelGirls.Notificar('Novas mensagens','Você tem ' + dado.mensagens + ' mensagens não lidas.', inboxURL);
					if(jQuery('#INBOX-OPTION').length>=1){
						INBOX.AtivarConteudo('INBOX');
					}
				}	
				AngelGirls.QuantidadeMensagens = dado.mensagens;

				if(AngelGirls.QuantidadeSets != null && AngelGirls.QuantidadeSets<dado.aprovar && dado.aprovar>0){
					AngelGirls.Notificar('Novas sessões','Você tem ' + dado.aprovar + ' sessões aguardando aprovação.', sessoesURL);
				}	
				AngelGirls.QuantidadeSets = dado.aprovar;				
				AngelGirls.ProcessandoMensagens = false;
			}
			else{
				clearInterval(AngelGirls.ProcessandoMensagensInterval);				
			}
		},'json');
		
	}
}


jQuery(document).ready(function(){

	AngelGirls.ProcessandoMensagensInterval = setInterval(function(){
		AngelGirls.CarregarDadosInformativos();
	}, 30000);
	

	AngelGirls.CarregarDadosInformativos();
	
	jQuery(".validate-numeric").mask("#.##0,00", {reverse: true});
	jQuery(".validate-inteiro").mask("9999999999999");
	jQuery(".validate-cep").mask("99999-999");
	jQuery(".validate-cpf").mask("999.999.999-99");

	jQuery(".validate-data").mask("99/99/9999", {placeholder: "__/__/____"});
	jQuery("input[data-validation='date']").mask("99/99/9999", {placeholder: "__/__/____"});
	jQuery(".validate-telefone").mask("(99) 99999-9999");
	jQuery(".validate-telefone-simples").mask("99999-9999");

		

		
	jQuery(".estado").change(function(){
		$objeto = jQuery(this);
		$ObjetoCidade = jQuery("#"+$objeto.attr("data-carregar"));
		$ObjetoCidade.empty();
		$ObjetoCidade.append(new Option("", ""));
		jQuery.post('index.php?option=com_angelgirls&view=perfil&task=cidadeJson',{
			uf: $objeto.val()}, function(dado){
			for(var i=0; i<dado.length;i++){
				var option = new Option(dado[i].nome, dado[i].id);
				$ObjetoCidade.append(option);
				if($ObjetoCidade.attr('data-value')==dado[i].id){
					option.selected = 'selected';
				}
			}
		},'json');
	});	
	
	AngelGirls.ResetConfig();
});


AngelGirls.URLNoCache= function (url){
	return url+(url.indexOf('?')>0?'&':'?')+'date='+(new Date()).getTime();
}


var ptBRValidation = {
        errorTitle: 'Falha ao enviar formulário!',
        requiredFields: 'Você deve preencher todos os campos obrigatórios.',
        badTime: 'Você deve colocar a hora correta.',
        badEmail: 'Você não forneceu um e-mail válido',
        badTelephone: 'Você não forneceu numero correto de telefone.',
        badSecurityAnswer: 'Você não forneceu uma resposta correta de segurança.',
        badDate: 'Você não forneceu uma data correta.',
        lengthBadStart: 'O dado de entrada deve estar entre ',
        lengthBadEnd: ' caracteres',
        lengthTooLongStart: 'Essa valor é maior que ',
        lengthTooShortStart: 'Essa valor é menor que ',
        notConfirmed: 'A informação não pode ser confirmada.',
        badDomain: 'Valor de dominio incorreto.',
        badUrl: 'O valor não é um URL válida.',
        badCustomVal: 'O valor não está correto.',
        andSpaces: ' e espaços ',
        badInt: 'O valor não é um número válido.',
        badSecurityNumber: 'Your social security number was incorrect',
        badUKVatAnswer: 'Incorrect UK VAT Number',
        badStrength: 'A senha não é fornte o suficiente.',
        badNumberOfSelectedOptionsStart: 'You have to choose at least ',
        badNumberOfSelectedOptionsEnd: ' respostas ',
        badAlphaNumeric: 'O campo só pode ter valores alfanumericos. ',
        badAlphaNumericExtra: ' e ',
        wrongFileSize: 'O arquivo que está tentando enviar é muito grande. (Máximo %s)',
        wrongFileType: 'Somente arquivos do tipo %s são permitidos',
        groupCheckedRangeStart: 'Por favor selecione entre ',
        groupCheckedTooFewStart: 'Please choose at least ',
        groupCheckedTooManyStart: 'Porfavor selecione o máximo de ',
        groupCheckedEnd: ' item(ns)',
        badCreditCard: 'The credit card number is not correct',
        badCVV: 'The CVV number was not correct',
        wrongFileDim : 'tamanho da imagem inválido,',
        imageTooTall : 'a imagem não pode ser maior que',
        imageTooWide : 'a imagem não pode ser menor que',
        imageTooSmall : 'a imagem é muito pequena',
        min : 'minimo',
        max : 'máximo',
        imageRatioNotAccepted : 'Imagem não aceita'
};