<?php

namespace App\Controller;

include 'Core/View.class.php';
// include 'Model/User.class.php';

use App\Core\View;
use App\Model\User as userModel;
use App\Core\Verificator;

use App\Model\Installer as installerModel;

class Installer {

    /**
	  * @return void
	  **/
    public function install():void
    {

      $installer = new installerModel();

      $error = false;
      if (!empty($_POST)) {
          $this->performInstall($_POST);
          exit();  
      }

      if (!empty($_GET) && isset($_GET['error'])) {
          $error = htmlspecialchars($_GET['error']);
      }
      $view = new View("","installerForm");
      $view->assign('error', $error);
      $view->assign("installer", $installer);
      exit();
    }

    /**
	  * @param array $data
	  * @return void
	  **/    
    public function performInstall($data):void
    {

      $installer = new installerModel();
      $result = Verificator::checkForm($installer->getFormStep1(), $data);  

      if (count($result)==0) {
        $installer->createDBandTable($data);
        $confFile = fopen("conf_perso.inc.php","w+");
        fwrite ($confFile, "<?php".PHP_EOL);

        $data['dbdriver'] = "mysql";
        $data['dbprefixe'] .= "_";

        foreach ($data as $key => $value) {
          $tmpdata = 'define("'.strtoupper($key).'","'.htmlspecialchars($value).'");'.PHP_EOL;
          fwrite ($confFile, $tmpdata);
        }

        fclose($confFile);

        header('Location: /install/step2');
        exit();
      }

      $view = new View("","installerForm");
      $view->assign("errors",$result);
      $view->assign("installer", $installer);
    }

    /**
	  * @return void
	  **/
    public function step2():void
    {
      $error = false;
      $user = new userModel();
      $installer = new installerModel();
      $result = array();

      if(!$user->checkSuperAdmin()) {
        header("Location: /");
        exit();
      }

      if (!empty($_POST)) {
        $result = Verificator::checkForm($installer->getFormStep2(), $_POST);  

        if (count($result)==0) {
          $where = array(
            "status"=>1
          );

          $res = $user->select();

          if (count($res)==0) {
            $installer->insertAdmin($_POST);
            header('Location: /install/step3');
            exit();
          } else {
            header("Location: /");
            exit();
          }
        }
      }
      $view = new View("","installerForm");
      $view->assign("step", 2);
      $view->assign("error", $error);
      $view->assign("installer", $installer);
      $view->assign("errors", $result);
    }

    /**
	  * @return void
	  **/
    public function step3():void
    {

      $installer = new installerModel();
      $result = [];

      if (defined('NEWSMAIL') && defined('NEWSPWD')) {
        header("Location: /");
        exit();
      }

      if (!empty($_POST)) {

        $result = Verificator::checkForm($installer->getFormStep3(), $_POST);  

        if (count($result)==0) {
          $confFile = fopen("conf_perso.inc.php","a+");

          foreach ($_POST as $key => $value) {
            $tmp_data = 'define("'.strtoupper($key).'","'.$value.'");'.PHP_EOL;
            $res = fwrite($confFile, $tmp_data);

            if($res===false) {
              fclose($confFile);
              die("Impossible d'écrire");
            }
          }
          fclose($confFile);

          header('Location: /');
          exit();
        }
      }

      $view = new View("","installerform");
      $view->assign("step",3);
      $view->assign("installer", $installer);
      $view->assign("errors", $result);
    }
}