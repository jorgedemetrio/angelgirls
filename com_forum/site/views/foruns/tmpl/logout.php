<?php


$app = JFactory::getApplication();
$error  = $app->logout();
$app->redirect(JRoute::_('index.php?option=com_angelgirls&view=home&task=homepage', false));
