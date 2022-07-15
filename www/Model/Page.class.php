<?php
namespace App\Model;

use App\Core\Sql;

class Page extends Sql
{
    protected $id = null;
    protected $title;
    protected $visible;
    protected $created_at;

    public function __construct()
    {
        parent::__construct();
    }

    public function setFromArray($data)
    {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }

        $this->title = (isset($data['title']))?$data['title']:"";
        $this->visible = (isset($data['visible']))?$data['visible']:"";
        $this->created_at = (isset($data['created_at']))?$data['created_at']:"";
        
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
                    "placeholder"=>"Newsletter title...",
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
                    "placeholder"=>"Newsletter title...",
                    "required"=>true,
                    "error"=>"Incorrect title",
                    "value"=>$this->title,
                    "label"=>"Titre"
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