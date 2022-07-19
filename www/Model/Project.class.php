<?php
namespace App\Model;

use App\Core\Sql;

class Project extends Sql
{
    protected $id = null;
    protected $name;
    protected $releaseDate;
    protected $description;
    protected $cover;

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

        if (isset($data['cover'])) {
            $this->cover = $data['cover'];
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

    /**
     * @return null|string
     */
    public function getCover(): ?string
    {
        return $this->cover;
    }

    /**
     * @param array $cover
     */
    public function setCover(array $cover): void
    {
        $image_name = $this->getId();
        $filename = $cover['name'];
        $temp_array = explode(".", $filename);
        $extension = end($temp_array);
        $image_path = './uploads/covers/' . $image_name . '.' . $extension;

        $this->cover = $image_path;
    }

    public function getAddForm(): array
    {
        return [
            "config"=>[
                "class"=>"formAddProject",
                "method"=>"POST",
                "action"=>"/administration/project/add",
                "submit"=>"Add",
                // CODE IZIA
                "enctype"=>"multipart/form-data",
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
                "cover"=>[
                    "type"=>"file",
                    "placeholder"=>"",
                    "accept"=>".jpg, .jpeg, .png",
                    "error"=>"Incorrect cover"
                ],
            ],
            'textAreas'=>[
                "description"=>[
                    "placeholder"=>"A few words about your project...",
                    "required"=>true,
                    "rows"=>10,
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