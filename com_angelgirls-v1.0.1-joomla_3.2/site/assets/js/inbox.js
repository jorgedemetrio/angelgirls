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
				order: [[ 3, "desc" ]],
		    	ordering: true,
		    	select: true,
		    	searching: false,
				columns: [
				            null,
				            { "orderSequence": [ "asc" ,"desc" ] },
				            { "orderSequence": [ "asc", "desc"  ] },
				            { "orderSequence": [ "desc", "asc" ] }
				        ],
				"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
				"language": {
		            "lengthMenu": "Exibir _MENU_ itens por p&aacute;gina",
		            "zeroRecords": "Vazio",
		            "info": "Exibir pag. _PAGE_ de _PAGES_",
		            "infoEmpty": "Sem registros",
		            "infoFiltered": "(filtrado de _MAX_ total)",
					"search": "Busca"
		        }
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
var htmlMensagemLida="";
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
		var mensagem = dado.mensagem;
		
		while(mensagem.indexOf("'")>=0){
			mensagem.replace('\'','');
		}
		console.log(dado);
		botataoResponde = '	<div class="btn-toolbar pull-right" role="group"><div class="btn-group" role="group"><button onclick="JavsScript: INBOX.Answer(\''+dado.token+'\',\''+dado.nome_remetente+'\',\''+dado.id_usuario_remetente+'\',\''+dado.titulo+'\');" class="btn btn-primary" type="buttom">Responder <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span></button></div></div>';
		var mensagem = "";
		mensagem +=  "<div class='bg-info' style='padding:10px; border-radius:10px;'><p class='text-left text-capitalize pull-right text-info'><strong>Enviado: </strong>"+
		dataEnvaido.getDate()+'/'+(dataEnvaido.getMonth()+1)+'/'+dataEnvaido.getFullYear()+' '+dataEnvaido.getHours()+':'+dataEnvaido.getMinutes()+'</p>';
		mensagem += "<p class='text-left text-capitalize text-info'><strong>Remetente:</strong> "+dado.nome_remetente+"</p>";
		mensagem += "<!--BOTAO--><p class='text-left text-capitalize text-info'><strong>Para:</strong> "+dado.nome_destinatario+"</p>";
		mensagem += "<p class='text-left text-capitalize'><strong>"+dado.titulo+"</strong></p></div><br/><br/>";
		mensagem += "<p class='text-left text-muted' id='MensagemEmail'>"+dado.mensagem+"</p>";
		htmlMensagemLida=mensagem; 
		
		
		
		jQuery("tr[data-id='"+id+"']").css('font-weight','normal');
		jQuery('#corpoMensagem').html(mensagem.replace('<!--BOTAO-->',botataoResponde));
		jQuery('#corpoMensagem').fadeIn(1000);
		//AngelGirls.Processando().hide();		
	},'json');
}

INBOX.Answer = function(id, remetente, idRemetente,titulo){
	//jQuery('#corpoMensagem').html();
	jQuery('#para').tokenInput("clear");
	jQuery('#para').tokenInput("add", {id: idRemetente, name: remetente});
	jQuery('#titulo').val('RES: '+titulo);
	tinyMCE.activeEditor.setContent('<p></p><p></p><span style="background: #eeffee;"><p>Resposta a:</p><dir>'+htmlMensagemLida+'</dir></span>');//, {format : 'raw'});
	//jQuery('textarea[name="mensagem"]').val('<p></p><p></p><p>Resposta a:</p><dir>'+jQuery('#corpoMensagem').html()+'</dir>');
	jQuery('a[href="#novaMensagem"]').click();
	jQuery('#btnNovo').removeClass('disabled');
	jQuery('#btnSalvar').removeClass('disabled');
	tinymce.activeEditor.focus();
}

INBOX.NovaMensagemControle = function(){
	var para = jQuery('#para').val().trim();
	var titulo = jQuery('#titulo').val().trim();
	var mensagem = jQuery('textarea[name="mensagem"]').val().trim();

	
	if( para !='' || titulo != '' || mensagem != ''){
		jQuery('#btnNovo').removeClass('disabled');
		jQuery('#btnSalvar').removeClass('disabled');
	}
	else{
		jQuery('#btnNovo').addClass('disabled');
		jQuery('#btnSalvar').addClass('disabled');
	}
}

jQuery(document).ready(function() {



    jQuery('#dadosFormMensage').submit(function(){
    	tinyMCE.triggerSave();
    	
    	if(jQuery('#para').val().trim()==''){
    		alert('Necess&aacute;rio selecionar um destinat&aacute;rio no campo "Para" !');
    		return false;
    	}
    	if(	jQuery('#titulo').val().trim() == ''){
    		alert('Necess&aacute;rio digitar um titulo!');
    		return false;
    	}
    	if(jQuery('textarea[name="mensagem"]').val().trim() ==  ''){
    		alert('Necess&aacute;rio digitar uma mensagem!');
    		return false;
    	}
   		return true;
    });
    
    jQuery("#tabelaInbox").DataTable({
		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
		order: [[ 3, "desc" ]],
    	ordering: true,
    	select: true,
    	searching: false,
		"language": {
            "lengthMenu": "Exibir _MENU_ itens por p&aacute;gina",
            "zeroRecords": "N&atilde;o encontrado - sorry",
            "info": "Exibir pag. _PAGE_ de _PAGES_",
            "infoEmpty": "Sem registros",
            "infoFiltered": "(filtrado de _MAX_ total)",
			"search": "Busca"
        },
		columns: [
            null,
            { "orderSequence": [ "asc" ,"desc" ] },
            { "orderSequence": [ "asc", "desc"  ] },
            { "orderSequence": [ "desc", "asc" ] }
        ]
	});
    
	jQuery('#para').change(function(){
		INBOX.NovaMensagemControle();
	});
	jQuery('#titulo').change(function(){
		INBOX.NovaMensagemControle();
	});
	jQuery('textarea[name="mensagem"]').change(function(){
		INBOX.NovaMensagemControle();
	});
	
	INBOX.NovaMensagemControle();
	
	jQuery('#btnNovo').click(function(){
		if(!jQuery('#btnNovo').hasClass('disabled')){
			jQuery("#para").tokenInput("clear");
			jQuery('#titulo').val('');
			tinyMCE.activeEditor.setContent('');
			jQuery('textarea[name="mensagem"]').val('');
			jQuery('#btnNovo').addClass('disabled');
			jQuery('#btnSalvar').addClass('disabled');
		}
	});

 
});


