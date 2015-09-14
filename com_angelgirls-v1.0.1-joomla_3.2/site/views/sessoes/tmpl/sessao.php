<?php

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );



if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=carregarSessoes&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}


$conteudo = JRequest::getVar('sessao');
$fotos = JRequest::getVar('fotos');
$id = JRequest::getInt('id');


// $query->select('`s`.`id`,`s`.`titulo`,`s`.`nome_foto`,`s`.`executada`,`s`.`descricao`,`s`.`historia`,`s`.`comentario_fotografo`,`s`.`comentario_modelos`,
// 						`s`.`comentario_equipe`,`s`.`meta_descricao`,`s`.`id_agenda`,`s`.`id_tema`,`s`.`id_modelo_principal`,`s`.`id_modelo_secundaria`,
// 						`s`.`id_locacao`,`s`.`id_fotografo_principal`,`s`.`id_fotografo_secundario`,`s`.`id_figurino_principal`,`s`.`id_figurino_secundario`,
// 						`s`.`audiencia_gostou`,`s`.`audiencia_ngostou`,`s`.`audiencia_view`,`s`.`publicar`,`s`.`status_dado`,`s`.`id_usuario_criador`,
// 						`s`.`id_usuario_alterador`,`s`.`data_criado`,`s`.`data_alterado`,
// 						`tema`.`nome` AS `nome_tema`,`tema`.`descricao` AS `descricao_tema`,`tema`.`nome_foto` AS `foto_tema`,`tema`.`audiencia_gostou` AS `gostou_tema`,
// 						CASE isnull(`vt_sessao`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_sessa`,
// 						CASE isnull(`vt_fo1`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_fot1`,
// 						CASE isnull(`vt_fo2`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_fot2`,
// 						CASE isnull(`mod1`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_mod1`,
// 						CASE isnull(`mod2`.`data_criado` ) WHEN 1 THEN \'NAO\' ELSE \'SIM\' END AS `gostei_mod2`,
// 						`fot1`.`nome_artistico` AS `fotografo1`,`fot1`.`audiencia_gostou` AS `gostou_fot1`,`fot1`.`nome_foto` AS `foto_fot1`,
// 						`fot2`.`nome_artistico` AS `fotografo2`,`fot2`.`audiencia_gostou` AS `gostou_fot2`,`fot2`.`nome_foto` AS `foto_fot2`,
// 						`loc`.`nome` AS `nome_locacao`,`loc`.`nome_foto` AS `foto_locacao`,`loc`.`audiencia_gostou` AS `gostou_locacao`,
// 						`mod1`.`nome_artistico` AS `modelo1`,`mod1`.`foto_perfil` AS `foto_mod1`,`mod1`.`audiencia_gostou` AS `gostou_mo1`,
// 						`mod2`.`nome_artistico` AS `modelo2`,`mod2`.`foto_perfil` AS `foto_mod2`,`mod2`.`audiencia_gostou` AS `gostou_mo2`,
// 						`fig1`.`titulo` AS `figurino1`,`fig1`.`audiencia_gostou` AS `gostou_fig1`,
// 						`fig2`.`titulo` AS `figurino2`,`fig2`.`audiencia_gostou` AS `gostou_fig2`')
?>
<div class="page-header">
	<h1><?php echo($conteudo->titulo);?>
	<small><?php echo($conteudo->nome_tema);?></small>
	<?php if($conteudo->gostei_sessa=='SIM'):?>
		<span class="badge" title="Gostou"><?php echo($conteudo->audiencia_gostou);?> 
		<span class="glyphicon glyphicon-star" aria-hidden="true" title="Gostou"></span>
		</span>
	<?php else : ?>
		<span class="badge" title=""><?php echo($conteudo->audiencia_gostou);?> 
		<span class="glyphicon glyphicon-heart-empty" aria-hidden="true" title=""></span>
		</span>
	<?php endif?></h1>

</div>

<ul class="nav nav-tabs nav-justified" id="myTabTabs" role="tablist" style="margin-bottom: 0;">
	<li class="active" role="presentation">
		<a href="#general" data-toggle="tab" aria-controls="profile" role="tab">Detalhe sess&atilde;o
		<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
		</a>
	</li>
	<li role="presentation">
		<a href="#modelos" data-toggle="tab" aria-controls="profile" role="tab">Modelo(s)
		<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
		</a>
	</li>
	<li role="presentation">
		<a href="#fotografos" data-toggle="tab" aria-controls="profile" role="tab">Fotografo(s)
		<span class="glyphicon glyphicon-camera" aria-hidden="true"></span>
		</a>
	</li>
