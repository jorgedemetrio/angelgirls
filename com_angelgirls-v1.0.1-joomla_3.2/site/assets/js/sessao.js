
jQuery(document).ready(function() {

	if(lidos>=24){
		jQuery('#carregando').css('display','');
		temMais=true;
	}
	else{
		jQuery('#carregando').css('display','none');
		temMais=false;
	}

	setTimeout(function(){
		jQuery('.thumbnail').each(function(){
			$this = jQuery(this);
			$img = jQuery($this.find('img'));
			$img.ready(function(){
				if(!$this.hasClass('in')){
					$this.addClass('in');
				}
			});
		});
	 },900);
	
	jQuery(document).scroll(function(){

		if(jQuery("#BtnBotoesAcao").length>0){
			
			
			
			if(jQuery(this).scrollTop() >=  (jQuery("#BtnBotoesAcao").position().top+jQuery('#content').position().top+(jQuery("#BtnBotoesAcao").height()/2))){
				jQuery("#TotaisHide").addClass('in');
				jQuery("#TotaisHide").css('top', jQuery(document).scrollTop()-jQuery('#content').position().top);
				jQuery("#TotaisHide").css('left', jQuery("#detalhesSessao").position().left);
				jQuery("#TotaisHide").width( jQuery("#detalhesSessao").width());
				jQuery("#TotaisHide").css('display','');
			}
			else{
				jQuery("#TotaisHide").removeClass('in');
				jQuery("#TotaisHide").css('display','none');
			}
			
			
		}
		
		if( (jQuery(window).height()+jQuery(this).scrollTop()) >= jQuery("#carregando").position().top+jQuery('#content').position().top && !carregando && temMais){
			carregando = true;
			jQuery.post(SessaoView.ImagensURL,
					{posicao: lidos}, function(dado){
				jQuery("#carregando").css("display","none");
				if(dado.length<=0){
					jQuery("#carregando").css("display","none");
					temMais=false;
				}
				else{
					//lidos = lidos+24;
					jQuery('#carregando').css('display','');
					jQuery('#linha').append(dado);
					jQuery('.thumbnail').each(function(){
						$this = jQuery(this);
						$img = jQuery($this.find('img'));
						$img.ready(function(){
							if(!$this.hasClass('in')){
								$this.addClass('in');
							}
						});
					});
				}		
				carregando=false;					
			},'html');
		 }
	});
});