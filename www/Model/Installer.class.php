<?php
namespace App\Model;

use App\Core\Sql;

class Installer
{

    public function __construct(){
        
    }

    public function createDBandTable(array $data):void
    {
      $host = addslashes(htmlspecialchars($data['dbhost']));
      $user = addslashes(htmlspecialchars($data['dbuser']));
      $pass = addslashes(htmlspecialchars($data['dbpwd']));
      $db = addslashes(htmlspecialchars($data['dbname']));
      $dbport = addslashes(htmlspecialchars($data['dbport']));
      $driver = "mysql";
      $prefix = addslashes(htmlspecialchars($data['dbprefixe']))."_";

      try {
        $dbh = new \PDO("mysql:host=$host", $user, $pass);

        $sql = "CREATE DATABASE `$db`;FLUSH PRIVILEGES;";

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
          `type` enum('project','concert','post') NOT NULL,
          `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `content` text NOT NULL,
          `id_user` int(11) NOT NULL,
          `id_project` int(11) DEFAULT NULL,
          `id_concert` int(11) DEFAULT NULL,
          `id_post` int(11) DEFAULT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          CREATE TABLE `".$prefix."concert` (
            `id` int(11) NOT NULL,
            `name` varchar(50) DEFAULT NULL,
            `date` date NOT NULL,
            `venue` varchar(50) NOT NULL,
            `city` varchar(50) NOT NULL,
            `link` text NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          CREATE TABLE `".$prefix."newsletter` (
            `id` int(11) NOT NULL,
            `title` varchar(120) NOT NULL,
            `content` text NOT NULL,
            `date` date NOT NULL,
            `active` int(11) NOT NULL,
            `type` enum('news','concert','project') NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          CREATE TABLE `".$prefix."newsletterlist` (
            `id` int(11) NOT NULL,
            `id_user` int(11) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          CREATE TABLE `".$prefix."page` (
            `id` int(11) NOT NULL,
            `type` enum('project','post','concert') NOT NULL,
            `descSEO` text,
            `kwordsSEO` text,
            `title` varchar(255) NOT NULL,
            `visible` int(11) NOT NULL DEFAULT '0',
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `route` varchar(255) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          CREATE TABLE `".$prefix."post` (
            `id` int(11) NOT NULL,
            `title` varchar(255),
            `content` text NOT NULL,
            `published` int(11) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          CREATE TABLE `".$prefix."project` (
            `id` int(11) NOT NULL,
            `name` varchar(50) NOT NULL,
            `releaseDate` date NOT NULL,
            `description` text,
            `cover` varchar(255) DEFAULT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          CREATE TABLE `".$prefix."tracklist` (
            `id` int(11) NOT NULL,
            `project` int(11) NOT NULL,
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
          ADD KEY `id_concert` (`id_concert`),
          ADD KEY `id_post` (`id_post`);
          ALTER TABLE `".$prefix."concert`
            ADD PRIMARY KEY (`id`);
          ALTER TABLE `".$prefix."newsletter`
            ADD PRIMARY KEY (`id`);
          ALTER TABLE `".$prefix."newsletterlist`
            ADD PRIMARY KEY (`id`),
            ADD KEY `id_user` (`id_user`);
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
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
          ALTER TABLE `".$prefix."newsletter`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
          ALTER TABLE `".$prefix."newsletterlist`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
          ALTER TABLE `".$prefix."page`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
          ALTER TABLE `".$prefix."post`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
          ALTER TABLE `".$prefix."project`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
          ALTER TABLE `".$prefix."tracklist`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
          ALTER TABLE `".$prefix."user`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
          ALTER TABLE `".$prefix."comment`
            ADD CONSTRAINT `".$prefix."comment_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `".$prefix."user` (`id`) ON DELETE CASCADE,
            ADD CONSTRAINT `".$prefix."comment_ibfk_2` FOREIGN KEY (`id_project`) REFERENCES `".$prefix."project` (`id`) ON DELETE CASCADE,
            ADD CONSTRAINT `".$prefix."comment_ibfk_3` FOREIGN KEY (`id_concert`) REFERENCES `".$prefix."concert` (`id`) ON DELETE CASCADE,
            ADD CONSTRAINT `".$prefix."comment_ibfk_4` FOREIGN KEY (`id_post`) REFERENCES `".$prefix."post` (`id`) ON DELETE CASCADE;
          ALTER TABLE `".$prefix."newsletterlist`
            ADD CONSTRAINT `".$prefix."newsletterlist_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `".$prefix."user` (`id`) ON DELETE CASCADE;
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
    }

    public function insertAdmin($data)
    {
        $tabuser = array(
            "email"=>addslashes(htmlspecialchars($data['adminemail'])),
            "login"=>addslashes(htmlspecialchars($data['adminlogin'])),
            "password"=>password_hash(addslashes(htmlspecialchars($data['password'])), PASSWORD_DEFAULT),
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
    }

    public function getFormStep1():array
    {
        return [
            "config"=>[
                "class"=>"formAddNewsletter",
                "method"=>"POST",
                "action"=>"/",
                "submit"=>"Submit"
            ],
            'inputs'=>[
                "dbuser"=>[
                    "type"=>"text",
                    "placeholder"=>"Database root user...",
                    "label"=>"Database Root User",
                    "required"=>true,
                    "error"=>"Incorrect Root User"
                ],
                "dbpwd"=>[
                    "type"=>"text",
                    "placeholder"=>"Database root password...",
                    "label"=>"Database Root Password",
                    "required"=>true,
                    "error"=>"Incorrect Root Password"
                ],
                "dbhost"=>[
                    "type"=>"text",
                    "placeholder"=>"Database Host...",
                    "label"=>"Database Host",
                    "required"=>true,
                    "error"=>"Incorrect Database Host"
                ],
                "dbname"=>[
                    "type"=>"text",
                    "placeholder"=>"Database Name...",
                    "label"=>"Database Name",
                    "required"=>true,
                    "error"=>"Incorrect database name"
                ],
                "dbprefixe"=>[
                    "type"=>"text",
                    "placeholder"=>"Database Prefixe title...",
                    "label"=>"Database Prefixe",
                    "required"=>true,
                    "error"=>"Incorrect Database Prexie"
                ],
                "dbport"=>[
                    "type"=>"text",
                    "placeholder"=>"Database Port title...",
                    "label"=>"Database Port",
                    "required"=>true,
                    "error"=>"Incorrect port"
                ],
                "sitename"=>[
                    "type"=>"text",
                    "placeholder"=>"Site name title...",
                    "label"=>"Site name",
                    "required"=>true,
                    "error"=>"Incorrect site name"
                ],

            ]
        ];
    }

    public function getFormStep2():array
    {
        return [
            "config"=>[
                "class"=>"formAddNewsletter",
                "method"=>"POST",
                "action"=>"/install/step2",
                "submit"=>"Submit"
            ],
            'inputs'=>[
                "adminlogin"=>[
                    "type"=>"text",
                    "placeholder"=>"Login Admin...",
                    "label"=>"Login Admin",
                    "required"=>true,
                    "error"=>"Incorrect Login Admin"
                ],
                "adminemail"=>[
                    "type"=>"text",
                    "placeholder"=>"Admin email...",
                    "label"=>"Admin email",
                    "required"=>true,
                    "error"=>"Incorrect Admin Email"
                ],
                "password"=>[
                    "type"=>"password",
                    "placeholder"=>"Password...",
                    "label"=>"Password",
                    "required"=>true,
                    "error"=>"Incorrect Password"
                ],
                "passwordconfirm"=>[
                    "type"=>"password",
                    "placeholder"=>"Password confirm...",
                    "label"=>"Password confirm",
                    "confirm"=>"password",
                    "required"=>true,
                    "error"=>"Incorrect password confirm"
                ],

            ]
        ];
    }

    public function getFormStep3():array
    {
        return [
            "config"=>[
                "class"=>"formAddNewsletter",
                "method"=>"POST",
                "action"=>"/install/step3",
                "submit"=>"Submit"
            ],
            'inputs'=>[
                "newsmail"=>[
                    "type"=>"email",
                    "placeholder"=>"Newsletter email...",
                    "label"=>"Newsletter email (only gmail)",
                    "required"=>true,
                    "error"=>"Incorrect Newsletter email"
                ],
                "newspwd"=>[
                    "type"=>"text",
                    "placeholder"=>"Newsletter application pwd...",
                    "label"=>"Newsletter appliaction pwd",
                    "required"=>true,
                    "error"=>"Incorrect Newsletter Password"
                ],                
            ]
        ];
    }

}