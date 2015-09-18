/**
 * Processando
 */

////FACEBOOK API
//(function(d, s, id) {
//	  var js, fjs = d.getElementsByTagName(s)[0];
//	  if (d.getElementById(id)) return;
//	  js = d.createElement(s); js.id = id;
//	  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.4";
//	  fjs.parentNode.insertBefore(js, fjs);
//	}(document, 'script', 'facebook-jssdk'));
//
//
//
//
////GOOGLE API
//window.___gcfg = {lang: 'pt-BR'};
//
//(function() {
//  var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
//  po.src = 'https://apis.google.com/js/platform.js';
//  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
//})();
//
//
//(function() {
//    var cx = '007002280365302771262:9-iwnl5ixt0';
//    var gcse = document.createElement('script');
//    gcse.type = 'text/javascript';
//    gcse.async = true;
//    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
//        '//cse.google.com/cse.js?cx=' + cx;
//    var s = document.getElementsByTagName('script')[0];
//    s.parentNode.insertBefore(gcse, s);
//  })();

//VK
//(function() {
//	  var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
//	  po.src = 'http://vk.com/js/api/share.js?9';
//	  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
//	  jQuery(document).ready(function(){
//		setTimeout(function(){
//			jQuery('.vkShare').each(function(){
//				$this = jQuery(this);
//				$this.html(VK.Share.button($this.attr('data-href') && $this.attr('data-href')!=''? $this.attr('data-href'):window.location, {type: 'link'}));
//			});
//		}, 1000);
//	  });
//})();

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
	jQuery('#modalWindowbody').removeClass('alert-warning');
	jQuery('#modalWindowbody').removeClass('alert-danger');
	jQuery('#modalWindowbody').addClass('alert-danger');
} 

info = function(msg){
	jQuery('#modalWindowtitle').html(window.document.title);
	jQuery('#modalWindowbody').html(msg);
	jQuery('#modalWindowok').css('display','none');
	jQuery('#modalWindow').modal('show');
	jQuery('#modalWindowbody').removeClass('alert-warning');
	jQuery('#modalWindowbody').removeClass('alert-danger');
	jQuery('#modalWindowbody').addClass('alert-warning');
} 



AngelGirls.AbrirModalAlerta = function(titulo, texto, legandaBotaoOk, destino){
	jQuery('#modalWindowtitle').html(titulo);
	jQuery('#modalWindowbody').html(texto);
	jQuery('#modalWindowok').attr('href',destino);
	jQuery('#modalWindowok').html(legandaBotaoOk);
	jQuery('#modalWindowok').css('display','');
	jQuery('#modalWindow').modal('show');
	jQuery('#modalWindowbody').removeClass('alert-warning');
	jQuery('#modalWindowbody').removeClass('alert-danger');
	jQuery('#modalWindowbody').addClass('alert-warning');
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



AngelGirls.ResetConfig = function(){
	jQuery('.gostar').each(function(){
		$objetoRef = jQuery(this);

		if(!$objetoRef.attr('data-checado') && $objetoRef.attr('data-checado')!='SIM'){
			if($objetoRef.attr('data-gostei')=='SIM'){
				$objetoRef.html('<span class="badge" title="Gostou">'+$objetoRef.attr('data-gostaram')+' <span class="glyphicon glyphicon-heart" aria-hidden="true" title="Gostou"></span></span>');
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

jQuery(document).ready(function(){


	
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
		jQuery.post('index.php?option=com_angelgirls&task=cidadeJson',{
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
        wrongFileSize: 'O arquivo qeu está tentando enviar é muito grande. (Máximo %s)',
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