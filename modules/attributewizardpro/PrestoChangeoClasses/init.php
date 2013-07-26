<?php 

if (!in_array('PrestoChangeoModule', get_declared_classes()))
	require_once(dirname(__FILE__).'/PrestoChangeoModule.php');

if (!in_array('Context', get_declared_classes()))
	require_once(dirname(__FILE__).'/Context.php');