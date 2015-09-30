jQuery(document).ready(function(){
	
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
	

	jQuery('#btnSalvarVideo').click(function(){
		EditarSessao.SalvarVideo();
	});
	jQuery('#btnAdicionarVideo').click(function(){
		EditarSessao.SalvarVideo();
	});
	
	jQuery('#btnCancelarSalvarVideo').click(function(){
		EditarSessao.LimparFormVideo();
	});
	
	jQuery('.btnRemoverSessao').click(function(){
		EditarSessao.RemoverSessao();
	});	


	
	jQuery('.btnPublicar').click(function(){
		if(EditarSessao.PublicacaoLiberada){
			EditarSessao.Publicar();		
		}
	});	
	

	
	
	
	
	EditarSessao.VerificarHabilitacaoPublicacao();
	
	
	jQuery('#meta_descricao').restrictLength($('#maxlength'));
	jQuery('#comentario').restrictLength($('#maxlengthComentario'));
	jQuery('#meta_descricao_video').restrictLength($('#maxlengthvideo'));

	
	jQuery.validate({
	    modules : 'security, date, file, html5',
	    language : ptBRValidation,
	    decimalSeparator : ','
	});
	
	
	var obj = $("#dragandrophandler");
	obj.on('dragenter', function (e) 
	{
	    e.stopPropagation();
	    e.preventDefault();
	    $(this).css('border', '2px solid #0B85A1');
	});
	obj.on('dragover', function (e) 
	{
	     e.stopPropagation();
	     e.preventDefault();
	});
	obj.on('drop', function (e) 
	{
	 
	     $(this).css('border', '2px dotted #0B85A1');
	     e.preventDefault();
	     var files = e.originalEvent.dataTransfer.files;
	 
	     //We need to send dropped files to Server
	     EditarSessao.handleFileUpload(files,obj);
	});

	$(document).on('dragenter', function (e) 
	{
	    e.stopPropagation();
	    e.preventDefault();
	});
	$(document).on('dragover', function (e) 
	{
	  e.stopPropagation();
	  e.preventDefault();
	  obj.css('border', '2px dotted #0B85A1');
	});
	$(document).on('drop', function (e) 
	{
	    e.stopPropagation();
	    e.preventDefault();
	});

	
	jQuery('#tema').change(function(){
		if(jQuery('#tema option:selected').val()=='NOVO'){
			jQuery('#tema').val('');
			AngelGirls.FrameModal("Cadastrar Novo Temas", EditarSessao.TemaURL, "Salvar", "JavaScript: $('#iFrameModal').contents().find('#dadosFormTema').submit();",270);
		}
	});

	jQuery('#locacao').change(function(){
		if(jQuery('#locacao option:selected').val()=='NOVO'){
			jQuery('#locacao').val('');
			AngelGirls.FrameModal("Cadastrar Nova Loca&ccedil;&atilde;o", EditarSessao.LocacaoURL, "Salvar", "JavaScript: $('#iFrameModal').contents().find('#dadosFormLocacao').submit();",350);
		}
	});

	jQuery('#id_figurino_principal').change(function(){
		if(jQuery('#id_figurino_principal option:selected').val()=='NOVO'){
			jQuery('#id_figurino_principal').val('');
			var url = EditarSessao.FigurinoURL;
			url = url +  (url.indexOf('?')>0?'&campo=id_figurino_principal':'?campo=id_figurino_principal');
			AngelGirls.FrameModal("Cadastrar Novo Figurino", url, "Salvar", "JavaScript: $('#iFrameModal').contents().find('#dadosFormFigurino').submit();",270);
		}
	});
	jQuery('#id_figurino_secundario').change(function(){
		if(jQuery('#id_figurino_secundario option:selected').val()=='NOVO'){
			jQuery('#id_figurino_secundario').val('');
			var url = EditarSessao.FigurinoURL;
			url = url +  (url.indexOf('?')>0?'&campo=id_figurino_secundario':'?campo=id_figurino_secundario');
			AngelGirls.FrameModal("Cadastrar Novo Figurino", url, "Salvar", "JavaScript: $('#iFrameModal').contents().find('#dadosFormFigurino').submit();",270);
		}
	});

	
	try{
		if(lidos>=24){
			jQuery('#carregando').css('display','');
			temMais=true;
		}
		else{
			jQuery('#carregando').css('display','none');
			temMais=false;
		}


	
	
	
		
		
		jQuery(document).scroll(function(){
			 //if( (jQuery(window).height()+jQuery(this).scrollTop()+350) >= jQuery(document).height() && !carregando && temMais) {
			
			if(jQuery(this).scrollTop() >= jQuery("#Totais").position().top+(jQuery("#Totais").height()/2)){
				jQuery("#TotaisHide").addClass('in');
				jQuery("#TotaisHide").css('top', jQuery(this).scrollTop());
				jQuery("#TotaisHide").css('left', jQuery("#Totais").position().left);
				jQuery("#TotaisHide").width( jQuery("#Totais").width());
				jQuery("#TotaisHide").css('display','');
			}
			else{
				jQuery("#TotaisHide").removeClass('in');
				jQuery("#TotaisHide").css('display','none');
			}

			
			
			if( (jQuery(window).height()+jQuery(this).scrollTop()) >= jQuery("#carregando").position().top && !carregando && temMais){
				
				carregando = true;
				jQuery.post(EditarSessao.LoadImagensURL,
						{posicao: lidos, id: EditarSessao.SessaoID}, function(dado){
					jQuery("#carregando").css("display","none");
					if(dado.length<=0){
						jQuery("#carregando").css("display","none");
						temMais=false;
					}
					else{
						jQuery('#carregando').css('display','');
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
		});
	
	}
	catch(ex){
		
	}

	
});



if(!EditarSessao){
	var EditarSessao = new Object();
}

EditarSessao.VerVideo = function(id){
	var url = EditarSessao.VerVideoURL;
	url = url +  (url.indexOf('?')>0?'&id=':'?id=')+id;
	alert('<video width="320" height="240" controls><source src="movie.mp4" type="video/mp4"></video>');
}

EditarSessao.RemoverVideo = function(idParam){
	jQuery.post(EditarSessao.RemoverVideoURL,
			{id: idParam}, function(){
		EditarSessao.VideosPublicados = EditarSessao.VideosPublicados - 1;
		EditarSessao.VerificarHabilitacaoPublicacao();
		EditarSessao.RecarregarVideos();	
		
	});
}


EditarSessao.RecarregarVideos = function(){
	jQuery.post(EditarSessao.CarregarVideoURL,
	{id: EditarSessao.SessaoID}, function(dados){
		jQuery('#listaVideos').html(dados);
	},'html');
};
 


EditarSessao.SalvarVideo = function(idParam){

	var mensagemErro='';
	
    if(jQuery('#descricao_video').val().trim()=='' || jQuery('#descricao_video').val().trim().length<5){
    	mensagemErro+="O campo \"Descri&ccedil;&atilde;o\" &eacute; um campo obrigat&oacute;rio! E deve conter no minimo 5 caracteres.<br/>";
    	
    }
    if(jQuery('#titulo_video').val().trim()=='' || jQuery('#titulo_video').val().trim().length<5){
    	mensagemErro+="O campo \"Titulo\" &eacute; um campo obrigat&oacute;rio! E deve conter no minimo 5 caracteres.<br/>";
    }
    if(jQuery('#meta_descricao_video').val().trim()=='' || jQuery('#meta_descricao_video').val().trim().length<5){
    	mensagemErro+="O campo \"Descri&ccedil;&atilde;o Breve\" &eacute; um campo obrigat&oacute;rio! E deve conter no minimo 5 caracteres.<br/>";
    }
    if(jQuery('#tipo_video').val().trim()==''){
    	mensagemErro+="O campo \"Tipo\" &eacute; um campo obrigat&oacute;rio!<br/>";
    }
    
    if(jQuery('#id_video').val().trim()=='' && jQuery('#video').val()==''){
    	mensagemErro+="O campo \"V&iacute;deo\" &eacute; um campo obrigat&oacute;rio!<br/>";
    }
    
    if(mensagemErro.length>0){
    	alert(mensagemErro);
    	return;
    }
	
	
    var fd = new FormData();
    fd.append('video', document.getElementById('video').files[0]);
    fd.append('id_sessao', EditarSessao.SessaoID);
    fd.append('id', jQuery('#id_video').val());
    fd.append('descricao', jQuery('#descricao_video').val());
    fd.append('titulo', jQuery('#titulo_video').val());
    fd.append('meta_descricao', jQuery('#meta_descricao_video').val());
    fd.append('tipo', jQuery('#tipo_video').val());
    
    

    
    AngelGirls.Processando().show();
    jQuery.ajax({
        url: EditarSessao.SalvarVideoURL,
        type: 'POST',
        dataType: 'json',
        contentType: false,
        processData: false,
        cache: false,
        data: fd,
	    success: function(data){
	    	AngelGirls.Processando().hide();
	    	if(data.ok=='ok'){
	    		EditarSessao.RecarregarVideos();		
				EditarSessao.LimparFormVideo();
				EditarSessao.VideosPublicados = EditarSessao.VideosPublicados + 1;
				EditarSessao.VerificarHabilitacaoPublicacao();
	    	}
	    	else{
	    		alert(data.mensagem);
	    	}
	    }  
	}); 

}

EditarSessao.Publicar = function(){
	
	if(EditarSessao.ImagensPublicadas < 40 || (EditarSessao.ImagensSemNunes < 5 || 10 > (EditarSessao.ImagensPublicadas- EditarSessao.ImagensSemNunes))){
		alert('Voc&ecirc; deve enviar no minimo 40 fotos, sendo delas no minimo 10 com nu ou semi nu e 5 sem nu nem semi nu!');
		return;
	}
	if(EditarSessao.VideosPublicados<1 ){
		alert('Voc&ecirc; deve enviar no minimo 1 v&iacute;deo!<br/>Prefer&ecirc;ncia o v&iacute;deo com as modelos comentando ci&ecirc;ncia que o material ser&aacute; publicado na Angel Girls e conhecimentos dos termos e condiu&ccedil;&otilde;es.<br/>O MakingOf &eacute; opcional.');
		return;
	}
	
	
	jQuery('#publicar').val('S');
	jQuery('#dadosForm').submit();		
	
};

EditarSessao.PublicacaoLiberada = false;

EditarSessao.VerificarHabilitacaoPublicacao = function(){
	jQuery('.totalFotos').html(EditarSessao.ImagensPublicadas);
	var erro=false;
	if(EditarSessao.ImagensPublicadas<40){
		jQuery('.totalFotos').removeClass('itemValor');
		jQuery('.totalFotos').removeClass('itemValorErro');
		jQuery('.totalFotos').addClass('itemValorErro');
		erro=true;
	}else{
		jQuery('.totalFotos').removeClass('itemValor');
		jQuery('.totalFotos').removeClass('itemValorErro');
		jQuery('.totalFotos').addClass('itemValor');		
	}
	
	
	jQuery('.totalVideos').html(EditarSessao.VideosPublicados );
	if(EditarSessao.VideosPublicados<1){
		jQuery('.totalVideos').removeClass('itemValor');
		jQuery('.totalVideos').removeClass('itemValorErro');
		jQuery('.totalVideos').addClass('itemValorErro');
		erro=true;
	}else{
		jQuery('.totalVideos').removeClass('itemValor');
		jQuery('.totalVideos').removeClass('itemValorErro');
		jQuery('.totalVideos').addClass('itemValor');		
	}
	
	
	jQuery('.totalFotosSemNu').html(EditarSessao.ImagensSemNunes);
	if(EditarSessao.ImagensSemNunes<5 || EditarSessao.ImagensSemNunes>(EditarSessao.ImagensPublicadas-10)){
		jQuery('.totalFotosSemNu').removeClass('itemValor');
		jQuery('.totalFotosSemNu').removeClass('itemValorErro');
		jQuery('.totalFotosSemNu').addClass('itemValorErro');
		erro=true;
	}else{
		jQuery('.totalFotosSemNu').removeClass('itemValor');
		jQuery('.totalFotosSemNu').removeClass('itemValorErro');
		jQuery('.totalFotosSemNu').addClass('itemValor');		
	}
	
	if(erro){
		EditarSessao.PublicacaoLiberada = false;
		jQuery('.btnPublicar').removeClass('disabled');
		jQuery('.btnPublicar').addClass('disabled');
		jQuery('.btnPublicar').attr('disabled','disabled');
	}
	else{
		EditarSessao.PublicacaoLiberada = true;
		jQuery('.btnPublicar').removeClass('disabled');
		jQuery('.btnPublicar').attr('disabled',null);
	}
} 

EditarSessao.RemoverSessao = function(){
	if(confirm('Est\u00e1 certo disto?')){
		window.location = EditarSessao.RemoverSessaoURL;		
	}
}


EditarSessao.EditarVideo = function(id,titulo,tipo,meta_descricao,descricao){
	jQuery('#btnCancelarSalvarVideo').addClass('in');
	jQuery('#btnSalvarVideo').addClass('in');
	jQuery('#btnAdicionarVideo').removeClass('in');
	jQuery('#id_video').val(id);
	jQuery('#titulo_video').val(titulo);
	jQuery('#tipo_video').val(tipo);
	jQuery('#meta_descricao_video').val(meta_descricao);
	jQuery('#descricao_video').val(descricao);
	jQuery('#video').attr('disabled','disabled');
}

EditarSessao.LimparFormVideo = function(){
	jQuery('#btnCancelarSalvarVideo').removeClass('in');
	jQuery('#btnSalvarVideo').removeClass('in');
	jQuery('#btnAdicionarVideo').addClass('in');
	jQuery('#id_video').val('');
	jQuery('#titulo_video').val('');
	jQuery('#tipo_video').val('');
	jQuery('#video').val('');
	jQuery('#video').attr('disabled',null);
	jQuery('#meta_descricao_video').val('');
	jQuery('#descricao_video').val('');
}


EditarSessao.EditarDadosFoto = function(id){
	var url = EditarSessao.EditarTextoImagemURL;
	url = url +  (url.indexOf('?')>0?'&id=':'?id=')+id;
	AngelGirls.FrameModal("Editar Texto Imagem", url, "Salvar", "JavaScript: $('#iFrameModal').contents().find('#dadosFormEditarFoto').submit();",270);
}

EditarSessao.RemoverFoto = function(idParam){
	jQuery('#foto'+idParam).removeClass('in');
	jQuery.post(EditarSessao.RemoverImagemURL,
			{id: idParam}, function(){
		jQuery('#foto'+idParam).remove();
		
        EditarSessao.ImagensPublicadas = EditarSessao.ImagensPublicadas - 1;
        
        EditarSessao.VerificarHabilitacaoPublicacao();
	},'text');
}

EditarSessao.PossuiNudes = function(idParam){
	jQuery.post(EditarSessao.PossuiNudesURL,
			{id: idParam}, function(){
		if(jQuery('#PossuiNudes'+idParam).attr('data-valor')=='S'){
			jQuery('#PossuiNudes'+idParam).html('<span class="glyphicon glyphicon-heart-empty" title="N&atilde;o possui nudez."></span>&nbsp;');
			jQuery('#PossuiNudes'+idParam).attr('data-valor','N');
			EditarSessao.ImagensSemNunes = EditarSessao.ImagensSemNunes+1;
		}else{
			jQuery('#PossuiNudes'+idParam).html('<span class="glyphicon glyphicon-heart" title="Possui nudez."></span>&nbsp;');
			jQuery('#PossuiNudes'+idParam).attr('data-valor','S');
			EditarSessao.ImagensSemNunes = EditarSessao.ImagensSemNunes-1;
		}
		EditarSessao.VerificarHabilitacaoPublicacao();
	},'json');
}


EditarSessao.BuscarModelo = function(idCampo, idDivNome, idDivImagem){
	var url = EditarSessao.BuscarModeloURL;
	url = url + (url.indexOf('?')>0?'&':'?') + 'campo='+idCampo+'&divNome='+idDivNome+'&divImagem='+idDivImagem;
	AngelGirls.FrameModal("Selecionar modelo",url , "Buscar <span class='glyphicon glyphicon-search' aria-hidden='true'></span>", 
			"JavaScript: $('#iFrameModal').contents().find('#dadosFormBuscarModelo').submit();",350);
}

EditarSessao.BuscarFotografo = function(idCampo, idDivNome, idDivImagem){
	var url = EditarSessao.BuscarFotografoURL;
	url = url + (url.indexOf('?')>0?'&':'?') + 'campo='+idCampo+'&divNome='+idDivNome+'&divImagem='+idDivImagem;
	AngelGirls.FrameModal("Selecionar Fotografo",url , "Buscar <span class='glyphicon glyphicon-search' aria-hidden='true'></span>", 
			"JavaScript: $('#iFrameModal').contents().find('#dadosFormBuscarFotografo').submit();",350);
}

EditarSessao.OpenImagem = function(imagem){
	alert('<div style="text-align:center"><img src="'+imagem+'" style="height:350px;"/></div>');

}


EditarSessao.sendFileToServer = function(formData,status) {
	var uploadURL =EditarSessao.sendFileToServerURL;
    var jqXHR=jQuery.ajax({
	        url: uploadURL,
	        type: 'POST',
	        dataType: 'json',
	        contentType: false,
	        processData: false,
	        cache: false,
	        data: formData,
            xhr: function() {
            var xhrobj = jQuery.ajaxSettings.xhr();
            if (xhrobj.upload) {
                    xhrobj.upload.addEventListener('progress', function(event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                        //Set progress
                        status.setProgress(percent);
                    }, false);
                }
            return xhrobj;
        },
        success: function(data){
            if(data.ok=='ok'){
                var html = '<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-2 thumbnail fade" id="imagemThumb'+data.id+'"><a href="'+data.url+'"><img src="'+data.cube+'" /></a></div>'
                jQuery('#linha').append(html);
                
                EditarSessao.ImagensPublicadas = EditarSessao.ImagensPublicadas + 1;
                
                EditarSessao.VerificarHabilitacaoPublicacao();
                
        		jQuery('#imagemThumb'+data.id+'').ready(function(){
        			$this = jQuery('#imagemThumb'+data.id+''); 
    				if(!$this.hasClass('in')){
    					$this.addClass('in');
    				}
        		});
            }
            else{
            	status.setFileNameSize('<span class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> '+data.mensagem+'</span>');
     		    status.abort.hide();
    		    status.progressBar.hide();
    		    status.size.hide();
            }
            status.setProgress(100);                       
        }  
    }); 
 
    status.setAbort(jqXHR);
}


var rowCount=0;

EditarSessao.handleFileUpload = function(files,obj) {
   for (var i = 0; i < files.length; i++) {
       var fd = new FormData(jQuery('#enviar'));
       fd.append('imagem', files[i]);
       fd.append('option', 'com_angelgirls');
       fd.append('view', 'sessoes');
       fd.append('task', 'enviarFotosSessao');
       fd.append('id', EditarSessao.SessaoID);

       
       var status = new EditarSessao.CreateStatusbar(obj); //Using this we can set progress.
        
	   if(files[i].type.toUpperCase().indexOf('JPG')>0 || files[i].type.toUpperCase().indexOf('JPEG')>0){
		    status.setFileNameSize(files[i].name,files[i].size);
		    EditarSessao.sendFileToServer(fd ,status);
	   }
	   else{
		   status.setFileNameSize('<span class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> "'+files[i].name+'" n&atilde;o &eacute; JPG</span>',files[i].size);
		   status.abort.hide();
		   status.progressBar.hide();
		   status.size.hide();
	   }
   }
}
EditarSessao.CreateStatusbar = function(obj) {
    rowCount++;
    var row="odd";
    if(rowCount %2 ==0) row ="even";
    this.statusbar = $("<div class='statusbar "+row+"'></div>");
    this.filename = $("<div class='filename'></div>").appendTo(this.statusbar);
    this.size = $("<div class='filesize'></div>").appendTo(this.statusbar);
    this.progressBar = $("<div class='progressBar'><div></div></div>").appendTo(this.statusbar);
    this.abort = $("<div class='abort'>Abortar</div>").appendTo(this.statusbar);
    jQuery('#tituloArquivosRecebidos').after(this.statusbar);

   this.setFileNameSize = function(name,size)
   {
       var sizeStr="";
       var sizeKB = size/1024;
       if(parseInt(sizeKB) > 1024)
       {
           var sizeMB = sizeKB/1024;
           sizeStr = sizeMB.toFixed(2)+" MB";
       }
       else
       {
           sizeStr = sizeKB.toFixed(2)+" KB";
       }

       this.filename.html(name);
       this.size.html(sizeStr);
   }
   this.setProgress = function(progress)
   {       
       var progressBarWidth =progress*this.progressBar.width()/ 100;  
       this.progressBar.find('div').animate({ width: progressBarWidth }, 10).html(progress + "% ");
       if(parseInt(progress) >= 100)
       {
           this.abort.hide();
       }
   }
   this.setAbort = function(jqxhr)
   {
       var sb = this.statusbar;
       this.abort.click(function()
       {
           jqxhr.abort();
           sb.hide();
       });
   }
}

