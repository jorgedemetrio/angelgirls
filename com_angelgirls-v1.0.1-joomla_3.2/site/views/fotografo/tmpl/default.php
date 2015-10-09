<?php

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );



if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=carregarSessoes&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}
JFactory::getDocument()->addStyleSheet('components/com_angelgirls/assets/css/lightbox.css');

$conteudo = JRequest::getVar('usuario');
$ultimas = JRequest::getVar('ultimas');
$vistas = JRequest::getVar('vistas');
$gostaram = JRequest::getVar('gostaram');


$total = JRequest::getVar('total');
$preferidos = JRequest::getVar('preferidos');
$tema = JRequest::getVar('tema');
$locacao = JRequest::getVar('locacao');

$letraSexo = 'o';
if(isset($conteudo->sexo)) :
	if($conteudo->sexo == 'F'):
		$letraSenhao='a';
	endif;
endif;

$urlFoto = JRoute::_('index.php?option=com_angelgirls&view=fotografo&task=loadImage&id='.$conteudo->token.':thumb');
?>
<div class="row">
<?php AngelgirlsController::GetMenuLateral(); ?>
	<div id="conteudo" class="col col-xs-12 col-sm-9 col-md-9 col-lg-10">
	<?php AngelgirlsController::getBotoesPerfil($conteudo->id_usuario, 'MODELO', $conteudo->token);?>
		<div class="page-header">
			<h1><small>Fotograf<?php echo($letraSexo);	?></small> <?php echo($conteudo->nome);?> 
			<div class="gostar" data-gostei='<?php echo($conteudo->gostei);?>' data-id='<?php echo($conteudo->id);?>' data-area='fotografo' data-gostaram='<?php echo($conteudo->audiencia_gostou);?>'></div>
			</h1>
		</div>
		<h3>Dados do fotograf<?php echo($letraSexo);	?></h3>
		<div class="row">
			<div class="col col-xs-12 col-sm-12 col-md-2 col-lg-2">
				<a class="example-image-link" href="<?php echo($urlFoto);?>" data-lightbox="example-set" data-title="<?php echo($conteudo->nome); ?>">
					<img src="<?php echo($urlFoto );?>" title="<?php echo($conteudo->nome);?>" alt="<?php echo($conteudo->nome);?>" class="img-responsive"/>
				</a>
			</div>
			<div class="col col-xs-12 col-sm-12 col-md-10 col-lg-10">
				<?php if(isset($conteudo->site)):?>
				<div class="row">
					<div class="label col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<a href="http://<?php echo($conteudo->site);?>" rel="nofollow"><?php echo($conteudo->site);?></a>
					</div>
				</div>
				<?php endif;?>
				<div class="table-responsive">
					<table class="table table-hover" >
						<thead>
							<tr>
								<th>
									Nome
								</th>
								<th>
									Nascimend<?php echo($letraSexo);	?>
								</th>	
								<th>
									Sexo
								</th>	
								<th>
									Nascionalidade
								</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="text-transform: capitalize;">
									<?php echo($conteudo->nome_completo);?>
								</td>
								<td class="text-center" style="text-transform: capitalize;">
									<?php 
									if(isset($conteudo->data_nascimento)){
										echo(JFactory::getDate($conteudo->data_nascimento)->format('d/m/Y'));
									}?>
								</td>	
								<td style="text-transform: capitalize;">
									<?php
									if(isset($conteudo->sexo)) : 
										if($conteudo->sexo == 'M'): 
											echo('masculino');
										else :
											echo('feminino');
										endif;
									endif;
									?>
								</td>
								<td style="text-transform: capitalize;">
									<?php echo($conteudo->nascionalidade);?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="table-responsive">
					<table class="table table-hover" >
						<thead>
							<tr>
								<th>
									Origem
								</th>	
								<th>
									Reside
								</th>	
								<th title="Quantidade de trabalhos realizados aqui">
									Trabalhos
								</th>
								<th title="Modelo que mais tem trabalhos">
									Modelo Fav.
								</th>
								<th title="Temas que mais usou em suas sessões">
									Tema Fav.
								</th>	
								<th title="Loca&ccedil&atilde;o preferida ">
									Loca&ccedil&atilde;o Fav.
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="text-transform: capitalize;">
									<?php 
									if(isset($conteudo->estado_nasceu) || isset($conteudo->cidade_nasceu)){
									echo($conteudo->estado_nasceu .'/'. strtolower($conteudo->cidade_nasceu));
									}?>
								</td>
								<td style="text-transform: capitalize;">
									<?php 
									if(isset($conteudo->estado_mora) || isset($conteudo->cidade_mora)){
									echo($conteudo->estado_mora .'/'. strtolower($conteudo->cidade_mora));
									}?>
								</td>
								<td class="text-center"  style="text-transform: capitalize;" title="Quantidade de trabalhos realizados aqui">
									<?php echo($total->total);?>
								</td>
								<td title="Modelo que mais tem trabalhos" style="text-transform: capitalize;">
									<?php
									foreach($preferidos as $preferido):
										$url = JRoute::_('index.php?option=com_angelgirls&task=carregarModelo&id='.$preferido->token.':modelo-'.strtolower(str_replace(" ","-",$preferido->nome)),false);
										echo('<a href="'.$url.'">'.strtolower($preferido->nome).'</a><br/>');
									endforeach;
									?>
								</td>
								<td title="Temas que mais usou em suas sessões" style="text-transform: capitalize;">
									<?php echo(strtolower($tema->nome));?>
								</td>
								<td title="Loca&ccedil&atilde;o preferida " style="text-transform: capitalize;">
									<?php echo(strtolower($locacao->nome));?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="row hidden-phone" style="margin-top: 15px;">
					<div class="col col-xs-12 col-sm-4 col-md-2 col-lg-2 text-center" style="vertical-align: middle; height: 100%">
						<div class="dropdown">
						  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    Compartilhar <span class="glyphicon glyphicon-share"></span>
						    <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						    <li><div class="fb-share-button" data-layout="button_count"></div></li>
						    <li role="separator" class="divider"></li>
						    <li><div class="vkShare" data-action="share"></div></li>
						    <li role="separator" class="divider"></li>
						    <li><div class="g-plus" data-action="share"></div></li>
						  </ul>
						</div>
					</div>
					<div  class="well col col-xs-12 col-sm-8 col-md-10 col-lg-10 text-justify">
						<p><?php echo($conteudo->descricao);?></p>
					</div>
				</div>	
			</div>
		</div>
		<h3>Ultimas sess&otilde;es</h3>
		<div class="row">
		<?php
		 foreach($ultimas as $sessao):?>
		 	<div class="thumbnail col col-xs-12 col-sm-6 col-md-4 col-lg-4" style="overflow: hidden;">
		 <?php 
		 	$url = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessao&id='.$sessao->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$sessao->alias)),false);
		 	$urlImg = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=loadImage&id='.$sessao->id.':ico'); 	
		 	?>
		 		<a href="<?php echo($url);?>"><img src="<?php echo($urlImg);?>" title="<?php echo($sessao->nome);?>" alt="<?php echo($sessao->nome);?>" style="height: 150px;"/></a>
		 		<div class="caption">
		 			<h4 class="list-group-item-heading"><a href="<?php echo($url);?>"><?php echo($sessao->nome);?></a></h4>
		 			<p>
		 				<div class="fb-share-button" data-href="<?php echo('http://'.$_SERVER['HTTP_HOST'] . $url);?>" data-layout="button_count"></div>
		 				<div class="g-plus" data-action="share" data-href="<?php echo('http://'.$_SERVER['HTTP_HOST'] . $url);?>"></div>
		 				<div class="vkShare" data-action="share" data-href="<?php echo('http://'.$_SERVER['HTTP_HOST'] . $url);?>"></div>
		 			</p>
		 			<p><?php echo($sessao->descricao);?></p>
		 			<p class="text-center"><a href="<?php echo($url);?>" class="btn btn-info" role="button" style="text-overflow: ellipsis;max-width: 80%;  overflow: hidden;  direction: ltr;"><?php echo($sessao->nome);?></a></p>
		 		</div>
		 	</div><?php 
		 endforeach;
		?>
		</div>
		<h3>Sess&otilde;es que mais gostaram</h3>
		<div class="row">
		<?php
		 foreach($gostaram as $sessao):?>
		 	<div class="thumbnail col col-xs-12 col-sm-6 col-md-4 col-lg-4" style="overflow: hidden;">
		 <?php 
		 	$url = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessao&id='.$sessao->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$sessao->alias)),false);
		 	$urlImg = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=loadImage&id='.$sessao->id.':ico'); 	
		 	?>
		 		<a href="<?php echo($url);?>"><img src="<?php echo($urlImg);?>" title="<?php echo($sessao->nome);?>" alt="<?php echo($sessao->nome);?>" style="height: 150px;"/></a>
		
		 		<div class="caption">
		 			<h4 class="list-group-item-heading"><a href="<?php echo($url);?>"><?php echo($sessao->nome);?></a></h4>
		 			<p>
		 				<div class="fb-share-button" data-href="<?php echo('http://'.$_SERVER['HTTP_HOST'] . $url);?>" data-layout="button_count"></div>
		 				<div class="g-plus" data-action="share" data-href="<?php echo('http://'.$_SERVER['HTTP_HOST'] . $url);?>"></div>
		 				<div class="vkShare" data-action="share" data-href="<?php echo('http://'.$_SERVER['HTTP_HOST'] . $url);?>"></div>
		 			</p>
		 			<p><?php echo($sessao->descricao);?></p>
		 			<p class="text-center"><a href="<?php echo($url);?>" class="btn btn-info" role="button" style="text-overflow: ellipsis;max-width: 80%;  overflow: hidden;  direction: ltr;"><?php echo($sessao->nome);?></a></p>
		 		</div>
		 	</div><?php 
		 endforeach;
		?>
		</div>
		<h3>Sess&otilde;es mais acessadas</h3>
		<div class="row">
		<?php
		 foreach($vistas as $sessao):?>
		 	<div class="thumbnail col col-xs-12 col-sm-6 col-md-4 col-lg-4" style="overflow: hidden;">
		 <?php 
		 	$url = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessao&id='.$sessao->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$sessao->alias)),false);
		 	$urlImg = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=loadImage&id='.$sessao->id.':ico'); 	
		 	?>
		 		<a href="<?php echo($url);?>"><img src="<?php echo($urlImg);?>" title="<?php echo($sessao->nome);?>" alt="<?php echo($sessao->nome);?>" style="height: 150px;"/></a>
		
		 		<div class="caption">
		 			<h4 class="list-group-item-heading"><a href="<?php echo($url);?>"><?php echo($sessao->nome);?></a></h4>
		 			<p>
		 				<div class="fb-share-button" data-href="<?php echo('http://'.$_SERVER['HTTP_HOST'] . $url);?>" data-layout="button_count"></div>
		 				<div class="g-plus" data-action="share" data-href="<?php echo('http://'.$_SERVER['HTTP_HOST'] . $url);?>"></div>
		 				<div class="vkShare" data-action="share" data-href="<?php echo('http://'.$_SERVER['HTTP_HOST'] . $url);?>"></div>
		 			</p>
		 			<p><?php echo($sessao->descricao);?></p>
		 			<p class="text-center"><a href="<?php echo($url);?>" class="btn btn-info" role="button" style="text-overflow: ellipsis;max-width: 80%;  overflow: hidden;  direction: ltr;"><?php echo($sessao->nome);?></a></p>
		 		</div>
		 	</div><?php 
		 endforeach;
		?>
		</div>
		<h3>Coment&aacute;rios</h3>
		<div class="fb-comments" data-href="http://<?php echo($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']); ?>" data-width="100%" style="margin: 0 auto;"></div>
	</div>
</div>

<script src="<?php echo(JURI::base( true ))?>/components/com_angelgirls/assets/js/lightbox.js" type="text/javascript" ></script>