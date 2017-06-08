<?php

// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=vamt_icici_scrap.csv');

// create a file pointer connected to the output stream/
$output = fopen('php://output', 'w');
//Asset Code
// output the column headings
fputcsv($output, array('AM Name','Transfer Location','Previous Location','State Name','Asset Code', 'Asset Type', 'FCRM No.', 'ATF No','Asset Status','Status Remark','Serial','Transfer By','Transfer Date')); 

include ('inc/includes.php');
$groups_id	=	$_REQUEST['groups_id'];
$assettype	=	$_REQUEST['at'];
$assetsyear	=	$_REQUEST['ay'];

if($groups_id!=0){
    $groupqry.=' and glpi_groups.id IN ('.$groups_id.')';
}


$tables				=	array('glpi_computers','glpi_printers','glpi_peripherals','glpi_phones','glpi_networkequipments');
$pluginstable		=	array('glpi_plugin_fields_computerlocationtypes','glpi_plugin_fields_printerprintcategories','glpi_plugin_fields_peripheralscanners','glpi_plugin_fields_phonetablets','glpi_plugin_fields_networkequipmentnetworkdevices');
$typestable			=	array('glpi_computertypes','glpi_printertypes','glpi_peripheraltypes','glpi_phonetypes','glpi_networkequipmenttypes');
$typeid				=	array('computertypes_id','printertypes_id','peripheraltypes_id','phonetypes_id','networkequipmenttypes_id');

if($assettype=='1'){
	$start  = 0;
	$count 	=	1;
}elseif($assettype=='2'){
	$start  = 1;
	$count 	=	2;
}elseif($assettype=='3'){
	$start  = 2;
	$count 	=	3;	
}elseif($assettype=='4'){
	$start  = 3;
	$count 	=	4;	
}elseif($assettype=='5'){
	$start  = 4;
	$count 	=	5;	
}else{
	$start  = 0;
	$count 	=	count($tables);
}

for($i=$start;$i<$count;$i++){
	if($i==0){
		$types =	'Computer';
	}elseif($i==1){
		$types =	'Printer';
	}elseif($i==2){
		$types =	'Peripheral';	
	}elseif($i==3){
		$types =	'Phone';
	}elseif($i==4){
		$types =	'NetworkEquipment';
	}
if($assetsyear!=0){
	$groupqry.=' and '.$pluginstable[$i].'.'.$assetyear[$i].'='.$assetsyear;	
}
 $ExtraFields	=	array(
 	 $pluginstable[$i].'.ipaddressfield as ipaddress',
 	 $pluginstable[$i].'.ipaddressfield2 as ipaddress',
	 $pluginstable[$i].'.ipaddressfield3 as ipaddress',
 	 $pluginstable[$i].'.ipaddressfield5 as ipaddress',
 	 $pluginstable[$i].'.ipaddressfield4 as iipaddress'
 	);
$amnamefield  	= 	array('amnamefield2','amnamefield3','amnamefield4','amnamefield5','amnamefield');
$state  		= 	array('statefield2','statefield3','statefield4','statefield5','statefield');




    $query = "SELECT glpi_transfer.* , glpi_groups.`name` as groupname,$typestable[$i].`name` as typename,glpi_states.`name` as statesname,glpi_plugin_fields_statusremarkfielddropdowns.`name` as remarkname,glpi_transfer.`fcrmno` as fcrmnumber,glpi_transfer.`atfno` as atfno ,$ExtraFields[$i],$tables[$i].serial as serialname,$tables[$i].name as name,$pluginstable[$i].`$amnamefield[$i]` as amname,$pluginstable[$i].`$state[$i]`  as statename  FROM glpi_transfer
 				LEFT JOIN `$tables[$i]`
                    ON (glpi_transfer.`assetid` = $tables[$i].`id`)
                LEFT JOIN `$pluginstable[$i]`
                    ON ($tables[$i].`id` = $pluginstable[$i].`items_id`)
                LEFT JOIN `glpi_groups`
                    ON ($tables[$i].`groups_id` = glpi_groups.`id`
                    )      
                LEFT JOIN `$typestable[$i]`
                    ON ($tables[$i].`$typeid[$i]` = $typestable[$i].`id`)
                LEFT JOIN `glpi_states`
                    ON ($tables[$i].`states_id` = glpi_states.`id`)
                LEFT JOIN `glpi_plugin_fields_statusremarkfielddropdowns`
                    ON ($pluginstable[$i].`plugin_fields_statusremarkfielddropdowns_id` = glpi_plugin_fields_statusremarkfielddropdowns.`id`)
                    where glpi_transfer.`status`=1 and glpi_transfer.`newlocid`=17274 and glpi_transfer.`assettype`='".$types."' ".$groupqry;

      $result = $DB->request($query);
      if ($result->numrows() > 0) {
      	foreach ($result as $line) {
      		$newlocation = dropdown::getSingalDataFromDB('glpi_locations','id',$line['newlocid'],'name');
      		$oldlocation = dropdown::getSingalDataFromDB('glpi_locations','id',$line['oldlocid'],'name');
			fputcsv($output, array($line['amname'],$newlocation,$oldlocation,$line['statename'],$line['name'],$line['typename'],$line['fcrmno'],$line['atfno'],$line['statesname'],$line['remarkname'],$line['serialname'],$line['transferby'],$line['transferdate']));      		
      	}
      }
 	}
 ?>