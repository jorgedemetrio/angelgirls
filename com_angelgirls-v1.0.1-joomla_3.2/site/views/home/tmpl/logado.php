<?php
// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );

if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=listTema', false ), "" );
	exit ();
}
$conteudos = JRequest::getVar ( 'conteudos' );
$perfil = JRequest::getVar ( 'perfil' );
?>
<script>

	AngelGirls.URLPost = '<?php echo(JRoute::_('index.php?option=com_angelgirls&view=post&task=salvarPostJson',false));?>';
	AngelGirls.URLRemovePost = '<?php echo(JRoute::_('index.php?option=com_angelgirls&view=post&task=excluirPostJson',false));?>';

	jQuery(document).ready(function (){
		AngelGirls.PostItEffects();
	});
	
	function removerPost(id){
		AngelGirls.Processando().show();
		jQuery.post(AngelGirls.URLRemovePost,{ id: id},
		function(dado){
			AngelGirls.Processando().hide();
			if(dado.ok=='ok'){
				jQuery("div[data-id='"+id+"']").remove();
			}
			else{
				alert(dado.mensagem);
			}
		},'json');
	} 
	function enviarPost(id){
		AngelGirls.Processando().show();
		jQuery.post(AngelGirls.URLPost,{texto: jQuery('#texto').val(), id: id},
		function(dado){
			AngelGirls.Processando().hide();
			if(dado.ok=='ok'){
				var $combo = '<div class="dropdown pull-right"><button class="btn btn-default dropdown-toggle" type="button" id="opcoesPost" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" ' +
					  	' title="Op&ccedil;&otile;es de edi&ccedil;&atile;o"><span class="glyphicon glyphicon-cog"></span><span class="caret"></span></button> <ul class="dropdown-menu" aria-labelledby="opcoesPost"> ' +
					    '<li><a href="JavaScript: removerPost(\''+dado.id2+'\')"><span class="glyphicon glyphicon-remove-circle" style="color:red"></span> Remover</a></li></ul></div>';
				jQuery('.content').first().before('<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-3 content"  data-id="'+dado.id2+'" data-tipo="POST" data-data="'+(new Date())+'"><div class="thumbnail content-thumbnail">'+$combo+'<div class="caption" style="display:inline-block;"><h4><div class="gostar pull-right" data-gostei="NAO" data-id="'+dado.id2+'" data-area="POST" data-gostaram="0"></div></h4><p>'+jQuery('#texto').val()+'</p></div></div></div>');
				AngelGirls.ResetGostar();
				jQuery('#texto').val('');
			}
			else{
				alert(dado.mensagem);
			}
		},'json');
		return false;
	}
</script>
<div class="row">
	
