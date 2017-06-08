<?php
include ('inc/includes.php');

$id =	$_REQUEST['states_id'];
PluginFieldsStatusremarkfieldDropdown::dropdown(array('value'  => '',
                               	'condition' => 'states_id='.$id
                               ));

?>