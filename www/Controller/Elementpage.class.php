<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\User as userModel;
use App\Model\Page as pageModel;
use App\Model\Elementpage as elementpageModel;

class Elementpage {

    public function add($data=array())
    {
        if (count($data)>0) {

            $element = new elementpageModel();

            $id_page = htmlspecialchars($data['id']);

            if (!empty($_POST)) {
                $data = array(
                    "type"=>htmlspecialchars($_POST['type']),
                    "content"=>htmlspecialchars($_POST['content']),
                    "ordre"=>htmlspecialchars($_POST['ordre']),
                    "id_page"=>htmlspecialchars($id_page),
                );

                $element->setFromArray($data);
                
                $checkOrdre = $element->checkOrdre($data['ordre'], $id_page);

                if ($checkOrdre) {
                    $res = $element->save();

                    if (is_numeric($res) && $res!=0) {
                        header('Location: /administration/page/edit/'.$id_page);
                        exit();
                    }
                }
                header('Location: /administration/page/edit/'.$id_page."?success=notok");
                exit();
            }
        }

        header('Location: /administration/page');
        exit();
    }

    public function edit($data=array())
    {
        if (count($data)>0) {
            $elem = new elementpageModel();

            $id = htmlspecialchars($data['id']);
            $id_page = htmlspecialchars($data['id_page']);

            if (!empty($_POST)) {
                $tmp_data = array(
                    "id"=>$id,
                    "ordre"=>htmlspecialchars($_POST['ordre']),
                    "content"=>htmlspecialchars($_POST['content']),
                    "type"=>htmlspecialchars($_POST['type']),
                );

                $elem->setFromArray($tmp_data);
                $res = $elem->save();

                if ($res) {
                    header('Location: /administration/page/edit/'.$id_page.'?success=ok&elem='.$id);
                    exit();
                }

                header('Location: /administration/page/edit/'.$id_page.'?success=notok?elem='.$id);
                exit();
                
            }
        }
    }

    public function delete($data=array())
    {
        if (count($data)>0) {
            $elem = new elementpageModel();

            $id = htmlspecialchars($data['id']);
            $id_page = htmlspecialchars($data['id_page']);

            $where = array(
                "id" => $id,
                "id_page" => $id_page
            );

            $res = $elem->delete($where);

            if ($res) {
                header('Location: /administration/page/edit/'.$id_page.'?success=ok');
                exit();
            }

            header('Location: /administration/page/edit/'.$id_page.'?success=ok');
            exit();        
        
        }
    }

    public function changeordre($data=array())
    {
        if (count($data)>0) {
            $elem = new elementpageModel();

            $id = htmlspecialchars($data['id']);
            $id_page = htmlspecialchars($data['id_page']);
            $change = htmlspecialchars($data['change']);

            $where = array(
                "id"=>$id
            );

            $tmp_elem = $elem->select($where);
            
            if (count($tmp_elem)>0) {
                $elem->setFromArray($tmp_elem[0]);
                $res = $elem->changeOrdre($change);

                if ($res) {
                    header('Location: /administration/page/edit/'.$elem->getIdPage().'?success=ok');
                    exit();
                }

                header('Location: /administration/page/edit/'.$elem->getIdPage().'?success=notok');
                exit();
            }

            die("Elem non trouvé");
        }
    }
}