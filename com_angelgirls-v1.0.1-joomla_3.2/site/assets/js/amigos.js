var Amigos = new Object();
var temMais = false;

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
		
		jQuery('#nivel').change(function(){
			jQuery('#nivelVal').html(
					jQuery('#nivel').val()==0?'Todos':jQuery('#nivel').val()); 
		});

		jQuery('#tipo').change(function(){
			if(jQuery('#tipo').val()=='MODELO'){
				jQuery('#extraModeloFiltros').css('display','none');
				jQuery('#iconeFiltroModelo').addClass('glyphicon-plus');
				jQuery('#iconeFiltroModelo').removeClass('glyphicon glyphicon-minus');
				jQuery('#extraModelo').fadeIn(500);
			}
		});

		jQuery('#dadosForm').submit(function(){
			AngelGirls.Processando().show();
			jQuery('#listaResultado').html('');
			
			var dataSubmit = {busca: jQuery('#busca').val(),
					tipo: jQuery('#tipo').val(),
					estado: jQuery('#estado').val(),
					id_cidade: jQuery('#id_cidade').val(),
					nivel: jQuery('#nivel').val(),
					idade_init: jQuery('#idade_init').val(),
					idade_fim: jQuery('#idade_fim').val(),
					pontos_init: jQuery('#pontos_init').val(),
					pontos_fim: jQuery('#pontos_fim').val(),
					sexo: jQuery('#sexo').val(),
					altura_inicial: jQuery('#che altura_inicial').val(),
					altura_final: jQuery('#altura_final').val(),
					peso_inicial: jQuery('#peso_inicial').val(),
					peso_final: jQuery('#peso_final').val(),
					calsado_inicial: jQuery('#calsado_inicial').val(),
					calsado_final: jQuery('#calsado_final').val()}
			
			
			if(jQuery('input[name="olhos"]:checked')){
				var itens = jQuery('input[name="olhos"]:checked');
				var lista = new Array(itens.length);
				for(var i =0; i< itens.length;i++){
					lista[i] = itens[i].value;
				}
				dataSubmit.olhos = lista;
			}
			if(jQuery('input[name="pele"]:checked')){
				var itens = jQuery('input[name="pele"]:checked');
				var lista = new Array(itens.length);
				for(var i =0; i< itens.length;i++){
					lista[i] = itens[i].value;
				}
				dataSubmit.pele = lista;
			}
			if(jQuery('input[name="etinia"]:checked')){
				var itens = jQuery('input[name="etinia"]:checked');
				var lista = new Array(itens.length);
				for(var i =0; i< itens.length;i++){
					lista[i] = itens[i].value;
				}
				dataSubmit.etinia = lista;
			}
			if(jQuery('input[name="cabelo"]:checked')){
				var itens = jQuery('input[name="cabelo"]:checked');
				var lista = new Array(itens.length);
				for(var i =0; i< itens.length;i++){
					lista[i] = itens[i].value;
				}
				dataSubmit.cabelo = lista;
			}
			if(jQuery('input[name="tamanho_cabelo"]:checked')){
				var itens = jQuery('input[name="tamanho_cabelo"]:checked');
				var lista = new Array(itens.length);
				for(var i =0; i< itens.length;i++){
					lista[i] = itens[i].value;
				}
				dataSubmit.tamanho_cabelo = lista;
			}
			if(jQuery('input[name="cor_cabelo"]:checked')){
				var itens = jQuery('input[name="cor_cabelo"]:checked');
				var lista = new Array(itens.length);
				for(var i =0; i< itens.length;i++){
					lista[i] = itens[i].value;
				}
				dataSubmit.cor_cabelo = lista;
			}

			
			jQuery.post(Amigos.URLBuscaPerfil, dataSubmit, 
				function(html){
						AngelGirls.Processando().hide();
						if(html.trim().length>0){
							jQuery('#listaResultado').html(html);
							setTimeout(function(){
								jQuery('.thumbnail').each(function(){
									var $this = jQuery(this);
									if($this.hasClass('fade') && !$this.hasClass('in')){
										$this.addClass('in');
									}
								});
							},500); 
						}
						else{
							alert('N&atilde;o encontramos registros!');
						}

			},'html');
			return false;
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


Amigos.ExibirModeloDetalhes = function (){	
	if(jQuery('#iconeFiltroModelo').hasClass('glyphicon-plus')){
		jQuery('#extraModeloFiltros').fadeIn(500);
		
		jQuery('#iconeFiltroModelo').removeClass('glyphicon-plus');
		jQuery('#iconeFiltroModelo').addClass('glyphicon glyphicon-minus');
	}
	else{
		jQuery('#extraModeloFiltros').fadeOut(500);
		jQuery('#iconeFiltroModelo').addClass('glyphicon-plus');
		jQuery('#iconeFiltroModelo').removeClass('glyphicon glyphicon-minus');
	}
};

