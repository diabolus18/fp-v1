<?php
//call module
include(dirname(__FILE__).'/../../config/config.inc.php');
Configuration::updateValue('AWP_IMAGE_RESIZE', $_POST['resize']);
Configuration::updateValue('AWP_IMAGE_RESIZE_WIDTH', $_POST['width']);
?>