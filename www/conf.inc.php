<?php

define("ROLES", [0=>"None", 1=>"Super admin", 2=>"Moderateur", 3=>"Banni"]);
define("NEWSTYPE", ["news"=>"Newsletter","project"=>"Project", "concert"=>"Concert"]);

if (file_exists('conf_perso.inc.php')) {
    include('conf_perso.inc.php');
}