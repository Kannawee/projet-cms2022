<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\User as userModel;
use App\Model\Page as pageModel;
use App\Model\Post as postModel;
use App\Model\Elementpage as elementpageModel;

class Page {

    public function list()
    {
        $page =  new pageModel();
        $all_pages = $page->select();
        $view = new View("page", "back");
        $view->assign('page',$page);
        $view->assign('allpages', $all_pages);
    }

    public function add()
    {
        if (!empty($_POST)) {
            $page = new pageModel();

            $tmp_tab = array(
                "title"=>htmlspecialchars($_POST['title']),
                "visible"=>0
            );

            $page->setFromArray($tmp_tab);
            $id = $page->save();

            if (is_numeric($id) && $id!=0) {
                header('Location: /administration/page/edit/'.$id);
                exit();
            }
            header('Location: /administration/page/');       
            exit();    
        }
    }


    public function edit($data=array())
    {
        if (!empty($data) && count($data)>0) {
            $page = new pageModel();
            $id = htmlspecialchars($data['id']);
            
            if (!empty($_POST)) {
                $data = array(
                    "id"=>$id,
                    "title"=>htmlspecialchars($_POST['title']),
                    "visible"=>htmlspecialchars($_POST['visible']),
                    "created_at"=>htmlspecialchars($_POST['created_at']),                    
                );

                $page->setFromArray($data);
                $res = $page->save();

                if ($res) {
                    header('Location: /administration/page/edit/'.$id.'?success=ok');
                    exit();
                }

                header('Location: /administration/page/edit/'.$id.'?success=notok');
                exit();
            } else {
                $page = $page->getById($id);
                $element = new elementpageModel();

                $listElem = $element->getListElement($id);

                $minOrdre = $element->getMinOrdre($id);
                $maxOrdre = $element->getMaxOrdre($id);

                $view = new View("pageedit","back");
                $view->assign("page", $page);
                $view->assign("element",$element);
                $view->assign("listElem",$listElem);
                $view->assign("minOrdre", $minOrdre);
                $view->assign("maxOrdre", $maxOrdre);

            }
        }
    }

    public function delete($data=array())
    {
        if (count($data)>0) {
            $id = htmlspecialchars($data['id']);

            $page = new pageModel();
            $page = $page->getById($id);

            if ($page!=false) {
                $page->delete();
            }

            $this->list();
        }
    }
}