</ul>

<div id="detalhesSessao" class="tab-content" style="overflow: auto;">
	<div id="general" class="tab-pane fade in active" style="height: 170px;">
		<h2>Detalhe sess&atilde;o</h2>
		<div class="row">
			<div class="label col col-xs-12 col-sm-3 col-md-3 col-lg-3">
		    	Tema
			</div>
			<div class="label col col-xs-12 col-sm-2 col-md-2 col-lg-3">
		    	Figurino
			</div>
			<div class="label col col-xs-12 col-sm-3 col-md-3 col-lg-4">
		    	Local
			</div>
			<div class="label col col-xs-12 col-sm-2 col-md-2 col-lg-1">
		    	Realizado
			</div>		
			<div class="label col col-xs-12 col-sm-2 col-md-2 col-lg-1">
		    	Publicado
			</div>		
		</div>
		<div class="row">
			<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-3 text-center">
		    	<?php echo($conteudo->nome_tema)?>
			</div>
			<div class="col col-xs-12 col-sm-3 col-md-2 col-lg-3 text-center">
		    	<?php echo($conteudo->figurino1 . isset($conteudo->figurino2)?', '.$conteudo->figurino2:'' )?>
			</div>
			<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-4 text-center">
		    	<?php echo($conteudo->nome_locacao )?>
			</div>
			<div class="col col-xs-12 col-sm-3 col-md-2 col-lg-1 text-center">
		    	<?php echo(JFactory::getDate($conteudo->executada)->format('d/m/Y')); ?>
			</div>
			<div class="col col-xs-12 col-sm-3 col-md-2 col-lg-1 text-center">
		    	<?php echo(JFactory::getDate($conteudo->publicar)->format('d/m/Y')); ?>
			</div>
		</div>
		<div class="row">
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 well">
		    	<?php echo($conteudo->descricao )?>
			</div>
		</div>    
	</div>
