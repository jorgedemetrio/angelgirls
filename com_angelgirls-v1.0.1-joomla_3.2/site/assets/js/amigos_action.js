var Amigos = new Object();
Amigos.TextoAmigos = 'Desfazer Amizade <span class="glyphicon glyphicon-scissors"></span>';
Amigos.TextoNaoAmigos = 'Solicitar Amizade <span class="glyphicon glyphicon-gift"></span>';
Amigos.TextoAguardandoAmigos = 'Cancelar solicita&ccedil;&atilde;o amizade <span class="glyphicon glyphicon-hourglass"></span>';


Amigos.TextoSeguindo = 'Para de seguir <span class="glyphicon glyphicon-thumbs-down"></span>';
Amigos.TextoNaoSeguindo = 'Seguir <span class="glyphicon glyphicon-thumbs-up"></span>';

jQuery(document).ready(function(){
	if(Amigos.Seguindo){
		jQuery('#btnSeguir').html(Amigos.TextoSeguindo);
	}
	else{
		jQuery('#btnSeguir').html(Amigos.TextoNaoSeguindo);
	}
	
	if(Amigos.Amigos){
		jQuery('#btnAmigos').html(Amigos.TextoAmigos);
	}
	else{
		if(Amigos.AmizadeSolicitada){
			jQuery('#btnAmigos').html(Amigos.TextoAguardandoAmigos);
		}
		else if(Amigos.AmizadeAprovar){
			// NO NOTHING	
		}
		else{
			jQuery('#btnAmigos').html(Amigos.TextoNaoAmigos);
		}
	}
	jQuery('#btnAmigos').click(function(){
		if(Amigos.Amigos || Amigos.AmizadeSolicitada){// Desafazer amizade
			jQuery.post(Amigos.DesaAmigarURL ,
					{id: Amigos.IdAmigo, tipo: Amigos.TipoAmigo}, function(dado){
				if(dado.ok='ok'){
					Amigos.Amigos = false;
					Amigos.AmizadeSolicitada= false;
					jQuery('#btnAmigos').html(Amigos.TextoNaoAmigos);
				}
				else{
					alert(dado.mensagem);
				}
			},'json');
		}
		else{ //Solicitar amizade
			jQuery.post(Amigos.AmigarURL,
					{id: Amigos.IdAmigo, tipo: Amigos.TipoAmigo}, function(dado){
				if(dado.ok='ok'){
					Amigos.Amigos = false;
					Amigos.AmizadeSolicitada= true;
					jQuery('#btnAmigos').html(Amigos.TextoAguardandoAmigos);
				}
				else{
					alert(dado.mensagem);
				}
			},'json');			
		}
	});

	jQuery('#btnSeguir').click(function(){
		if(Amigos.Seguindo){
			jQuery.post(Amigos.ParaDeSeguirURL ,
					{id: Amigos.IdAmigo, tipo: Amigos.TipoAmigo}, function(dado){
				if(dado.ok='ok'){
					Amigos.Seguindo = false;
					jQuery('#btnSeguir').html(Amigos.TextoNaoSeguindo);
				}
				else{
					alert(dado.mensagem);
				}
			},'json');
		}
		else{
			jQuery.post(Amigos.SeguirURL,
					{id: Amigos.IdAmigo, tipo: Amigos.TipoAmigo}, function(dado){
				if(dado.ok='ok'){
					Amigos.Seguindo = true;
					jQuery('#btnSeguir').html(Amigos.TextoSeguindo);
				}
				else{
					alert(dado.mensagem);
				}
			},'json');
		}
	});

	jQuery('#btnEnviarMensagem').click(function(){
		var url = Amigos.InboxURL;
		url = url +  (url.indexOf('?')>0? '&':'?') + '&token=' +Amigos.IdAmigo + '&tipo=' + Amigos.TipoAmigo;
		AngelGirls.FrameModal("Enviar mensagem r&aacute;pida", url, "Enviar", "JavaScript: $('#iFrameModal').contents().find('#dadosFormMensage').submit();",270);
	});
	

	jQuery('#btnAprovarAmizade').click(function(){
		jQuery('#groupBtnAProvacao').css('display','none');
		jQuery.post(Amigos.AceitarAmizadeURL,
				{id: Amigos.IdAmigo, tipo: Amigos.TipoAmigo}, function(dado){
			if(dado.ok='ok'){
				jQuery('#btnSeguir').html(Amigos.TextoSeguindo);
				jQuery('#btnAmigos').html(Amigos.TextoAmigos);
				jQuery('#btnAmigos').css('display','block');
				Amigos.AmizadeSolicitada= true;
				Amigos.Amigos = true;
				Amigos.Seguindo = true;

			}
			else{
				alert(dado.mensagem);
			}
		},'json');
	});

	jQuery('#btnReprovarAmizade').click(function(){
		jQuery('#groupBtnAProvacao').css('display','none');
		jQuery.post(Amigos.RejeitarAmizadeURL,
				{id: Amigos.IdAmigo, tipo: Amigos.TipoAmigo}, function(dado){
			if(dado.ok='ok'){
				jQuery('#btnSeguir').html(Amigos.TextoNaoSeguindo);
				jQuery('#btnAmigos').html(Amigos.TextoNaoAmigos);
				jQuery('#btnAmigos').css('display','block');
				Amigos.AmizadeSolicitada= false;
				Amigos.Amigos = false;
				Amigos.Seguindo = false;
			}
			else{
				alert(dado.mensagem);
			}
		},'json');
	});
	
});