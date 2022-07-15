<?php
namespace App\Model;

use App\Core\Sql;

class Project extends Sql
{
    protected $id = null;
    protected $name;
    protected $releaseDate;
    protected $description;

    public function __construct()
    {
        parent::__construct();
    }

    public function setFromArray($data)
    {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }

        if (isset($data['name'])) {
            $this->name = $data['name'];
        }

        if (isset($data['releaseDate'])) {
            $this->releaseDate = $data['releaseDate'];
        }

        if (isset($data['description'])) {
            $this->description = $data['description'];
        }
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
                "action"=>"/administration/project/add",
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

    public function getEditForm(): array
    {
        return [
            "config"=>[
                "class"=>"formAddProject",
                "method"=>"POST",
                "action"=>"/administration/project/edit/".$this->getId(),
                "submit"=>"Edit"
            ],
            'inputs'=>[
                "name"=>[
                    "type"=>"text",
                    "placeholder"=>"Project name...",
                    "required"=>true,
                    "error"=>"Incorrect name",
                    "value"=>$this->getName()
                ],
                "releaseDate"=>[
                    "type"=>"date",
                    "placeholder"=>"",
                    "required"=>true,
                    "error"=>"Incorrect date",
                    "value"=>$this->getDate(),
                    "readonly"=>true
                ],
            ],
            'textAreas'=>[
                "description"=>[
                    "placeholder"=>"A few words about your project...",
                    "required"=>true,
                    "error"=>"Incorrect description",
                    "value"=>$this->getDescription()
                ],
            ]
        ];
    }
}