<?php $urlBusca = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessoes&id=sessoes-fotos-sensuais',false); ?>
	<div id="modelos" class="tab-pane fade in" style="height: 170px;">
		<h2>Modelo(s)</h2>
		<div class="row">
			<div class="col col-xs-12 col-sm-2 col-md-2 col-lg-1 text-center">
			<?php $url = JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$conteudo->id_modelo_principal.':modelo-'.strtolower(str_replace(" ","-",$conteudo->modelo1)),false); ?>
				<a href="<?php echo($url); ?>" href="<?php echo($url); ?>" title="Modelo <?php echo($conteudo->modelo1);?>">
					<img src="<?php echo(JURI::base( true ));?>/images/modelos/<?php echo($conteudo->foto_mod1);?>" title="Modelo <?php echo($conteudo->modelo1);?>" alt="Modelo <?php echo($conteudo->modelo1);?>" class="img-circle">
				</a>
			</div>
			<?php if(isset($conteudo->modelo2)) : ?>
			<div class="col col-xs-12 col-sm-4 col-md-4 col-lg-5">
			<?php else :?>
			<div class="col col-xs-12 col-sm-10 col-md-10 col-lg-11">
			<?php endif; ?>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<h3><a href="<?php echo($url); ?>" title="Modelo <?php echo($conteudo->modelo1);?>">
				    	<?php echo($conteudo->modelo1); ?> 
						</a>			    	
				    	<?php if($conteudo->gostei_mod1=='SIM'):?>
							<span class="badge" title="Gostou"><?php echo($conteudo->gostou_mo1);?> 
							<span class="glyphicon glyphicon-heart" aria-hidden="true" title="Gostou"></span>
							</span>
						<?php else : ?>
							<span class="badge" title=""><?php echo($conteudo->gostou_mo1);?> 
							<span class="glyphicon glyphicon-heart-empty" aria-hidden="true" title=""></span>
							</span>
						<?php endif?></h3>
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
				    	<?php echo($conteudo->desc_mo1); ?> 
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<a href="<?php echo($urlBusca);?>?id_modelo=<?php echo($conteudo->id_modelo_principal);?>" class="btn">Mais sess&otilde;es desta modelo</a>
					</div>
				</div>			
			</div>
			<?php if(isset($conteudo->modelo2)) : ?>
			<div class="col col-xs-12 col-sm-4 col-md-4 col-lg-1 text-center">
			<?php $url = JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$conteudo->id_modelo_secundaria.':modelo-'.strtolower(str_replace(" ","-",$conteudo->modelo2)),false); ?>
				<a href="<?php echo($url); ?>" title="Modelo <?php echo($conteudo->modelo2);?>">
					<img src="<?php echo(JURI::base( true ));?>/images/modelos/<?php echo($conteudo->foto_mod2);?>" title="Modelo <?php echo($conteudo->modelo2);?>" alt="Modelo <?php echo($conteudo->modelo2);?>" class="img-circle">
				</a>
			</div>
			<div class="col col-xs-12 col-sm-5 col-md-5 col-lg-5">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<h3><a href="<?php echo($url); ?>" title="Modelo <?php echo($conteudo->modelo2);?>">
				    	<?php echo($conteudo->modelo2); ?> 
						</a>			    	
				    	<?php if($conteudo->gostei_mod1=='SIM'):?>
							<span class="badge" title="Gostou"><?php echo($conteudo->gostou_mo2);?> 
							<span class="glyphicon glyphicon-heart" aria-hidden="true" title="Gostou"></span>
							</span>
						<?php else : ?>
							<span class="badge" title=""><?php echo($conteudo->gostou_mo2);?> 
							<span class="glyphicon glyphicon-heart-empty" aria-hidden="true" title=""></span>
							</span>
						<?php endif?></h3>
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
				    	<?php echo($conteudo->desc_mo2); ?> 
					</div>
				</div>	
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<a href="<?php echo($urlBusca);?>?id_modelo=<?php echo($conteudo->id_modelo_secundaria);?>" class="btn">Mais sess&otilde;es desta modelo</a>
					</div>
				</div>	
			</div>
			<?php endif; ?>
		</div>
		<div class="row">
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
		    	<?php echo($conteudo->comentario_modelos)?>
			</div>	
		</div>
    </div>
    <div id="fotografos" class="tab-pane fade in" style="height: 170px;">
		<h2>Fotografo(s)</h2>
		<div class="row">
			<div class="col col-xs-12 col-sm-2 col-md-2 col-lg-1 text-center">
			<?php $url = JRoute::_('index.php?option=com_angelgirls&task=carregarFotografo&id='.$conteudo->id_fotografo_principal.':fotografo-'.strtolower(str_replace(" ","-",$conteudo->fotografo1)),false); ?>
				<a href="<?php echo($url); ?>" title="Fotografo(a) <?php echo($conteudo->fotografo1);?>">
					<img src="<?php echo(JURI::base( true ));?>/images/fotografos/<?php echo($conteudo->foto_mod1);?>" title="Fotografo(a) <?php echo($conteudo->fotografo1);?>" alt="Fotografo(a) <?php echo($conteudo->fotografo1);?>" class="img-circle">
				</a>
			</div>
			<?php if(isset($conteudo->fotografo2)) : ?>
			<div class="col col-xs-12 col-sm-4 col-md-4 col-lg-5">
			<?php else :?>
			<div class="col col-xs-12 col-sm-10 col-md-10 col-lg-11">
			<?php endif; ?>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<h3><a href="<?php echo($url); ?>"  title="Fotografo(a) <?php echo($conteudo->fotografo1);?>">
				    	<?php echo($conteudo->fotografo1); ?> 
						</a>			    	
				    	<?php if($conteudo->gostei_fot1=='SIM'):?>
							<span class="badge" title="Gostou"><?php echo($conteudo->gostou_fot1);?> 
							<span class="glyphicon glyphicon-heart" aria-hidden="true" title="Gostou"></span>
							</span>
						<?php else : ?>
							<span class="badge" title=""><?php echo($conteudo->gostou_fot1);?> 
							<span class="glyphicon glyphicon-heart-empty" aria-hidden="true" title=""></span>
							</span>
						<?php endif?></h3>
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
				    	<?php echo($conteudo->desc_fot1); ?> 
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<a href="<?php echo($urlBusca);?>?id_fotografo=<?php echo($conteudo->id_fotografo_principal);?>" class="btn">Mais sess&otilde;es deste(a) fotorgafo(a)</a>
					</div>
				</div>	
			</div>
			<?php if(isset($conteudo->fotografo2)) : ?>
			<div class="col col-xs-12 col-sm-4 col-md-4 col-lg-1 text-center">
			<?php $url = JRoute::_('index.php?option=com_angelgirls&task=carregarFotografo&id='.$conteudo->id_fotografo_secundaria.':fotografo-'.strtolower(str_replace(" ","-",$conteudo->fotografo2)),false); ?>
				<a href="<?php echo($url); ?>"  title="Fotografo(a) <?php echo($conteudo->fotografo2);?>">
					<img src="<?php echo(JURI::base( true ));?>/images/fotografos/<?php echo($conteudo->foto_mod2);?>" title="Fotografo(a) <?php echo($conteudo->fotografo2);?>" alt="Fotografo(a) <?php echo($conteudo->fotografo2);?>" class="img-circle">
				</a>
			</div>
			<div class="col col-xs-12 col-sm-5 col-md-5 col-lg-5">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<h3><a href="<?php echo($url); ?>" title="Fotografo(a) <?php echo($conteudo->fotografo2);?>">
				    	<?php echo($conteudo->fotografo2); ?> 
						</a>			    	
				    	<?php if($conteudo->gostei_fot1=='SIM'):?>
							<span class="badge" title="Gostou"><?php echo($conteudo->gostou_fot2);?> 
							<span class="glyphicon glyphicon-heart" aria-hidden="true" title="Gostou"></span>
							</span>
						<?php else : ?>
							<span class="badge" title=""><?php echo($conteudo->gostou_fot2);?> 
							<span class="glyphicon glyphicon-heart-empty" aria-hidden="true" title=""></span>
							</span>
						<?php endif?></h3>
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
				    	<?php echo($conteudo->desc_mo2); ?> 
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<a href="<?php echo($urlBusca);?>?id_fotografo=<?php echo($conteudo->id_fotografo_secundaria);?>" class="btn">Mais sess&otilde;es deste(a) fotorgafo(a)</a>
					</div>
				</div>	
			</div>
			<?php endif; ?>
		</div>
		<div class="row">
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
		    	<?php echo($conteudo->comentario_fotografo)?>
			</div>	
		</div>
	</div>
