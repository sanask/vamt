<?php

// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=vamt_icici_Tablet.csv');

// create a file pointer connected to the output stream/
$output = fopen('php://output', 'w');
//Asset Code
// output the column headings
fputcsv($output, array('GROUP','LOCATION TYPE','BRANCH','AM NAME','SOLID','ASSETCODE','IMEI','IMEI 2','SERIAL NUMBER','MAKE','MODEL','EMPLOYEE NUMBER','EMPLOYEE NAME','EMP REPORTING','DEPARTMENT CUSTODY','CHARGER','USB CABLE','COVER','SIM OPERATOR','SIM IMSI NO','AIR WATCH AGENT','AIRWATCH BROWSER','ENROLLMENT STATUS','STATUS','INSTALLATION BY','INSTALLATION DATE')); 

include ('inc/includes.php');
$groups_id	=	$_REQUEST['groups_id'];

if($groups_id!=0){
    $groupqry.=' where glpi_groups.id IN ('.$groups_id.')';
}


$tables				=	array('glpi_phones');
$pluginstable		=	array('glpi_plugin_fields_phonetablets');
$typestable			=	array('glpi_phonetypes');
$modelstable		=	array('glpi_phonemodels');
$typeid				=	array('phonetypes_id');
$modelid			=	array('phonemodels_id');


$amnamefield  	= 	array('amnamefield5');
$consultantid  	= 	array('consultantidfield5');
$cname  		= 	array('consultantnamefield5');
$cnumber  		= 	array('consultantcontactnumberfield5');
$state  		= 	array('statefield5');
$city  		= 	array('cityfield6');
$solid 		  	=	array('solidfield5');
$assetyear	  	=   array('assetyearfield4');
$gateway  		=	array('gatewayfield5');
$loctype  		=	array('locationtypefield5');
$country  		=	array('countryfield5');
$brspeed  		=	array('branchspeedfield4');
$ename	  		=	array('employeenamefield5');
$egrade	  		=	array('employeegradefield2');
$edept  		=	array('employeedepartmentnamefield3');
$cdept	  		=	array('consultantdepartmentnamefield5');
$edesi 	  		=	array('employeedesignationfield3');
$cdesi 	  		=	array('consultantdesignationfield3');
$cgrade  		=	array('consultantgradefield5');
$invoice 		=	array('invoicenumberfield4');
$fcrmno   		=	array('fcrmnumberfield4');
$pono 	 		=	array('ponumberfield4');
$emprepo    = array('employeereportingfield');
$deptcust   = array('custodyfield');


$start  = 0;
$count 	=	count($tables);

