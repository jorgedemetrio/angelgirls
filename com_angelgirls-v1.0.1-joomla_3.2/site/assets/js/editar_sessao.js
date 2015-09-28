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
	
	jQuery('#meta_descricao').restrictLength($('#maxlength'));
	jQuery('#comentario').restrictLength($('#maxlengthComentario'));
	
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
		if( (jQuery(window).height()+jQuery(this).scrollTop()) >= jQuery("#carregando").position().top && !carregando && temMais){
			
			carregando = true;
			jQuery.post(EditarSessao.LoadImagensURL,
					{posicao: lidos}, function(dado){
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
	
});



if(!EditarSessao){
	var EditarSessao = new Object();
}

EditarSessao.EditarDadosFoto = function(id){
	
}

EditarSessao.RemoverFoto = function(id){
	jQuery.post(EditarSessao.RemoveFotoURL,
			{id: id}, function(dado){
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
	
	jQuery('#ft'+id).remove();
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
                var html = '<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-2 thumbnail fade in"><a href="'+data.url+'"><img src="'+data.cube+'" /></a></div>'
                jQuery('#linha').append(html);
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
		    EditarSessao.ImagensPublicadas++;
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

