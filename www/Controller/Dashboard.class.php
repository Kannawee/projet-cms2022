<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\User as UserModel;
use App\Model\Dashboard as dashboardModel;

class Dashboard {

    /**
	 * @return void
	**/
    public function dashboard():void
    {
        $view = new View("dashboard","back");
    }

}