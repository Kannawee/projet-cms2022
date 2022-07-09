<?php
namespace App\Model;

use App\Core\Sql;

class Project extends Sql
{
    protected $id = null;
    protected $name;
    protected $releaseDate;
    protected $description;
    public static $table = "esgi_project";

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
     * @return null|array
     */
    public function getAll(): ?array
    {
        $res = $this->select();
        return $res;

    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = trim($name);
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * @param string $releaseDate
     */
    public function setDate(string $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getAddForm(): array
    {
        return [
            "config"=>[
                "class"=>"formAddProject",
                "method"=>"POST",
                "action"=>"projects/add",
                "submit"=>"Add"
            ],
            'inputs'=>[
                "name"=>[
                    "type"=>"text",
                    "placeholder"=>"Project name...",
                    "required"=>true,
                    "error"=>"Incorrect name"
                ],
                "releaseDate"=>[
                    "type"=>"date",
                    "placeholder"=>"",
                    "required"=>true,
                    "error"=>"Incorrect date"
                ],
            ],
            'textAreas'=>[
                "description"=>[
                    "placeholder"=>"A few words about your project...",
                    "required"=>true,
                    "error"=>"Incorrect description"
                ],
            ]
        ];
    }
}