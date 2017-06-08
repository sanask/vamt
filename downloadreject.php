<?php

// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=vamt_icici_rejected.csv');

// create a file pointer connected to the output stream/
$output = fopen('php://output', 'w');
//Asset Code
// output the column headings
fputcsv($output, array('Asset Code','IP address', 'Asset Type', 'Asset Status','Status Remark','Serial','Group','Comments','Rejected Comments','Make','Model','Location Name','Added By')); 

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

$modelid      = array('computermodels_id','printermodels_id','peripheralmodels_id','phonemodels_id','networkequipmentmodels_id');
$amnamefield    =   array('amnamefield2','amnamefield3','amnamefield4','amnamefield5','amnamefield');
$modelstable    = array('glpi_computermodels','glpi_printermodels','glpi_peripheralmodels','glpi_phonemodels','glpi_networkequipmentmodels');

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

if($assetsyear!=0){
	$groupqry.=' and '.$pluginstable[$i].'.'.$assetyear[$i].'='.$assetsyear;	
}

    $query = "SELECT $tables[$i].* , glpi_groups.`name` as groupname,$typestable[$i].`name` as typename,glpi_states.`name` as statesname,glpi_plugin_fields_statusremarkfielddropdowns.`name` as remarkname,$tables[$i].serial as serialname,$tables[$i].name as name,$pluginstable[$i].`$amnamefield[$i]` as amname,$modelstable[$i].`name` as modelname,glpi_manufacturers.`name` as makename ,glpi_locations.`name` as location FROM $tables[$i]
 				LEFT JOIN `$pluginstable[$i]`
                    ON ($tables[$i].`id` = $pluginstable[$i].`items_id`)
                LEFT JOIN `glpi_groups`
                    ON ($tables[$i].`groups_id` = glpi_groups.`id`
                    )
                LEFT JOIN `glpi_manufacturers`
                    ON ($tables[$i].`manufacturers_id` = glpi_manufacturers.`id`)
                LEFT JOIN `$modelstable[$i]`
                    ON ($tables[$i].`$modelid[$i]` = $modelstable[$i].`id`)
                LEFT JOIN `glpi_locations`
                    ON ($tables[$i].`locations_id` = glpi_locations.`id`)          
                LEFT JOIN `$typestable[$i]`
                    ON ($tables[$i].`$typeid[$i]` = $typestable[$i].`id`)
                LEFT JOIN `glpi_states`
                    ON ($tables[$i].`states_id` = glpi_states.`id`)
                LEFT JOIN `glpi_plugin_fields_statusremarkfielddropdowns`
                    ON ($pluginstable[$i].`plugin_fields_statusremarkfielddropdowns_id` = glpi_plugin_fields_statusremarkfielddropdowns.`id`)
                    where is_approve=2 ".$groupqry;
      $result = $DB->request($query);
      if ($result->numrows() > 0) {
      	foreach ($result as $line) {
			fputcsv($output, array($line['name'],$line['ipaddress'],$line['typename'],$line['statesname'],$line['remarkname'],$line['serialname'],$line['groupname'],$line['comment'],$line['reject_comments'], $line['makename'], $line['modelname'],$line['location'],$line['date_creation']));      		
      	}
      }
 	}
 ?>