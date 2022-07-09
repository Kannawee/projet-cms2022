<?php
namespace App\Model;

use App\Core\Sql;

class Newsletter extends Sql
{
    protected $id = null;
    protected $title;
    protected $content;
    protected $date;
    public static $table = "esgi_newsletter";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return null|int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = trim($title);
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = trim($content);
    }


    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }


    public function getAddForm(): array
    {
        return [
            "config"=>[
                "class"=>"formAddNewsletter",
                "method"=>"POST",
                "action"=>"newsletter/add",
                "submit"=>"Add"
            ],
            'inputs'=>[
                "title"=>[
                    "type"=>"text",
                    "placeholder"=>"Newsletter title...",
                    "required"=>true,
                    "error"=>"Incorrect title"
                ]
            ],
            'textAreas'=>[
                "content"=>[
                    "placeholder"=>"Newsletter content...",
                    "require"=>true,
                    "error"=>"Incorrect content"
                ]
            ]
        ];
    }
}

?>