/**
 * Processando
 */
document.processing = function () {
    var pleaseWaitDiv = $('<div class="modal hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false"><div class="modal-header"><h1>Processando...</h1></div><div class="modal-body"><div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div></div></div>');
    return {
        show: function() {
            pleaseWaitDiv.modal();
        },
        hide: function () {
            pleaseWaitDiv.modal('hide');
        },
    };
};


//FACEBOOK API
(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.4";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));




//GOOGLE API
window.___gcfg = {lang: 'pt-BR'};

(function() {
  var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
  po.src = 'https://apis.google.com/js/platform.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();


(function() {
    var cx = '007002280365302771262:9-iwnl5ixt0';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
        '//cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();


(function() {
	  var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	  po.src = 'http://vk.com/js/api/share.js?9';
	  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  jQuery(document).ready(function(){
		setTimeout(function(){
			jQuery('.vkShare').each(function(){
				$this = jQuery(this);
				$this.html(VK.Share.button($this.attr('data-href'), {type: 'link'}));
			});
		}, 1000);
	  });
})();


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
	
});