<?php

define('WEB_ID','38');
define('WEB_DB','_lucid_ptce');
define('WEB FRAMEWORK','1');
define('WEB_PROTOCOL','https');
define('WEB_FOLDER','www.pharmacytimes.org');
define('WEB_URL','www.pharmacytimes.org');

// gtw vars
define("GTWorganizerKey", 3144842);
define("GTWaccessKey", "0lWWADkMcSKT6MaaqRttFVsAZrVZ");

require '../../../_core/1/Core.php';
require '../_model/global.php';
require '../_class/titan.php';

$code = "
";

$objCore = new Core();
$objCore->googleAnalytics($code);
$objCore->run();

?>
