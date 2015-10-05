var INBOX = new Object();

INBOX.AtivarConteudo = function(tipo){
	$option = jQuery('#'+tipo+'-OPTION');
	jQuery('#corpoMensagem').fadeOut(500);
	console.log($option);
	if($option.length>0){
		jQuery('.tiposCaixas').removeClass('active');
		$option.addClass('active');	
		AngelGirls.Processando().show();
		jQuery.post(INBOX.AtivarConteudoURL, {caixa: tipo},function(dado){
			AngelGirls.Processando().hide();
			jQuery('#caixas').html(dado);
			
		    jQuery("#tabelaInbox").DataTable({
				"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
				"language": {
		            "lengthMenu": "Exibir _MENU_ itens por p&aacute;gina",
		            "zeroRecords": "Vazio",
		            "info": "Exibir pag. _PAGE_ de _PAGES_",
		            "infoEmpty": "Sem registros",
		            "infoFiltered": "(filtrado de _MAX_ total)",
					"search": "Busca"
		        },
				"aoColumns": [
		            null,
		            { "orderSequence": [ "desc", "asc" ] },
		            { "orderSequence": [ "desc", "asc" ] },
		            { "orderSequence": [ "desc", "asc" ] }
		        ]
			});
			
		},"html");
	}
}



INBOX.moverLixeira = function(id){
	AngelGirls.Processando().show();
	jQuery('#corpoMensagem').fadeOut(500);

	var tipo = null;
	jQuery('.tiposCaixas').each(function(){
	    var $this = jQuery(this);
	    if($this.hasClass('active')){
	    	tipo=$this.attr('id').replace('-OPTION','');
	    }
	})
	
	jQuery.post(INBOX.lixeiraURL , {token:id },function(dado){
		AngelGirls.CarregarDadosInformativos();
		INBOX.AtivarConteudo(tipo);
		AngelGirls.Processando().hide();
	},'json');
}

INBOX.BuscarPerfil = function(){
	var url = INBOX.BuscarPerfilURL;
	url = url + (url.indexOf('?')>0?'&':'?') + 'campo=INBOX.Selecionar';
	AngelGirls.FrameModal("Buscar...",url , "Buscar <span class='glyphicon glyphicon-search' aria-hidden='true'></span>", 
			"JavaScript: $('#iFrameModal').contents().find('#dadosFormBuscarPerfil').submit();",350);
}
 
INBOX.Selecionar = function(nome, id){
	jQuery('#para').tokenInput("add", {id: id, name: nome});
	parent.document.AngelGirls.FrameModalHide();
}

INBOX.ReadMessage = function(id){
	//AngelGirls.Processando().show();
	jQuery('#corpoMensagem').fadeOut(500);
	var tipo = null;
	jQuery('.tiposCaixas').each(function(){
	    var $this = jQuery(this);
	    if($this.hasClass('active')){
	    	tipo=$this.attr('id').replace('-OPTION','');
	    }
	})
	jQuery.post(INBOX.MensagemURL, {caixa: tipo, token:id },function(dado){
		AngelGirls.CarregarDadosInformativos();
		var dataEnvaido = new Date(dado.data_criado);
		var botataoResponde = '	<div class="btn-toolbar pull-right" role="group"><div class="btn-group" role="group"><button onclick="JavsScript: INBOX.Answer(\''+dado.token+'\', )" class="btn btn-primary" type="buttom">Responder <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span></button></div></div>';
		var mensagem = "";
		mensagem +=  "<div class='bg-info' style='padding:10px; border-radius:10px;'><p class='text-left text-capitalize pull-right text-info'><strong>Enviado: </strong>"+
		dataEnvaido.getDate()+'/'+(dataEnvaido.getMonth()+1)+'/'+dataEnvaido.getFullYear()+' '+dataEnvaido.getHours()+':'+dataEnvaido.getMinutes()+'</p>';
		mensagem += "<p class='text-left text-capitalize text-info'><strong>Remetente:</strong> "+dado.nome_remetente+"</p>";
		mensagem += botataoResponde+"<p class='text-left text-capitalize text-info'><strong>Para:</strong> "+dado.nome_destinatario+"</p>";
		mensagem += "<p class='text-left text-capitalize'><strong>"+dado.titulo+"</strong></p></div><br/><br/>";
		mensagem += "<p class='text-left text-muted'>"+dado.mensagem+"</p>";
		jQuery("tr[data-id='"+id+"']").css('font-weight','normal');
		jQuery('#corpoMensagem').html(mensagem);
		jQuery('#corpoMensagem').fadeIn(1000);
		//AngelGirls.Processando().hide();		
	},'json');
}


jQuery(document).ready(function() {

    $("#para").tokenInput(INBOX.pesquisarContatosURL,{
        hintText: "Para quem vai mandar a mensagem?",
        noResultsText: "N&aacute;o encontrado.",
        searchingText: "Buscando..."
    });
	

    jQuery("#tabelaInbox").DataTable({
		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
		"language": {
            "lengthMenu": "Exibir _MENU_ itens por p&aacute;gina",
            "zeroRecords": "N&atilde;o encontrado - sorry",
            "info": "Exibir pag. _PAGE_ de _PAGES_",
            "infoEmpty": "Sem registros",
            "infoFiltered": "(filtrado de _MAX_ total)",
			"search": "Busca"
        },
		"aoColumns": [
            null,
            { "orderSequence": [ "desc", "asc" ] },
            { "orderSequence": [ "desc", "asc" ] },
            { "orderSequence": [ "desc", "asc" ] }
        ]
	});

 
});


