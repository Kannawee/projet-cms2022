<?php

define("ROLES", [0=>"none", 1=>"super admin", 2=>"moderateur", 3=>"banni"]);
define("NEWSTYPE", ["news"=>"Newsletter","project"=>"Project", "concert"=>"Concert"]);

if (file_exists('conf_perso.inc.php')) {
    include('conf_perso.inc.php');
}