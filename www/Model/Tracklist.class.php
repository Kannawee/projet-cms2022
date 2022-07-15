<?php
namespace App\Model;

use App\Core\Sql;

class Tracklist extends Sql
{
    protected $id = null;
    protected $project;
    protected $media;
    protected $position;

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
     * @return int
     */
    public function getProject(): int
    {
        return $this->project;
    }

    /**
     * @param int $project
     */
    public function setProject(int $project): void
    {
        $this->project = $project;
    }

    /**
     * @return int
     */
    public function getMedia(): int
    {
        return $this->media;
    }

    /**
     * @param int $media
     */
    public function setMedia(int $media): void
    {
        $this->media = $media;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

}