<?php
namespace App\Model;

use App\Core\Sql;

class Media extends Sql
{
    protected $id = null;
    protected $name;
    protected $fileName;
    public static $table = "esgi_media";

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
    public function getFile(): string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFile(string $fileName): void
    {
        $this->fileName = trim($fileName);
    }

    public function getAddForm(): array
    {
        return [
            "config"=>[
                "class"=>"",
                "method"=>"POST",
                "action"=>"",
                "submit"=>"Add"
            ],
            'inputs'=>[
                "name"=>[
                    "type"=>"text",
                    "placeholder"=>"Media name...",
                    "required"=>true,
                    "error"=>"Incorrect name"
                ],
                "fileName"=>[
                    "type"=>"file",
                    "required"=>true,
                    "accept"=>"audio/*",
                    "error"=>"Incorrect date"
                ],
            ]
        ];
    }
}