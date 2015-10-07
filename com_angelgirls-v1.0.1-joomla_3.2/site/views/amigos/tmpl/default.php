<?php

/**
 * Agendas HTML Default Template
 *
 * PHP versions 5
 *
 * @category  Template
 * @package   AngelGirls
 * @author    Jorge Demetiro <jorge.demetrio@alldreams.com.br>
 * @copyright All rights reserved.
 * @license   GNU General Public License
 * @link      http://www.alldreams.com.br
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.calendar');
//JHtml::_('dropdown.init');
//JHtml::_('behavior.keepalive');

if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&view=perfil&task=amigos&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}



$amigos = JRequest::getVar('amigos');
$perfil = JRequest::getVar('perfil');
$perfil = JRequest::getVar('perfil');
$perfil = JRequest::getVar('perfil');

$this->item = $perfil; 

$ufs = JRequest::getVar('ufs');






JFactory::getDocument()->addStyleSheet(JURI::base( true ).'/components/com_angelgirls/assets/css/form.css');
JFactory::getDocument()->addStyleSheet('//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/theme-default.min.css');


JFactory::getDocument()->addScript(JURI::base( true ).'/components/com_angelgirls/assets/js/perfil.js?v='.VERSAO_ANGELGIRLS);

//Mais informações da API em http://formvalidator.net/
JFactory::getDocument()->addScript('//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js');
JFactory::getDocument()->addStyleDeclaration('
.validate-numeric{
	text-align: right;
}
.validate-inteiro{
	text-align: right;
}
');


 ?>
<script>

var lidos = 0;
var carregando=false;
var Amigos = new Object();

Amigos.LoadAmigosURL = '<?php echo( JRoute::_('index.php?option=com_angelgirls&view=amigos&task=AmigosHTML',false));?>';
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

});

</script>
<div class="row">
<?php AngelgirlsController::GetMenuLateral(); ?>
	<div id="conteudo" class="col col-xs-12 col-sm-9 col-md-9 col-lg-10">
			<div class="page-header">
				<h1><?php echo JText::_('Amigos'); ?></h1>
			</div>	
			<br/>
			<br/>
		    <div class="clr"></div>
			<ul class="nav nav-tabs nav-justified" id="myTabTabs" role="tablist" style="margin-bottom: 0;">
				<li class="active" role="presentation">
					<a href="#amigos" data-toggle="tab" aria-controls="profile" role="tab">Meus Amigos
					<span class="glyphicon glyphicon-user" aria-hidden="true" title="Amigos"></span>
					</a>
				</li>
				<li role="presentation">
					<a href="#buscar" data-toggle="tab" aria-controls="profile" role="tab">Buscar
					<span class="glyphicon glyphicon-search" aria-hidden="true" title="Fotos"></span>
					</a>
				</li>
				<li role="presentation">
					<a href="#solicitacoes" aria-controls="profile"  data-toggle="tab">Solicita&ccedil;&otilde;es
					<span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
					</a>
				</li>
				<li role="presentation">
					<a href="#convidar" aria-controls="profile"  data-toggle="tab">Convidar
					<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
					</a>
				</li>
			</ul>
			<div class="tab-content" style="overflow: auto;">
				<div id="amigos" class="tab-pane fade in active">
					<h3><?php echo JText::_('Meus amigos'); ?></h3>
					<div class="row" id="listaAmigos">
<?php require_once 'lista_amigos.php';?>	
					</div>
					<div class="row" id="carregandoAmigos" style="display: none">
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="height: 300px; vertical-align: middle; text-align: center;" class="text-center">
							<img src="<?php echo(JURI::base( true ))?>/components/com_angelgirls/loading_img.gif" alt="carregando" title="Carregando" style="width: 450px"/>
						</div>
					</div>
				</div>
				<div id="buscar" class="tab-pane fade">
					<h3><?php echo JText::_('Buscar amigos'); ?></h3>
					<form action="<?php echo(JRoute::_('index.php?option=com_angelgirls&view=perfil&task=salvarPerfil')); ?> " method="post" name="dadosForm" id="dadosForm" class="form-validate" role="form" data-toggle="validator" enctype="multipart/form-data" >
						<?php echo JHtml::_('form.token'); ?>
					</form>
				</div>
			    <div id="solicitacoes" class="tab-pane fade">
			    	<h3><?php echo JText::_('Solicita&ccedil;&otilde;es de amizade'); ?></h3>
			    	
			    </div>
			    <div id="convidar" class="tab-pane fade">
			    	<h3><?php echo JText::_('Convidar para entrar no Angel Girls'); ?></h3>
			    </div>
			</div>
	</div>
</div>


