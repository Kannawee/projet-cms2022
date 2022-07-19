<?php
namespace App\Model;

use App\Core\Sql;

class Page extends Sql
{
    protected $id = null;
    protected $title;
    protected $visible;
    protected $created_at;
    protected $route;
    protected $type;
    protected $descSEO;
    protected $kwordsSEO;

    public static $protectedWords = ['delete','add','edit'];

    public function __construct()
    {
        parent::__construct();
    }

    public function setFromArray($data)
    {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }

        $this->title = (isset($data['title']))?$data['title']:null;
        $this->visible = (isset($data['visible']))?$data['visible']:null;
        $this->created_at = (isset($data['created_at']))?$data['created_at']:null;
        $this->route = (isset($data['route']))?$data['route']:null;
        $this->type = (isset($data['type']))?$data['type']:null;
        $this->descSEO = (isset($data['descSEO']))?$data['descSEO']:null;
        $this->kwordsSEO = (isset($data['kwordsSEO']))?$data['kwordsSEO']:null;
        
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setKwordsSEO($kwordsSEO)
    {
        $this->kwordsSEO = $kwordsSEO;
    }

    public function getKwordsSEO()
    {
        return $this->kwordsSEO;
    }

    public function setDescSEO($descSEO)
    {
        $this->descSEO = $descSEO;
    }

    public function getDescSEO()
    {
        return $this->descSEO;
    }

    public function setVisible($visible)
    {
        return $this->visible = $visible;   
    }

    public function getVisible()
    {
        return $this->visible;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setRoute($route)
    {
        $this->route = $route;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function getNavLink()
    {
        $where = array(
            "visible"=>1,
        );

        return $this->select($where);
    }

    public function checkUnicity()
    {

        $where = array(
            "visible"=>1,
            "type"=>$this->getType(),
            "id"=>$this->getId(),
        );

        $this->reset();
        $this->builder->select($this->table, ['*']);
        $this->builder->where("visible", $this->table);
        $this->builder->where("type", $this->table);
        $this->builder->where("id", $this->table, "!=");

        $res = $this->execute($where, true, true);
        
        if ($res && count($res)>0) {
            return false;
        }

        return true;
    }

    public function getAddForm(): array
    {
        return [
            "config"=>[
                "class"=>"formAddPage",
                "method"=>"POST",
                "action"=>"/administration/page/add",
                "submit"=>"Add"
            ],
            'inputs'=>[
                "title"=>[
                    "type"=>"text",
                    "placeholder"=>"Page title...",
                    "required"=>true,
                    "error"=>"Incorrect title"
                ],
                "route"=>[
                    "type"=>"text",
                    "placeholder"=>"Page route...",
                    "required"=>true,
                    "error"=>"Incorrect title"
                ],
            ],
            "textAreas"=>[
                "descSEO"=>[
                    "type"=>"text",
                    "placeholder"=>"Description SEO...",
                    "error"=>"Incorrect SEO tdescription",
                ],
                "kwordsSEO"=>[
                    "type"=>"text",
                    "placeholder"=>"SEO KeyWord1, KeyWord2, KeyWord3...",
                    "error"=>"Incorrect SEO KeyWords",
                ]
            ],
            "select"=>[
                "type"=>[
                    "required"=>true,
                    "error"=>"Incorrect type",
                    "options"=>["project"=>"Project","post"=>"Post","concert"=>"Concert"],
                    "label"=>"type"
                ]
            ]
        ];
    }

    public function getEditForm(): array
    {

        return [
            "config"=>[
                "class"=>"formAddNewsletter",
                "method"=>"POST",
                "action"=>"",
                "submit"=>"EDIT"
            ],
            'inputs'=>[
                "title"=>[
                    "type"=>"text",
                    "placeholder"=>"Page title...",
                    "required"=>true,
                    "error"=>"Incorrect title",
                    "value"=>$this->title,
                    "label"=>"Title"
                ],
                "route"=>[
                    "type"=>"text",
                    "placeholder"=>"Page route...",
                    "required"=>true,
                    "error"=>"Incorrect route",
                    "value"=>$this->route,
                    "label"=>"Route"
                ],
                "created_at"=>[
                    "type"=>"text",
                    "placeholder"=>"Date création",
                    "error"=>"Date incorrect",
                    "readonly"=>true,
                    "value"=>$this->created_at,
                    "label"=>"Date"
                ]
            ],
            "select"=>[
                "visible"=>[
                    "required"=>true,
                    "error"=>"Incorrect visible",
                    "options"=>[0=>"non publiée",1=>"publiée"],
                    "value"=>$this->visible,
                    "label"=>"Visible"
                ],
                "type"=>[
                    "required"=>true,
                    "error"=>"Incorrect type",
                    "options"=>["project"=>"Project","post"=>"Post","concert"=>"Concert"],
                    "value"=>$this->type,
                    "label"=>"Visible"
                ]
            ],
            "textAreas"=>[
                "descSEO"=>[
                    "type"=>"text",
                    "placeholder"=>"Description SEO...",
                    "error"=>"Incorrect SEO tdescription",
                    "value"=>$this->descSEO
                ],
                "kwordsSEO"=>[
                    "type"=>"text",
                    "placeholder"=>"SEO KeyWord1, KeyWord2, KeyWord3...",
                    "error"=>"Incorrect SEO KeyWords",
                    "value"=>$this->kwordsSEO
                ]
            ]
        ];
    }

}