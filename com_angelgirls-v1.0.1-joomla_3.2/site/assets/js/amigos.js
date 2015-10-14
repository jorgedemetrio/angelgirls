var Amigos = new Object();


jQuery(document).scroll(function(){
	
	if(jQuery('#amigos').hasClass('active')){
		if( (jQuery(window).height()+jQuery(document).scrollTop()) >= (jQuery("#carregandoAmigos").position().top+jQuery('#content').position().top) && !carregando && temMais){
			
			carregando = true;
			jQuery.post(Amigos.LoadAmigosURL,
					{posicao: lidos, id: EditarSessao.SessaoID}, function(dado){
				jQuery("#carregandoAmigos").css("display","none");
				if(dado.length<=0){
					jQuery("#carregandoAmigos").css("display","none");
					temMais=false;
				}
				else{
					jQuery('#carregandoAmigos').css('display','');
					jQuery('#linha').append(dado);
				}		
				
				jQuery('.thumbnail').each(function(){
					$this = jQuery(this);
					$img = jQuery($this.find('img'));
					$img.ready(function(){
						if(!$this.hasClass('in')){
							$this.addClass('in');
						}
					});
				});
				carregando=false;					
			},'html');
		 }
	}
});


jQuery(document).ready(function(){
	

		jQuery('.thumbnail').each(function(){
			$this = jQuery(this);
			$img = jQuery($this.find('img'));
			$img.ready(function(){
				if(!$this.hasClass('in')){
					$this.addClass('in');
				}
			});
		});

});




Amigos.Aceitar = function(obj){

	var $obj = jQuery(obj);
	
	jQuery.post(Amigos.AceitarAmizadeURL,
			{id: $obj.attr('data-id'), tipo: $obj.attr('data-tipo')}, function(dado){
		if(dado.ok='ok'){
			jQuery('#amigo'+$obj.attr('data-id')).fadeOut(500);
		}
		else{
			alert(dado.mensagem);
		}
	},'json');
};

Amigos.Recusar = function(obj){
	var $obj = jQuery(obj);
	jQuery.post(Amigos.RejeitarAmizadeURL,
			{id: $obj.attr('data-id'), tipo: $obj.attr('data-tipo')}, function(dado){
		if(dado.ok='ok'){
			jQuery('#amigo'+$obj.attr('data-id')).fadeOut(500);
		}
		else{
			alert(dado.mensagem);
		}
	},'json');
};

