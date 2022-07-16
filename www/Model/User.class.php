<?php
namespace App\Model;

use App\Core\Sql;
use App\Model\Mymail as mymailModel;

class User extends Sql
{
    protected $id = null;
    protected $login;
    protected $email;
    protected $password;
    protected $status = 0;
    protected $token = null;
    protected $confirmed;

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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = strtolower(trim($email));
    }

    public function getConfirmed()
    {
        return $this->confirmed;
    }

    public function setConfirmed(string $confirmed): void
    {
        $this->confirmed = strtolower(trim($confirmed));
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = trim($login);
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return null|string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * length : 255
     */
    public function generateToken(): void
    {
        $this->token = substr(bin2hex(random_bytes(128)), 0, 255);
    }

    public function getSubscribedUsers($id)
    {
        $where = array(
            "id_newsletter"=>$id
        );

        $this->reset();
        $this->builder->select(DBPREFIXE.'newsletterlist', ['login','email',DBPREFIXE.'user.id as id']);
        $this->builder->join(DBPREFIXE.'user',DBPREFIXE.'newsletterlist','id','id_user');
        $this->builder->where('id_newsletter',DBPREFIXE.'newsletterlist');
        $res = $this->execute($where, true, true);

        return $res;        
    }

    public function sendResetPwd()
    {
        $mail = new mymailModel();
        $body = "<a href=\"http://".$_SERVER['HTTP_HOST']."/resetpwd/".$this->id."/".$this->token."\">Cliquer ici pour réinitialiser votre mot de passe</a>";
        // echo $body;die;
        $subject = "Reset Password ".$this->login;
        $addr = [$this->email];
        $mail->setupMyMail($subject, $body, $addr);
        $res = $mail->sendMyMail();

        return $res;
    }

    public function sendConfirm($id)
    {
        $mail = new mymailModel();
        $body = "<a href=\"http://".$_SERVER['HTTP_HOST']."/confirmuser/".$id."/".$this->token."\">Cliquer ici pour confirmer votre compte</a>";
        // echo $body;die;
        $subject = "Confirmer votre compte ".$this->login;
        $addr = [$this->email];
        $mail->setupMyMail($subject, $body, $addr);
        $res = $mail->sendMyMail();

        return $res;
    }

    public function checkSuperAdmin()
    {
        $where = array(
            "status"=>1
        );
        $res = $this->select($where);

        if ($res!==false && count($res)>0) {
            return false;
        }
        return true;
    }

    public function getResetPwdForm()
    {
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"/resetpwd/".$this->id."/".$this->token,
                "submit"=>"Confirmer"
            ],
            "inputs"=>[
                "password"=>[
                    "type"=>"password",
                    "required"=>true,
                    "class"=>"inputForm",
                    "id"=>"pwdForm",
                    "error"=>"Password incorrect",
                ],
                "passwordConfirm"=>[
                    "type"=>"password",
                    "required"=>true,
                    "class"=>"inputForm",
                    "id"=>"pwdConfForm",
                    "error"=>"Password confirm incorrect",
                ]
            ]
        ];
    }


    public function getFgtPwdForm(): array
    {
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"/forgottenpwd",
                "submit"=>"S'inscrire"
            ],
            "inputs"=>[
                "email"=>[
                    "type"=>"email",
                    "placeholder"=>"Votre email ...",
                    "required"=>true,
                    "class"=>"inputForm",
                    "id"=>"emailForm",
                    "error"=>"Email incorrect",
                    "unicity"=>"true",
                    "errorUnicity"=>"Email déjà en bdd",
                ]
            ]
        ];
    }


    public function getRegisterForm(): array
    {
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "submit"=>"S'inscrire"
            ],
            'inputs'=>[
                "email"=>[
                    "type"=>"email",
                    "placeholder"=>"Votre email ...",
                    "required"=>true,
                    "class"=>"inputForm",
                    "id"=>"emailForm",
                    "error"=>"Email incorrect",
                    "unicity"=>"true",
                    "value"=>(isset($this->email) && !is_null($this->email))?$this->email:"",
                    "errorUnicity"=>"Email déjà en bdd",
                ],
                "login"=>[
                    "type"=>"text",
                    "placeholder"=>"Votre login ...",
                    "class"=>"inputForm",
                    "id"=>"loginForm",
                    "min"=>2,
                    "max"=>50,
                    "error"=>"Login incorrect",
                    "value"=>(isset($this->login) && !is_null($this->login))?$this->login:"",
                ],
                "password"=>[
                    "type"=>"password",
                    "placeholder"=>"Votre mot de passe ...",
                    "required"=>true,
                    "class"=>"inputForm",
                    "id"=>"pwdForm",
                    "error"=>"Votre mot de passe doit faire au min 8 caractères avec majuscule, minuscules et des chiffres"
                    ],
                "passwordConfirm"=>[
                    "type"=>"password",
                    "placeholder"=>"Confirmation ...",
                    "required"=>true,
                    "class"=>"inputForm",
                    "id"=>"pwdConfirmForm",
                    "confirm"=>"password",
                    "error"=>"Votre mot de passe de confirmation ne correspond pas",
                ],
            ]
        ];
    }

    public function getLoginForm(): array
    {
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "submit"=>"Se connecter"
            ],
            'inputs'=>[
                "email"=>[
                    "type"=>"email",
                    "placeholder"=>"Votre email ...",
                    "required"=>true,
                    "class"=>"inputForm",
                    "id"=>"emailForm",
                    "error"=>"Email incorrect",
                    "value"=>(isset($this->email))?$this->email:""
                ],
                "password"=>[
                    "type"=>"password",
                    "placeholder"=>"Votre mot de passe ...",
                    "required"=>true,
                    "class"=>"inputForm",
                    "error"=>"Incorrect password", 
                    "id"=>"pwdForm"
                ]
            ]
        ];
    }

    public function getRoleForm(): array
    {

        return [
            "config"=>[
                "class"=>"formAddNewsletter",
                "method"=>"POST",
                "action"=>"/administration/user/role/".$this->id,
                "submit"=>"OK"
            ],
            "select"=>[
                "status"=>[
                    "required"=>true,
                    "error"=>"Incorrect visible",
                    "options"=>ROLES,
                    "value"=>$this->status,
                    "label"=>"Role"
                ]
            ]
        ];
    }

    public function checkLogin(): array
    {
        $where = [
          'email' => $this->email
        ];

        return $this->select($where);
    }

}