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
                ]
            ]
        ];
    }

}