<?php AngelgirlsController::GetMenuLateral(); ?>
	<div id="conteudo" class="col col-xs-12 col-sm-9 col-md-9 col-lg-10">
		<div class="thumbnail">
			<form action="" onsubmit="JavaScript: return enviarPost(null);">
				<div class="form-group">
					<label class="control-label"  for="texto"><?php echo JText::_('O que gostaria de falar?'); ?></label>
					<textarea rows="5" cols="20" id="texto" style="width: 80%" name="texto" required="required" maxlength="2000" minlength="2"
					title="<?php echo JText::_('O que est&aacute; pensado?'); ?>" 
					placeholder="<?php echo JText::_('O que est&aacute; pensado?'); ?>"></textarea>
					<div class="btn-toolbar pull-right" role="group">
						<div class="btn-group" role="group">
							<button  class="btn btn-success" type="submit" id="EnviarPost">Enviar
								<span class="glyphicon glyphicon-send" aria-hidden="true"></span>
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class='row'>
<?php	foreach ($conteudos as $conteudo):
			$url ='';
			$urlImg ='';
			$tipoGostar=null;
			$titulo = '';
			$botao = '';
			$area = strtolower($conteudo->tipo);
			$audiencia = $conteudo->audiencia;
			switch( $conteudo->tipo){
				case 'POST';
					$url = null;
					$urlImg = null;
					?>
					<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-3 content"  data-id="<?php echo($conteudo->token);?>" data-tipo="<?php echo($conteudo->tipo);?>" data-data="<?php echo($conteudo->data_publicado);?>">
						<div class="thumbnail content-thumbnail content-post jquery-shadow-perspective">
							<div class="caption" style="display:inline-block; width: 100%; overflow: hidden;">
								<?php if($perfil->id_usuario == $conteudo->opt1) :?>
								<div class="dropdown pull-right">
								  <button class="btn btn-default dropdown-toggle" type="button" id="opcoesPost" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"
								  	title="Op&ccedil;&otile;es de edi&ccedil;&atile;o">
								    <span class="glyphicon glyphicon-cog"></span>
								    <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu" aria-labelledby="opcoesPost">
								    <li><a href="JavaScript: removerPost('<?php echo($conteudo->token);?>')"><span class="glyphicon glyphicon-remove-circle" style="color:red"></span> Remover</a></li>
								    <!-- li><a href="#"><span class="glyphicon glyphicon-edit" style="color:blue"></span> Alterar</a></li-->
								  </ul>
								</div>
								<?php endif;?>
								<h4><a href="<?php 
								$tipoPessoa = strtolower( $conteudo->autor2);
								echo(JRoute::_('index.php?option=com_angelgirls&view='.$tipoPessoa.'&task='.$tipoPessoa.'&id='.$conteudo->autorid1.':'.$tipoPessoa.'-'.strtolower(str_replace(" ","-",$conteudo->autor1)),false));?>">
								<?php echo(JText::_('Por') . ' ' .  $conteudo->autor1) ; ?> 
								</a></h4>
								<p>
								<div class="gostar pull-right" data-gostei='<?php echo($conteudo->gostei);?>' data-id='<?php echo($conteudo->id);?>' data-area='<?php echo($area); ?>' data-gostaram='<?php echo($conteudo->audiencia);?>'></div>
									<small><small><?php echo(JFactory::getDate($conteudo->data_publicado)->format('d/m/Y H:i'));?></small> </small> 
								</p>
								<p><?php echo($conteudo->descricao);?></p>
								
							</div>
						</div>
					</div>
<?php				break;
				case 'CONTENT';
					$url = JRoute::_(ContentHelperRoute::getArticleRoute($conteudo->opt1, $conteudo->opt2, $conteudo->opt3));
					$urlImg = $conteudo->opt4 != ''? JURI::base( true ) . '/' . $conteudo->opt4:null;
					$titulo = $conteudo->titulo;
					?>
					<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-3 content"  data-id="<?php echo($conteudo->token);?>" data-tipo="<?php echo($conteudo->tipo);?>" data-data="<?php echo($conteudo->data_publicado);?>">
						<div class="thumbnail content-thumbnail ">
							<?php if(isset($urlImg)) : ?>
							<a href="<?php echo($url); ?>">
								<img class="img-responsive" style="width: 90%;  margin: 10px; display:inline-block;"
									src="<?php echo($urlImg);?>" title="<?php echo($conteudo->titulo);?>" alt="<?php echo($conteudo->titulo);?>"/>
							</a>
							<?php endif;?>
							<div class="caption" style="display:inline-block;">
								<h4><a href="<?php echo($url);?>"><?php echo($titulo);?></a> 
								</h4>
								<p><?php echo($conteudo->descricao);?></p>
							</div>
						</div>
					</div>
<?php				break;
				case 'SESSOES';
					$url = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=carregarSessao&id='.$conteudo->id.':sessao-fotografica-'.strtolower(str_replace(" ","-",$conteudo->titulo)),false);
					$urlImg = JRoute::_('index.php?option=com_angelgirls&view=sessoes&task=loadImage&id='.$conteudo->token.':thumb');
					$titulo = $conteudo->titulo;
					$area ='sessao';?>
					<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-3 content"  data-id="<?php echo($conteudo->token);?>" data-tipo="<?php echo($conteudo->tipo);?>" data-data="<?php echo($conteudo->data_publicado);?>">
						<div class="thumbnail content-thumbnail ">
							<?php if(isset($urlImg)) : ?>
							<a href="<?php echo($url); ?>">
								<img class="img-responsive" style="width: 90%;  margin: 10px; display:inline-block;"
									src="<?php echo($urlImg);?>" title="<?php echo($conteudo->titulo);?>" alt="<?php echo($conteudo->titulo);?>"/>
							</a>
							<?php endif;?>
							<div class="caption" style="display:inline-block;">
								<h4><a href="<?php echo($url);?>"><?php echo($titulo);?></a> 
								<div class="gostar" data-gostei='<?php echo($conteudo->gostei);?>' data-id='<?php echo($conteudo->id);?>' data-area='<?php echo($area); ?>' data-gostaram='<?php echo($conteudo->audiencia);?>'></div>
								</h4>
								<p><?php echo($conteudo->descricao);?></p>
							</div>
						</div>
					</div>
<?php				break;
				case 'MODELO';
					$url = JRoute::_('index.php?option=com_angelgirls&view=modelo&task=modelo&id='.$conteudo->token.':modelo-'.strtolower(str_replace(" ","-",$conteudo->titulo)),false);
					$urlImg = JRoute::_('index.php?option=com_angelgirls&view=modelo&task=loadImage&id='.$conteudo->token.':thumb');
					$titulo = 'Voc&ecirc; j&aacute; conhece a modelo ' . $conteudo->titulo . '?';
					$botao = '<p class="text-center"><a href="'. $url .'" class="btn">Conhe&ccedil;a os trabalhos dessa musa.</a></p>';?>
					<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-3 content"  data-id="<?php echo($conteudo->token);?>" data-tipo="<?php echo($conteudo->tipo);?>" data-data="<?php echo($conteudo->data_publicado);?>">
						<div class="thumbnail content-thumbnail ">
							<?php if(isset($urlImg)) : ?>
							<a href="<?php echo($url); ?>">
								<img class="img-responsive" style="width: 90%;  margin: 10px; display:inline-block;"
									src="<?php echo($urlImg);?>" title="<?php echo($conteudo->titulo);?>" alt="<?php echo($conteudo->titulo);?>"/>
							</a>
							<?php endif;?>
							<div class="caption" style="display:inline-block;">
								<h4><a href="<?php echo($url);?>"><?php echo($titulo);?></a> 
								<div class="gostar" data-gostei='<?php echo($conteudo->gostei);?>' data-id='<?php echo($conteudo->id);?>' data-area='<?php echo($area); ?>' data-gostaram='<?php echo($conteudo->audiencia);?>'></div>
								</h4>
								<p><?php echo($conteudo->descricao);?></p>
								<?php echo($botao);?>
							</div>
						</div>
					</div>
<?php				break;
				default?>
					<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-3 content"  data-id="<?php echo($conteudo->token);?>" data-tipo="<?php echo($conteudo->tipo);?>" data-data="<?php echo($conteudo->data_publicado);?>">
						<div class="thumbnail content-thumbnail ">
							<?php if(isset($urlImg)) : ?>
							<a href="<?php echo($url); ?>">
								<img class="img-responsive" style="width: 90%;  margin: 10px; display:inline-block;"
									src="<?php echo($urlImg);?>" title="<?php echo($conteudo->titulo);?>" alt="<?php echo($conteudo->titulo);?>"/>
							</a>
							<?php endif;?>
							<div class="caption" style="display:inline-block;">
								<h4><a href="<?php echo($url);?>"><?php echo($titulo);?></a> 
								</h4>
								<p><?php echo($conteudo->descricao);?></p>
								<?php echo($botao);?>
							</div>
						</div>
					</div>
<?php				break;
			}
		endforeach;?>
		</div>
	</div>
</div>