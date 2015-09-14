<?php

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );



if (JRequest::getVar ( 'task' ) == null || JRequest::getVar ( 'task' ) == '') {
	$mainframes = JFactory::getApplication ();
	$mainframes->redirect ( JRoute::_ ( 'index.php?option=com_angelgirls&task=carregarSessoes&Itemid='.JRequest::getVar ( 'Itemid' ), false ), "" );
	exit ();
}

//http://osvaldas.info/image-lightbox-responsive-touch-friendly
JFactory::getDocument()->addScript('components/com_angelgirls/assets/js/imagelightbox.min.js');
JFactory::getDocument()->addScriptDeclaration('
 $( function()
    {
        $( \'a\' ).imageLightbox({allowedTypes:\'jpg|jpeg\'});
    });');

// selector:       'id="imagelightbox"',   // string;
// allowedTypes:   'png|jpg|jpeg|gif',     // string;
// animationSpeed: 250,                    // integer;
// preloadNext:    true,                   // bool;            silently preload the next image
// enableKeyboard: true,                   // bool;            enable keyboard shortcuts (arrows Left/Right and Esc)
// quitOnEnd:      false,                  // bool;            quit after viewing the last image
// quitOnImgClick: false,                  // bool;            quit when the viewed image is clicked
// quitOnDocClick: true,                   // bool;            quit when anything but the viewed image is clicked
// onStart:        false,                  // function/bool;   calls function when the lightbox starts
// onEnd:          false,                  // function/bool;   calls function when the lightbox quits
// onLoadStart:    false,                  // function/bool;   calls function when the image load begins
// onLoadEnd:      false                   // function/bool;   calls function when the image finishes loading
$foto = JRequest::getVar('foto');
$fotos = JRequest::getVar('fotos');
$urlFoto = JRoute::_('index.php?option=com_angelgirls&view=fotosessao&task=loadImage&id='.$foto->id.':'.$foto->id_sessao.'thumbnail');


?>
