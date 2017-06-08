<?php

// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=vamt_icici_iprange.csv');

// create a file pointer connected to the output stream/
$output = fopen('php://output', 'w');
//Asset Code
// output the column headings
fputcsv($output, array('AM Name','Location Name','Location Type','Utilize IP', 'Free IP','Whitelisting IP','Location Speed','Solid','Subnet Mask','Gateway')); 

include ('inc/includes.php');



$tables				=	array('glpi_computers','glpi_printers','glpi_peripherals','glpi_phones','glpi_networkequipments');
$pluginstable		=	array('glpi_plugin_fields_computerlocationtypes','glpi_plugin_fields_printerprintcategories','glpi_plugin_fields_peripheralscanners','glpi_plugin_fields_phonetablets','glpi_plugin_fields_networkequipmentnetworkdevices');

	$start  = 0;
	$count 	=	count($tables);
	$query = "SELECT * from glpi_locations";
	$result = $DB->request($query);
    if ($result->numrows() > 0) {
      	foreach ($result as $line) {

   	   	    $locid = $line['id'];
   	   	    for($i=$start;$i<$count;$i++){
	            $result1  = $DB->request('select a.ipaddressfield as ipaddress from '.$pluginstable[$i].' a,'.$tables[$i].' b where b.`id` = a.`items_id`and b.locations_id='.$locid);
    	        foreach ($result1 as $line1) {
        	      $ipaddress[] = $line1['ipaddress'];
            	}      		
      		}
      		$ipaddress = implode('-', $ipaddress);
	      	fputcsv($output, array($line['areamanager'],$line['name'],$line['locm'],$ipaddress,'','',$line['brspeed'],$line['solid'],$line['subnet'],$line['gateway']));
    	}
 	}
 ?>