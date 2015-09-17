/**
 * Processando
 */
document.processing = function () {
    var pleaseWaitDiv = jQuery('<div class="modal hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false"><div class="modal-header"><h1>Processando...</h1></div><div class="modal-body"><div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div></div></div>');
    return {
        show: function() {
            pleaseWaitDiv.modal();
        },
        hide: function () {
            pleaseWaitDiv.modal('hide');
        },
    };
};


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
				console.log($objeto);
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

jQuery(document).ready(function(){


	
	jQuery(".validate-numeric").mask("#.##0,00", {reverse: true});
	jQuery(".validate-inteiro").mask("9999999999999");
	jQuery(".validate-cep").mask("99999-999");
	jQuery(".validate-cpf").mask("999.999.999-99");

	jQuery(".validate-data").mask("99/99/9999", {placeholder: "__/__/____"});
		
	jQuery(".validate-telefone").mask("(99) 99999-9999");

		
		
		
	jQuery(".estado").change(function(){
		$objeto = jQuery(this);
		$ObjetoCidade = jQuery("#"+$objeto.attr("data-carregar"));
		$ObjetoCidade.empty();
		$ObjetoCidade.append(new Option(  "", ""));
		
		
		jQuery.post('index.php?option=com_angelgirls&task=cidadeJson',{
			uf:$objeto.val()}, function(dado){
			for(var i=0; i<dado.length;i++){
				$ObjetoCidade.append(new Option(dado[i].nome, dado[i].id));
			}
		},'json');
	});	
	
	AngelGirls.ResetConfig();
});