for($i=$start;$i<$count;$i++){

 $ExtraFields	=	array(
 	$pluginstable[$i].'.ipaddressfield5 as ipaddress,'.$pluginstable[$i].'.imei1field,'.$pluginstable[$i].'.imei2field,'.$pluginstable[$i].'.simoperatorfield,'.$pluginstable[$i].'.simimsinofield,'.$pluginstable[$i].'.airwatchagentfield,'.$pluginstable[$i].'.airwatchbrowserfield,glpi_plugin_fields_enrollmentstatusfielddropdowns.name as enroll,glpi_plugin_fields_chargerfielddropdowns.name as charger,glpi_plugin_fields_usbcablefielddropdowns.name as usbcable,glpi_plugin_fields_coverfielddropdowns.name as cover,'.$pluginstable[$i].'.addedbyfield as installationby',

 	);



$ExtraJoin		=	array('
LEFT JOIN `glpi_plugin_fields_enrollmentstatusfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_enrollmentstatusfielddropdowns_id` = glpi_plugin_fields_enrollmentstatusfielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_chargerfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_chargerfielddropdowns_id` = glpi_plugin_fields_chargerfielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_usbcablefielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_usbcablefielddropdowns_id` = glpi_plugin_fields_usbcablefielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_coverfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_coverfielddropdowns_id` = glpi_plugin_fields_coverfielddropdowns.`id`)');

  $query = "SELECT $tables[$i].* , glpi_groups.`name` as groupname,$typestable[$i].`name` as typename,glpi_locations.`name` as location,glpi_plugin_fields_statusfielddropdowns.`name` as statusnme,$pluginstable[$i].`$amnamefield[$i]` as amname,$modelstable[$i].`name` as modelname,glpi_manufacturers.`name` as makename,$pluginstable[$i].`$consultantid[$i]` as consultantid,$pluginstable[$i].`$cname[$i]` as consultantname,$pluginstable[$i].`$cnumber[$i]` as concontactnumber,glpi_states.`name` as statesname,glpi_plugin_fields_statusremarkfielddropdowns.`name` as remarkname,$pluginstable[$i].`$state[$i]` as statename,$pluginstable[$i].`$city[$i]` as cityname,$pluginstable[$i].`$solid[$i]` as solid,$pluginstable[$i].`$assetyear[$i]` as assetyear,$pluginstable[$i].`$gateway[$i]` as gateway,$pluginstable[$i].`$loctype[$i]` as locationtype,$pluginstable[$i].`$country[$i]` as country,$pluginstable[$i].`$brspeed[$i]` as brspeed,$pluginstable[$i].`$ename[$i]` as employeename,$pluginstable[$i].`$egrade[$i]` as grade,$pluginstable[$i].`$edept[$i]` as deptname,$pluginstable[$i].`$cdept[$i]` as cdeptname,$pluginstable[$i].`$edept[$i]` as edesignation,$pluginstable[$i].`$cdesi[$i]` as cdesign,$pluginstable[$i].`$cgrade[$i]` as cgrade,$pluginstable[$i].`$invoice[$i]` as invoicenumber,glpi_plugin_fields_hardwareinstalledbyfielddropdowns.`name` as hardwareinstall,$pluginstable[$i].`$fcrmno[$i]` as fcrmnumber,$pluginstable[$i].`$pono[$i]` as ponumber,glpi_plugin_fields_servicetypefielddropdowns.`name` as servicetype,$ExtraFields[$i],$pluginstable[$i].`$emprepo[$i]` as empreporting,$pluginstable[$i].`$deptcust[$i]` as deptcustody  FROM $tables[$i]
                LEFT JOIN `$pluginstable[$i]`
                    ON ($tables[$i].`id` = $pluginstable[$i].`items_id`)
                LEFT JOIN `glpi_groups`
                    ON ($tables[$i].`groups_id` = glpi_groups.`id`
                    )      
                LEFT JOIN `$typestable[$i]`
                    ON ($tables[$i].`$typeid[$i]` = $typestable[$i].`id`)
                LEFT JOIN `glpi_locations`
                    ON ($tables[$i].`locations_id` = glpi_locations.`id`)
                LEFT JOIN `glpi_plugin_fields_statusfielddropdowns`
                    ON ($pluginstable[$i].`plugin_fields_statusfielddropdowns_id` = glpi_plugin_fields_statusfielddropdowns.`id`)                  
                LEFT JOIN `glpi_manufacturers`
                    ON ($tables[$i].`manufacturers_id` = glpi_manufacturers.`id`)
                LEFT JOIN `$modelstable[$i]`
                    ON ($tables[$i].`$modelid[$i]` = $modelstable[$i].`id`)
                LEFT JOIN `glpi_states`
                    ON ($tables[$i].`states_id` = glpi_states.`id`)
                LEFT JOIN `glpi_plugin_fields_statusremarkfielddropdowns`
                    ON ($pluginstable[$i].`plugin_fields_statusremarkfielddropdowns_id` = glpi_plugin_fields_statusremarkfielddropdowns.`id`)
                LEFT JOIN `glpi_plugin_fields_hardwareinstalledbyfielddropdowns`
                    ON ($pluginstable[$i].`plugin_fields_hardwareinstalledbyfielddropdowns_id` = glpi_plugin_fields_hardwareinstalledbyfielddropdowns.`id`) 
                 LEFT JOIN `glpi_plugin_fields_servicetypefielddropdowns`
                    ON ($pluginstable[$i].`plugin_fields_servicetypefielddropdowns_id` = glpi_plugin_fields_servicetypefielddropdowns.`id`)
                    ".$ExtraJoin[$i]." ".$groupqry;
      $result = $DB->request($query);
      if ($result->numrows() > 0) {
      	foreach ($result as $line) {
      		if($line['audio']==1){$audio = 'Yes';}else{$audio = 'No';}
			if($line['physical']==1){$physical = 'Yes';}else{$physical = 'No';}
			if($line['redtag']==1){$redtag = 'Yes';}else{$redtag = 'No';}
			if($line['have_serial']==1){$serial='Yes';}else{$serial = 'No';}
			if($line['have_parallel']==1){$parallel='Yes';}else{$parallel='No';}
			if($line['have_usb']==1){$husb='Yes';}else{$husb='No';}
			if($line['have_ethernet']==1){$hether='Yes';}else{$hether='No';}
			if($line['have_wifi']==1){$hwifi='Yes';}else{$hwifi='No';}
			if($line['fupgrade']==1){$fupgrade='Yes';}else{$fupgrade='No';}
			
			fputcsv($output, array($line['groupname'],$line['locationtype'],$line['location'],$line['amname'],$line['solid'],$line['name'],$line['imei1field'],$line['imei2field'],$line['serial'],$line['makename'],$line['modelname'],$empno,$line['employeename'],$line['empreporting'],$line['deptcustody'],$line['charger'],$line['usb'],$line['cover'],$line['simoperatorfield'],$line['simimsinofield'],$line['airwatchagentfield'],$line['airwatchbrowserfield'],$line['enroll'],$line['statusnme'],$line['installationby'],
$line['installationdate'],));      		
      	}
      }
 	}
 ?>