<?php
namespace App\Model;

use App\Core\Sql;

class Post extends Sql
{
    protected $id=null;
    protected $title;
    protected $content;
    protected $published;

    public function __construct()
    {
        parent::__construct();
    }

    public function setFromArray($data)
    {
        $this->id = (isset($data['id']))?htmlspecialchars($data['id']):null;
        $this->title = (isset($data['title']))?htmlspecialchars($data['title']):null;
        $this->content = (isset($data['content']))?htmlspecialchars($data['content']):null;
        $this->published = (isset($data['published']))?htmlspecialchars($data['published']):null;
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

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setPublished($published)
    {
        $this->published = $published;
    }

    public function getPublished()
    {
        return $this->published;
    }

    public function getAddForm(): array
    {
        return [
            "config"=>[
                "class"=>"formAddPage",
                "method"=>"POST",
                "action"=>"/administration/post/add",
                "submit"=>"Add"
            ],
            'inputs'=>[
                "title"=>[
                    "type"=>"text",
                    "placeholder"=>"Post title...",
                    "error"=>"Incorrect title"
                ],
            ],
            'textAreas'=>[
                "content"=>[
                    "type"=>"text",
                    "placeholder"=>"Post content...",
                    "required"=>true,
                    "error"=>"Incorrect content"
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
                    "placeholder"=>"Post title...",
                    "value"=>$this->title,
                    "error"=>"Incorrect title"
                ],
            ],
            'textAreas'=>[
                "content"=>[
                    "type"=>"text",
                    "placeholder"=>"Post content...",
                    "required"=>true,
                    "value"=>$this->content,
                    "error"=>"Incorrect content"
                ],
            ],
            "select"=>[
                "published"=>[
                    "required"=>true,
                    "error"=>"Incorrect published",
                    "options"=>[0=>"non publiée",1=>"publiée"],
                    "value"=>$this->published,
                    "label"=>"Publié"
                ]
            ]
        ];
    }

}