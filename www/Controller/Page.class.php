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
        $error = array();
        $all_pages = $page->select();
        $view = new View("page", "back");
        $view->assign('page',$page);
        $view->assign('allpages', $all_pages);
        $view->assign('errors', $error);
    }

    public function add()
    {
        if (!empty($_POST)) {
            $page = new pageModel();
            $error = array();

            $tmp_tab = array(
                "title"=>htmlspecialchars($_POST['title']),
                "route"=>htmlspecialchars($_POST['route']),
                "visible"=>0
            );

            $tmp_tab['route'] = preg_replace("/\ /", "", $tmp_tab['route']);

            if (in_array($tmp_tab['route'], $page::$protectedWords)) {
                $error[] = "The word you are using for route is protected";
            }

            if (preg_match("/^([a-zA-Z0-9]|!(@))+$/", $tmp_tab['route']) == 0) {
                $error[] = "The route can only contains letters and numbers";
            }

            if (count($error)==0) {
                $where = array(
                    "route"=>$tmp_tab['route'],
                );

                $check = $page->getUnique(['*'], $where);

                if ($check!==false) {
                    $error[] = "The route is already used by another page.";
                }
                
                if (count($error)==0) {
                    $page->setFromArray($tmp_tab);
                    $id = $page->save();

                    if (is_numeric($id) && $id!=0) {
                        header('Location: /administration/page/edit/'.$id);
                        exit();
                    } else {
                        $error[] = "Error during insertion of page in database.";
                    }
                }
            }

            $all_pages = $page->select();

            $view = new View("page", "back");
            $view->assign('page',$page);
            $view->assign('allpages', $all_pages);
            $view->assign('errors', $error);  
        }
    }


    public function edit($data=array())
    {
        if (!empty($data) && count($data)>0) {
            $page = new pageModel();
            $error = array();
            $id = htmlspecialchars($data['id']);
            
            if (!empty($_POST)) {
                $tmpdata = array(
                    "id"=>$id,
                    "title"=>htmlspecialchars($_POST['title']),
                    "visible"=>htmlspecialchars($_POST['visible']),
                    "created_at"=>htmlspecialchars($_POST['created_at']),
                    "route"=>htmlspecialchars($_POST['route']),
                );

                $tmpdata['route'] = preg_replace("/\ /", "", $tmpdata['route']);

                if (in_array($tmpdata['route'], $page::$protectedWords)) {
                    $error[] = "The word you are using for route is protected";
                }

                if (preg_match("/^([a-zA-Z0-9]|!(@))+$/", $tmpdata['route']) == 0) {
                    $error[] = "The route can only contains letters and numbers";
                }

                if (count($error)==0) {
                    $tmppage = $page->getById($id);

                    if ($tmppage===false) {
                        header('Location: /administration/pages?error=notfound');
                        exit();
                    }

                    $page->setFromArray($tmpdata);
                    $res = $page->save();

                    if ($res) {
                        header('Location: /administration/page/edit/'.$id.'?success=ok');
                        exit();
                    }

                    $error[] = "Error during insertion in database.";
                }
            }
            $page = $page->getById($id);

            // $element = new elementpageModel();
            // $listElem = $element->getListElement($id);
            // $minOrdre = $element->getMinOrdre($id);
            // $maxOrdre = $element->getMaxOrdre($id);

            $view = new View("pageedit","back");
            $view->assign("page", $page);
            $view->assign("errors", $error);
            // $view->assign("element",$element);
            // $view->assign("listElem",$listElem);
            // $view->assign("minOrdre", $minOrdre);
            // $view->assign("maxOrdre", $maxOrdre);

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

    public function displaypage($data=array())
    {
        if (count($data)>0 && isset($data['route'])) {
            $page = new pageModel();
            $error = array();
            $route = htmlspecialchars($data['route']);

            if (preg_match("/^([a-zA-Z0-9]|!(@))+$/", $route) == 0) {
                $error[] = "The route can only contains letters and numbers";
            }

            if (count($error)==0) {
                $where = array(
                    "route"=>$route
                );

                $page = $page->getUnique(['*'],$where);

                if ($page===false) {
                    $error[] = "Page Not found";
                }
            }

            $view = new View("","page");
            $view->assign("errors", $error);
            $view->assign("page", $page);
        }
    }
}