<?php
include ('inc/includes.php');

$id  =	$_REQUEST['items_id'];
$typ =	$_REQUEST['typ'];
if($typ=='Printer'){

	$uuid = dropdown::getSingalDataFromDB('glpi_printers','id',$id,'contact');
	$computertypes_id = dropdown::getSingalDataFromDB('glpi_printers','id',$id,'printertypes_id');
	$consultantidfield = dropdown::getSingalDataFromDB('glpi_plugin_fields_printerprintcategories','items_id',$id,'consultantidfield2');
	$oldassettype = dropdown::getSingalDataFromDB('glpi_printertypes','id',$computertypes_id,'name');

	echo $uuid."|".$consultantidfield."|".$oldassettype;



}elseif($typ=='Computer'){

	$uuid = dropdown::getSingalDataFromDB('glpi_computers','id',$id,'uuid');
	$computertypes_id = dropdown::getSingalDataFromDB('glpi_computers','id',$id,'computertypes_id');
	$consultantidfield = dropdown::getSingalDataFromDB('glpi_plugin_fields_computerlocationtypes','items_id',$id,'consultantidfield');
	$oldassettype = dropdown::getSingalDataFromDB('glpi_computertypes','id',$computertypes_id,'name');

	echo $uuid."|".$consultantidfield."|".$oldassettype;


}elseif($typ=='Peripheral'){
	$uuid = dropdown::getSingalDataFromDB('glpi_peripherals','id',$id,'contact');
	$computertypes_id = dropdown::getSingalDataFromDB('glpi_peripherals','id',$id,'peripheralypes_id');
	$consultantidfield = dropdown::getSingalDataFromDB('glpi_plugin_fields_peripheralscanners','items_id',$id,'consultantidfield3');
	$oldassettype = dropdown::getSingalDataFromDB('glpi_peripheraltypes','id',$computertypes_id,'name');

	echo $uuid."|".$consultantidfield."|".$oldassettype;


}	
?>