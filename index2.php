<?php
/*
 * @version $Id$
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2015-2016 Teclib'.

 http://glpi-project.org

 based on GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2014 by the INDEPNET Development Team.

 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */


/** @file
* @brief
*/

// Check PHP version not to have trouble
if (version_compare(PHP_VERSION, "5.4.0") < 0) {
   die("PHP >= 5.4.0 required");
}

define('DO_NOT_CHECK_HTTP_REFERER', 1);
// If config_db doesn't exist -> start installation
define('GLPI_ROOT', dirname(__FILE__));
include (GLPI_ROOT . "/config/based_config.php");

if (!file_exists(GLPI_CONFIG_DIR . "/config_db.php")) {
   include_once (GLPI_ROOT . "/inc/autoload.function.php");
   Html::redirect("install/install.php");
   die();

} else {
   $TRY_OLD_CONFIG_FIRST = true;
   include (GLPI_ROOT . "/inc/includes.php");
   $_SESSION["glpicookietest"] = 'testcookie';

   // For compatibility reason
   if (isset($_GET["noCAS"])) {
      $_GET["noAUTO"] = $_GET["noCAS"];
   }

   Auth::checkAlternateAuthSystems(true, isset($_GET["redirect"])?$_GET["redirect"]:"");

   // Send UTF8 Headers
   header("Content-Type: text/html; charset=UTF-8");

   // Start the page
   echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" '.
         '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'."\n";
   echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">';
   echo '<head><title>'.__('Vara United - Authentication').'</title>'."\n";
   echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>'."\n";
   echo '<meta http-equiv="Content-Script-Type" content="text/javascript"/>'."\n";
   echo "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n";
   echo '<link rel="shortcut icon" type="images/x-icon" href="'.$CFG_GLPI["root_doc"].
          '/pics/favicon1.ico" />';

   // auto desktop / mobile viewport
   echo "<meta name='viewport' content='width=device-width, initial-scale=1'>";

   // Appel CSS
   echo '<link rel="stylesheet" href="'.$CFG_GLPI["root_doc"].'/css/styles.css" type="text/css" '.
         'media="screen" />';
   // CSS theme link
      echo Html::css($CFG_GLPI["root_doc"]."/css/palettes/".$CFG_GLPI["palette"].".css");
   // surcharge CSS hack for IE
   echo "<!--[if lte IE 6]>" ;
   echo "<link rel='stylesheet' href='".$CFG_GLPI["root_doc"]."/css/styles_ie.css' type='text/css' ".
         "media='screen' >\n";
   echo "<![endif]-->";
//    echo "<script type='text/javascript'><!--document.getElementById('var_login_name').focus();-->".
//          "</script>";

   echo "</head>";

   echo "<body>";
   echo "<div id='firstboxlogin'>";
 echo "<div id='text-login'>";
   echo nl2br(Toolbox::unclean_html_cross_side_scripting_deep($CFG_GLPI['text_login']));
   echo "</div>";
 echo "<div id='header_top' style='float:left; width:100%; height:87px; border-bottom:3px solid #264796;'>
	  <div style='width:1170px; margin:0px auto;'><img src='pics/vara-logo.png' style='float:left;'><h3 style='float:left; color:#264796; font-size:24px; font-weight:bold; margin-top:30px; margin-left:15px;'>Asset Management System</h3></div>
	  </div>";
	  
	   
   echo "<div id='logo_login' style='display:none;'></div>";
  
     echo "<div id='boxlogin' style='width:900px; border:0px;margin-top:200px;'>";
  
   echo "<div style='float:left; width:400px; height:230px; border-right: 1px solid #f4f4f4; margin-right:50px; padding-top:70px;'>

<div class='item' style='float:left; text-align:center;'>
<img src='https://cdn2.iconfinder.com/data/icons/thesquid-ink-40-free-flat-icon-pack/64/envelope-2-128.png' class='img-responsive center-block' alt=''>
<div class='container'>
<div class='carousel-caption'>
<p>display properly due to web browser security rules.</p>
</div>
</div>
</div>
</div>";

   echo "<div style='float:left; width:400px;'><h1>Login Screen</h1>";
   echo "<form action='".$CFG_GLPI["root_doc"]."/front/login.php' method='post'>";

   $_SESSION['namfield'] = $namfield = uniqid('fielda');
   $_SESSION['pwdfield'] = $pwdfield = uniqid('fieldb');

   // Other CAS
   if (isset($_GET["noAUTO"])) {
      echo "<input type='hidden' name='noAUTO' value='1' />";
   }
   // redirect to ticket
   if (isset($_GET["redirect"])) {
      Toolbox::manageRedirect($_GET["redirect"]);
      echo '<input type="hidden" name="redirect" value="'.$_GET['redirect'].'"/>';
   }
   echo '<p class="login_input">
         <input type="text" name="'.$namfield.'" id="login_name" required="required"
                placeholder="'.__('Login').'" />
         <span class="login_img"></span>
         </p>';
   echo '<p class="login_input">
         <input type="password" name="'.$pwdfield.'" id="login_password" required="required"
                placeholder="'.__('Password').'"  />
         <span class="login_img"></span>
         </p>';
   echo '<p class="login_input">
         <input type="submit" name="submit" value="'._sx('button','Post').'" class="submit" />
         </p>';

   if ($CFG_GLPI["use_mailing"]
       && countElementsInTable('glpi_notifications',
                               "`itemtype`='User'
                                AND `event`='passwordforget'
                                AND `is_active`=1")) {
      echo '<a id="forget" href="front/lostpassword.php?lostpassword=1">'.
             __('Forgotten password?').'</a>';
   }
   Html::closeForm();

   echo "<script type='text/javascript' >\n";
   echo "document.getElementById('login_name').focus();";
   echo "</script>";

   echo "</div>";  // end login box


   echo "<div class='error'>";
   echo "<noscript><p>";
   _e('You must activate the JavaScript function of your browser');
   echo "</p></noscript>";

   if (isset($_GET['error']) && isset($_GET['redirect'])) {
      switch ($_GET['error']) {
         case 1 : // cookie error
            _e('You must accept cookies to reach this application');
            break;

         case 2 : // GLPI_SESSION_DIR not writable
            _e('Checking write permissions for session files');
            break;

         case 3 :
            _e('Invalid use of session ID');
            break;
      }
   }
   echo "</div>";

   // Display FAQ is enable
   if ($CFG_GLPI["use_public_faq"]) {
      echo '<div id="box-faq">'.
            '<a href="front/helpdesk.faq.php">[ '.__('Access to the Frequently Asked Questions').' ]';
      echo '</a></div>';
   }

   echo "<div id='display-login'>";
   Plugin::doHook('display_login');
   echo "</div>";


   echo "</div>"; // end contenu login

   if (GLPI_DEMO_MODE) {
      echo "<div class='center'>";
      Event::getCountLogin();
      echo "</div>";
   }
   echo "<div id='footer-login'>" . Html::getCopyrightMessage() . "</div>";

}
// call cron
if (!GLPI_DEMO_MODE) {
   CronTask::callCronForce();
}

echo "<footer style='margin-top:40px; border-top:3px solid #264796; background-color:#f4f4f4; position:fixed; text-align:center; bottom:0px; width:100%; padding:10px 0px;'>
                    <div class='ontainer'>
                        <div class='row'>
                            <div class='col-xs-12'>
                                © 2017. All rights reserved.
                            </div>
                        </div>
                    </div>
                </footer>";

echo "</body></html>";
?>
<script src="http://codeorigin.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="http://www.jqueryscript.net/demo/Simple-jQuery-Progress-Bar-For-Form-Completion-Progress-Bar/assets/js/jq.progress-bar.js"></script>
