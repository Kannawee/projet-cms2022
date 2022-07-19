<?php
namespace App\Model;

use App\Core\Sql;
use App\Model\User as userModel;

class Newsletter extends Sql
{
    protected $id = null;
    protected $title;
    protected $content;
    protected $date;
    protected $active;
    protected $type;
    
    public function __construct()
    {
        parent::__construct();
    }

    public function setFromArray($data)
    {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }

        if (isset($data['title'])) {
            $this->title = $data['title'];
        }

        if (isset($data['content'])) {
            $this->content = $data['content'];
        }

        if (isset($data['date'])) {
            $this->date = $data['date'];
        }

        if (isset($data['active'])) {
            $this->active = $data['active'];
        }

        if (isset($data['type'])) {
            $this->type = $data['type'];
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

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        return $this->type = $type;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        return $this->active = $active;
    }

    public function subscribe($data)
    {
        $data = array_map('intval', $data);
        $this->reset();
        $this->builder->select(DBPREFIXE.'newsletterlist', ['id']);
        $this->builder->where('id_user',DBPREFIXE.'newsletterlist');

        $check = count($this->execute($data, true));

        if ($check===0) {
            $this->reset();
            $this->builder->insert(DBPREFIXE.'newsletterlist',$data);

            // echo $this->builder->getQuery();die;
            $res = $this->execute($data);
            return $res;
        }
        return false;
    }

    public function unsubscribe($data)
    {
        $data = array_map('intval', $data);
        $this->reset();
        $this->builder->select(DBPREFIXE.'newsletterlist', ['id']);
        $this->builder->where('id_user',DBPREFIXE.'newsletterlist');

        $check = count($this->execute($data, true));

        if ($check===1) {
            $this->reset();
            $this->builder->delete(DBPREFIXE.'newsletterlist');
            $this->builder->where('id_user', DBPREFIXE.'newsletterlist');

            $res = $this->execute($data);
            return $res;
        }
        return false;
    }

    public function listemail()
    {

        $this->reset();
        $this->builder->select(DBPREFIXE.'user', [DBPREFIXE.'user.email', DBPREFIXE.'user.login']);
        $this->builder->join(DBPREFIXE.'newsletterlist', DBPREFIXE.'user', 'id_user', 'id', 'INNER');
        
        $res = $this->execute([],true);

        return $res;
    }

    public function getNewsById($id_news)
    {
        $data = array(
            "id"=>$id_news
        );

        $this->reset();
        $this->builder->select(DBPREFIXE.'newsletter', ['*']);
        $this->builder->where('id', DBPREFIXE.'newsletter');
        
        $res = $this->execute($data, true);
        return $res;
    }

    public function getAddForm(): array
    {
        return [
            "config"=>[
                "class"=>"formAddNewsletter",
                "method"=>"POST",
                "action"=>"/administration/newsletter/add",
                "submit"=>"Add"
            ],
            'inputs'=>[
                "title"=>[
                    "type"=>"text",
                    "placeholder"=>"Newsletter title...",
                    "required"=>true,
                    "error"=>"Incorrect title"
                ],
            ],
            'textAreas'=>[
                "content"=>[
                    "placeholder"=>"Newsletter content...",
                    // "required"=>true,
                    "error"=>"Incorrect content",
                    "id"=>"newsContent"
                ]
            ],
            "select"=>[
                "type"=>[
                    "required"=>true,
                    "error"=>"Incorrect statut",
                    "options"=>NEWSTYPE,
                    "value"=>$this->type,
                    "label"=>"Type"
                ]
            ]
        ];
    }

    public function getEditForm(): array
    {

        $title = $this->title;
        $content = $this->content;
        $date = $this->date;

        return [
            "config"=>[
                "class"=>"formAddNewsletter",
                "method"=>"POST",
                "action"=>"",
                "submit"=>"EDIT"
            ],
            'inputs'=>[
                "date"=>[
                    "type"=>"text",
                    "placeholder"=>"Date création",
                    "error"=>"Date incorrect",
                    "readonly"=>true,
                    "value"=>$date,
                    "label"=>"Date"
                ],
                "title"=>[
                    "type"=>"text",
                    "placeholder"=>"Newsletter title...",
                    "required"=>true,
                    "error"=>"Incorrect title",
                    "value"=>$title,
                    "label"=>"Titre"
                ],
                "idnews"=>[
                    "type"=>"hidden",
                    "placeholder"=>"Newsletter title...",
                    "required"=>true,
                    "error"=>"Incorrect id",
                    "value"=>$this->getId(),
                    "label"=>"Titre"
                ],
            ],
            'textAreas'=>[
                "content"=>[
                    "placeholder"=>"Newsletter content...",
                    // "required"=>true,
                    "error"=>"Incorrect content",
                    "value"=>$content,
                    "label"=>"Contenu",
                    "id"=>"newsContent"
                ]
            ],
            "select"=>[
                "active"=>[
                    "required"=>true,
                    "error"=>"Incorrect statut",
                    "options"=>[0=>"Manuel",1=>"Auto"],
                    "value"=>$this->active,
                    "label"=>"Statut"
                ],
                "type"=>[
                    "required"=>true,
                    "error"=>"Incorrect statut",
                    "options"=>NEWSTYPE,
                    "value"=>$this->type,
                    "label"=>"Statut"
                ]
            ]
        ];
    }
}

?>