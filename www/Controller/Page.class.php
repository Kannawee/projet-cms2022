<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\User as userModel;
use App\Model\Page as pageModel;
use App\Model\Post as postModel;
use App\Model\Comment as commentModel;
use App\Model\Concert as concertModel;
use App\Model\Project as projectModel;
use App\Model\Elementpage as elementpageModel;

class Page {

    /**
	 * @return void
	**/
    public function list():void
    {
        $page =  new pageModel();
        $error = array();
        $all_pages = $page->select();
        $view = new View("page", "back");
        $view->assign('page',$page);
        $view->assign('allpages', $all_pages);
        $view->assign('errors', $error);
    }

    /**
	 * @return void
	**/
    public function add():void
    {
        if (!empty($_POST)) {
            $page = new pageModel();
            $error = array();

            $tmp_tab = array(
                "title"=>htmlspecialchars($_POST['title']),
                "route"=>htmlspecialchars($_POST['route']),
                "type"=>htmlspecialchars($_POST['type']),
                "descSEO"=>htmlspecialchars($_POST['descSEO']),
                "kwordsSEO"=>htmlspecialchars($_POST['kwordsSEO']),
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

    /**
	 * @param array $data
	 * @return void
	**/
    public function edit($data=array()):void
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
                    "descSEO"=>htmlspecialchars($_POST['descSEO']),
                    "kwordsSEO"=>htmlspecialchars($_POST['kwordsSEO']),
                    "type"=>htmlspecialchars($_POST['type']),
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

                    $unicity = $page->checkUnicity();

                    if ($unicity) {
                        $res = $page->save();

                        if ($res) {
                            header('Location: /administration/page/edit/'.$id.'?success=ok');
                            exit();
                        }

                        $error[] = "Error during insertion in database.";
                    } else {
                        $error[] = "A page with the same type is already visible, please make it not visible or check the other one";
                    }
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

    /**
	 * @param array $data
	 * @return void
	**/
    public function delete($data=array()):void
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

    /**
	 * @param array $data
	 * @return void
	**/
    public function displaypage($data=array()):void
    {
        if (count($data)>0 && isset($data['route'])) {
            $page = new pageModel();
            $comm = new commentModel();
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

            $obj = $listObj = $listComm = "";

            if ($page->getType()=="post") {
                $obj = new postModel();

                $where = array(
                    "published"=>1
                );

                $listObj = $obj->select($where);
                $listComm = array();
                $key = "id_".$page->getType();

                if (is_array($listObj)) {
                    foreach ($listObj as $obje) {
                        $where = array(
                            $key=>$obje->getId(),
                            "moded"=>1
                        );

                        $tmpcomm = $comm->getModedCommentFromObjId($obje->getId(), $page->getType());

                        if ($tmpcomm && count($tmpcomm)>0) {
                            $listComm[$obje->getId()] = $tmpcomm;
                        }
                    }
                }
            } elseif ($page->getType()=="concert") {
                $obj = new concertModel();

                $listObj = $obj->select();
                $listComm = array();
                $key = "id_".$page->getType();

                if (is_array($listObj)) {
                    foreach ($listObj as $obje) {
                        $where = array(
                            $key=>$obje->getId(),
                            "moded"=>1,
                        );

                        $tmpcomm = $comm->getModedCommentFromObjId($obje->getId(), $page->getType());
                        if ($tmpcomm && count($tmpcomm)>0) {
                            $listComm[$obje->getId()] = $tmpcomm;
                        }
                    }
                }
            } elseif ($page->getType()=="project") {
                $obj = new projectModel();

                $listObj = $obj->select();

                $listComm = array();
                $key = "id_".$page->getType();

                if (is_array($listObj)) {
                    foreach ($listObj as $obje) {
                        $where = array(
                            $key=>$obje->getId(),
                            "moded"=>1,
                        );

                        $tmpcomm = $comm->getModedCommentFromObjId($obje->getId(), $page->getType());
                        if ($tmpcomm && count($tmpcomm)>0) {
                            $listComm[$obje->getId()] = $tmpcomm;
                        }
                    }
                }
            }

            $navLink = $page->getNavLink();

            $view = new View("","page");
            $view->assign("errors", $error);
            $view->assign("page", $page);
            $view->assign("listObj", $listObj);
            $view->assign("type", $page->getType());
            $view->assign("comm", $comm);
            $view->assign("listComm", $listComm);
            $view->assign("navLink", $navLink);
        }
    }
}