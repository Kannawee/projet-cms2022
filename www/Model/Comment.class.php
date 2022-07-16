<?php
namespace App\Model;

use App\Core\Sql;

class Comment extends Sql
{

    protected $id=null;
    protected $moded;
    protected $type;
    protected $content;
    protected $id_user;
    protected $id_project;
    protected $id_concert;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getModed()
    {
        return $this->$moded;
    }

    public function setModed($moded)
    {
        $this->moded = $moded;
    }

    public function getType()
    {
        return $this->$type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getContent()
    {
        return $this->$content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getIdUser()
    {
        return $this->$id_user;
    }

    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    public function getIdProject()
    {
        return $this->$project;
    }

    public function setIdProject($project)
    {
        $this->project = $project;
    }

    public function getIdConcert()
    {
        return $this->$id_concert;
    }

    public function setIdConcert($id_concert)
    {
        $this->id_concert = $id_concert;
    }

    public function getModedCommentFromObjId($id, $type)
    {

        $col = "id_".$type;

        $where = array(
            "moded"=>1,
            $col=>$id
        );

        $this->reset();
        $this->builder->select($this->table, [$this->table.".*", DBPREFIXE."user.id as user_id", DBPREFIXE."user.login"]);
        $this->builder->join(DBPREFIXE."user", $this->table, "id", "id_user", "INNER");
        $this->builder->where("moded", $this->table);
        $this->builder->where($col, $this->table);

        $res = $this->execute($where, true);

        if ($res!==false && count($res)>0) {
            return $res;
        }
        return false;
        
    }

    public function getListUnmod()
    {
        $where = array(
            "moded"=>0
        );

        $this->reset();
        $this->builder->select($this->table, [$this->table.".*", DBPREFIXE."user.id as user_id", DBPREFIXE."user.login"]);
        $this->builder->join(DBPREFIXE."user", $this->table, "id", "id_user", "INNER");
        $this->builder->where("moded", $this->table);

        $res = $this->execute($where, true);

        if ($res!==false && count($res)>0) {
            return $res;
        }
        return false;
        
    }

}