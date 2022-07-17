<?php

namespace App\Controller;

include 'Core/View.class.php';
// include 'Model/User.class.php';

use App\Core\View;
use App\Model\User as userModel;

class Installer {

    public function install()
    {
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
        exit();
    }

    public function performInstall($data)
    {

      if (count($data)!=6) {
        die("Espece de hacker.");
      }
      foreach ($data as $key => $value) {
          if ($value=="") {
              header('Location: /?error=form');
              exit();
          } else {
              $data[$key] = addslashes(htmlspecialchars(trim($value)));
          }
      }

      $host = addslashes(htmlspecialchars($data['dbhost']));
      $root = "root";
      $root_password = "password";

      $user = addslashes(htmlspecialchars($data['dbuser']));
      $pass = addslashes(htmlspecialchars($data['dbpwd']));
      $db = addslashes(htmlspecialchars($data['dbname']));
      $dbport = addslashes(htmlspecialchars($data['dbport']));
      $driver = "mysql";
      $prefix = addslashes(htmlspecialchars($data['dbprefixe']))."_";

      try {
        $dbh = new \PDO("mysql:host=$host", $root, $root_password);

        $sql = "CREATE DATABASE `$db`;";

        if ($user!="root") {
            $sql .= "CREATE USER '$user'@'localhost' IDENTIFIED BY '$pass';
            GRANT ALL ON `$db`.* TO '$user'@'localhost';";
        } else {
            $pass = "password";
        }
        $sql .= "FLUSH PRIVILEGES;";

        $res = $dbh->exec($sql);
        
        if ($res===false) {
            header('Location: /?error=database');
            exit();
        }

      } catch (\PDOException $e) {
          header('Location: /?error=database');
          exit();
      }

      try{
        $dbh = new \PDO( $driver.":host=".$host.";port=".$dbport.";dbname=".$db
            ,$user, $pass , [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]);
    
        $sql = "CREATE TABLE `".$prefix."comment` (
          `id` int(11) NOT NULL,
          `moded` int(11) NOT NULL,
          `type` enum('project','concert') NOT NULL,
          `content` text NOT NULL,
          `id_user` int(11) NOT NULL,
          `id_project` int(11) DEFAULT NULL,
          `id_concert` int(11) DEFAULT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          CREATE TABLE `".$prefix."concert` (
            `id` int(11) NOT NULL,
            `name` varchar(50) DEFAULT NULL,
            `date` date NOT NULL,
            `venue` varchar(50) NOT NULL,
            `city` varchar(50) NOT NULL,
            `link` text NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          CREATE TABLE `".$prefix."elementpage` (
            `id` int(11) NOT NULL,
            `type` enum('project','concert','post','') NOT NULL,
            `ordre` int(11) NOT NULL,
            `id_page` int(11) NOT NULL,
            `id_project` int(11) DEFAULT NULL,
            `id_post` int(11) DEFAULT NULL,
            `id_concert` int(11) DEFAULT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          CREATE TABLE `".$prefix."media` (
            `id` int(11) NOT NULL,
            `name` varchar(80) NOT NULL,
            `filename` varchar(255) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          CREATE TABLE `".$prefix."newsletter` (
            `id` int(11) NOT NULL,
            `title` varchar(120) NOT NULL,
            `content` text NOT NULL,
            `date` date NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          CREATE TABLE `".$prefix."newsletterlist` (
            `id` int(11) NOT NULL,
            `id_user` int(11) NOT NULL,
            `id_newsletter` int(11) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          CREATE TABLE `".$prefix."page` (
            `id` int(11) NOT NULL,
            `title` varchar(255) NOT NULL,
            `visible` int(11) NOT NULL DEFAULT '0',
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          CREATE TABLE `".$prefix."post` (
            `id` int(11) NOT NULL,
            `title` varchar(255) NOT NULL,
            `content` text NOT NULL,
            `published` int(11) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          CREATE TABLE `".$prefix."project` (
            `id` int(11) NOT NULL,
            `name` varchar(50) NOT NULL,
            `releaseDate` date NOT NULL,
            `description` text
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          CREATE TABLE `".$prefix."tracklist` (
            `id` int(11) NOT NULL,
            `project` int(11) NOT NULL,
            `media` int(11) NOT NULL,
            `position` int(11) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          CREATE TABLE `".$prefix."user` (
            `id` int(11) NOT NULL,
            `email` varchar(320) NOT NULL,
            `login` varchar(50) DEFAULT NULL,
            `password` varchar(255) NOT NULL,
            `confirmed` int(11) NOT NULL,
            `status` tinyint(4) NOT NULL DEFAULT '0',
            `token` char(255) DEFAULT NULL,
            `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          ALTER TABLE `".$prefix."comment`
          ADD PRIMARY KEY (`id`),
          ADD KEY `id_user` (`id_user`),
          ADD KEY `id_project` (`id_project`),
          ADD KEY `id_concert` (`id_concert`);
          ALTER TABLE `".$prefix."concert`
            ADD PRIMARY KEY (`id`);
          ALTER TABLE `".$prefix."elementpage`
            ADD PRIMARY KEY (`id`),
            ADD KEY `id_page` (`id_page`),
            ADD KEY `id_project` (`id_project`),
            ADD KEY `id_concert` (`id_concert`),
            ADD KEY `id_post` (`id_post`);
          ALTER TABLE `".$prefix."media`
            ADD PRIMARY KEY (`id`);
          ALTER TABLE `".$prefix."newsletter`
            ADD PRIMARY KEY (`id`);
          ALTER TABLE `".$prefix."newsletterlist`
            ADD PRIMARY KEY (`id`),
            ADD KEY `id_user` (`id_user`),
            ADD KEY `id_newsletter` (`id_newsletter`);
          ALTER TABLE `".$prefix."page`
            ADD PRIMARY KEY (`id`);
          ALTER TABLE `".$prefix."post`
            ADD PRIMARY KEY (`id`);
          ALTER TABLE `".$prefix."project`
            ADD PRIMARY KEY (`id`);
          ALTER TABLE `".$prefix."tracklist`
            ADD PRIMARY KEY (`id`);
          ALTER TABLE `".$prefix."user`
            ADD PRIMARY KEY (`id`),
            ADD UNIQUE KEY `email` (`email`);
          ALTER TABLE `".$prefix."comment`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
          ALTER TABLE `".$prefix."concert`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
          ALTER TABLE `".$prefix."elementpage`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
          ALTER TABLE `".$prefix."media`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
          ALTER TABLE `".$prefix."newsletter`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
          ALTER TABLE `".$prefix."newsletterlist`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
          ALTER TABLE `".$prefix."page`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
          ALTER TABLE `".$prefix."post`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
          ALTER TABLE `".$prefix."project`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
          ALTER TABLE `".$prefix."tracklist`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
          ALTER TABLE `".$prefix."user`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
          ALTER TABLE `".$prefix."comment`
            ADD CONSTRAINT `".$prefix."comment_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `".$prefix."user` (`id`) ON DELETE CASCADE,
            ADD CONSTRAINT `".$prefix."comment_ibfk_2` FOREIGN KEY (`id_project`) REFERENCES `".$prefix."project` (`id`) ON DELETE CASCADE,
            ADD CONSTRAINT `".$prefix."comment_ibfk_3` FOREIGN KEY (`id_concert`) REFERENCES `".$prefix."concert` (`id`) ON DELETE CASCADE;
          ALTER TABLE `".$prefix."elementpage`
            ADD CONSTRAINT `".$prefix."elementpage_ibfk_1` FOREIGN KEY (`id_page`) REFERENCES `".$prefix."page` (`id`) ON DELETE CASCADE,
            ADD CONSTRAINT `".$prefix."elementpage_ibfk_2` FOREIGN KEY (`id_project`) REFERENCES `".$prefix."project` (`id`) ON DELETE CASCADE,
            ADD CONSTRAINT `".$prefix."elementpage_ibfk_3` FOREIGN KEY (`id_concert`) REFERENCES `".$prefix."concert` (`id`) ON DELETE CASCADE,
            ADD CONSTRAINT `".$prefix."elementpage_ibfk_4` FOREIGN KEY (`id_post`) REFERENCES `".$prefix."post` (`id`) ON DELETE CASCADE;
          ALTER TABLE `".$prefix."newsletterlist`
            ADD CONSTRAINT `".$prefix."newsletterlist_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `".$prefix."user` (`id`) ON DELETE CASCADE,
            ADD CONSTRAINT `".$prefix."newsletterlist_ibfk_2` FOREIGN KEY (`id_newsletter`) REFERENCES `".$prefix."newsletter` (`id`) ON DELETE CASCADE;
          COMMIT;";
    
        $res = $dbh->exec($sql);
        
        if ($res === false) {
          header("Location: /?error=table");
          exit();
        }
          
      }catch (\Exception $e){
          header("Location: /?error=table");
          exit();
      }

      $confFile = fopen("conf_perso.inc.php","w+");
      fwrite ($confFile, "<?php".PHP_EOL);

      $data['dbdriver'] = "mysql";
      $data['dbprefixe'] .= "_";

      foreach ($data as $key => $value) {
        $tmpdata = 'define("'.strtoupper($key).'","'.$value.'");'.PHP_EOL;
        fwrite ($confFile, $tmpdata);
      }

      fclose($confFile);

      header('Location: /install/step2');
      exit();        
    }


    public function step2()
    {
      $error = false;
      $user = new userModel();

      if(!$user->checkSuperAdmin()) {
        header("Location: /");
        exit();
      }

      if (!empty($_POST)) {
        $res = $user->select();

        $tabuser = array(
          "email"=>addslashes(htmlspecialchars($_POST['adminemail'])),
          "login"=>addslashes(htmlspecialchars($_POST['adminlogin'])),
          "password"=>password_hash(addslashes(htmlspecialchars($_POST['password'])), PASSWORD_DEFAULT),
          "status"=>1,
          "token"=>substr(bin2hex(random_bytes(128)), 0, 255),
          "confirmed"=>1
        );
  
        try{
          $dbh = new \PDO( DBDRIVER.":host=".DBHOST.";port=".DBPORT.";dbname=".DBNAME
              ,DBUSER, DBPWD , [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]);
      
          $sql = "INSERT INTO ".DBPREFIXE."user (email, login, password, confirmed, status, token) VALUES (:email, :login, :password, :confirmed, :status, :token)";
          $stmt = $dbh->prepare($sql);
      
          if(!$stmt) {
              print_r($dbh->errorInfo());die;
          }
          $res = $stmt->execute($tabuser);
          
          if ($res === false) {
              print_r($dbh->errorInfo());die;
              header('Location: /?error=insert');
              exit();
          }
          
        }catch (\Exception $e){
          print_r($dbh->errorInfo());die;
          header('Location: /?error=insert');
          exit();
        }

        header('Location: /install/step3');
        exit();
      }
      $view = new View("","installerForm");
      $view->assign("step", 2);
      $view->assign("error", $error);
    }

    public function step3()
    {

      if (defined('NEWSMAIL') && defined('NEWSPWD')) {
        header("Location: /");
        exit();
      }

      if (!empty($_POST)) {

        if (count($_POST)!=2) {
          die("OH LE HACKER LAAAAAAA!");
        }

        if (!isset($_POST['newsmail']) || !isset($_POST['newspwd'])) {
          die("Mauvais champs");
        }

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
      $view = new View("","installerform");
      $view->assign("step",3);
    }
}