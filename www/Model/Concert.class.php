<?php
namespace App\Model;

use App\Core\Sql;

class Concert extends Sql
{
    protected $id = null;
    protected $name = null;
    protected $date;
    protected $venue;
    protected $city;
    protected $link;
    
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
     * @return null|string
     */
    public function getName(): ?string
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
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getVenue(): string
    {
        return $this->venue;
    }

    /**
     * @param string $venue
     */
    public function setVenue(string $venue): void
    {
        $this->venue = trim($venue);
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = trim($link);
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = trim($city);
    }

    public function getAddForm(): array
    {
        return [
            "config"=>[
                "class"=>"formAddConcert",
                "method"=>"POST",
                "action"=>"concerts/add",
                "submit"=>"Add"
            ],
            'inputs'=>[
                "name"=>[
                    "type"=>"text",
                    "placeholder"=>"Concert name...",
                    "required"=>false,
                    "error"=>"Incorrect name"
                ],
                "date"=>[
                    "type"=>"date",
                    "required"=>true,
                    "error"=>"Incorrect date"
                ],
                "venue"=>[
                    "type"=>"text",
                    "placeholder"=>"Venue...",
                    "required"=>true,
                    "error"=>"Incorrect venue name"
                ],
                "city"=>[
                    "type"=>"text",
                    "placeholder"=>"City...",
                    "required"=>true,
                    "error"=>"Incorrect city name"
                ],
                "link"=>[
                    "type"=>"text",
                    "placeholder"=>"Link...",
                    "required"=>true
                ]
            ]
        ];
    }
}

?>