</div>
<h2>Fotos</h2>
<div class="row"  id="linha">
	<?php
	$count = 0;
	foreach($fotos as $foto): 
		$url = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarFoto&id='.$foto->id.':'.strtolower(str_replace(" ","-",$foto->titulo))); 
		$urlFoto = JRoute::_('index.php?option=com_angelgirls&view=fotosessao&task=loadImage&id='.$foto->id.':'.$conteudo->id.'-thumbnail'); ?>

		<div class="col col-xs-12 col-sm-3 col-md-3 col-lg-2 thumbnail">
    		<a href="<?php echo($url);?>"><img src="<?php echo($urlFoto);?>" /></a>
    	</div>
	<?php
	endforeach; 
	?>
</div>
<div class="row" id="carregando" style="display: none">
	<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="height: 300px; vertical-align: middle; text-align: center;" class="text-center">
		<img src="<?php echo(JURI::base( true ))?>/components/com_angelgirls/loading_img.gif" alt="carregando" title="Carregando" style="width: 450px"/>
	</div>
</div>
<script>
var lidos = <?php echo(sizeof($fotos));?>;
var carregando = false;
var temMais=false;
jQuery(document).ready(function() {

	if(lidos>=24){
		jQuery('#carregando').css('display','');
		temMais=true;
	}
	else{
		jQuery('#carregando').css('display','none');
		temMais=false;
	}
	
	
	jQuery(document).scroll(function(){
		 if( (jQuery(window).height()+jQuery(this).scrollTop()+300) >= jQuery(document).height() && !carregando && temMais) {
			carregando = true;
			jQuery.post('<?php echo(JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarFotosContinuaHtml&id='.$conteudo->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$conteudo->titulo)),false)); ?>',
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
				}		
				carregando=false;					
			},'html');
		 }
	});
});
</script>