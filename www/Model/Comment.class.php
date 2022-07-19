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
    protected $id_post;
    protected $created_at;

    public function __construct()
    {
        parent::__construct();
    }

    public function setFromArray($data)
    {
        $this->id = (isset($data['id']))?$data['id']:null;
        $this->moded = (isset($data['moded']))?$data['moded']:null;
        $this->type = (isset($data['type']))?$data['type']:null;
        $this->content = (isset($data['content']))?$data['content']:null;
        $this->id_user = (isset($data['id_user']))?$data['id_user']:null;
        $this->id_project = (isset($data['id_project']))?$data['id_project']:null;
        $this->id_concert = (isset($data['id_concert']))?$data['id_concert']:null;
        $this->id_post = (isset($data['id_post']))?$data['id_post']:null;
        $this->created_at = (isset($data['created_at']))?$data['created_at']:null;
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

    public function getIdPost()
    {
        return $this->$id_post;
    }

    public function setIdPost($id_post)
    {
        $this->id_post = $id_post;
    }

    public function getCreatedAt()
    {
        return $this->$created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getModedCommentFromObjId($id, $type)
    {

        $col = "id_".$type;

        $where = array(
            "moded"=>1,
            $col=>$id,
            "status"=>3
        );

        $this->reset();
        $this->builder->select($this->table, [$this->table.".*", DBPREFIXE."user.id as user_id", DBPREFIXE."user.login"]);
        $this->builder->join(DBPREFIXE."user", $this->table, "id", "id_user", "INNER");
        $this->builder->where("moded", $this->table);
        $this->builder->where($col, $this->table);
        $this->builder->where("status", DBPREFIXE."user", "!=");

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

    public function getAddForm($type, $id, $redirect): array
    {

        return [
            "config"=>[
                "class"=>"formAddPage",
                "method"=>"POST",
                "action"=>"/administration/comment/add/".$type."/".$id,
                "submit"=>"Comment"
            ],
            "textAreas"=>[
                "content"=>[
                    "type"=>"text",
                    "required"=>true,
                    "placeholder"=>"Comment content...",
                    "error"=>"Incorrect content",
                ],
            ],
            "inputs"=>[
                "redirect"=>[
                    "type"=>"hidden",
                    "required"=>true,
                    "value"=>$redirect,
                    "error"=>"Incorrect redirect",
                ]
            ]
        ];
    }

}