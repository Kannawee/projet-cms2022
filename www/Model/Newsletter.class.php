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
                ],
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

    public function getSubscribedUsers($id)
    {
        $where = array(
            "id_newsletter"=>$id
        );

        $this->reset();
        $this->getBuilder()->select('esgi_newsletter_list', ['esgi_user.login','esgi_user.email','esgi_user.id']);
        $this->getBuilder()->join('esgi_user','esgi_newsletter_list','id','id_user');
        $res = $this->execute($where, true);

        return $res;        
    }

    public function subscribe($data)
    {
        $data = array_map('intval', $data);
        $this->reset();
        $this->getBuilder()->select('esgi_newsletter_list', ['id']);
        $this->getBuilder()->where('id_user','esgi_newsletter_list');
        $this->getBuilder()->where('id_newsletter','esgi_newsletter_list');

        $check = count($this->execute($data, true));

        if ($check===0) {
            $this->reset();
            $this->getBuilder()->insert('esgi_newsletter_list',$data);

            // echo $this->getBuilder()->getQuery();die;
            $res = $this->execute($data);
            return $res;
        }
        return false;
    }

    public function unsubscribe($data)
    {
        $data = array_map('intval', $data);
        $this->reset();
        $this->getBuilder()->select('esgi_newsletter_list', ['id']);
        $this->getBuilder()->where('id_user','esgi_newsletter_list');
        $this->getBuilder()->where('id_newsletter','esgi_newsletter_list');

        $check = count($this->execute($data, true));

        if ($check===1) {
            $this->reset();
            $this->getBuilder()->delete('esgi_newsletter_list');
            $this->getBuilder()->where('id_user', 'esgi_newsletter_list');
            $this->getBuilder()->where('id_newsletter', 'esgi_newsletter_list');

            $res = $this->execute($data);
            return $res;
        }
        return false;
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
                    "require"=>true,
                    "error"=>"Incorrect content",
                    "value"=>$content,
                    "label"=>"Contenu"
                ]
            ]
        ];
    }
}

?>